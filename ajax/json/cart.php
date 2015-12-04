<?php
session_start();
header('Content-type:application/json;charset=utf-8');
/*
* This file expects the following post variables: itemID, qty.
*/
/*
if(isset($_POST['itemID']) && isset($_POST['qty'])) {
	updateCart($_POST['itemID'], $_POST['qty']);
}
else
	echo json_encode(displayCart());
*/

function displayCart() {
	if(isset($_SESSION['cart']))
		return $_SESSION['cart'];
	return array();
}

function updateCart($itemID, $qty) {
	//Update the sessions cart
	if(isset($_SESSION['cart']))
	{
		//Check if item is already in the cart, and get its key.
		$key = array_search($_SESSION['cart'], array_column($_SESSION['cart'], $itemID));
		if($key)
		{
			if($qty < 0)
				array_plice($_SESSION['cart'], $key, 1);
			else
				if($qty <= 255)
					$_SESSION['cart']['key']['qty'] = $qty;

		}
	}
	else
		if($qty <= 255 && $qty >= 0)
		{
			if(empty($_SESSION['cart']))
				$_SESSION['cart'] = array();
			array_push($_SESSION['cart'], array("itemID"=>$itemID, "qty"=>$qty));
		}
}

function emptyCart() {
	unset($_SESSION['cart']);
}