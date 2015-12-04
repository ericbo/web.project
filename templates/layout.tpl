<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Online Store - Demo">
    <meta name="author" content="Eric Bottazzi">
    <link rel="icon" href="../../favicon.ico">

    <title>Richards Steak Knives</title>
    <link href="{$baseURL}css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	</head>
  <body onload="init()">
    <div class="container">
      <div class="page-header">
        <h1>Richards Steak Knives<small> All natural hardened steel!</small></h1>
      </div>
      <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="{$baseURL}" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
          <li role="presentation"><a href="{$baseURL}login" aria-controls="login" role="tab" data-toggle="tab" onclick="changePage('index.php/login')">Login</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="home">
          {block name=body}{/block}
          </div>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{$baseURL}js/bootstrap.min.js"></script>
    {block name=scripts}{/block}
  </body>
</html>