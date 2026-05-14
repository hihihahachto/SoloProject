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

// ========== API ФУНКЦИИ ДЛЯ index.php ==========

function getAllAnimalsApi($pdo) {
    $animals = getAllAnimals($pdo);
    echo json_encode($animals, JSON_UNESCAPED_UNICODE);
}

function getAnimalByIdApi($pdo, $id) {
    $animal = getAnimalById($pdo, $id);

    if (!$animal) {
        http_response_code(404);
        echo json_encode(['status' => false, 'message' => 'Animal not found'], JSON_UNESCAPED_UNICODE);
        return;
    }

    $details = getAnimalDetails($pdo, $id);
    if ($details) {
        $animal['character_desc'] = $details['character_desc'];
        $animal['health_desc'] = $details['health_desc'];
        $animal['story'] = $details['story'];
        $animal['treatment_text'] = $details['treatment_text'];
    }

    echo json_encode($animal, JSON_UNESCAPED_UNICODE);
}

function addAnimalApi($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = addAnimal($pdo,
        $data['name'],
        $data['species'],
        $data['breed'] ?? null,
        $data['age'] ?? null,
        $data['status'],
        $data['photo_url'] ?? null
    );

    http_response_code(201);
    echo json_encode([
        'status' => true,
        'message' => 'Animal added successfully',
        'id' => $id
    ], JSON_UNESCAPED_UNICODE);
}

function updateAnimalApi($pdo, $id) {
    $data = json_decode(file_get_contents('php://input'), true);

    $animal = getAnimalById($pdo, $id);
    if (!$animal) {
        http_response_code(404);
        echo json_encode(['status' => false, 'message' => 'Animal not found'], JSON_UNESCAPED_UNICODE);
        return;
    }

    updateAnimal($pdo, $id,
        $data['name'] ?? $animal['name'],
        $data['species'] ?? $animal['species'],
        $data['breed'] ?? $animal['breed'],
        $data['age'] ?? $animal['age'],
        $data['status'] ?? $animal['status'],
        $data['photo_url'] ?? $animal['photo_url']
    );

    echo json_encode([
        'status' => true,
        'message' => 'Animal updated successfully'
    ], JSON_UNESCAPED_UNICODE);
}

function deleteAnimalApi($pdo, $id) {
    deleteAnimal($pdo, $id);

    echo json_encode([
        'status' => true,
        'message' => 'Animal deleted successfully'
    ], JSON_UNESCAPED_UNICODE);
}
?>