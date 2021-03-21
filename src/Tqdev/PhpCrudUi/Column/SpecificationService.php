<?php

namespace Tqdev\PhpCrudUi\Column;

use Tqdev\PhpCrudApi\Cache\Cache;
use Tqdev\PhpCrudUi\Client\CrudApi;

class SpecificationService
{
    private $api;
    private $cache;
    private $ttl;

    public function __construct(CrudApi $api, Cache $cache, int $ttl)
    {
        $this->api = $api;
        $this->cache = $cache;
        $this->ttl = $ttl;
        $this->definition = $this->getDefinition();
        $this->properties = array();
    }

    private function getDefinition(): array
    {
        $data = $this->cache->get('Definition');
        if ($data) {
            $result = json_decode(gzuncompress($data), true);
        } else {
            $result = $this->api->getOpenApi();
            if ($result) {
                $data = gzcompress(json_encode($result));
                $this->cache->set('Definition', $data, $this->ttl);
            } else {
                $result = [];
            }
        }
        return $result;
    }

    private function resolve($path)
    {
        $definition = $this->definition;
        while (null !== ($element = array_shift($path))) {
            if (!isset($definition[$element])) {
                return false;
            }
            $definition = $definition[$element];
        }
        return $definition;
    }

    private function getProperties(string $table, string $action)
    {
        $key = $action . '-' . $table;
        if (!isset($this->properties[$key])) {
            if ($action == 'list') {
                $path = array('components', 'schemas', $key, 'properties', 'records', 'items', 'properties');
            } else {
                $path = array('components', 'schemas', $key, 'properties');
            }
            $this->properties[$key] = $this->resolve($path);
        }
        return $this->properties[$key];
    }

    public function hasTable(string $table, string $action): bool
    {
        return (bool) $this->getProperties($table, $action);
    }

    public function getReferences(string $table, string $action)
    {
        $properties = $this->getProperties($table, $action);

        $references = array();
        foreach ($properties as $field => $property) {
            $references[$field] = isset($property['x-references']) ? $property['x-references'] : false;
        }
        return $references;
    }

    public function getTypes(string $table, string $action)
    {
        $properties = $this->getProperties($table, $action);

        $types = array();
        foreach ($properties as $field => $property) {
            $type = $property['type'];
            $nullable = isset($property['nullable']) ? $property['nullable'] : false;
            $format = isset($property['format']) ? $property['format'] : $property['type'];
            $maxLength = isset($property['maxLength']) ? $property['maxLength'] : 0;
            $pattern = $property['pattern'];
            $hint = '';

            switch ($format) {
                case 'timestamp':
                    $hint = 'yyyy-mm-dd hh:mm:ss';
                    $maxLength = 19;
                    break;
                case 'date':
                    $hint = 'yyyy-mm-dd';
                    $maxLength = 10;
                    break;
                case 'time':
                    $hint = 'hh:mm:ss';
                    $maxLength = 8;
                    break;
                case 'decimal':
                    if (preg_match_all('/{1,([0-9]+)}/', $pattern, $matches) == 2) {
                        $maxLength = array_sum($matches[1]) + 2;
                        $decimals = $matches[1][1];
                        $hint = '#.' . str_repeat('#', $decimals);
                    }
                    break;
                case 'color':
                    $pattern = '/^#?[0-9a-fA-F]{6}$/';
                    $hint = '#3399ff';
                    $maxLength = 7;
                    break;
                case 'email':
                    $pattern = '/^.+@[^\.].*\.[a-z]{2,}$/';
                    $hint = 'xxx@xxx.xxx';
                    break;
                case 'url':
                    $pattern = '/^(ftp|http|https):\/\/.*$/';
                    $hint = 'https://...';
                    break;
                case 'point':
                    $pattern = '/^POINT\s?\(.*\)$/';
                    $hint = 'POINT(lon lat)';
                    break;
                case 'polygon':
                    $pattern = '/^POLYGON\s?\(\(.*\)\)$/';
                    $hint = 'POLYGON((lon1 lat1,lon2 lat2,lon3 lat3,lon1 lat1))';
                    break;
            }
            $types[$field] = [
                'type' => $type,
                'nullable' => $nullable,
                'format' => $format,
                'maxLength' => $maxLength,
                'hint' => $hint,
                'pattern' => $pattern,
            ];
        }
        return $types;
    }

    public function getReferenced(string $table, string $action)
    {
        $properties = $this->getProperties($table, $action);

        $referenced = array();
        foreach ($properties as $field => $property) {
            if (isset($property['x-referenced'])) {
                $referenced = array_merge($referenced, $property['x-referenced']);
            }
        }
        for ($i = 0; $i < count($referenced); $i++) {
            $referenced[$i] = explode('.', $referenced[$i]);
        }
        return $referenced;
    }

    public function getPrimaryKey(string $table, string $action)
    {
        $properties = $this->getProperties($table, $action);

        foreach ($properties as $field => $property) {
            if (isset($property['x-primary-key'])) {
                return $field;
            }
        }
        return false;
    }

    private function getDisplayColumn(string $table, string $action)
    {
        $properties = $this->getProperties($table, $action);

        foreach ($properties as $field => $property) {
            if ($property['type'] == 'string') {
                return $field;
            }
        }
        return false;
    }

    public function getColumnPair(string $table)
    {
        $primaryKey = $this->getPrimaryKey($table, 'list');
        $displayColumn = $this->getDisplayColumn($table, 'list');
        return array($primaryKey, $displayColumn);
    }

    public function getColumns(string $table, string $action): array
    {
        $properties = $this->getProperties($table, $action);
        return array_keys($properties);
    }

    public function getInfo()
    {
        $info = array();
        if (isset($this->definition['info'])) {
            $info = $this->definition['info'];
            if (!isset($info['title'])) {
                $info['title'] = 'PHP-CRUD-UI';
            }
            if (!isset($info['x-subtitle'])) {
                $info['x-subtitle'] = 'by TQdev.com';
            }
        }
        return $info;
    }

    public function getMenu()
    {
        $items = array();
        if (isset($this->definition['tags'])) {
            foreach ($this->definition['tags'] as $tag) {
                if ($this->hasTable($tag['name'], 'list')) {
                    array_push($items, $tag['name']);
                }
            }
        }
        return $items;
    }

    public function referenceText(string $table, /* object */ $record)
    {
        if (!$record) {
            return '';
        }
        $displayColumn = $this->getDisplayColumn($table, 'read');
        return $record[$displayColumn];
    }

    public function referenceId(string $table, /* object */ $record)
    {
        if (!$record) {
            return null;
        }
        $primaryKey = $this->getPrimaryKey($table, 'read');
        return $record[$primaryKey];
    }
}
