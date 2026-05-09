<?php
require_once '../model/Database.php';

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
?>