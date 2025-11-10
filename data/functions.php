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
    $stmt = $pdo->prepare("SELECT r.id, r.title, r.price, r.artist, f.name FROM `records` as r JOIN `formats` AS f ON r.format_id = f.id; ");
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




function record_get(int $id): ?array
{
    $pdo = get_pdo();
    $sql = "
    SELECT r.id, r.title, r.artist, r.price, r.format_id, f.name
    FROM `records` r 
    JOIN `formats` f ON f.id = r.genre_id
    WHERE r.id = :id LIMIT 1 
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

function record_update(int $id, string $title, string $artist, float $price, int $format_id): int {
    $pdo = get_pdo();
    $sql = "UPDATE `records` SET title = :title, artist = :artist, price = :price, format_id = :format_id WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':title' =>$title, ':artist' => $artist, ':price' => $price, ':format_id' => $format_id, ':id' =>$id]);

    return $stmt->rowCount();
}

function record_delete(int $id): int {
    $pdo = get_pdo();
    $stmt = $pdo->prepare("DELETE FROM `records` WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->rowCount();
}

?>