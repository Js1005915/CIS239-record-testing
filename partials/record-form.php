<?php 

$is_edit = isset($record) && isset($record['id']);
$action = $is_edit ? 'update' : 'create';

$title = $is_edit ? htmlspecialchars($record['title']) : '';
$artist = $is_edit ? htmlspecialchars($record['artist']) : '';
$price = $is_edit ? htmlspecialchars($record['price']) : '';
$format_id = $is_edit ? htmlspecialchars($record['format_id']) : 0;




$formats = formats_all()

?>

<form method="post">
    <h2><?= $is_edit ? 'Edit' : 'Create' ?></h2>
    <label >Title</label>
    <input name="title" type="text"  value="<?= $title ?>"required>

    <label >Artist</label>
    <input name="artist" type="text" value="<?= $artist ?>"required>

    <label >Price</label>
    <input name="price" type="float" step="3" value="<?= $price ?>"required>

    <label >Format</label>
    <select name="format_id" required>
        <option value="">Select</option>
        <?php foreach($formats as $f): ?>
            <?php $fid = (int)$f['id'];?>
            <option value="<?= $fid ?>" <?= $fid === $format_id ? 'selected' : ''?> >
                <?= htmlspecialchars($f['name'])?>
            </option>
            <?php endforeach; ?>
    </select>

    <input type="hidden" name="action" value="<?= $action ?>">
    <?php if ($is_edit): ?>
        <input type="hidden" name="id" value="<?= (int)$record['id'] ?>">
    <?php endif;?>
    <button><?= $is_edit ? "Update" : "Create" ?></button>

</form>