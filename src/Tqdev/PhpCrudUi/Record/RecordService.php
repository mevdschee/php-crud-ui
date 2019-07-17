<?php
namespace Tqdev\PhpCrudUi\Record;

use Tqdev\PhpCrudUi\Column\DefinitionService;
use Tqdev\PhpCrudUi\Curl\Curl;

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

    public function getType(string $table): string
    {
        return $this->definition->getType($table);
    }

    public function create(string $tableName, /* object */ $record, array $params) /*: ?int*/
    {
        $this->sanitizeRecord($tableName, $record, '');
        $table = $this->reflection->getTable($tableName);
        $columnValues = $this->columns->getValues($table, true, $record, $params);
        return $this->db->createSingle($table, $columnValues);
    }

    public function read(string $tableName, string $id, array $params) /*: ?object*/
    {
        $table = $this->reflection->getTable($tableName);
        $this->joiner->addMandatoryColumns($table, $params);
        $columnNames = $this->columns->getNames($table, true, $params);
        $record = $this->db->selectSingle($table, $columnNames, $id);
        if ($record == null) {
            return null;
        }
        $records = array($record);
        $this->joiner->addJoins($table, $records, $params, $this->db);
        return $records[0];
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

    public function _list(string $table, string $action, string $field, string $id, string $name, array $params) /*: object */
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

        return array(
            '__layout' => 'layouts/default',
            '__view' => 'record/list',
            'table' => $table,
            'action' => $action,
            'field' => $field,
            'id' => $id,
            'name' => $name,
            'primaryKey' => $primaryKey,
            'columns' => $columns,
            'records' => $data['records'],
        );

        $maxPage = ceil($data['results'] / $pageSize);
        if ($maxPage > 1) {
            $html .= '<div style="float:right">';
            $html .= "page $pageNumber / $maxPage ";
            if ($pageNumber - 1 >= 1) {
                $href = '?page=' . ($pageNumber - 1) . ',' . $pageSize;
                $html .= '<a href="' . $href . '" class="btn btn-default">&lt;</a> ';
            } else {
                $html .= '<a href="javascript:void(0);" class="btn btn-default" disabled>&lt;</a> ';
            }
            if ($pageNumber + 1 <= $maxPage) {
                $href = '?page=' . ($pageNumber + 1) . ',' . $pageSize;
                $html .= '<a href="' . $href . '" class="btn btn-default">&gt;</a> ';
            } else {
                $html .= '<a href="javascript:void(0);" class="btn btn-default" disabled>&gt;</a> ';
            }
            $html .= '</div>';
        }

        if ($primaryKey) {
            $href = $this->url($table, 'create');
            $html .= '<a href="' . $href . '" class="btn btn-primary">Add</a> ';
        }

        if ($related) {
            $html .= '<br/><br/><h4>Related</h4>';
            $html .= '<ul>';
            foreach ($references as $field => $relation) {
                if ($relation) {
                    $href = $this->url($relation, 'list');
                    $html .= '<li><a href="' . $href . '">' . $relation . '</a></li>';
                }
            }
            foreach ($referenced as $relation) {
                $href = $this->url($relation[0], 'list');
                $html .= '<li><a href="' . $href . '">' . $relation[0] . '</a></li>';
            }
            $html .= '</ul>';
        }

        return $html;
    }
}
