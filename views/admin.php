<?php
session_start();

if (empty($_SESSION['user_id'])) {
    http_response_code(403);
    die("Unauthorized access");
}

$roles = $_SESSION['roles'] ?? '';
if (!str_contains($roles, 'Administrator')) {
    http_response_code(403);
    die("Access restricted to administrators only");
}

require_once __DIR__ . '/../app/controllers/VideoTrackingController.php';

$connection = new Connection();
$pdo        = $connection->getConnection();
$controller = new VideoTrackingController($pdo);
$data       = $controller->getData();

$videos   = $data['videos'];
$progress = $data['progress'];
$stats    = $data['stats'];
$name     = $_SESSION['name_full'];

require_once __DIR__ . '/templates/admin.html.php';