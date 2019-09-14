<?php

namespace Tqdev\PhpCrudUi;

class Config
{
    private $values = [
        'url' => '',
        'api' => [],
        'definition' => '',
        'controllers' => 'records',
        'cacheType' => 'TempFile',
        'cachePath' => '',
        'cacheTime' => 10,
        'debug' => false,
        'basePath' => '',
        'templatePath' => '.',
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

    public function getControllers(): array
    {
        return array_map('trim', explode(',', $this->values['controllers']));
    }

    public function getUrl(): String
    {
        return $this->values['url'];
    }

    public function getApi(): array
    {
        return $this->values['api'];
    }

    public function getDefinition(): String
    {
        return $this->values['definition'];
    }

    public function getCacheType(): string
    {
        return $this->values['cacheType'];
    }

    public function getCachePath(): string
    {
        return $this->values['cachePath'];
    }

    public function getCacheTime(): int
    {
        return $this->values['cacheTime'];
    }

    public function getDebug(): bool
    {
        return $this->values['debug'];
    }

    public function getBasePath(): string
    {
        return $this->values['basePath'];
    }

    public function getTemplatePath(): string
    {
        return $this->values['templatePath'];
    }
}
