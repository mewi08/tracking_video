<?php
session_start();

if (empty($_SESSION['user_id'])) {
    http_response_code(403);
    die("Unauthorized access");
}

require_once __DIR__ . '/../app/controllers/VideoController.php';

$connection = new Connection();
$pdo        = $connection->getConnection();
$controller = new VideoController($pdo);
$data       = $controller->getData();

$videos    = $data['videos'];
$name      = $_SESSION['name_full'];
$user_id   = $_SESSION['user_id'];
$course_id = $_SESSION['course_id'];

require_once __DIR__ . '/templates/student.html.php';