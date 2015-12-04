<?php
//error_reporting(0);
##############################################################################
#
# Author: Ericbo
# Description:  Simple functions with no validation that interact with the MySQL
#               datebase.
#
# WARNING: Do not use require for this file, instead use connect.php.
##############################################################################

# ============================================================================
# connect to database
# 
# The function bellow is used in connect.php. The database instance is created
# as a global variable whitch is then passed to each other function bellow.
# ============================================================================

//include_once('/home/ubuntu/workspace/functions/ErrorHandling.php');

function get_db_connection()
{
    $servername = '127.0.0.1';
    $username = 'root';
    $password = "";
    $database = "c9";
    $dbport = "3306";
    $dbh = new PDO('mysql:host=' . $servername . ';dbname='. $database, $username, $password);
    return $dbh;
}

# ============================================================================
# simple credential validation
# ============================================================================
function email_exist($db, $email) {
    //Check if there is an active connection to the database.
    if (isset($db))
        //Check if there are any database errors.
        try {
            $query = $db->prepare("SELECT email FROM users WHERE email=?");
            $query->execute(array($email));
            if($query->rowCount() > 0)
                return true;
        } catch (PDOException $e) {
            //log_error($e->getCode(), $e->getMessage());
            throw new Exception('Internal Server error.');
        }
    else
        {
            //log_error(E_ERROR, "NULL database handler given in db_functions.php.");
            throw new Exception('Internal Server Error.');
        }
    return false;
}

function valid_password($db, $email, $password) {
    if(isset($db))
        try {
            //Retrive database password
            $query = $db->prepare("SELECT password FROM users WHERE email=?");
            $query->execute(array($email));
            $dbPassword = $query->fetch(PDO::FETCH_NUM)[0]; //Saw this in a video once... Only works with newer versions of php.
            //Validate password using build in hashin functions, requires php5.5
            if(password_verify($password, $dbPassword))
                return true;
        } catch (PDOException $e) {
            //log_error($e->getCode(), $e->getMessage());
            throw new Exception('Internal Server error.');
        }
    return false;
}

function create_user($db, $email, $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    if(isset($db))
        try {
            $query = $db->prepare("INSERT INTO users (email, password) VALUES (?,?)");
            return $query->execute(array($email, $hash)); //Returns false if query did not work.
        } catch (PDOException $e) {
            //log_error($e->getCode(), $e->getMessage());
            throw new Exception('Internal Server error.');
        }
    
    return false;
}

function get_products_size() {
    $dbh = get_db_connection();

    try {
        $query = $dbh->query("SELECT count(*) as num FROM products", PDO::FETCH_ASSOC);
        $rows = $query->fetch()['num'];
    } catch (PDOException $e) {
        //log_error($e->getCode(), $e->getMessage());
        throw new Exception('Internal Server error.');
    }

    return $rows;
}

function get_products($pageNumber, $pageSize, $filterString) {
    $dbh = get_db_connection();

    ######################## Get amount of rows in the table #############
    try {
        $query = $dbh->query("SELECT count(*) as num FROM products", PDO::FETCH_ASSOC);
        $rows = $query->fetch()['num'];
    } catch (PDOException $e) {
        //log_error($e->getCode(), $e->getMessage());
        throw new Exception('Internal Server error.');
    }

    ######################## Validate the page number (basic) ####################################
    if(!is_numeric($pageNumber) || $pageNumber < 0)
        $pageNumber = 1;
        else
            if ($pageNumber == 0)
            {
                $pageNumber = 1;
                $pageSize = $rows; //Set size to the amount of rows in the products table.
            }
            else
                $pageNumber = floor($pageNumber);

    ######################## Validate the page size ###################
    if(!is_numeric($pageSize) || $pageSize < 1)
        $pageSize = 10;
    else 
        $pageSize = floor($pageSize);

    ######################## Validate page number (advanced) ##############################
    $maxPageNumber = ceil($rows / $pageSize);   //Max amount of pages given the table size.
    $offset = $pageSize * ($pageNumber - 1);    //Default offset

    if($maxPageNumber < $pageNumber)            //Page number given way to large?
        if($pageSize <= $rows)                  //Is the page size larger than the amount of data in the DB?
            $offset = $rows - $pageSize;
        else
            $offset = 0;

    //Database query
    try {
        $query = $dbh->prepare("SELECT * FROM products LIMIT ?, ?");
        $query->bindParam(1, $offset, PDO::PARAM_INT);
        $query->bindParam(2, $pageSize, PDO::PARAM_INT);
        $query->execute(); //Execute does not bind ints... This provided so much greif I'm shocked my computer did not bind to my window.
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        //log_error($e->getCode(), $e->getMessage());
        throw new Exception('Internal Server error.');
    }

    //Close the database connection.
    $query = null;
    $dbh = null;

    return $result;
}

