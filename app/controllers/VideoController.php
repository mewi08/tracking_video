<?php

require_once __DIR__ . '/../models/Connection.php';
require_once __DIR__ . '/../models/Video.php';

class VideoController {

    private $video;

    public function __construct($pdo) {
        $this->video = new Video($pdo);
    }

    public function getData(): array {
        return [
            'videos' => $this->video->getAll()
        ];
    }
}