<?php

class Helper
{
    public function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname($_SERVER['PHP_SELF']);

        return $protocol . $host . $path;
    }

    public function response($code, $data)
    {
        http_response_code($code);
        echo json_encode($data);
    }

    public function rand_str($length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $randomString = substr(str_shuffle($characters), 0, $length);
        return $randomString;
    }
}
?>