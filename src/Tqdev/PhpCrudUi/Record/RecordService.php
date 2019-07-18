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

    private function getDropDownValues(string $relatedTable): array
    {
        $values = array();
        if ($relatedTable) {
            $pair = $this->definition->getColumnPair($relatedTable);
            $args = array('include' => implode(',', $pair));
            $data = $this->curl->getRecords($relatedTable, $args);
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

        return new TemplateDocument('layouts/default', 'record/create', $variables);
    }

    public function create(string $table, string $action, /* object */ $record): TemplateDocument
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

    public function updateForm(string $table, string $action, string $id): TemplateDocument
    {
        $references = $this->definition->getReferences($table, $action);
        $primaryKey = $this->definition->getPrimaryKey($table, $action);

        $columns = $this->definition->getColumns($table, $action);

        $record = $this->curl->getRecord($table, $id, []);

        foreach ($record as $key => $value) {
            $values = $this->getDropDownValues($references[$key]);
            $record[$key] = array('value' => $value, 'values' => $values);
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

        $affected = $this->curl->editRecord($table, $id, $record);

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

        $record = $this->curl->getRecord($table, $id, []);

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

        $affected = $this->curl->removeRecord($table, $id);

        $variables = array(
            'table' => $table,
            'action' => $action,
            'id' => $id,
            'primaryKey' => $primaryKey,
            'affected' => $affected,
        );

        return new TemplateDocument('layouts/default', 'record/deleted', $variables);
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
