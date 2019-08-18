<?php

namespace Tqdev\PhpCrudUi\Document;

use Tqdev\PhpCrudUi\Template\Template;

class CsvDocument
{
    private $variables;

    public function __construct(array $variables)
    {
        $this->variables = $variables;
    }

    public function addVariables(array $variables)/*: void*/
    {
        $this->variables = array_merge($variables, $this->variables);
    }

    public function setTemplatePath(string $path)/*: void*/
    {
        $this->templatePath = rtrim($path, '/');
    }

    public function __toString(): string
    {
        $f = fopen('php://memory', 'r+');
        fputcsv($f, $this->variables['columns']);
        foreach ($this->variables['records'] as $record) {
            fputcsv($f, $record);
        }
        rewind($f);
        return stream_get_contents($f);
    }
}
