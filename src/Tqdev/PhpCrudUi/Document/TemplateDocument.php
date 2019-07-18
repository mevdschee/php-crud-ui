<?php
namespace Tqdev\PhpCrudUi\Document;

use Tqdev\PhpCrudUi\Template\Template;

class TemplateDocument 
{
    private $masterTemplate;
    private $contentTemplate;
    private $variables;

    function __construct($masterTemplate, $contentTemplate, $variables) {
        $this->masterTemplate = $masterTemplate;
        $this->contentTemplate = $contentTemplate;
        $this->variables = $variables;
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
        $content = file_get_contents('../templates/' . $this->contentTemplate . '.html');
        $data['content'] = Template::render($content, $data, $functions);
        $master = file_get_contents('../templates/' . $this->masterTemplate . '.html');
        return (string) Template::render($master, $data, $functions);
    }
}