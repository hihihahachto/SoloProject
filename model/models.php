<?php
require_once 'config.php';

// ========== СУЩЕСТВУЮЩИЕ ФУНКЦИИ (оставляем) ==========

function selectAnimals($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM animals");
    $stmt->execute();
    return $stmt->fetchAll();
}

function detailsAnimal($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM animal_details WHERE animal_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function selectVolunteers($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM volunteers");
    $stmt->execute();
    return $stmt->fetchAll();
}

function addVolunteer($pdo, $name, $phone, $skill, $photo_url)
{
    $stmt = $pdo->prepare("INSERT INTO volunteers (full_name, phone, skill, photo_url) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $skill, $photo_url]);
}

function checkVolunteerByPhone($pdo, $phone)
{
    $stmt = $pdo->prepare("SELECT * FROM volunteers WHERE phone = ?");
    $stmt->execute([$phone]);
    return $stmt->fetch();
}

function addAdoption($pdo, $animal_id, $name, $phone)
{
    $stmt = $pdo->prepare("INSERT INTO adoptions (animal_id, adopter_name, adopter_phone, adoption_date) VALUES (?, ?, ?, CURDATE())");
    $stmt->execute([$animal_id, $name, $phone]);
}

function checkAdoption($pdo, $animal_id)
{
    $stmt = $pdo->prepare("SELECT * FROM adoptions WHERE animal_id = ?");
    $stmt->execute([$animal_id]);
    return $stmt->fetch();
}

// ========== ДЛЯ АДМИНА ==========

// Добавление нового животного
function addAnimal($pdo, $name, $species, $breed, $age, $status, $photo_url)
{
    $stmt = $pdo->prepare("INSERT INTO animals (name, species, breed, age, status, photo_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $species, $breed, $age, $status, $photo_url]);
    return $pdo->lastInsertId();
}
function deleteAnimal($pdo, $id)
{
    $stmt = $pdo->prepare("DELETE FROM animals WHERE id = ?");
    $stmt->execute([$id]);
}

function deleteVolunteer($pdo, $id)
{
    $stmt = $pdo->prepare("DELETE FROM volunteers WHERE id = ?");
    $stmt->execute([$id]);
}

function getAnimalById($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM animals WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function updateAnimal($pdo, $id, $name, $species, $breed, $age, $status, $photo_url)
{
    $stmt = $pdo->prepare("UPDATE animals SET name=?, species=?, breed=?, age=?, status=?, photo_url=? WHERE id=?");
    $stmt->execute([$name, $species, $breed, $age, $status, $photo_url, $id]);
}
function updateVolunteer($pdo, $id, $full_name, $phone, $skill, $photo_url)
{
    $stmt = $pdo->prepare("UPDATE volunteers SET full_name=?, phone=?, skill=?, photo_url=? WHERE id=?");
    $stmt->execute([$full_name, $phone, $skill, $photo_url, $id]);
}

function getVolunteerById($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM volunteers WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}
// Получить лечение животного
function getTreatment($pdo, $animal_id)
{
    $stmt = $pdo->prepare("SELECT treatment_text FROM animal_details WHERE animal_id = ?");
    $stmt->execute([$animal_id]);
    return $stmt->fetch();
}

// Обновить лечение животного
function updateTreatment($pdo, $animal_id, $treatment_text)
{
    $stmt = $pdo->prepare("SELECT * FROM animal_details WHERE animal_id = ?");
    $stmt->execute([$animal_id]);
    $exists = $stmt->fetch();

    if ($exists) {
        $stmt = $pdo->prepare("UPDATE animal_details SET treatment_text = ? WHERE animal_id = ?");
        $stmt->execute([$treatment_text, $animal_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO animal_details (animal_id, treatment_text) VALUES (?, ?)");
        $stmt->execute([$animal_id, $treatment_text]);
    }
}
?>