<?php

namespace Tqdev\PhpCrudUi\Record;

use Tqdev\PhpCrudUi\Client\CrudApi;
use Tqdev\PhpCrudUi\Column\SpecificationService;
use Tqdev\PhpCrudUi\Document\CsvDocument;
use Tqdev\PhpCrudUi\Document\TemplateDocument;

class RecordService
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

    public function home(): TemplateDocument
    {
        return new TemplateDocument('layouts/default', 'record/home', array());
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

        return new TemplateDocument('layouts/default', 'record/create', $variables);
    }

    public function create(string $table, string $action, /* object */ $record): TemplateDocument
    {
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $id = $this->api->createRecord($table, $record);

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
        $types = $this->definition->getTypes($table, $action);
        $references = $this->definition->getReferences($table, $action);
        $referenced = $this->definition->getReferenced($table, $action);

        $args = array();
        $args['join'] = array_values(array_filter($references));
        $record = $this->api->readRecord($table, $id, $args);

        $name = $this->definition->referenceText($table, $record);

        foreach ($record as $key => $value) {
            if (!isset($references[$key])) {
                unset($record[$key]);
                continue;
            }
            $relatedTable = false;
            $relatedValue = false;
            $text = $value;
            $type = isset($types[$key]) ? $types[$key] : null;
            if (isset($references[$key]) && $references[$key]) {
                $relatedTable = $references[$key];
                if ($value) {
                    $relatedValue = $this->definition->referenceId($relatedTable, $value);
                    $text = $this->definition->referenceText($relatedTable, $value);
                }
            }
            $record[$key] = array('text' => $text, 'table' => $relatedTable, 'value' => $relatedValue, 'type' => $type);
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

        return new TemplateDocument('layouts/default', 'record/read', $variables);
    }

    public function updateForm(string $table, string $action, string $id): TemplateDocument
    {
        $types = $this->definition->getTypes($table, $action);
        $references = $this->definition->getReferences($table, $action);
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $record = $this->api->readRecord($table, $id, []);

        foreach ($record as $key => $value) {
            $values = $this->getDropDownValues($references[$key]);
            $record[$key] = array('type' => $types[$key], 'value' => $value, 'values' => $values);
        }

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $id,
            'primaryKey' => $primaryKey,
            'record' => $record,
        );

        return new TemplateDocument('layouts/default', 'record/update', $variables);
    }

    public function update(string $table, string $action, string $id, /* object */ $record): TemplateDocument
    {
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $affected = $this->api->updateRecord($table, $id, $record);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $id,
            'primaryKey' => $primaryKey,
            'affected' => $affected,
        );

        return new TemplateDocument('layouts/default', 'record/updated', $variables);
    }

    public function deleteForm(string $table, string $action, string $id): TemplateDocument
    {
        $primaryKey = $this->definition->getPrimaryKey($table, 'read');

        $record = $this->api->readRecord($table, $id, []);

        $name = $this->definition->referenceText($table, $record);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $id,
            'primaryKey' => $primaryKey,
            'name' => $name,
        );

        return new TemplateDocument('layouts/default', 'record/delete', $variables);
    }

    public function delete(string $table, string $action, string $id): TemplateDocument
    {
        $primaryKey = $this->definition->getPrimaryKey($table, 'read');

        $affected = $this->api->deleteRecord($table, $id);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $id,
            'primaryKey' => $primaryKey,
            'affected' => $affected,
        );

        return new TemplateDocument('layouts/default', 'record/deleted', $variables);
    }

    public function _list(string $table, string $action, array $params): TemplateDocument
    {
        $references = $this->definition->getReferences($table, $action);
        $referenced = $this->definition->getReferenced($table, $action);
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $columns = $this->definition->getColumns($table, $action);

        $pageParams = isset($params['page']) ? $params['page'][0] : '1,50';
        list($pageNumber, $pageSize) = explode(',', $pageParams, 2);

        $filters = array();
        $args = array();
        if (isset($params['filter'])) {
            foreach ($params['filter'] as $i => $filter) {
                $filter = array_combine(array('field', 'operator', 'value', 'name'), explode(',', $filter, 4));
                $args["filter[$i]"] = implode(',', array($filter['field'], $filter['operator'], $filter['value']));
                $filters[] = $filter;
            }
        }

        $args['join'] = array_values(array_filter($references));
        $args['page'] = "$pageNumber,$pageSize";
        $data = $this->api->listRecords($table, $args);

        foreach ($data['records'] as $i => $record) {
            foreach ($record as $key => $value) {
                if (!isset($references[$key])) {
                    unset($data['records'][$i][$key]);
                    continue;
                }
                $relatedTable = false;
                $relatedValue = $value;
                $text = $value;
                if ($references[$key]) {
                    $relatedTable = $references[$key];
                    if ($value) {
                        $relatedValue = $this->definition->referenceId($relatedTable, $value);
                        $text = $this->definition->referenceText($relatedTable, $value);
                    }
                }
                $data['records'][$i][$key] = array('text' => $text, 'table' => $relatedTable, 'value' => $relatedValue);
            }
        }

        if (!isset($data['results'])) {
            $data['results'] = count($data['records']);
        }

        $maxPage = ceil($data['results'] / $pageSize);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'filters' => $filters,
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
