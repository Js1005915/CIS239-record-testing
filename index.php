<?php 

require __DIR__ . '/data/functions.php';

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Unit Test 1 — Formats</h2>
    <table>
        <td>Formats:</td>
<?php
    $rows = formats_all();
    foreach ($rows as $r):
?>
        
    <td><?= $r['name'] ?></td>

<?php 
endforeach;
?>
</table>



<hr&gt>

<h2>Unit Test 2 — Records JOIN</h2>
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
        <td><?= $r['title'] ?></td>
        <td><?= $r['name'] ?></td>
        <td><?= $r['price'] ?></td>
    </tr>

<?php 
endforeach;
?>
</table>
<hr>

<h2>Unit Test 3 — Insert</h2>
<?php record_insert("pen", "pineapple", 2, 1);
?>
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
        <td><?= $r['title'] ?></td>
        <td><?= $r['name'] ?></td>
        <td><?= $r['price'] ?></td>
    </tr>

<?php 
endforeach;
?>
</table>
<hr>
</body>
</html>