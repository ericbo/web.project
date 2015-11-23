var baseURL = window.location.protocol + "//" + window.location.hostname + "/";

/*
* Monitors if the users tries to return to a previous page.
*/
window.onpopstate = function(event) {
  init();
};

/*
* Once the page has loaded, checks the url and loads content accordingly.
*/
function init() {
	var path = window.location.pathname.split("/");

	//Removes empty strings and index.php from the path array.
	while(path[0] == "" || path[0] == "index.php")
		path.splice(0,1);

	//This mess of a code interprets the url and loads the appropriate functions
	if(path.length == 0) //URL is empty, load dependencies for homepage.
		loadJsFile(baseURL + "js/products.js", function() {initProducts();});
	else if (path.length > 1)
		window.location.replace(baseURL + path.join("/"));
	else if(path[0] == "login")
		console.log("You are on the login page");
	else
		window.location.replace(baseURL + path.join("/"));
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

function changePage(path) {
	window.history.pushState("home", "Richards Steak Knives", baseURL + path);
	init();
}