<?php

namespace Tqdev\PhpCrudUi\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
use Tqdev\PhpCrudApi\ResponseFactory;

class StaticFileMiddleware extends Middleware
{

    private function santizeFilename(string $filename): string
    {
        $realBase = realpath($this->getProperty('webRootPath', '.'));
        $realUserPath = realpath($realBase . $filename);

        if ($realUserPath === false || strpos($realUserPath, $realBase) !== 0) {
            return '';
        }
        return $realUserPath;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if ($response->getStatusCode() == 404) {
            $filename = $request->getUri()->getPath();
            $filename = $this->santizeFilename($filename);
            if ($filename) {
                return ResponseFactory::fromFile(ResponseFactory::OK, $filename);
            }
        }
        return $response;
    }
}
