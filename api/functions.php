<?php
function getAnimals($pdo)
{
    $sql = "SELECT * FROM animals ORDER BY id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($animals, JSON_UNESCAPED_UNICODE);
}

function getAnimal($pdo, $id)
{
    $sql = "SELECT * FROM animals WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() === 1) {
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);

        $sqlDetails = "SELECT * FROM animal_details WHERE animal_id = :id";
        $stmtDetails = $pdo->prepare($sqlDetails);
        $stmtDetails->execute(['id' => $id]);
        $details = $stmtDetails->fetch(PDO::FETCH_ASSOC);

        if ($details) {
            $animal['character_desc'] = $details['character_desc'];
            $animal['health_desc'] = $details['health_desc'];
            $animal['story'] = $details['story'];
            $animal['treatment_text'] = $details['treatment_text'];
        }

        echo json_encode($animal, JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(404);
        echo json_encode([
            'status' => false,
            'message' => 'Animal not found'
        ], JSON_UNESCAPED_UNICODE);
    }
}

function addAnimal($pdo, $data)
{
    $sql = "INSERT INTO animals (name, species, breed, age, status, photo_url) VALUES (:name, :species, :breed, :age, :status, :photo_url)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name' => $data['name'],
        'species' => $data['species'],
        'breed' => $data['breed'],
        'age' => $data['age'],
        'status' => $data['status'],
        'photo_url' => $data['photo_url']
    ]);

    http_response_code(201);
    echo json_encode([
        'status' => true,
        'message' => 'Animal added successfully',
        'id' => $pdo->lastInsertId()
    ], JSON_UNESCAPED_UNICODE);
}

function updateAnimal($pdo, $id, $data)
{
    $sql = "UPDATE animals SET name = :name, species = :species, breed = :breed, age = :age, status = :status, photo_url = :photo_url WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name' => $data['name'],
        'species' => $data['species'],
        'breed' => $data['breed'],
        'age' => $data['age'],
        'status' => $data['status'],
        'photo_url' => $data['photo_url'],
        'id' => $id
    ]);

    http_response_code(200);
    echo json_encode([
        'status' => true,
        'message' => 'Animal updated successfully'
    ], JSON_UNESCAPED_UNICODE);
}

function deleteAnimal($pdo, $id)
{
    $sql = "DELETE FROM animals WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    http_response_code(200);
    echo json_encode([
        'status' => true,
        'message' => 'Animal deleted successfully'
    ], JSON_UNESCAPED_UNICODE);
}

function getVolunteers($pdo)
{
    $sql = "SELECT * FROM volunteers ORDER BY id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $volunteers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($volunteers, JSON_UNESCAPED_UNICODE);
}

function addVolunteer($pdo, $data)
{
    $sql = "INSERT INTO volunteers (full_name, phone, skill, photo_url) 
            VALUES (:full_name, :phone, :skill, :photo_url)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'full_name' => $data['full_name'],
        'phone' => $data['phone'],
        'skill' => $data['skill'],
        'photo_url' => $data['photo_url']
    ]);

    http_response_code(201);
    echo json_encode([
        'status' => true,
        'message' => 'Volunteer added successfully',
        'id' => $pdo->lastInsertId()
    ], JSON_UNESCAPED_UNICODE);
}