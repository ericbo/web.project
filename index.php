<?php

$dir = dirname(__FILE__);

include_once($dir . '/smarty/libs/Smarty.class.php');

$smarty = new Smarty;
$smarty->display($dir . '/templates/index-bootstrap.tpl');