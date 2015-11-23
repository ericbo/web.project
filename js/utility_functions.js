/*
* Once the page has loaded, checks the url and loads content accordingly.
*/
function init() {
	loadJsFile("js/products.js", function() {initProducts();});
}

/*
* Takes the url of a script and appends it to the body tag.
*/
function loadJsFile(url, callback) {
	//Create the script tag.
	var script = document.createElement("script");
	script.setAttribute('src', url);
	script.async = false;
	document.body.appendChild(script);

	//Launch the callback function once the script has been loaded.
	script.onreadystatechange = callback;
	script.onload = callback;
}