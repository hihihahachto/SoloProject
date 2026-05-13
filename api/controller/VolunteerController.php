<?php
require_once __DIR__ . '/../../database.php';

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

function getAllVolunteersApi($pdo) {
    $stmt = $pdo->query("SELECT * FROM volunteers ORDER BY id");
    $volunteers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($volunteers, JSON_UNESCAPED_UNICODE);
}

function addVolunteerApi($pdo, $data) {
    $sql = "INSERT INTO volunteers (full_name, phone, skill, photo_url) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['full_name'],
        $data['phone'],
        $data['skill'],
        $data['photo_url'] ?? null
    ]);

    http_response_code(201);
    echo json_encode([
        'status' => true,
        'message' => 'Volunteer added successfully',
        'id' => $pdo->lastInsertId()
    ], JSON_UNESCAPED_UNICODE);
}

function deleteVolunteerApi($pdo, $id) {
    $stmt = $pdo->prepare("SELECT id FROM volunteers WHERE id = ?");
    $stmt->execute([$id]);

    if (!$stmt->fetch()) {
        http_response_code(404);
        echo json_encode(['status' => false, 'message' => 'Volunteer not found'], JSON_UNESCAPED_UNICODE);
        return;
    }

    $stmt = $pdo->prepare("DELETE FROM volunteers WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode([
        'status' => true,
        'message' => 'Volunteer deleted successfully'
    ], JSON_UNESCAPED_UNICODE);
}
?>