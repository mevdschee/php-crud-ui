<?php
namespace Tqdev\PhpCrudUi\Curl;

class Curl
{
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function get(string $path)
    {
        return $this->call('GET', $path);
    }

    private function call(string $method, string $path, $data = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $this->url . $path);
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
