<?php
header('Content-type:application/json;charset=utf-8');

$dir = dirname(__FILE__);

include_once($dir . '/../functions/db_functions.php');

try {
	$data['size'] = get_products_size();
	echo json_encode($data);
}
catch (Exception $e) {
	header("HTTP/1.0 500 Internal Error");
}