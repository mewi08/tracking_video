<?php

require_once __DIR__ . '/../models/Connection.php';
require_once __DIR__ . '/../models/Video.php';
require_once __DIR__ . '/../models/VideoTracking.php';

class VideoTrackingController {

    private $video;
    private $tracking;

    public function __construct($pdo) {
        $this->video    = new Video($pdo);
        $this->tracking = new VideoTracking($pdo);
    }

    public function getData(): array {
        return [
            'videos'   => $this->video->getAllAdmin(),
            'progress' => $this->tracking->getAllProgress(),
            'stats'    => $this->tracking->getStats()
        ];
    }
}