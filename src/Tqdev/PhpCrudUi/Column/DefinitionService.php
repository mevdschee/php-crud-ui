<?php
namespace Tqdev\PhpCrudUi\Column;

use Tqdev\PhpCrudUi\Curl\Curl;

class DefinitionService
{

    private $curl;

    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
        $this->definition = $this->getDefinition();
        $this->properties = array();
    }

    private function getDefinition(): array
    {
        if (!isset($_SESSION['definition'])) {
            $_SESSION['definition'] = $this->curl->getOpenApi();
        }
        return $_SESSION['definition'];
    }

    private function resolve($path)
    {
        $definition = $this->definition;
        while (null !== ($element = array_shift($path))) {
            //echo '"'.$element.'",';
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

    private function getDisplayColumn($columns)
    {
        // TODO: make configurable
        $names = array('name', 'title', 'description', 'username');
        foreach ($names as $name) {
            if (in_array($name, $columns)) {
                return $name;
            }

        }
        return $columns[0];
    }

    public function getColumns(string $table, string $action): array
    {
        $properties = $this->getProperties($table, $action);
        return array_keys($properties);
    }

    public function getMenu()
    {
        $items = array();
        if (isset($this->definition['tags'])) {
            foreach ($this->definition['tags'] as $tag) {
                array_push($items, $tag['name']);
            }
        }
        return $items;
    }

    public function referenceText(string $table, /* object */ $record)
    {
        $properties = $this->getProperties($table, 'read');
        $displayColumn = $this->getDisplayColumn(array_keys($properties));
        return $record[$displayColumn];
    }

    public function referenceId(string $table, /* object */ $record)
    {
        $properties = $this->getProperties($table, 'read');
        $primaryKey = $this->getPrimaryKey($table, 'read');
        return $record[$primaryKey];
    }

}
