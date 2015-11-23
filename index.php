<?php

$dir = dirname(__FILE__);

include_once($dir . '/smarty/libs/Smarty.class.php');

$smarty = new Smarty;
$smarty->assign('baseURL', get_base_url());
$smarty->display($dir . '/templates/index-bootstrap.tpl');

/*
* Used to determin the url that points to the web servers root.
*/
function get_base_url() {
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
		return 'https://' . $_SERVER['SERVER_NAME'] . '/';
	else
		return 'http://' . $_SERVER['SERVER_NAME'] . '/';
}