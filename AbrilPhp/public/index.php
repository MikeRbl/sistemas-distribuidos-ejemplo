<?php
require_once '../vendor/autoload.php';
use Router\router;

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$HEADERS = getallheaders();

$requestUri = rute(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$httpMethod = $_SERVER['REQUEST_METHOD'];

Router::handle($httpMethod, $requestUri, $HEADERS);

function rute(String $url){
    $parts = explode('/', $url);
    $publicIndex = array_search('public', $parts);

    if($publicIndex !== false && isset($parts[$publicIndex + 1])){
        $routeParts = array_slice($parts, $publicIndex + 1);
        return implode('/',$routeParts);
    }else{
        return "";
    }
}