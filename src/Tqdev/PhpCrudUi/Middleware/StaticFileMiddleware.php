<?php

namespace Tqdev\PhpCrudUi\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
use Tqdev\PhpCrudApi\ResponseFactory;

class StaticFileMiddleware extends Middleware
{

    private function getContentType(string $filename): string
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        switch ($extension) {
            case 'css':
                return 'text/css';
            case 'svg':
                return 'image/svg+xml';
        }
        return '';
    }

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
            $contentType = $this->getContentType($filename);
            if ($contentType && $filename) {
                return ResponseFactory::fromFile(ResponseFactory::OK, $contentType, $filename);
            }
        }
        return $response;
    }
}
