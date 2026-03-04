<?php

header("Content-Type: application/json");

require_once __DIR__ . '/../models/Connection.php';
require_once __DIR__ . '/../models/Video.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST allowed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id   = isset($data['id']) ? (int) $data['id'] : null;

if (!$id) {
    echo json_encode(["error" => "Missing video id"]);
    exit;
}

try {
    $connection = new Connection();
    $pdo        = $connection->getConnection();
    $video = new Video($pdo);

    $result = $video->toggle($id);

    echo json_encode([
        "status" => $result ? "success" : "error"
    ]);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}