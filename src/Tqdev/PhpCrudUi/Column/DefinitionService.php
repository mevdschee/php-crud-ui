<?php
namespace Tqdev\PhpCrudUi\Column;

use Tqdev\PhpCrudUi\Curl\Curl;

class DefinitionService
{

    private $curl;

    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }

    protected function getDefinition(string $url)
    {
        if (!isset($_SESSION['definition'])) {
            $_SESSION['definition'] = $this->curl->get('/openapi');
        }
        return $_SESSION['definition'];
    }

    public function resolve($definition, $path)
    {
        while (null !== ($element = array_shift($path))) {
            //echo '"'.$element.'",';
            if (!isset($definition[$element])) {
                return false;
            }

            $definition = $definition[$element];
        }
        return $definition;
    }

    public function getProperties($table, $action, $definition)
    {
        if (!$table || !$definition) {
            return false;
        }
        if ($action == 'list') {
            $path = array('components', 'schemas', $action . '-' . $table, 'properties', 'records', 'items', 'properties');
        } else {
            $path = array('components', 'schemas', $action . '-' . $table, 'properties');
        }
        return $this->resolve($definition, $path);
    }

    public function getReferences($table, $properties)
    {
        if (!$table || !$properties) {
            return false;
        }

        $references = array();
        foreach ($properties as $field => $property) {
            $references[$field] = isset($property['x-references']) ? $property['x-references'] : false;
        }
        return $references;
    }

    public function getReferenced($table, $properties)
    {
        if (!$table || !$properties) {
            return false;
        }

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

    public function getPrimaryKey($table, $properties)
    {
        if (!$table || !$properties) {
            return false;
        }

        foreach ($properties as $field => $property) {
            if (isset($property['x-primary-key'])) {
                return $field;
            }
        }
        return false;
    }
}
