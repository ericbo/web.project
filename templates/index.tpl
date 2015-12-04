{extends file="layout.tpl"}
{block name=body}
  <body onload="initProducts()">
    <div class="container">
      <div class="page-header">
        <h1>Richards Steak Knives<small> All natural hardened steel!</small></h1>
      </div>
      <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="{$baseURL}">Home</a></li>
          <li role="presentation"><a href="{$baseURL}login.php">Login</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="home">
				    <!--Home Page-->
				    <div class="container-fluid">
					    <div class="row">
						    <div class="col-xs-12 col-sm-12 col-md-8">
						    	<div id="products"></div>
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
{/block}
{block name=scripts}<script src="{$baseURL}/js/products.js"></script>{/block}