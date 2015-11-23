{extends file="layout-bootstrap.tpl"}
{block name=body}
  <body onload="init()">
  <div class="container">
		<div class="page-header">
		  <h1>Richards Steak Knives<small> All natural hardened steel!</small></h1>
		</div>
		<div>
		  <!-- Nav tabs -->
		  	<ul class="nav nav-tabs" role="tablist">
		    	<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
		    	<li role="presentation"><a href="#login" aria-controls="login" role="tab" data-toggle="tab" onclick="changePage('index.php/login')">Login</a></li>
			</ul>
		  <!-- Tab panes -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="home">
		    <!--Home Page-->
		    <div class="container-fluid">
		    <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-8">
		    	<div id="products"></div>
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
			   <div role="tabpanel" class="tab-pane" id="login">New Page</div>
		  </div>
		</div>
	</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="{$baseURL}js/utility_functions.js"></script>
  <script src="{$baseURL}js/bootstrap.min.js"></script>
</body>
{/block}