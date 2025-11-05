<?php 

include __DIR__ . '/db.php';

function formats_all(): array {
    $pdo = get_pdo();
    $stmt = $pdo->prepare("SELECT * FROM `formats`  ORDER BY id");
    $stmt->execute();
    return $stmt->fetchAll();
}


function records_all(): array {
    $pdo = get_pdo();
    $stmt = $pdo->prepare("SELECT r.title, r.price, r.artist, f.name FROM `records` as r JOIN `formats` AS f ON r.format_id = f.id; ");
    $stmt->execute();
    return $stmt->fetchAll();
}


function record_insert($title, $artist, $price, $format_id): void {
    $pdo = get_pdo();
    $stmt = $pdo->prepare("INSERT INTO `records`(`title`, `artist`, `price`, `format_id`)
    VALUES (:title, :artist, :price, :format_id)
    ");

    $stmt->execute([
    ':title' => $title,
    ':artist' => $artist,
    ':price' => $price,
    ':format_id' => $format_id
    ]);
}

?>