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
{/strip}