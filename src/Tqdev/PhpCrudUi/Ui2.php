<?php
namespace Tqdev\PhpCrudUi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tqdev\PhpCrudApi\Cache\CacheFactory;
use Tqdev\PhpCrudApi\Middleware\Router\SimpleRouter;
use Tqdev\PhpCrudApi\Record\ErrorCode;
use Tqdev\PhpCrudApi\ResponseUtils;
use Tqdev\PhpCrudUi\Column\DefinitionService;
use Tqdev\PhpCrudUi\Controller\HtmlResponder;
use Tqdev\PhpCrudUi\Controller\RecordController;
use Tqdev\PhpCrudUi\Curl\Curl;
use Tqdev\PhpCrudUi\Record\RecordService;

class Ui2 implements RequestHandlerInterface
{
    private $router;
    private $responder;
    private $debug;

    public function __construct(Config $config)
    {
        $curl = new Curl($config->getUrl());
        $prefix = sprintf('phpcrudui-%s-%s-', $config->getUrl(), substr(md5(__FILE__), 0, 8));
        $cache = CacheFactory::create($config->getCacheType(), $prefix, $config->getCachePath());
        $definition = new DefinitionService($curl);
        $responder = new HtmlResponder();
        $router = new SimpleRouter($config->getBasePath(), $responder, $cache, $config->getCacheTime(), $config->getDebug());
        foreach ($config->getControllers() as $controller) {
            switch ($controller) {
                case 'records':
                    $records = new RecordService($curl, $definition);
                    new RecordController($router, $responder, $records);
                    break;
            }
        }
        $this->router = $router;
        $this->responder = $responder;
        $this->debug = $config->getDebug();
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = null;
        try {
            $response = $this->router->route($request);
        } catch (\Throwable $e) {
            $response = $this->responder->error(ErrorCode::ERROR_NOT_FOUND, $e->getMessage());
            if ($this->debug) {
                $response = ResponseUtils::addExceptionHeaders($response, $e);
            }
        }
        return $response;
    }
}
