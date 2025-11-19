<h2>Records</h2>
<table>
        <tr>
            <th>Title</th>
            <th>Format</th>
            <th>Price</th>
        </tr>
<?php
    $rows = records_all();
    foreach ($rows as $r):
?>
    <tr>
        <td><?= htmlspecialchars($r['title']) ?></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= htmlspecialchars($r['price']) ?></td>
        <td>
            <!-- this form shows the id of the record, an edit button, and an add to cart button. -->
            <form method="post">
                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                <input type="hidden" name="action" value="edit">
                <button>Edit</button>
                <input type="hidden" name="action" value="add_to_cart">
                <button class="btn btn-sm btn-outline-success">Add to Cart</button>

            </form>
            <!-- shows a confirmation box when you click delete, enabling a layer of security. -->
            <form method="post"  onsubmit="return confirm('Delete this record?');">
                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                <input type="hidden" name="action" value="delete">
                <button>Delete</button>
            </form>
        </td>
    </tr>

<?php 
endforeach;
?>
</table>