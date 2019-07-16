<?php
namespace Tqdev\PhpCrudUi\Record;

use Tqdev\PhpCrudApi\Record\Document\ListDocument;
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

    public function hasTable(string $table): bool
    {
        return $this->definition->hasTable($table);
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

    public function _list(string $tableName, array $params): ListDocument
    {
        $properties = $this->getProperties($table, $action, $definition);
        $references = $this->getReferences($table, $properties);
        $referenced = $this->getReferenced($table, $properties);
        $primaryKey = $this->getPrimaryKey($table, $properties);

        $table = $this->reflection->getTable($tableName);
        $this->joiner->addMandatoryColumns($table, $params);
        $columnNames = $this->columns->getNames($table, true, $params);
        $condition = $this->filters->getCombinedConditions($table, $params);
        $columnOrdering = $this->ordering->getColumnOrdering($table, $params);
        if (!$this->pagination->hasPage($params)) {
            $offset = 0;
            $limit = $this->pagination->getPageLimit($params);
            $count = 0;
        } else {
            $offset = $this->pagination->getPageOffset($params);
            $limit = $this->pagination->getPageLimit($params);
            $count = $this->db->selectCount($table, $condition);
        }
        $records = $this->db->selectAll($table, $columnNames, $condition, $columnOrdering, $offset, $limit);
        $this->joiner->addJoins($table, $records, $params, $this->db);
        return new ListDocument($records, $count);
    }
}
