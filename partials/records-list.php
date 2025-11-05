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
    </tr>

<?php 
endforeach;
?>
</table>