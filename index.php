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
    case 'edit':
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $record = record_get($id);
            
        }

        $view = 'create';
        break;
    case 'update':
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $title = (string)filter_input(INPUT_POST, 'title', FILTER_UNSAFE_RAW);
        $artist = (string)filter_input(INPUT_POST, 'artist', FILTER_UNSAFE_RAW);
        $price_in = filter_input(INPUT_POST, 'price', FILTER_UNSAFE_RAW);
        $format_id = filter_input(INPUT_POST, 'format_id', FILTER_VALIDATE_INT);

        $price = is_numeric($price_in) ? (float)$price_in : null;

        if ($id && $title !== '' && $artist !== '' && $price !== null && $format_id) {
            record_update($id, $title, $artist, $price, $format_id);
        }
        $view = 'updated';
        break;
    case 'delete':
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            $deleted = record_delete($id);
        }
        $view = 'deleted';
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
    <title>List Page</title>
    
</head>
<body>
    <?php include __DIR__ . '/components/nav.php';?>


    <?php 
    if ($view === 'list')
        include __DIR__ . '/partials/records-list.php';
    elseif ($view === 'create')
        include __DIR__ . '/partials/record-form.php';
    elseif ($view === 'created')
        include __DIR__ . '/partials/record-created.php';
    elseif ($view === 'updated')
        include __DIR__ . '/partials/record-updated.php';
    elseif ($view === 'deleted')
        include __DIR__ . '/partials/record-deleted.php';
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