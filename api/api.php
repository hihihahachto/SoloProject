<?php
header('Content-Type: application/json');

require_once '../model/Database.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM animals WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
    } else {
        $sql = "SELECT * FROM animals";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
    }
    echo json_encode($result);
}

if ($method == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $sql = "INSERT INTO animals (name, species, breed, age, status, photo_url) VALUES (:name, :species, :breed, :age, :status, :photo_url)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $data['name'],
        ':species' => $data['species'],
        ':breed' => $data['breed'],
        ':age' => $data['age'],
        ':status' => $data['status'],
        ':photo_url' => $data['photo_url']
    ]);
    echo json_encode(['id' => $pdo->lastInsertId()]);
}

if ($method == 'DELETE') {
    $id = $_GET['id'];
    $sql = "DELETE FROM animals WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    echo json_encode(['deleted' => true]);
}
?>