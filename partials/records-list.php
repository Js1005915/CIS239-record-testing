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
            <form method="post">
                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                <input type="hidden" name="action" value="edit">
                <button>Edit</button>
            </form>
            <form method="post"  onsubmit="return confirm('Delete this book?');">
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