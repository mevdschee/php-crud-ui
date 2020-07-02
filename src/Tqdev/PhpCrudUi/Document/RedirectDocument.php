<?php

namespace Tqdev\PhpCrudUi\Document;

class RedirectDocument
{
    private $path;
    private $variables;

    public function __construct(string $path, array $variables)
    {
        $this->path = $path;
        $this->variables = $variables;
    }

    public function addVariables(array $variables) /*: void*/
    {
        $this->variables = array_merge($variables, $this->variables);
    }

    public function __toString(): string
    {
        return $this->variables['base'] . $this->path;
    }
}
