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
    return $pdo->lastInsertId();
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

// ========== API ФУНКЦИИ ДЛЯ index.php ==========

function getAllVolunteersApi($pdo) {
    $volunteers = getAllVolunteers($pdo);
    echo json_encode($volunteers, JSON_UNESCAPED_UNICODE);
}

function addVolunteerApi($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);

    $exists = checkVolunteerByPhone($pdo, $data['phone']);
    if ($exists) {
        http_response_code(400);
        echo json_encode([
            'status' => false,
            'message' => 'Волонтёр с таким телефоном уже зарегистрирован'
        ], JSON_UNESCAPED_UNICODE);
        return;
    }

    $id = addVolunteer($pdo, $data['full_name'], $data['phone'], $data['skill'], $data['photo_url'] ?? null);

    http_response_code(201);
    echo json_encode([
        'status' => true,
        'message' => 'Volunteer added successfully',
        'id' => $id
    ], JSON_UNESCAPED_UNICODE);
}

function updateVolunteerApi($pdo, $id) {
    $data = json_decode(file_get_contents('php://input'), true);

    $volunteer = getVolunteerById($pdo, $id);
    if (!$volunteer) {
        http_response_code(404);
        echo json_encode(['status' => false, 'message' => 'Volunteer not found'], JSON_UNESCAPED_UNICODE);
        return;
    }

    updateVolunteer($pdo, $id,
        $data['full_name'] ?? $volunteer['full_name'],
        $data['phone'] ?? $volunteer['phone'],
        $data['skill'] ?? $volunteer['skill'],
        $data['photo_url'] ?? $volunteer['photo_url']
    );

    echo json_encode([
        'status' => true,
        'message' => 'Volunteer updated successfully'
    ], JSON_UNESCAPED_UNICODE);
}

function deleteVolunteerApi($pdo, $id) {
    deleteVolunteer($pdo, $id);

    echo json_encode([
        'status' => true,
        'message' => 'Volunteer deleted successfully'
    ], JSON_UNESCAPED_UNICODE);
}
?>