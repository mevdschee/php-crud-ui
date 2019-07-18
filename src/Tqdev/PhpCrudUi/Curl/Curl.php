<?php
namespace Tqdev\PhpCrudUi\Curl;

class Curl
{
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getOpenApi()
    {
        return $this->call('GET', '/openapi');
    }

    public function getRecords(string $table, array $args)
    {
        return $this->call('GET', '/records/' . urlencode($table), $args);
    }

    public function getRecord(string $table, string $id, array $args)
    {
        return $this->call('GET', '/records/' . urlencode($table) . '/' . urlencode($id), $args);
    }

    public function addRecord(string $table, $record)
    {
        return $this->call('POST', '/records/' . urlencode($table), [], $record);
    }

    public function removeRecord(string $table, string $id)
    {
        return $this->call('DELETE', '/records/' . urlencode($table) . '/' . urlencode($id));
    }

    public function editRecord(string $table, string $id, $record)
    {
        return $this->call('PUT', '/records/' . urlencode($table) . '/' . urlencode($id), [], $record);
    }

    private function call(string $method, string $path, array $args = [], $data = false)
    {
        $query = rtrim('?' . preg_replace('|%5B[0-9]+%5D|', '', http_build_query($args)), '?');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $this->url . $path . $query);
        if ($data) {
            $content = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Content-Length: ' . strlen($content);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

}
