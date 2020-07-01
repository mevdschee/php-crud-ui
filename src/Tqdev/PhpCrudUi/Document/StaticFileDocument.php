<?php

namespace Tqdev\PhpCrudUi\Document;

class StaticFileDocument
{
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
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
