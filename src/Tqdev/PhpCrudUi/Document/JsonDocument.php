<?php

namespace Tqdev\PhpCrudUi\Document;

class JsonDocument
{
    private $variables;

    public function __construct(array $variables)
    {
        $this->variables = $variables;
    }

    public function __toString(): string
    {
        return json_encode($this->variables['records']);
    }
}
