<?php
namespace Tqdev\PhpCrudUi;

class Config
{
    private $values = [
        'url' => '',
        'definition' => '',
    ];

    public function __construct(array $values)
    {
        $newValues = array_merge($this->values, $values);
        $diff = array_diff_key($newValues, $this->values);
        if (!empty($diff)) {
            $key = array_keys($diff)[0];
            throw new \Exception("Config has invalid value '$key'");
        }
        $this->values = $newValues;
    }

    public function getUrl(): String
    {
        return $this->values['url'];
    }

    public function getDefinition(): String
    {
        return $this->values['definition'];
    }
}
