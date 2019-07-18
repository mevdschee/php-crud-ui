<?php
namespace Tqdev\PhpCrudUi\Record;

use Tqdev\PhpCrudUi\Column\DefinitionService;
use Tqdev\PhpCrudUi\Curl\Curl;
use Tqdev\PhpCrudUi\Document\TemplateDocument;

class RecordService
{
    private $curl;
    private $definition;

    public function __construct(Curl $curl, DefinitionService $definition)
    {
        $this->curl = $curl;
        $this->definition = $definition;
    }

    public function hasTable(string $table, string $action): bool
    {
        return $this->definition->hasTable($table, $action);
    }

    public function createForm(string $table, string $action): TemplateDocument
    {
        $references = $this->definition->getReferences($table, $action);
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $columns = $this->definition->getColumns($table, $action);

        foreach ($columns as $i => $column) {
            $name = $column;
            $pairs = false;
            if ($references[$name]) {
                $relatedTable = $references[$name];

                $pair = $this->definition->getColumnPair($relatedTable, $action);
                $args = array('include' => implode(',', $pair));
                $data = $this->curl->getRecords($relatedTable, $args);
                $pairs = array();
                foreach ($data['records'] as $record) {
                    if (count($pair) > 1) {
                        $pairs[$record[$pair[0]]] = $record[$pair[1]];
                    } else {
                        $pairs[$record[$pair[0]]] = $record[$pair[0]];
                    }
                }
            }
            $columns[$i] = array('name' => $name, 'values' => $pairs);
        }

        $variables = array(
            'table' => $table,
            'action' => $action,
            'columns' => $columns,
            'primaryKey' => $primaryKey,
        );

        return new TemplateDocument('layouts/default', 'record/create', $variables);
    }

    public function create(string $table, string $action, $record): TemplateDocument
    {
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $id = $this->curl->addRecord($table, $record);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $id,
            'primaryKey' => $primaryKey,
        );

        return new TemplateDocument('layouts/default', 'record/created', $variables);
    }

    public function read(string $table, string $action, string $id, array $params): TemplateDocument
    {
        $references = $this->definition->getReferences($table, $action);
        $referenced = $this->definition->getReferenced($table, $action);
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $columns = $this->definition->getColumns($table, $action);

        $args = array();
        $args['join'] = array_values(array_filter($references));
        $record = $this->curl->getRecord($table, $id, $args);

        $name = $this->definition->referenceText($table, $record);

        foreach ($record as $key => $value) {
            $relatedTable = false;
            $relatedId = false;
            $text = $value;
            if ($references[$key]) {
                $relatedTable = $references[$key];
                $relatedId = $this->definition->referenceId($relatedTable, $value);
                $text = $this->definition->referenceText($relatedTable, $value);
            }
            $record[$key] = array('text' => $text, 'table' => $relatedTable, 'id' => $relatedId);
        }

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $id,
            'name' => $name,
            'references' => $references,
            'referenced' => $referenced,
            'record' => $record,
        );

        return new TemplateDocument('layouts/default', 'record/view', $variables);
    }

    public function update(string $tableName, string $id, /* object */ $record, array $params) /*: ?int*/
    {
        $this->sanitizeRecord($tableName, $record, $id);
        $table = $this->reflection->getTable($tableName);
        $columnValues = $this->columns->getValues($table, true, $record, $params);
        return $this->db->updateSingle($table, $columnValues, $id);
    }

    public function delete(string $tableName, string $id, array $params) /*: ?int*/
    {
        $table = $this->reflection->getTable($tableName);
        return $this->db->deleteSingle($table, $id);
    }

    private function url($table, $action, $id = '', $field = '', $name = '')
    {
        return rtrim("/src/$table/$action/$id/$field/$name", '/');
    }

    public function _list(string $table, string $action, string $field, string $id, string $name, array $params): TemplateDocument
    {
        $references = $this->definition->getReferences($table, $action);
        $referenced = $this->definition->getReferenced($table, $action);
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $columns = $this->definition->getColumns($table, $action);

        list($pageNumber, $pageSize) = explode(',', @$_GET['page'] ?: '1,5', 2);

        $args = array();
        if ($field) {
            $args['filter'] = $field . ',eq,' . $id;
        }
        $args['join'] = array_values(array_filter($references));
        $args['page'] = "$pageNumber,$pageSize";
        $data = $this->curl->getRecords($table, $args);

        foreach ($data['records'] as $i => $record) {
            foreach ($record as $key => $value) {
                if ($references[$key]) {
                    $value = $this->definition->referenceText($references[$key], $record[$key]);
                    $data['records'][$i][$key] = $value;
                }
            }
        }

        $maxPage = ceil($data['results'] / $pageSize);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'field' => $field,
            'id' => $id,
            'name' => $name,
            'references' => $references,
            'referenced' => $referenced,
            'primaryKey' => $primaryKey,
            'columns' => $columns,
            'records' => $data['records'],
            'maxPage' => $maxPage,
            'pageNumber' => $pageNumber,
            'pageSize' => $pageSize,
        );

        return new TemplateDocument('layouts/default', 'record/list', $variables);
    }
}
