<?php

// api/index.php
require '../model/database.php';
require 'functions.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

$method = $_SERVER['REQUEST_METHOD'];

// Получаем параметры из URL: /api/index.php?q=animals/1
$params = explode('/', $_GET['q']);
$type = $params[0];      // 'animals' или 'volunteers'
$id = $params[1] ?? null; // ID, если есть

switch ($method) {
    case 'GET':
        if ($type === 'animals') {
            if ($id) {
                getAnimal($pdo, $id);
            } else {
                getAnimals($pdo);
            }
        } elseif ($type === 'volunteers') {
            getVolunteers($pdo);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            $data = $_POST;
        }

        if ($type === 'animals') {
            addAnimal($pdo, $data);
        } elseif ($type === 'volunteers') {
            addVolunteer($pdo, $data);
        }
        break;

    case 'PATCH':
        if ($type === 'animals' && $id) {
            $data = json_decode(file_get_contents('php://input'), true);
            updateAnimal($pdo, $id, $data);
        }
        break;

    case 'DELETE':
        if ($type === 'animals' && $id) {
            deleteAnimal($pdo, $id);
        }
        break;
}