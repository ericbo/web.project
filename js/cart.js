// ###############################################################
// #
// #
// #
// #
// ###############################################################

/*
* Takes the ID passed to it and send a request to the server via AJAX.
* updateCart() is then called to refesh the users cart.
* TODO: Display an error to the user if the cart is not updated.
*/
function addToCart(id) {
	//Simple validation
	if(isNaN(id))
		return false;

	//Let PHP do the rest, because this is a lazzy funtion.
	var XHR = new XMLHttpRequest();

  XHR.addEventListener('load', function(event) {
    if(XHR.status === 200)
    {
	    var data = XHR.responseText;

	    if(data != "")
	    	document.getElementById(id).innerHTML = data;
    	else
    		document.getElementById(id).innerHTML = "No data found...";
    }
    else
    	document.getElementById(id).innerHTML = "No data found...";

    getPagination();
  });

  // We setup our request
  XHR.open('POST', baseURL + 'ajax/html/cart.php', true);
  XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  XHR.send('itemID=' + id);
}