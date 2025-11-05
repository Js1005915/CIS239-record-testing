<?php

use BcMath\Number;

require __DIR__ . '/data/functions.php';

$view = filter_input(INPUT_GET, 'view') ?: 'list';
$action = filter_input(INPUT_POST, 'action');


switch ($action) {
    case 'create':
        $title = trim((string)(filter_input(INPUT_POST, 'title') ?? ''));
        $artist = trim((string)(filter_input(INPUT_POST, 'artist') ?? ''));
        $price = trim((float)(filter_input(INPUT_POST, 'price') ?? 0));
        $format_id = trim((int)(filter_input(INPUT_POST, 'format_id') ?? 0));

        if ($title && $artist && $format_id) {
            record_insert($title, $artist, $price, $format_id);
            $view = 'created';
        } else {
            $view = 'create'; // missing fields
        }
        break;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
    <title>Document</title>
    
</head>
<body>
    <?php include __DIR__ . '/components/nav.php';?>


    <?php 
    if ($view === 'list')
        include __DIR__ . '/partials/records-list.php';
    elseif ($view === 'create')
        include __DIR__ . '/partials/record-form.php';
    elseif ($view === 'created')
        include __DIR__ . '/partials/record-created.php'
    
    ?>





    <!-- <h2>Unit Test 1 — Formats</h2>
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


<hr> -->
</body>
</html>