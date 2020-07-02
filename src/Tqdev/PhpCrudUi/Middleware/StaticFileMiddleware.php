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

    private function santizeFilename(string $base, string $filename): string
    {
        $realBase = realpath($base);
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
            $path = $request->getUri()->getPath();
            $contentType = $this->getContentType($path);

            global $_STATIC;

            if (isset($_STATIC[$path])) {
                $content = base64_decode($_STATIC[$path]);
                return ResponseFactory::from(ResponseFactory::OK, $contentType, $content);
            }

            $filename = $this->santizeFilename('.', $path);
            if ($contentType && $filename) {
                $content = file_get_contents($filename);
                return ResponseFactory::from(ResponseFactory::OK, $contentType, $content);
            }
        }
        return $response;
    }
}
