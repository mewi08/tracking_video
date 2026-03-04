<?php
class Video {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function save(array $data): int {
        $sql = "
            INSERT INTO video (title, description, duration_seconds, video_url)
            VALUES (?, ?, ?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['duration_seconds'],
            $data['video_url']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function getAll(): array {
        $sql = "
            SELECT id, title, description, duration_seconds, video_url, created_at
            FROM video
            WHERE is_active = true
            ORDER BY created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array {
        $sql = "
            SELECT id, title, description, duration_seconds, video_url
            FROM video
            WHERE id = ? AND is_active = true
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $video = $stmt->fetch(PDO::FETCH_ASSOC);

        return $video ?: null;
    }

    public function disable(int $id): bool {
        $sql = "UPDATE video SET is_active = false WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Get all videos including inactive (for admin)
    public function getAllAdmin(): array {
        $sql = "
            SELECT id, title, description, duration_seconds, video_url, is_active, created_at
            FROM video
            ORDER BY created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Toggle video active/inactive
    public function toggle(int $id): bool {
        $sql = "UPDATE video SET is_active = !is_active WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}