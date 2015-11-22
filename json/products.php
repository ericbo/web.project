<?php
header('Content-type:application/json;charset=utf-8');
$dir = dirname(__FILE__);

include_once($dir . '/../functions/db_functions.php');

//Get page
if(isset($_GET['page']) && is_numeric($_GET['page']))
	$page = $_GET['page'];
else
	$page = 1;

//Get page size
if(isset($_GET['size']) && is_numeric($_GET['size']))
	$size = $_GET['size'];
else
	$size = 10;

try {
	echo json_encode(get_products($page, $size, ''));
} catch(Exception $e) {
	header("HTTP/1.0 500 Internal Error");
}