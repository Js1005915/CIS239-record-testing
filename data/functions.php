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
#user create function, uses the inputted fields to create a username and put it into the table called users
function user_create(string $username, string $full_name, string $hash): void {
    $pdo = get_pdo();
    $sql = "INSERT INTO users (username, full_name, password_hash)
            VALUES (:u, :f, :p)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':u'=>$username, ':f'=>$full_name, ':p'=>$hash]);
}
#finds a user by a username inputted into the function, using the where clause on the users table
function user_find_by_username(string $username): ?array {
    $pdo = get_pdo();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u");
    $stmt->execute([':u'=>$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}
#returns the records by their ids
function records_by_ids(array $ids): array {
    if (empty($ids)) return [];
    $pdo = get_pdo();
    $ph = implode(',', array_fill(0, count($ids), '?'));
    $sql = "SELECT r.id, r.title, r.artist, r.price, f.name
            FROM records r
            JOIN formats f ON r.format_id = f.id
            WHERE r.id IN ($ph)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($ids);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
#creates a purchase inside the purcahses table using the inputted fields
function purchase_create(int $user_id, int $record_id): void {
    $pdo = get_pdo();
    $sql = "INSERT INTO purchases (user_id, record_id, purchase_date)
            VALUES (:u, :r, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':u'=>$user_id, ':r'=>$record_id]);
}

?>