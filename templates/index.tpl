{extends file="layout.tpl"}
{block name=body}
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
{/block}