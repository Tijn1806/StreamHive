<?php

class Like
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function toggle(int $userId, int $videoId): void
    {
        $sql = "SELECT * FROM likes WHERE user_id = :user_id AND video_id = :video_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':video_id' => $videoId
        ]);

        if ($stmt->fetch()) {
            $sql = "DELETE FROM likes WHERE user_id = :user_id AND video_id = :video_id";
        } else {
            $sql = "INSERT INTO likes (user_id, video_id) VALUES (:user_id, :video_id)";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':video_id' => $videoId
        ]);
    }

    public function countByVideoId(int $videoId): int
    {
        $sql = "SELECT COUNT(*) FROM likes WHERE video_id = :video_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':video_id' => $videoId]);

        return (int) $stmt->fetchColumn();
    }
}