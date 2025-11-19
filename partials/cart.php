<h2>Your Cart</h2>

<!-- sets the records to records in cart, this is set inside the index file under the switch statement,
 that checks if the view is set to cart, and if so uses the get records by ids function on the records inside the cart session -->
<?php $records = $records_in_cart ?? []; ?>

<?php if (empty($records)): ?>
  <p>Your cart is empty.</p>
<?php else: ?>
<!-- creates a table with the headers title, artist, format and price, and when submitted sets action to checkout -->
  <table class="table">
    <thead>
      <tr>
        <th>Title</th>
        <th>Artist</th>
        <th>Format</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($records as $row): ?>
        <tr>
          <td><?= $row['title'] ?></td>
          <td><?= $row['artist'] ?></td>
          <td><?= $row['name'] ?></td>
          <td><?= $row['price'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <form method="post">
    <input type="hidden" name="action" value="checkout">
    <button class="btn btn-success">Complete Purchase</button>
  </form>

<?php endif; ?>