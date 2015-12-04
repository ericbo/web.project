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
          <li role="presentation"><a href="{$baseURL}">Home</a></li>
          <li role="presentation"><a href="{$baseURL}login.php">Login</a></li>
          <li role="presentation" class="active"><a href="{$baseURL}cart.php">Cart Details</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="home">
				    <!--Home Page-->
				    <div class="container-fluid">
					    <div class="row">
					    	<!--Login Feild-->
						    <div class="col-xs-12 col-sm-12 col-md-12">
							    <div id="cart">Cart here...</div>
							  </div>
							  <!--Register Feild-->
						    <!--Home Page ENDS-->
						   </div>
					   </div>
          </div>
        </div>
      </div>
    </div>
{/block}
{block name=scripts}{/block}