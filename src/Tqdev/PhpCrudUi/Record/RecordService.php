<?php

namespace Tqdev\PhpCrudUi\Record;

use Tqdev\PhpCrudUi\Client\CrudApi;
use Tqdev\PhpCrudUi\Column\SpecificationService;
use Tqdev\PhpCrudUi\Document\CsvDocument;
use Tqdev\PhpCrudUi\Document\RedirectDocument;
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
        $types = $this->definition->getTypes($table, $action);
        $references = $this->definition->getReferences($table, $action);
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $columns = $this->definition->getColumns($table, $action);
        $record = array();
        foreach ($columns as $column) {
            $values = $this->getDropDownValues($references[$column]);
            $type = $types[$column];
            //TODO: sensible default
            $default = '';
            $record[$column] = array('value' => $default, 'values' => $values, 'type' => $type);
        }

        $variables = array(
            'table' => $table,
            'action' => $action,
            'record' => $record,
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
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

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
            $type = $types[$key];
            if (isset($references[$key]) && $references[$key]) {
                $relatedTable = $references[$key];
                $relatedValue = $this->definition->referenceId($relatedTable, $value);
                $text = $this->definition->referenceText($relatedTable, $value);
            }
            $record[$key] = array('text' => $text, 'table' => $relatedTable, 'value' => $relatedValue, 'type' => $type);
        }

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $id,
            'name' => $name,
            'primaryKey' => $primaryKey,
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
        $name = $this->definition->referenceText($table, $record);

        foreach ($record as $key => $value) {
            $values = $this->getDropDownValues($references[$key]);
            $type = $types[$key];
            $record[$key] = array('value' => $value, 'values' => $values, 'type' => $type);
        }

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $id,
            'name' => $name,
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
            'name' => $name,
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

    private function getArguments(array $types, array $filters): array
    {
        $args = array();
        $i = 0;
        foreach ($filters as $filter) {
            if ($filter['type'] == 'search') {
                $j = 0;
                foreach ($types as $column => $type) {
                    switch ($type['type']) {
                        case 'string':
                            $args["filter${j}[0]"] = implode(',', array($column, $filter['operator'], $filter['value']));
                            $j++;
                            break;
                    }
                }
            } elseif ($filter['type'] == 'value') {
                $args["filter[$i]"] = implode(',', array($filter['field'], $filter['operator'], $filter['value']));
                $i++;
            } elseif ($filter['type'] == 'reference') {
                $args["filter[$i]"] = implode(',', array($filter['field'], $filter['operator'], implode('|', explode(',', $filter['value']))));
                $i++;
            }
        }
        return $args;
    }

    private function getFilters(array $references, array $params): array
    {
        $filters = array();
        if (isset($params['filter'])) {
            foreach ($params['filter'] as $filter) {
                $type = substr($filter, 0, strpos($filter, ','));
                if ($type == 'search') {
                    $filter = array_combine(array('type', 'operator', 'value'), explode(',', $filter, 3));
                    $filter['field'] = '*any*';
                } elseif ($type == 'value') {
                    $filter = array_combine(array('type', 'field', 'operator', 'value'), explode(',', $filter, 4));
                    $filter['text'] = $filter['value'];
                } elseif ($type == 'reference') {
                    $filter = array_combine(array('type', 'field', 'operator', 'value', 'text'), explode(',', $filter, 5));
                    $filter['value'] = implode(',', explode('|', $filter['value']));
                }
                $filters[] = $filter;
            }
        }
        return $filters;
    }

    private function getParams(array $references, array $filters): array
    {
        $params = ['filter' => []];
        foreach ($filters as $filter) {
            if ($filter['type'] == 'search') {
                $param = $filter['type'] . ',' . $filter['operator'] . ',' . $filter['value'];
            } elseif ($filter['type'] == 'value') {
                $param = $filter['type'] . ',' . $filter['field'] . ',' . $filter['operator'] . ',' . $filter['value'];
            } elseif ($filter['type'] == 'reference') {
                $param = $filter['type'] . ',' . $filter['field'] . ',' . $filter['operator'] . ',' . implode('|', explode(',', $filter['value'])) . ',' . $filter['text'];
            }
            $params['filter'][] = $param;
        }
        return $params;
    }

    public function _list(string $table, string $action, array $params): TemplateDocument
    {
        $types = $this->definition->getTypes($table, $action);
        $references = $this->definition->getReferences($table, $action);
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $columns = $this->definition->getColumns($table, $action);

        $pageParams = isset($params['page']) ? $params['page'][0] : '1,50';
        list($pageNumber, $pageSize) = explode(',', $pageParams, 2);

        $filters = $this->getFilters($references, $params);
        $args = $this->getArguments($types, $filters);

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
                $type = $types[$key];
                if ($references[$key]) {
                    $relatedTable = $references[$key];
                    $relatedValue = $this->definition->referenceId($relatedTable, $value);
                    $text = $this->definition->referenceText($relatedTable, $value);
                }
                $data['records'][$i][$key] = array('text' => $text, 'table' => $relatedTable, 'value' => $relatedValue, 'type' => $type);
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
            'primaryKey' => $primaryKey,
            'columns' => $columns,
            'records' => $data['records'],
            'maxPage' => $maxPage,
            'pageNumber' => $pageNumber,
            'pageSize' => $pageSize,
        );

        return new TemplateDocument('layouts/default', 'record/list', $variables);
    }

    public function search(string $table, array $body, array $params)
    {
        $action = 'list';
        $references = $this->definition->getReferences($table, $action);

        $filters = $this->getFilters($references, $params);

        if (isset($body['search'])) {
            foreach ($filters as $i => $filter) {
                if ($filter['type'] == 'search') {
                    unset($filters[$i]);
                }
            }
            $filters = array_values($filters);
            $filters[] = ['type' => 'search', 'field' => '*any*', 'operator' => 'cs', 'value' => $body['search']];
        }
        if (isset($body['value'])) {
            if (isset($references[$body['field']]) && $references[$body['field']]) {
                $otherTable = $references[$body['field']];
                $otherKey = $this->definition->getPrimaryKey($otherTable, $action);
                $otherTypes = $this->definition->getTypes($otherTable, $action);
                $args = $this->getArguments($otherTypes, [['type' => 'search', 'field' => '*any*', 'operator' => 'cs', 'value' => $body['value']]]);
                $args['include'] = $otherKey;
                $records = $this->api->listRecords($otherTable, $args);
                $values = array_map(function ($a) use ($otherKey) {return $a[$otherKey];}, $records['records']);
                $filters[] = ['type' => 'reference', 'field' => $body['field'], 'operator' => 'in', 'value' => implode(',', $values), 'text' => $body['value']];
            } else {
                $filters[] = ['type' => 'value', 'field' => $body['field'], 'operator' => 'cs', 'value' => $body['value']];
            }
        }
        $params = $this->getParams($references, $filters);
        $query = http_build_query($params);
        return new RedirectDocument('/' . $table . '/list?' . $query, []);
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
