<?php

$host = 'localhost';
$dbname = 'shelter';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

// Функции уведомлений
function addNotification($pdo, $message, $type) {
    $sql = "INSERT INTO notifications (message, type, is_read, created_at) VALUES (:message, :type, 0, CURDATE())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':message' => $message, ':type' => $type]);
}

function getUnreadNotifications($pdo) {
    $sql = "SELECT * FROM notifications WHERE is_read = 0 ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getUnreadCount($pdo) {
    $sql = "SELECT COUNT(*) FROM notifications WHERE is_read = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
}
?>