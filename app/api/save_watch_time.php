<?php

if ($_ENV['APP_ENV'] === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

header("Content-Type: application/json");

require_once __DIR__ . '/../models/Connection.php';
require_once __DIR__ . '/../models/VideoTracking.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST allowed"]);
    exit;
}

$raw = file_get_contents("php://input");

if (!$raw) {
    echo json_encode(["error" => "No data received"]);
    exit;
}

$data = json_decode($raw, true);

if (!$data) {
    echo json_encode(["error" => "Invalid JSON"]);
    exit;
}

$user_id   = isset($data['user_id'])   ? (int) $data['user_id']   : null;
$course_id = isset($data['course_id']) ? (int) $data['course_id'] : null;
$video_id  = isset($data['video_id'])  ? (int) $data['video_id']  : null;
$watched = isset($data['watched_seconds']) ? (int) $data['watched_seconds'] : 0;
$percentage = max(0, min(100, (float) ($data['percentage'] ?? 0)));
$allowed_statuses = ['not started', 'in progress', 'completed'];
$status = in_array($data['status'] ?? '', $allowed_statuses)? $data['status'] : 'not started';

if (!$user_id || !$course_id || !$video_id) {
    echo json_encode(["error" => "Missing required data"]);
    exit;
}

try {

    $connection = new Connection();
    $pdo = $connection->getConnection();

    $tracking = new VideoTracking($pdo);

    $result = $tracking->saveProgress([
        "user_id" => $user_id,
        "course_id" => $course_id,
        "video_id" => $video_id,
        "watched_seconds" => $watched,
        "percentage" => $percentage,
        "status" => $status
    ]);

    echo json_encode([
        "status" => $result ? "success" : "error"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "error" => $e->getMessage()
    ]);
}