{strip}
<table class="table table-hover">
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Price</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  {foreach $products as $product}
    <tr>
      <td>{$product.name}</td>
      <td>{$product.descr}</td>
      <td>{$product.price}</td>
      <td><button class="btn btn-primary btn-sm pull-right" onclick="addToCart({$product.id})">Add to Cart</button></td>
    </tr>
  {/foreach}
  </tbody>
</table>
{/strip}<button id="last" onclick="lastPage()" class="btn btn-primary">Previous Page</button> <button id="next" onclick="nextPage()" class="btn btn-primary">Next Page</button>{strip}
<div class="pull-right">
Page Size:
  <select id="size" onchange="changeSize()">
    <option value="5" selected="selected">5</option>
    <option value="10">10</option>
    <option value="20">20</option>
    <option value="50">50</option>
  </select>
</div>
{/strip}