<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'database.php';
require '../SoloProject/api/controller/AnimalController.php';
require '../SoloProject/api/controller/VolunteerController.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE');

$method = $_SERVER['REQUEST_METHOD'];
$q = $_GET['q'] ?? '';
$params = $q ? explode('/', $q) : [];
$type = $params[0] ?? null;
$id = $params[1] ?? null;

function sendJson($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

switch ($method) {
    case 'GET':
        if ($type === 'animals') {
            if ($id) {
                getAnimalByIdApi($pdo, $id);
            } else {
                getAllAnimalsApi($pdo);
            }
        } elseif ($type === 'volunteers') {
            getAllVolunteersApi($pdo);
        } else {
            sendJson(['error' => 'Not found'], 404);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) sendJson(['error' => 'Invalid JSON'], 400);

        if ($type === 'animals') {
            addAnimalApi($pdo, $data);
        } elseif ($type === 'volunteers') {
            addVolunteerApi($pdo, $data);
        } else {
            sendJson(['error' => 'Not found'], 404);
        }
        break;

    case 'DELETE':
        if ($type === 'animals' && $id) {
            deleteAnimalApi($pdo, $id);
        } elseif ($type === 'volunteers' && $id) {
            // ДОБАВЛЯЕМ УДАЛЕНИЕ ВОЛОНТЁРА
            deleteVolunteerApi($pdo, $id);
        } else {
            sendJson(['error' => 'Not found'], 404);
        }
        break;

    default:
        sendJson(['error' => 'Method not allowed'], 405);
}