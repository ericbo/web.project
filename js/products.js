/*GLOBAL VRAIABLES*/
var tableID = "products";									//Id of the prodicts table
var hostname = window.location.hostname;	//Hostname of the website. 
var page; //Current page.
var size; //Size of page.

/****************************************************
* 		Simple Function (impliments other funtions)
*****************************************************/

//Run when the page is loaded. Sets up deafaults and loads the table.
function init() {
	page = 1; //Default page number when the page is laoded.
	size = 10; //Default size of page when it is loaded.
	document.getElementById("size").value = size;
	getProducts(tableID, page, size);
}

//Increase the page number and reload the table
function nextPage() {
	page++;
	getProducts(tableID, page, size);
}


//Descrease the page number and reload the table.
function lastPage() {
	page--;
	getProducts(tableID, page, size);
}

/*
* Reads the dropdown "size" and adjusts the size variable accordingly
*/
function changeSize() {
	var sizeDropdown = +document.getElementById("size").value;
	if(!isNaN(sizeDropdown))
	{
		size = sizeDropdown;
		page = 1;
		getProducts(tableID, page, size);
	}
}

//Uppercase first character in a string
function uFirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

/****************************************************
* Advanced Functions (Create HTML elements, send AJAX requests)
****************************************************/

/*
*	Disables and enables buttons based on the current page, size of page and size of products database.
* @returns void
*/
function getPagination() {
	//Store button elements
	var lastButton = document.getElementById("last");
	var nextButton = document.getElementById("next");
	var productsSize = 0; //The amount of products stored in the database.

	//Create a get request to find out the size of the products table.
	var XHR = new XMLHttpRequest();

  XHR.addEventListener('load', function(event) {
    if(XHR.status === 200) {
    	//Check if a json parse error occurs
    	try {
	    	productsSize = JSON.parse(XHR.responseText)['size'];

			  //Disable the previous page button?
			  if(page <= 1)
			  	lastButton.disabled = true;
			  else
			  	lastButton.disabled = false;

			  //Disable the next page button?
			  var lastPage = productsSize / size;
			  if(page >= lastPage)
			  	nextButton.disabled = true;
			  else
			  	nextButton.disabled = false;
			} catch(e) {
	  		lastButton.disabled = true;
	  		nextButton.disabled = true;
			}
    }
    else {
  		//Disable buttons if AJAX failes
  		lastButton.disabled = true;
  		nextButton.disabled = true;
  	}
  });

  // We setup our request
  XHR.open('GET', 'http://' + hostname +'/json/products_size.php');
  XHR.send();
}

/*
* This function will populate a table with the given page and size.
* It works in conjunction with clear_table, create_table_headers and fill_table
* @param string id
* @param int page
* @param int size
* @return void
*/
function getProducts(id, page, size) {
  
  var XHR = new XMLHttpRequest();

  XHR.addEventListener('load', function(event) {
    if(XHR.status === 200)
    {
    	try {
	    	var data = JSON.parse(XHR.responseText);
	    	clear_table(id);
	    	create_table_headers(id, data[0]);
	    	fill_table(id, data);
    	} catch(e) {
    		document.getElementById(id).innerHTML = "No data found...";
    	}
    }
    else
    	document.getElementById(id).innerHTML = "No data found...";

    getPagination();
  });

  // We setup our request
  XHR.open('GET', 'http://' + hostname + '/json/products.php?page=' + page + '&size=' + size);
  XHR.send();
}

/*
* Using the ID of a table, populate the headers with the values given in the array passed.
* @param string id - ID of an empty table.
* @param array(string) headers - An array of column titles for the table.
* @returns void
*/
function create_table_headers(id, object) {

	//Get table
	var table = document.getElementById(id);

	//Create table head
	var head = document.createElement("thead");

	//Create row
	var row = document.createElement("tr");

	//Create columns
	for(var header in object) {
		var column = document.createElement("th");
		column.innerHTML = uFirst(header);
		row.appendChild(column);
	}

	//Append row to table
	head.appendChild(row);
	table.appendChild(head);
}

/*
* Using the ID of a table, fill it with content given an associative array.
* @param string id - ID of a table.
* @param array(string) headers - An array of objects (row data).
* @returns void
*/
function fill_table(id, data) {

	//Get table
	var table = document.getElementById(id);

	//Create table body
	var body = document.createElement("tbody");

	for (var rowData in data) {
		//Create row
		var row = document.createElement("tr");

		//Create columns
		for(var colData in data[rowData]) {
			var column = document.createElement("td");
			column.innerHTML = data[rowData][colData];
			row.appendChild(column);
		}

		//Append row to table
		body.appendChild(row);
		table.appendChild(body);
	}
}

/*
* Remove all from the table that matches the ID given.
* @param string id - ID of a table.
* @returns void
*/
function clear_table(id) {

	//Get table
	var table = document.getElementById(id);

	//Deletes rows, from bottom to top.
	while (table.hasChildNodes()) {
		table.removeChild(table.lastChild);
	}
}