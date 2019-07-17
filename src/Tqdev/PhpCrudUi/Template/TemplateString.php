<?php
namespace Tqdev\PhpCrudUi\Template;

class TemplateString
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function __toString()
    {
        return $this->string;
    }
}
