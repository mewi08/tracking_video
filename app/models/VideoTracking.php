<?php

class VideoTracking{

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function saveProgress(array $data): bool {
        $required = ['user_id', 'course_id', 'video_id', 'watched_seconds', 'percentage', 'status'];
        foreach ($required as $key) {
            if (!isset($data[$key])) {
                throw new InvalidArgumentException("Missing required field: $key");
            }
        }

        $sql = "
            INSERT INTO video_tracking
                (user_id, course_id, video_id, watched_seconds, percentage, status, started_at, completed_at)
            VALUES
                (?, ?, ?, ?, ?, ?,
                    IF(? > 0, NOW(), NULL),
                    IF(? = 'completed', NOW(), NULL)
                )
            ON DUPLICATE KEY UPDATE
                watched_seconds = IF(status = 'completed', watched_seconds, GREATEST(watched_seconds, VALUES(watched_seconds))),
                percentage      = IF(status = 'completed', percentage, GREATEST(percentage, VALUES(percentage))),
                status          = IF(status = 'completed', 'completed', VALUES(status)),
                started_at      = IF(started_at IS NULL AND VALUES(watched_seconds) > 0, NOW(), started_at),
                completed_at    = IF(VALUES(status) = 'completed' AND completed_at IS NULL, NOW(), completed_at),
                last_activity   = NOW()
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $data['user_id'],
            $data['course_id'],
            $data['video_id'],
            $data['watched_seconds'],
            $data['percentage'],
            $data['status'],
            $data['watched_seconds'],
            $data['status']
        ]);
    }

    // Get progress of all students
    public function getAllProgress(): array {
        $sql = "
            SELECT 
                vt.user_id,
                vt.course_id,
                v.title        AS video_title,
                vt.percentage,
                vt.status,
                vt.started_at,
                vt.completed_at,
                vt.last_activity
            FROM video_tracking vt
            JOIN video v ON v.id = vt.video_id
            ORDER BY vt.last_activity DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get general statistics
    public function getStats(): array {
        $sql = "
            SELECT
                COUNT(*)                                        AS total_students,
                SUM(status = 'completed')                       AS completed,
                SUM(status = 'in progress')                     AS in_progress,
                SUM(status = 'not started')                     AS not_started,
                ROUND(AVG(percentage), 2)                       AS avg_percentage
            FROM video_tracking
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}