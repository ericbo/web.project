<pre>
<?php
    require ("../functions/db_functions.php");

# =========================================================================
# This test file tests the functionality of the function get_products
# ... these are unit tests and run on the server (no posting, etc)
# ==========================================================================
#
# Requirements for get_products:
#   inputs: page number, page size, filter string
#   outputs: an array of associative arrays...
#            example:
#              data[0][price]   # price of product 
#              data[0][name]
#              data[0][descr]
#              data[0][image]   # url pointing to a picture
#
# Special Cases:
# ==============
#   if page set to invalid number (-1, 'x'), set to page 1
#   page number and page size will be rounded down to the nearest integer
#   if page set to zero, return all records
#   if page size set to zero or less (or invalid #), set page size to 10
#   if page number so large that no records will be returned, return the last
#     'page size' rows of the table.
#     Example:  313 records in table
#            :  page requested 999
#            :  page size 10
#            :  return the last 10 rows of the table, i.e. 
#            :    304,305,306,307,308,309,310,311,312,313
#
# ==========================================================================
# Database Design:
#    table:  products
#    columns:
#       id autoincrement primary key
#       name varchar(128)
#       descr text
#       image varchar(256)
#       price float (6,2)
# ==========================================================================

# ==========================================================================
# Step 1, Set up the database table into a known state, so that I know
#         what the results will be.
# ==========================================================================
$table_name = 'products';
create_table($table_name);

# ********************************************************************
# for the following tests, I want to have fifteen rows, with product
# names called "a1" ... "a15"
# ********************************************************************
$data = array();
for ($i=1;$i<=15;$i++) {
    $data[$i-1]['price'] = $i*1.5;  # price of product 
    $data[$i-1]['name'] = 'a'.$i;
    $data[$i-1]['descr'] = 'descr'.$i;
    $data[$i-1]['image'] = 'url'.$i; 
}

empty_table($table_name);
insert_into_table($table_name,$data);

# --------------------------------------------------------------------------
# test 1 - get page 2, with page size of 3
# expected result: since page 1 would be a1, a2, a3, then we would expect
#                  page 2 to be a4, a5, a6
#                  number of products returned: 3
# --------------------------------------------------------------------------
$page_data = get_products(2,3,'');
print_pass_fail( 1.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==3, # test condition
                'page size 3, full page' # test description
                );

print_pass_fail( 1.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a4'&&$page_data[2]['name']=='a6', # test condition (start/end of page)
                'page 2, size 3, first and last products' # test description
                );

print_pass_fail( 1.3,               
                $page_data,         
                $page_data[0]['name']=='a4'
                    && $page_data[0]['price']==4*1.5
                    && $page_data[0]['image']=="url4"
                    && $page_data[0]['descr']=="descr4"
                    && $page_data[0]['id']!=0
             , 
                'all required columns have been returned' 
                );

$page_data = get_products(2.8,3.8,'');
print_pass_fail( 1.3,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==3, # test condition
                'page 2.8, size 3.8, full page' # test description
                );

print_pass_fail( 1.4,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a4'&&$page_data[2]['name']=='a6', # test condition (start/end of page)
                'page 2.8, size 3.8, first and last products' # test description
                );

# --------------------------------------------------------------------------
# test 2 - get page 2, with page size of 5
# expected result: since page 1 would be a1-a5, then we would expect
#                  page 2 to be a6-a10
#                  number of products returned: 5
# --------------------------------------------------------------------------
$page_data = get_products(2,5,'');
print_pass_fail( 2.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==5, # test condition
                'page size 5, full page' # test description
                );

print_pass_fail( 2.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a6'&&$page_data[count($page_data)-1]['name']=='a10', # test condition (start/end of page)
                'page 2, size 5, first and last products' # test description
                );


# --------------------------------------------------------------------------
# test 3 - what if last page is less than a page size?
# page 3, page size 6 (rows 13-18, but there are only 15 rows total)
# expected result: 
#                  page 3 to be a13-a15
#                  number of products returned: 3
# --------------------------------------------------------------------------
$page_data = get_products(3,6,'');
print_pass_fail( 3.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==3, # test condition
                'page size 3, last page' # test description
                );

