<?php

namespace Tqdev\PhpCrudUi;

class Config
{
    private $values = [
        'url' => '',
        'api' => [],
        'definition' => '',
        'middlewares' => 'staticFile',
        'controllers' => 'records',
        'cacheType' => 'TempFile',
        'cachePath' => '',
        'cacheTime' => 10,
        'debug' => false,
        'basePath' => '',
        'templatePath' => '.',
        'passwordColumnFormat' => 'string',
        'passwordColumnName' => 'password$',
        'colorColumnFormat' => 'string',
        'colorColumnName' => '_color$',
        'emailColumnFormat' => 'string',
        'emailColumnName' => '_email$',
        'urlColumnFormat' => 'string',
        'urlColumnName' => '_url$',
        'pointColumnFormat' => 'geometry',
        'pointColumnName' => '_point$',
        'polygonColumnFormat' => 'geometry',
        'polygonColumnName' => '_polygon$',
    ];

    private function parseMiddlewares(array $values): array
    {
        $newValues = array();
        $properties = array();
        $middlewares = array_map('trim', explode(',', $values['middlewares']));
        foreach ($middlewares as $middleware) {
            $properties[$middleware] = [];
        }
        foreach ($values as $key => $value) {
            if (strpos($key, '.') === false) {
                $newValues[$key] = $value;
            } else {
                list($middleware, $key2) = explode('.', $key, 2);
                if (isset($properties[$middleware])) {
                    $properties[$middleware][$key2] = $value;
                } else {
                    throw new \Exception("Config has invalid value '$key'");
                }
            }
        }
        $newValues['middlewares'] = array_reverse($properties, true);
        return $newValues;
    }

    public function __construct(array $values)
    {
        $newValues = array_merge($this->values, $values);
        $newValues = $this->parseMiddlewares($newValues);
        $diff = array_diff_key($newValues, $this->values);
        if (!empty($diff)) {
            $key = array_keys($diff)[0];
            throw new \Exception("Config has invalid value '$key'");
        }
        $this->values = $newValues;
    }

    public function getMiddlewares(): array
    {
        return $this->values['middlewares'];
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

    public function getPasswordColumnFormat(): string
    {
        return $this->values['passwordColumnFormat'];
    }

    public function getPasswordColumnName(): string
    {
        return $this->values['passwordColumnName'];
    }

    public function getColorColumnFormat(): string
    {
        return $this->values['colorColumnFormat'];
    }

    public function getColorColumnName(): string
    {
        return $this->values['colorColumnName'];
    }

    public function getEmailColumnFormat(): string
    {
        return $this->values['emailColumnFormat'];
    }

    public function getEmailColumnName(): string
    {
        return $this->values['emailColumnName'];
    }

    public function getUrlColumnFormat(): string
    {
        return $this->values['urlColumnFormat'];
    }

    public function getUrlColumnName(): string
    {
        return $this->values['urlColumnName'];
    }

    public function getPointColumnFormat(): string
    {
        return $this->values['pointColumnFormat'];
    }

    public function getPointColumnName(): string
    {
        return $this->values['pointColumnName'];
    }

    public function getPolygonColumnFormat(): string
    {
        return $this->values['polygonColumnFormat'];
    }

    public function getPolygonColumnName(): string
    {
        return $this->values['polygonColumnName'];
    }
}
