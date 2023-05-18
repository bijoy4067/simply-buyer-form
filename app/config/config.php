<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'php_form');
//App Root
define('APPROOT', dirname(dirname(__FILE__)));

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$path = dirname($_SERVER['PHP_SELF']);
$url_root = $protocol . $host . $path;

define('URLROOT', $url_root);

$script = $_SERVER['SCRIPT_NAME'];
$script = str_replace('/public', '', $script);
$baseUrl = $protocol . $host . $script; 

define('BASEURL', $baseUrl);
//site name
define('SITENAME', '_YOUR_SITENAME');