print_pass_fail( 3.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a13'&&$page_data[count($page_data)-1]['name']=='a15', # test condition (start/end of page)
                'page 3, size 6, first and last products' # test description
                );

# --------------------------------------------------------------------------
# test 4 - page # larger than the last page, return last page
# page 3, page size 10 (too large, return last page)
# expected result: 
#                  page 3 to be a6-a15
#                  number of products returned: 10
# --------------------------------------------------------------------------
$page_data = get_products(4,10,'');
print_pass_fail( 4.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==10, # test condition
                'page size 10, last page' # test description
                );

print_pass_fail( 4.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a6'&&$page_data[count($page_data)-1]['name']=='a15', # test condition (start/end of page)
                'page 4, size 10, first and last products' # test description
                );

# --------------------------------------------------------------------------
# test 5 - negative page #, return 1st page
# page -1, page size 4
# expected result: 
#                  page 1 to be a1-a4
#                  number of products returned: 4
# --------------------------------------------------------------------------
$page_data = get_products(-1,4,'');
print_pass_fail( 5.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==4, # test condition
                'page size 4, negative page number' # test description
                );

print_pass_fail( 5.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a1'&&$page_data[count($page_data)-1]['name']=='a4',
                'page -1, size 4, first and last products' 
                );

# --------------------------------------------------------------------------
# test 6 - zero page #, return everything
# page 0, page size 3
# expected result: 
#                  page 'all' to be a1-a15
#                  number of products returned: 15
# --------------------------------------------------------------------------
$page_data = get_products(0,3,'');
print_pass_fail( 6.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==15, # test condition
                'page size 3, zero page #' # test description
                );

print_pass_fail( 6.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a1'&&$page_data[count($page_data)-1]['name']=='a15',
                'page 0, size 3, first and last products (all products)'
                );


# --------------------------------------------------------------------------
# test 7 - page 2, page size less than zero, default to size 10
# page 2, page size -1
# expected result: 
#                  page 2 to be a11-a15
#                  number of products returned: 5
# --------------------------------------------------------------------------
$page_data = get_products(2,-1,'');
print_pass_fail( 7.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==5, # test condition
                'page size less than zero, page 2' # test description
                );

print_pass_fail( 7.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a11'&&$page_data[count($page_data)-1]['name']=='a15',
                'page 2,  page size -1, first and last products' 
                );

# --------------------------------------------------------------------------
# test 8 - page 2, page size zero, default to size 10
# page 2, page size 0
# expected result: 
#                  page 2 to be a11-a15
#                  number of products returned: 5
# --------------------------------------------------------------------------
$page_data = get_products(2,0,'');
print_pass_fail( 8.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==5, # test condition
                'page size zero, page 2' # test description
                );

print_pass_fail( 8.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a11'&&$page_data[count($page_data)-1]['name']=='a15',
                'page 2,  page size 0, first and last products' 
                );

# --------------------------------------------------------------------------
# test 9 - non digit page #
# page x, page size 5
# expected result: 
#                  page 1 to be a1-5
#                  number of products returned: 5
# --------------------------------------------------------------------------
$page_data = get_products('x',5,'');
print_pass_fail( 9.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==5, # test condition
                'page x, page size 5' # test description
                );

print_pass_fail( 9.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a1'&&$page_data[count($page_data)-1]['name']=='a5',
                'page x,  page size 5, first and last products' 
                );

$page_data = get_products(1,'x','');
print_pass_fail( 9.3,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==10, # test condition
                'page 1, page size x' # test description
                );

print_pass_fail( 9.4,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a1'&&$page_data[count($page_data)-1]['name']=='a10',
                'page 1, page size x' # test description
                );

exit;
# ==========================================================================
# TEST FILTERING
# ==========================================================================

