<?php

namespace Tqdev\PhpCrudUi\Client;

class CrudApi
{
    private $caller;

    public function __construct(ApiCaller $caller)
    {
        $this->caller = $caller;
    }

    public function getOpenApi()
    {
        return $this->caller->call('GET', '/openapi');
    }

    public function listRecords(string $table, array $args)
    {
        return $this->caller->call('GET', '/records/' . rawurlencode($table), $args);
    }

    public function readRecord(string $table, string $id, array $args)
    {
        return $this->caller->call('GET', '/records/' . rawurlencode($table) . '/' . rawurlencode($id), $args);
    }

    public function createRecord(string $table, $record)
    {
        return $this->caller->call('POST', '/records/' . rawurlencode($table), [], $record);
    }

    public function deleteRecord(string $table, string $id)
    {
        return $this->caller->call('DELETE', '/records/' . rawurlencode($table) . '/' . rawurlencode($id));
    }

    public function updateRecord(string $table, string $id, $record)
    {
        return $this->caller->call('PUT', '/records/' . rawurlencode($table) . '/' . rawurlencode($id), [], $record);
    }
}
