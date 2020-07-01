<?php

namespace Tqdev\PhpCrudUi\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Tqdev\PhpCrudApi\Middleware\Base\Middleware;

class StaticFileMiddleware extends Middleware
{

    private function santizeFilename()
    {
        $basepath = '/foo/bar/baz/';
        $realBase = realpath($basepath);

        $userpath = $basepath . $_GET['path'];
        $realUserPath = realpath($userpath);

        if ($realUserPath === false || strpos($realUserPath, $realBase) !== 0) {
            //Directory Traversal!
        } else {
            //Good path!
        }
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if ($response->getStatusCode() == 404) {
            return $this->responder->
        }
        return $response;
    }
}
