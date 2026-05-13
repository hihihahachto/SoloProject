<?php
require_once __DIR__ . '/../../database.php';

function getAllAnimals($pdo)
{
    $sql = "SELECT * FROM animals";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getAnimalById($pdo, $id)
{
    $sql = "SELECT * FROM animals WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function getAnimalDetails($pdo, $id)
{
    $sql = "SELECT * FROM animal_details WHERE animal_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function addAnimal($pdo, $name, $species, $breed, $age, $status, $photo_url)
{
    $sql = "INSERT INTO animals (name, species, breed, age, status, photo_url) VALUES (:name, :species, :breed, :age, :status, :photo_url)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':species' => $species,
        ':breed' => $breed,
        ':age' => $age,
        ':status' => $status,
        ':photo_url' => $photo_url
    ]);
    return $pdo->lastInsertId();
}

function updateAnimal($pdo, $id, $name, $species, $breed, $age, $status, $photo_url)
{
    $sql = "UPDATE animals SET name = :name, species = :species, breed = :breed, age = :age, status = :status, photo_url = :photo_url WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':species' => $species,
        ':breed' => $breed,
        ':age' => $age,
        ':status' => $status,
        ':photo_url' => $photo_url,
        ':id' => $id
    ]);
}

function deleteAnimal($pdo, $id)
{
    $sql = "DELETE FROM animals WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}

function updateAnimalDetails($pdo, $id, $character_desc, $health_desc)
{
    $sql = "SELECT * FROM animal_details WHERE animal_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $exists = $stmt->fetch();

    if ($exists) {
        $sql = "UPDATE animal_details SET character_desc = :character_desc, health_desc = :health_desc WHERE animal_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':character_desc' => $character_desc,
            ':health_desc' => $health_desc,
            ':id' => $id
        ]);
    } else {
        $sql = "INSERT INTO animal_details (animal_id, character_desc, health_desc) VALUES (:id, :character_desc, :health_desc)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':character_desc' => $character_desc,
            ':health_desc' => $health_desc
        ]);
    }
}

function getAllAnimalsApi($pdo) {
    $stmt = $pdo->query("SELECT * FROM animals ORDER BY id");
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($animals, JSON_UNESCAPED_UNICODE);
}

function getAnimalByIdApi($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM animals WHERE id = ?");
    $stmt->execute([$id]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        http_response_code(404);
        echo json_encode(['status' => false, 'message' => 'Animal not found'], JSON_UNESCAPED_UNICODE);
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM animal_details WHERE animal_id = ?");
    $stmt->execute([$id]);
    $details = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($details) {
        $animal['character_desc'] = $details['character_desc'];
        $animal['health_desc'] = $details['health_desc'];
        $animal['story'] = $details['story'];
        $animal['treatment_text'] = $details['treatment_text'];
    }

    echo json_encode($animal, JSON_UNESCAPED_UNICODE);
}

function addAnimalApi($pdo, $data) {
    $sql = "INSERT INTO animals (name, species, breed, age, status, photo_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['name'],
        $data['species'],
        $data['breed'] ?? null,
        $data['age'] ?? null,
        $data['status'],
        $data['photo_url'] ?? null
    ]);

    http_response_code(201);
    echo json_encode([
        'status' => true,
        'message' => 'Animal added successfully',
        'id' => $pdo->lastInsertId()
    ], JSON_UNESCAPED_UNICODE);
}

function deleteAnimalApi($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM animals WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode([
        'status' => true,
        'message' => 'Animal deleted successfully'
    ], JSON_UNESCAPED_UNICODE);
}
?>