# ============================================================================
# Cart Functions
# ============================================================================

/*
* This function simply retrives all the contents of the users cart (from the database).
*/
function get_cart($userID) {
    $dbh = get_db_connection();

    try {
        $query = $dbh->prepare("SELECT * FROM cart WHERE userID = ?");
        $query->execute(array($userID));
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        //log_error($e->getCode(), $e->getMessage());
        throw new Exception('Internal Server error.');
    }

    //Close the database connection.
    $query = null;
    $dbh = null;

    return $result;
}

/*
* This function adds an item to the cart database if it does not already exist. Otherwise
* it will change the quantity of the item pased in or delete it a non-valid quantity is passed.
*/
function update_cart($userID, $itemID, $qty) {
    if(!is_numeric($qty) || !is_numeric($itemID) || !is_numeric($userID))
        return false;
    $qty = floor($qty);

    $dbh = get_db_connection();

    //Check it item is already in the users cart
    try {
        $query = $dbh->prepare("SELECT * FROM cart WHERE userID = ? AND productID = ?");
        $query->execute(array($userID, $itemID));
    } catch (PDOException $e) {
        //log_error($e->getCode(), $e->getMessage());
        throw new Exception('Internal Server error.');
    }

    if($query->rowCount())
    {
        if($qty > 0 && $qty <= 255)
            //Update Item
                try {
                    $query = $dbh->prepare("UPDATE cart SET qty = ? WHERE productID = ? AND userID = ?");
                    $query->execute(array($qty, $itemID, $userID));
                } catch (PDOException $e) {
                    //log_error($e->getCode(), $e->getMessage());
                    throw new Exception('Internal Server error.');
                }
        else
            //Delete from cart
                try {
                    $query = $dbh->prepare("DELETE FROM cart WHERE productID = ? AND userID = ?");
                    $query->execute(array($itemID, $userID));
                } catch (PDOException $e) {
                    //log_error($e->getCode(), $e->getMessage());
                    throw new Exception('Internal Server error.');
                }
    }
    else
        if($qty > 0 && $qty <= 255)
             try {
                $query = $dbh->prepare("INSERT INTO cart VALUES (?, ?, ?)");
                $query->execute(array($userID, $itemID, $qty));
            } catch (PDOException $e) {
                //log_error($e->getCode(), $e->getMessage());
                throw new Exception('Internal Server error.');
            }

    //Close the database connection.
    $query = null;
    $dbh = null;
}

function validID($userID) {
    $dbh = get_db_connection();

    try {
        $query = $dbh->prepare("SELECT * FROM user WHERE id = ?");
        $query->execute(array($userID));
    } catch (PDOException $e) {
        //log_error($e->getCode(), $e->getMessage());
        throw new Exception('Internal Server error.');
    }

    //Store result before closing DB connection
    $rows = $query->rowCount();

    //Close the database connection.
    $query = null;
    $dbh = null;

    if($rows > 0)
        return true;
    return false;
}

function clear_cart() {
    $dbh = get_db_connection();

    //Check it item is already in the users cart
    try {
        $query = $dbh->prepare("truncate cart");
        $query->execute();
    } catch (PDOException $e) {
        //log_error($e->getCode(), $e->getMessage());
        throw new Exception('Internal Server error.');
    }

    //Close the database connection.
    $query = null;
    $dbh = null;
}

# ============================================================================
# Utility functions
# ============================================================================

function truncate_users($db) {
    $query = $db->prepare("TRUNCATE TABLE users");
    
    return $query->execute();
}

//This function will return true even if a table is not created. Must be fixed...
function create_database_tables($db) {
    
    $sql = "
    DROP TABLE IF EXISTS users;
    CREATE TABLE users 
    (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) unique,
        password VARCHAR(64)
    );
    ";
    
    $query = $db->prepare($sql);

    return $query->execute();
}
