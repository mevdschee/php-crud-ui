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

    private function call(string $method, string $path, array $args = [], $data = false)
    {
        $query = rtrim('?' . preg_replace('|%5B[0-9]+%5D|', '', http_build_query($args)), '?');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $this->url . $path . $query);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Content-Length: ' . strlen($data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

}