# --------------------------------------------------------------------------
# test 10 - page 1, page size 3
# filter:  'name' like a1%
# expected result: 
#                  page 1 to be a10-a12
#                  number of products returned: 3
# --------------------------------------------------------------------------
$page_data = get_products(1,3,'"a1%"');
print_pass_fail( 10.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==3, # test condition
                'filter name like a1%' # test description
                );

print_pass_fail( 10.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a10'&&$page_data[2]['name']=='a13',
                'filter name like a1%' # test description
                );

# --------------------------------------------------------------------------
# test 11 - page 1, page size 3
# filter:  price > 11.00
# expected result: 
#                  page 1 to be a8-a10
#                  number of products returned: 3
# --------------------------------------------------------------------------
$page_data = get_products(1,3,"","",11);
print_pass_fail( 11.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==3, # test condition
                'filter price > 11.00' # test description
                );

print_pass_fail( 11.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a8'&&$page_data[2]['name']=='a10',
                'filter price > 11.00' # test description
                );

# --------------------------------------------------------------------------
# test 12 - page 1, page size 10
# filter:  price > 2 and price < 6.00
# expected result: 
#                  page 1 to be a2-a3
#                  number of products returned: 2
# --------------------------------------------------------------------------
$page_data = get_products(1,3,"",2,6);
print_pass_fail( 12.1,               # tc number
                $page_data,         # object that we are testing
                count($page_data)==2, # test condition
                'filter price > 2 && price < 6' # test description
                );

print_pass_fail( 12.2,               # tc number
                $page_data,         # object that we are testing
                $page_data[0]['name']=='a2'&&$page_data[2]['name']=='a3',
                'filter price > 2 && price < 6' # test description
                );




# ====================================================================
# function to print pass or fail info:
# Inputs:  test case number, associative array, pass/fail, test description
# ====================================================================
function print_pass_fail ($tc, $obj, $true, $descr) {
    if ($true) {
        print "test $tc passed\t$descr\n";
    }
    else {
        print "test $tc FAILED\t$descr\n";
        var_dump($obj);
    }
}



# ==========================================================================
# function used to create table for testing purposes
# - if table already exists, nothing is done, else the table is created
# ==========================================================================
function create_table($name) {

    # logon to database
    $dbh = get_db_connection();

    # ----------------------------------------------------------------------
    # if table does not exist, create it
    # ----------------------------------------------------------------------
    # find list of tables with our name
    $sql = "show tables like '" . $name . "'";
    $result = $dbh->query($sql);

    # if no tables were found...
    if (! $result->rowCount()){
        
        # create table
        $sql="
        create table products ( 
            id int not null auto_increment, 
            name varchar(128), 
            descr text, 
            image varchar(256),
            price float(6,2),
            primary key (id)
        )";
        $result = $dbh->query($sql);
        
        # report any error on creating table
        if (!$result) {
            print "Could not create table:\n ".$dbh->error;
        }
    }
    $result = null; //Can cause server connection to hang if queries are not cleared.
    $dbh = null;
}

# ==========================================================================
# function used to remove all rows from the table
# ==========================================================================
function empty_table($name) {

    # logon to database
    $dbh = get_db_connection();

    # delete everything in table
    $sql = "delete from " . $name ;
    $result = $dbh->query($sql);

    # report any error on deleting records from table
    if (!$result) {
        print "Could not delete records from table:\n ".$dbh->error;
    }
    
    $result = null;
    $dbh = null;

}

# ==========================================================================
# function used to insert rows into table
# ==========================================================================
function insert_into_table($name,$data) {

    # logon to database
    $dbh = get_db_connection();

    # prepare query
    $sql = "insert into " . $name . "(name, descr, image, price) " .
    "values (?,?,?,?)";
    $sth = $dbh->prepare("insert into " . $name . "(name, descr, image, price) " .
    "values (?,?,?,?)");
    
    # insert data
    foreach ($data as $datum) {
        $name = $datum['name'];
        $descr = $datum['descr'];
        $image = $datum['image'];
        $price = $datum['price'];
        $sth->execute(array($name,$descr,$image,$price));
    }

    $result = null;
    $dbh = null;
}

?>
