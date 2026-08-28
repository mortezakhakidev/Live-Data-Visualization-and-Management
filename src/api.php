<?php
// include req 
require 'vendor/autoload.php';
require 'database.php';
require 'post.php';

use Src\Post;
use Src\Database;

$dbConnection = (new Database())->connet();

// set header params
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// get request methods: GET,POST,PUT,DELETE
$requestMethod = $_SERVER["REQUEST_METHOD"];


// pass the request method and post ID to the Post and process the HTTP request:

$controller = new Post($dbConnection, $requestMethod, $_GET['id']);

$controller->processRequest();