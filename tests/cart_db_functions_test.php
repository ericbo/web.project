<?php
// ##################################################################
// # Description: This file tests the following database functions:
// # 	update_cart(userID, productID, quantity) and get_cart(userID).
// # TODO: The entire database schema has not been fully normalized,
// # thus some test that rely on the database validation have not yet
// # been implimented.
// ##################################################################

// Include db file.
$dir = dirname(__FILE__);
include_once($dir . '/../functions/db_functions.php');

//Sanatize the test inviornment
createTable();

// ############### Test 1.0: Add 4 items to the cart ###############
update_cart(1,1,1);
update_cart(1,4,12);
update_cart(1,2,8);
update_cart(1,7,8);

$cart = get_cart(1);

if(count($cart) == 4 && $cart[2]['qty'] == 12 && $cart[3]['productID'] == 7)
	passMessage(1.0, "Items inserted into cart without a hitch!");
else
{
	failMessage(1.0, "Could not add items to cart.");
}

// ############### Test 1.1: Remove two previous items ###############
update_cart(1,1,0);
update_cart(1,2,0);

if(count(get_cart(1)) != 2)
	failMessage(1.1, "Could not delete items from cart. Expected cart size: 2, Actuall: " . count(get_cart(1)));
else
	passMessage(1.1, "Item's deleted from cart without a hitch!");

// ############### Test 1.2: Update item quantities ###############
update_cart(1,4,1);
update_cart(1,7,244);
$cart = get_cart(1);

if($cart[0]['qty'] == 1 && $cart[1]['qty'] == 244)
	passMessage(1.2, "Cart item's updated without a hitch!");
else
	failMessage(1.2, "Could not update existing cart items!");

// ############### Test 2.0: Pass a quantity too large for the DB ###############
if(update_cart(1,7,246))
	failMessage(2.0, "You should never see this alone, an unhandled exception should be thrown.");
else
	passMessage(2.0, "Could not add a qty to large for the DB.");

// ############### Test 2.1: Pass a quantity too small for the DB, should delete row ###############
update_cart(1,4,-255);
update_cart(1,7,-2000000);
$cart = get_cart(1);

if(count($cart))
	failMessage(2.1, "Negative numbers should delete row from the cart table. Cart should be empty, not have " . count($cart) . " items.");
else
	passMessage(2.1, "Negative qty deletes rows.");

// ############### Test 2.2: Pass an item that does not exist ###############
warningMessage(2.2, "Forign keys must be added befor this test can be... tested?");

// ############### Test 2.3: Pass a userID that does not exist ###############
warningMessage(2.3, "Forign keys must be added befor this test can be... tested?");

// ############### Test 3: Pass strings into the quantity argument ###############
if(update_cart(1,4,"Twenty"))
	failMessage(3, "Passing a string for a quantity should not effect the database.");
else
	passMessage(3, "Using a string instead of an int for quantity does nothing.");

// ############### Test 3.1: Pass strings into the item argument ###############
if(update_cart(1,"shoes",20))
	failMessage(3.1, "Passing a string for a item should not effect the database.");
else
	passMessage(3.1, "Using a string instead of an int for item does nothing.");

// ############### Test 3.2: Pass strings into the user argument ###############
if(update_cart("eric",4,20))
	failMessage(3.2, "Passing a string for a user should not effect the database.");
else
	passMessage(3.2, "Using a string instead of an int for user does nothing.");

// ############### Test 4.0: Passing a decimal number for a quantity should be rounded down ###############
update_cart(1,7,4.99);
$cart = get_cart(1);
if($cart[0]['qty'] == 4)
	passMessage(4, "Decimal quantity was rounded down.");
else
	failMessage(4, "Decimal quantity was not rounded down.");

// ############### Test 4.1: Passing a decimal number for a user should be rounded down ###############
warningMessage(4.1, "Forign keys must be added befor this test can be... tested?");
// ############### Test 4.2: Passing a decimal number for a item should be rounded down ###############
warningMessage(4.2, "Forign keys must be added befor this test can be... tested?");

//Sanitize table after tests.
clear_cart();

// ############### Error output functions ###############
function failMessage($number, $message) {
	echo "Test {$number}: <span style=\"color: red;\">has failed!</span><br>";
	echo "<span style=\"margin-left: 25px;\">$message</span><br><br>";
}

function passMessage($number, $message) {
	echo "Test {$number}: <span style=\"color: green;\">has passed!</span><br>";
	echo "<span style=\"margin-left: 25px;\">$message</span><br><br>";
}

function warningMessage($number, $message) {
	echo "Test {$number}: <span style=\"color: darkorange;\">Not Implimented!</span><br>";
	echo "<span style=\"margin-left: 25px;\">$message</span><br><br>";
}

// ############### Database creating funtions ###############
function createTable() {
	$dbh = get_db_connection();

	$table = "
	CREATE TABLE cart(
		userID INT,
		productID INT,
		qty TINYINT UNSIGNED NOT NULL,
		PRIMARY KEY(userID, productID),
		UNIQUE(userID, productID)
	)";
	
	try {
    $query = $dbh->prepare("DROP TABLE IF EXISTS cart");
    $query->execute();
    $query = $dbh->prepare($table);
    $query->execute();
  } catch (PDOException $e) {
  	echo $e->getMessage();
  }
}