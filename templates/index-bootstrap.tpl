<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Richards Steak Knives</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
		#cart td {
			border: none;
		}
    </style>
  </head>
  <body onload="init()">
  <div class="container">
		<div class="page-header">
		  <h1>Richards Steak Knives<small> All natural hardened steel!</small></h1>
		</div>
		<div>
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
			</ul>
		  <!-- Tab panes -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="home">
		    <!--Home Page-->
		    <div class="container-fluid">
		    <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-8">
			    <table class="table table-hover" id="products">
			      <thead>
			        <tr>
			          <th>#</th>
			          <th>First Name</th>
			          <th>Last Name</th>
			          <th>Username</th>
			        </tr>
			      </thead>
			      <tbody>
			        <tr>
			          <th scope="row">1</th>
			          <td>Mark</td>
			          <td>Otto</td>
			          <td>@mdo</td>
			        </tr>
			        <tr>
			          <th scope="row">2</th>
			          <td>Jacob</td>
			          <td>Thornton</td>
			          <td>@fat</td>
			        </tr>
			        <tr>
			          <th scope="row">3</th>
			          <td>Larry</td>
			          <td>the Bird</td>
			          <td>@twitter</td>
			        </tr>
			      </tbody>
			    </table>
			    <button id="last" onclick="lastPage()" class="btn btn-primary">Previous Page</button>
			    <button id="next" onclick="nextPage()" class="btn btn-primary">Next Page</button>
			    <div class="pull-right">
			    Page Size:
			    	<select id="size" onchange="changeSize()">
							<option value="5" selected="selected">5</option>
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
						</select>
					</div>
			   	</div>
			   	<div class="col-xs-12 col-md-4">
				   	<div class="well well-sm" style="margin-top: 10px;">
							<h1 style="margin:0; padding-bottom:5px;text-align:center;border-bottom: 1px solid #eee;">Shopping Cart</h1>
							<table class="table" id="cart">
								<tr>
									<td>Items: 0</td>
								</tr>
								<tr>
									<td>Price: $0.00</td>
								</tr>
								<tr>
									<td><button class="btn btn-block btn-success">Checkout</button></td>
								</tr>
							</table>
						</div>
			   	</div>
			    <!--Home Page ENDS-->
			   </div>
			   </div>
			   </div>
		  </div>
		</div>
	</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/products.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>