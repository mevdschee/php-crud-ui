<?php

namespace Tqdev\PhpCrudUi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tqdev\PhpCrudApi\Cache\CacheFactory;
use Tqdev\PhpCrudApi\Middleware\Router\SimpleRouter;
use Tqdev\PhpCrudApi\Record\ErrorCode;
use Tqdev\PhpCrudApi\ResponseUtils;
use Tqdev\PhpCrudUi\Client\CrudApi;
use Tqdev\PhpCrudUi\Client\CurlCaller;
use Tqdev\PhpCrudUi\Client\LocalCaller;
use Tqdev\PhpCrudUi\Column\SpecificationService;
use Tqdev\PhpCrudUi\Controller\MultiResponder;
use Tqdev\PhpCrudUi\Controller\RecordController;
use Tqdev\PhpCrudUi\Middleware\StaticFileMiddleware;
use Tqdev\PhpCrudUi\Record\RecordService;

class Ui implements RequestHandlerInterface
{
    private $router;
    private $responder;
    private $debug;

    public function __construct(Config $config)
    {
        $caller = new LocalCaller($config->getApi());
        if ($config->getUrl()) {
            $caller = new CurlCaller($config->getUrl());
        }
        $api = new CrudApi($caller);
        $prefix = sprintf('phpcrudui-%s-%s-', substr(md5($config->getUrl()), 0, 12), substr(md5(__FILE__), 0, 12));
        $cache = CacheFactory::create($config->getCacheType(), $prefix, $config->getCachePath());
        $definition = new SpecificationService($api, $cache, $config->getCacheTime());
        $responder = new MultiResponder($config->getTemplatePath());
        $router = new SimpleRouter($config->getBasePath(), $responder, $cache, $config->getCacheTime(), $config->getDebug());
        foreach (array_keys($config->getMiddlewares()) as $middleware) {
            switch ($middleware) {
                case 'staticFile':
                    new StaticFileMiddleware($router, $responder, $config, $middleware);
                    break;
            }
        }
        $responder->setVariable('info', $definition->getInfo());
        $responder->setVariable('base', $router->getBasePath());
        $responder->setVariable('menu', $definition->getMenu());
        $responder->setVariable('table', '');
        foreach ($config->getControllers() as $controller) {
            switch ($controller) {
                case 'records':
                    $records = new RecordService($api, $definition);
                    new RecordController($router, $responder, $records);
                    break;
            }
        }
        $this->router = $router;
        $this->responder = $responder;
        $this->debug = $config->getDebug();
    }

    private function addParsedBody(ServerRequestInterface $request): ServerRequestInterface
    {
        $body = $request->getBody();
        if ($body->isReadable() && $body->isSeekable()) {
            $contents = $body->getContents();
            $body->rewind();
            if ($contents) {
                parse_str($contents, $parsedBody);
                $request = $request->withParsedBody($parsedBody);
            }
        }
        return $request;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = null;
        try {
            $response = $this->router->route($this->addParsedBody($request));
            if ($response->getStatusCode() == 404) {
            }
        } catch (\Throwable $e) {
            $response = $this->responder->error(ErrorCode::ERROR_NOT_FOUND, $e->getMessage());
            if ($this->debug) {
                $response = ResponseUtils::addExceptionHeaders($response, $e);
            }
        }
        return $response;
    }
}
