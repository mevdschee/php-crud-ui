<?php
namespace Tqdev\PhpCrudUi\Controller;

use Psr\Http\Message\ResponseInterface;
use Tqdev\PhpCrudApi\Controller\Responder;
use Tqdev\PhpCrudApi\Record\Document\ErrorDocument;
use Tqdev\PhpCrudApi\Record\ErrorCode;
use Tqdev\PhpCrudApi\ResponseFactory;
use Tqdev\PhpCrudUi\Document\TemplateDocument;

class TemplateResponder implements Responder
{
    private $variables;
    private $templatePath;

    public function __construct(string $path)
    {
        $this->variables = array();
        $this->templatePath = $path;
    }

    public function setVariable(string $name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function error(int $error, string $argument, $details = null): ResponseInterface
    {
        $errorCode = new ErrorCode($error);
        $status = $errorCode->getStatus();
        $document = new ErrorDocument($errorCode, $argument, $details);
        $result = new TemplateDocument('layouts/error', 'error/show', $document->serialize());
        $result->addVariables($this->variables);
        $result->setTemplatePath($this->templatePath);
        return ResponseFactory::fromHtml($status, (string) $result);
    }

    public function success($result): ResponseInterface
    {
        $result->addVariables($this->variables);
        $result->setTemplatePath($this->templatePath);
        return ResponseFactory::fromHtml(ResponseFactory::OK, $result);
    }

}
