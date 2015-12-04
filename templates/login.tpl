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
          <li role="presentation" class="active"><a href="{$baseURL}login.php">Login</a></li>
          <li role="presentation"><a href="{$baseURL}cart.php">Cart Details</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="home">
				    <!--Home Page-->
				    <div class="container-fluid">
					    <div class="row">
					    	<!--Login Feild-->
						    <div class="col-xs-12 col-sm-12 col-md-6">
							    <form>
							    	<h1>Login</h1>
							    	<div class="alert alert-danger" role="alert">You messed up kid...</div>
									  <div class="form-group">
									    <label for="exampleInputEmail1">Email address</label>
									    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
									  </div>
									  <div class="form-group">
									    <label for="exampleInputPassword1">Password</label>
									    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
									  </div>
									  <button type="submit" class="btn btn-primary btn-block">Login</button>
									</form>
							  </div>
							  <!--Register Feild-->
						   	<div class="col-xs-12 col-sm-12 col-md-6">
						   		<h1>Register</h1>
						   		<div class="alert alert-success" role="alert">You have been registerd</div>
							    <form>
									  <div class="form-group">
									    <label for="exampleInputEmail1">Email address</label>
									    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
									  </div>
									  <div class="form-group">
									    <label for="exampleInputPassword1">Password</label>
									    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
									  </div>
									  <div class="form-group">
									    <label for="exampleInputPassword1">Confirm Password</label>
									    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password">
									  </div>
									  <button type="submit" class="btn btn-primary btn-block">Register</button>
									</form>
						   	</div>
						    <!--Home Page ENDS-->
						   </div>
					   </div>
          </div>
        </div>
      </div>
    </div>
{/block}
{block name=scripts}{/block}