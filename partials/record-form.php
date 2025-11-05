<?php 

$formats = formats_all()

?>

<form method="post">
    <label >Title</label>
    <input name="title" type="text" required>

    <label >Artist</label>
    <input name="artist" type="text" required>

    <label >Price</label>
    <input name="price" type="float" step="3" required>

    <label >Format</label>
    <select name="format_id" required>
        <option value="">Select</option>
        <?php foreach($formats as $f): ?>
            <option value="<?= (int)$f['id'] ?>"><?= htmlspecialchars($f['name'])?></option>
            <?php endforeach; ?>
    </select>

    <input type="hidden" name="action" value="create">

    <button>Create</button>

</form>