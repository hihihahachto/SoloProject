<?php
require_once '../model/database.php';

function getAllVolunteers($pdo)
{
    $sql = "SELECT * FROM volunteers";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getVolunteerById($pdo, $id)
{
    $sql = "SELECT * FROM volunteers WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function addVolunteer($pdo, $name, $phone, $skill, $photo_url)
{
    $sql = "INSERT INTO volunteers (full_name, phone, skill, photo_url) VALUES (:full_name, :phone, :skill, :photo_url)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':full_name' => $name,
        ':phone' => $phone,
        ':skill' => $skill,
        ':photo_url' => $photo_url
    ]);
}

function updateVolunteer($pdo, $id, $full_name, $phone, $skill, $photo_url)
{
    $sql = "UPDATE volunteers SET full_name = :full_name, phone = :phone, skill = :skill, photo_url = :photo_url WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':full_name' => $full_name,
        ':phone' => $phone,
        ':skill' => $skill,
        ':photo_url' => $photo_url,
        ':id' => $id
    ]);
}

function deleteVolunteer($pdo, $id)
{
    $sql = "DELETE FROM volunteers WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}

function checkVolunteerByPhone($pdo, $phone)
{
    $sql = "SELECT * FROM volunteers WHERE phone = :phone";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':phone' => $phone]);
    return $stmt->fetch();
}
?>