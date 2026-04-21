<?php
require_once 'config.php';

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
?>