<?php
namespace Tqdev\PhpCrudUi\Document;

use Tqdev\PhpCrudUi\Template\Template;

class TemplateDocument
{
    private $masterTemplate;
    private $contentTemplate;
    private $variables;

    public function __construct(string $masterTemplate, string $contentTemplate, array $variables)
    {
        $this->masterTemplate = $masterTemplate;
        $this->contentTemplate = $contentTemplate;
        $this->variables = $variables;
    }

    public function addVariables(array $variables)
    {
        $this->variables = array_merge($variables, $this->variables);
    }

    private function getHtmlFileContents(string $template)
    {
        global $_HTML;
        $filename = 'templates/' . $template . '.html';
        if (isset($_HTML[$filename])) {
            return $_HTML[$filename];
        }
        return file_get_contents('../' . $filename);
    }

    public function __toString(): string
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

        $data = $this->variables;
        $content = $this->getHtmlFileContents($this->contentTemplate);
        $data['content'] = Template::render($content, $data, $functions);
        $master = $this->getHtmlFileContents($this->masterTemplate);
        return (string) Template::render($master, $data, $functions);
    }
}
