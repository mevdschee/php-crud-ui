<?php
namespace Tqdev\PhpCrudUi\Controller;

use Psr\Http\Message\ResponseInterface;
use Tqdev\PhpCrudApi\Controller\Responder;
use Tqdev\PhpCrudApi\Record\Document\ErrorDocument;
use Tqdev\PhpCrudApi\Record\ErrorCode;
use Tqdev\PhpCrudApi\ResponseFactory;
use Tqdev\PhpCrudUi\Template\Template;

class TemplateResponder implements Responder
{

    private function applyTemplates($data): string
    {
        $functions = [
            'lt' => function ($a, $b) {return $a < $b;},
            'gt' => function ($a, $b) {return $a > $b;},
            'le' => function ($a, $b) {return $a <= $b;},
            'ge' => function ($a, $b) {return $a >= $b;},
            'eq' => function ($a, $b) {return $a == $b;},
            'add' => function ($a, $b) {return $a + $b;},
            'sub' => function ($a, $b) {return $a - $b;},
        ];
        $view = file_get_contents('../templates/' . $data['__view'] . '.html');
        $content = Template::render($view, $data, $functions);
        $layout = file_get_contents('../templates/' . $data['__layout'] . '.html');
        return Template::render($layout, array('menu' => array(), 'content' => $content), $functions);
    }

    public function error(int $error, string $argument, $details = null): ResponseInterface
    {
        $errorCode = new ErrorCode($error);
        $status = $errorCode->getStatus();
        $document = new ErrorDocument($errorCode, $argument, $details);
        return ResponseFactory::fromHtml($status, json_encode($document));
    }

    public function success($result): ResponseInterface
    {
        return ResponseFactory::fromHtml(ResponseFactory::OK, $this->applyTemplates($result));
    }

}
