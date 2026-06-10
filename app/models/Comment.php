<?php

class Comment
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $userId, int $videoId, string $content): bool
    {
        $sql = "INSERT INTO comments (user_id, video_id, content, created_at)
                VALUES (:user_id, :video_id, :content, CURDATE())";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':video_id' => $videoId,
            ':content' => $content
        ]);
    }

    public function findByVideoId(int $videoId): array
    {
        $sql = "SELECT comments.*, users.email
                FROM comments
                JOIN users ON comments.user_id = users.id
                WHERE video_id = :video_id
                ORDER BY comments.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':video_id' => $videoId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}