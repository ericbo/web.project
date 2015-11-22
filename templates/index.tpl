<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title>Ritchards Steak Knives</title>
		<script src="js/products.js"></script>
		<link rel="stylesheet" href="css/main.css" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body onload="init()">
		<!--Header-->
		<header>
			<h1>Ritchards Steak Knives</h1>
			<p>All natural hardened steel.</p>
		</header>
		<div id="wrapper">
			<!--Groupe Navbar and Content-->
			<div class="groupe">
				<!--Content-->
				<section>
					<article>
						<select id="size" onchange="changeSize()">
							<option value="5" selected="selected">5</option>
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
						</select>
						<table id="products">
						</table>
						<button id="last" onclick="lastPage()">Previous Page</button>
						<button id="next" onclick="nextPage()">Next Page</button>
					</article>
				</section>
				<!--Navbar-->
				<nav>
					<h1>A Cool Sidebar!</h1>
				</nav>
			</div>
			<!--Footer-->
			<footer>Copyright &copy; 2015</footer>
		</div>
	</body>
</html>