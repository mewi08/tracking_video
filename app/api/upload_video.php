<?php

header("Content-Type: application/json");

require_once __DIR__ . '/../models/Connection.php';
require_once __DIR__ . '/../models/Video.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST allowed"]);
    exit;
}

// Validate text fields
$title            = trim($_POST['title'] ?? '');
$description      = trim($_POST['description'] ?? '');
$duration_seconds = isset($_POST['duration_seconds']) ? (int) $_POST['duration_seconds'] : 0;

if (empty($title) || empty($description)) {
    echo json_encode(["error" => "Title and description are required"]);
    exit;
}

if ($duration_seconds <= 0) {
    echo json_encode(["error" => "Duration must be greater than 0"]);
    exit;
}

// Validate uploaded file
if (!isset($_FILES['video']) || $_FILES['video']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["error" => "No video file received"]);
    exit;
}

$file    = $_FILES['video'];
$allowed = ['video/mp4', 'video/webm', 'video/ogg'];
$maxSize = 500 * 1024 * 1024; // 500MB

// Validate file type
if (!in_array($file['type'], $allowed)) {
    echo json_encode(["error" => "Invalid file type. Only mp4, webm, ogg allowed"]);
    exit;
}

// Validate file size
if ($file['size'] > $maxSize) {
    echo json_encode(["error" => "File too large. Maximum 500MB"]);
    exit;
}

// Generate unique filename
$extension  = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename   = uniqid('video_') . '.' . $extension;
$uploadDir  = __DIR__ . '/../../public/video/';
$uploadPath = $uploadDir . $filename;

// Move uploaded file
if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
    echo json_encode(["error" => "Failed to save video file"]);
    exit;
}

try {
    $connection = new Connection();
    $pdo        = $connection->getConnection();
    $video = new Video($pdo);

    $video_id = $video->save([
        'title'            => $title,
        'description'      => $description,
        'duration_seconds' => $duration_seconds,
        'video_url'        => '/tracking/public/video/' . $filename
    ]);

    echo json_encode([
        "status"   => "success",
        "video_id" => $video_id
    ]);

} catch (Exception $e) {
    // If DB fails, delete uploaded file
    unlink($uploadPath);
    echo json_encode(["error" => $e->getMessage()]);
}