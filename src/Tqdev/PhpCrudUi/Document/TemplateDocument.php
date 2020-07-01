<?php

namespace Tqdev\PhpCrudUi\Document;

use Tqdev\PhpCrudUi\Template\Template;

class TemplateDocument
{
    private $masterTemplate;
    private $contentTemplate;
    private $variables;
    private $template;
    private $templatePath;

    public function __construct(string $masterTemplate, string $contentTemplate, array $variables)
    {
        $this->masterTemplate = $masterTemplate;
        $this->contentTemplate = $contentTemplate;
        $this->variables = $variables;
        $this->template = new Template('html', $this->getFunctions());
        $this->templatePath = '';
    }

    private function getFunctions(): array
    {
        return array(
            'lt' => function ($a, $b) {
                return $a < $b;
            },
            'gt' => function ($a, $b) {
                return $a > $b;
            },
            'le' => function ($a, $b) {
                return $a <= $b;
            },
            'ge' => function ($a, $b) {
                return $a >= $b;
            },
            'eq' => function ($a, $b) {
                return $a == $b;
            },
            'neq' => function ($a, $b) {
                return $a != $b;
            },
            'add' => function ($a, $b) {
                return $a + $b;
            },
            'sub' => function ($a, $b) {
                return $a - $b;
            },
            'has' => function ($a, $b) {
                return isset($a[$b]);
            },
            'prop' => function ($a, $b) {
                return $a[$b];
            },
            'bool' => function ($a, $b, $c) {
                return $a ? $b : $c;
            },
            'or' => function ($a, $b) {
                return $a ?: $b;
            },
            'humanize' => function ($a) {
                $a = substr($a, -3) == '_id' ? substr($a, 0, -3) : $a;
                return ucwords(str_replace('_', ' ', $a));
            },
        );
    }

    public function addVariables(array $variables) /*: void*/
    {
        $this->variables = array_merge($variables, $this->variables);
    }

    public function setTemplatePath(string $path) /*: void*/
    {
        $this->templatePath = rtrim($path, '/');
    }

    private function getHtmlFileContents(string $template): string
    {
        global $_HTML;
        if (isset($_HTML[$template])) {
            return $_HTML[$template];
        }
        $filename = $this->templatePath . '/' . $template . '.html';
        return file_get_contents($filename);
    }

    public function __toString(): string
    {
        $data = $this->variables;
        $content = $this->getHtmlFileContents($this->contentTemplate);
        $data['content'] = $this->template->render($content, $data);
        $master = $this->getHtmlFileContents($this->masterTemplate);
        return (string) $this->template->render($master, $data);
    }
}
