<?php

namespace Tqdev\PhpCrudUi\Record;

use Tqdev\PhpCrudUi\Client\CrudApi;
use Tqdev\PhpCrudUi\Column\SpecificationService;
use Tqdev\PhpCrudUi\Document\TemplateDocument;
use Tqdev\PhpCrudUi\Document\CsvDocument;

class ColumnService
{
    private $api;
    private $definition;

    public function __construct(CrudApi $api, SpecificationService $definition)
    {
        $this->api = $api;
        $this->definition = $definition;
    }

    public function hasTable(string $table, string $action): bool
    {
        return $this->definition->hasTable($table, $action);
    }

    private function getColumnFields(): array
    {
        return ['name', 'type', 'length', 'precision', 'scale', 'nullable', 'pk', 'fk'];
    }

    private function fillSparse(array &$array, array $keys)
    {
        foreach ($keys as $key) {
            if (!key_exists($key, $array)) {
                $array[$key] = null;
            }
        }
    }

    private function fillAllSparse(array &$array, array $keys)
    {
        foreach (array_keys($array) as $i) {
            $this->fillSparse($array[$i], $keys);
        }
    }

    private function getDropDownValues(string $relatedTable): array
    {
        $values = array();
        if ($relatedTable) {
            $pair = $this->definition->getColumnPair($relatedTable);
            $args = array('include' => implode(',', $pair));
            $data = $this->api->listRecords($relatedTable, $args);
            foreach ($data['records'] as $record) {
                if (count($pair) > 1) {
                    $values[$record[$pair[0]]] = $record[$pair[1]];
                } else {
                    $values[$record[$pair[0]]] = $record[$pair[0]];
                }
            }
        }
        return $values;
    }

    public function createForm(string $table, string $action): TemplateDocument
    {
        $references = $this->definition->getReferences($table, $action);
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $columns = $this->definition->getColumns($table, $action);

        foreach ($columns as $i => $column) {
            $values = $this->getDropDownValues($references[$column]);
            $columns[$i] = array('name' => $column, 'values' => $values);
        }

        $variables = array(
            'table' => $table,
            'action' => $action,
            'columns' => $columns,
            'primaryKey' => $primaryKey,
        );

        return new TemplateDocument('layouts/default', 'column/create', $variables);
    }

    public function create(string $table, string $action, /* object */ $record): TemplateDocument
    {
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $name = $this->api->createRecord($table, $record);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $name,
            'primaryKey' => $primaryKey,
        );

        return new TemplateDocument('layouts/default', 'column/created', $variables);
    }

    public function read(string $table, string $action, string $name): TemplateDocument
    {
        $columnFields = $this->getColumnFields();

        $record = $this->api->readColumn($table, $name, array());
        $this->fillSparse($record, $columnFields);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'name' => $name,
            'record' => $record,
        );

        return new TemplateDocument('layouts/default', 'column/read', $variables);
    }

    public function updateForm(string $table, string $action, string $name): TemplateDocument
    {
        $references = $this->definition->getReferences($table, $action);
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $record = $this->api->readRecord($table, $name, []);

        foreach ($record as $key => $value) {
            $values = $this->getDropDownValues($references[$key]);
            $record[$key] = array('value' => $value, 'values' => $values);
        }

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $name,
            'primaryKey' => $primaryKey,
            'record' => $record,
        );

        return new TemplateDocument('layouts/default', 'column/update', $variables);
    }

    public function update(string $table, string $action, string $name, /* object */ $record): TemplateDocument
    {
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $affected = $this->api->updateRecord($table, $name, $record);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $name,
            'primaryKey' => $primaryKey,
            'affected' => $affected,
        );

        return new TemplateDocument('layouts/default', 'column/updated', $variables);
    }

    public function deleteForm(string $table, string $action, string $name): TemplateDocument
    {
        $primaryKey = $this->definition->getPrimaryKey($table, 'read');

        $record = $this->api->readRecord($table, $name, []);

        $name = $this->definition->referenceText($table, $record);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $name,
            'primaryKey' => $primaryKey,
            'name' => $name,
        );

        return new TemplateDocument('layouts/default', 'column/delete', $variables);
    }

    public function delete(string $table, string $action, string $name): TemplateDocument
    {
        $primaryKey = $this->definition->getPrimaryKey($table, 'read');

        $affected = $this->api->deleteRecord($table, $name);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $name,
            'primaryKey' => $primaryKey,
            'affected' => $affected,
        );

        return new TemplateDocument('layouts/default', 'column/deleted', $variables);
    }

    public function _list(string $table, string $action): TemplateDocument
    {
        $columnFields = $this->getColumnFields();

        $data = $this->api->listColumns($table, array());
        $this->fillAllSparse($data['columns'], $columnFields);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'columns' => $columnFields,
            'records' => $data['columns'],
        );

        return new TemplateDocument('layouts/default', 'column/list', $variables);
    }

    public function export(string $table, string $action): CsvDocument
    {
        $references = $this->definition->getReferences($table, $action);

        $columns = $this->definition->getColumns($table, $action);

        $args = array();
        $args['join'] = array_values(array_filter($references));
        $data = $this->api->listRecords($table, $args);

        foreach ($data['records'] as $i => $record) {
            foreach ($record as $key => $value) {
                if ($references[$key]) {
                    $value = $this->definition->referenceText($references[$key], $record[$key]);
                    $data['records'][$i][$key] = $value;
                }
            }
        }

        $variables = array(
            'table' => $table,
            'action' => $action,
            'columns' => $columns,
            'records' => $data['records'],
        );

        return new CsvDocument($variables);
    }
}
