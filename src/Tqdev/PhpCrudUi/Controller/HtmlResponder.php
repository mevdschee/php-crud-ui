<?php
namespace Tqdev\PhpCrudUi\Controller;

use Psr\Http\Message\ResponseInterface;
use Tqdev\PhpCrudApi\Controller\Responder;
use Tqdev\PhpCrudApi\Record\Document\ErrorDocument;
use Tqdev\PhpCrudApi\Record\ErrorCode;
use Tqdev\PhpCrudApi\ResponseFactory;

class HtmlResponder implements Responder
{
    public function error(int $error, string $argument, $details = null): ResponseInterface
    {
        $errorCode = new ErrorCode($error);
        $status = $errorCode->getStatus();
        $document = new ErrorDocument($errorCode, $argument, $details);
        return ResponseFactory::fromHtml($status, json_encode($document));
    }

    public function success($result): ResponseInterface
    {
        return ResponseFactory::fromHtml(ResponseFactory::OK, $result);
    }

}
