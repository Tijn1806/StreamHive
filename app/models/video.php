<?php

class Video
{
    // PDO database connectie
    private PDO $pdo;

    // Constructor
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Nieuwe video toevoegen
     */
    public function create(
        int $userId,
        string $title,
        ?string $description,
        string $filename
    ): bool {

        // SQL query
        $sql = "INSERT INTO videos
                (user_id, title, description, filename, weergaven, created_at)
                VALUES
                (:user_id, :title, :description, :filename, 0, CURDATE())";

        // Query voorbereiden
        $stmt = $this->pdo->prepare($sql);

        // Query uitvoeren
        return $stmt->execute([
            ':user_id' => $userId,
            ':title' => $title,
            ':description' => $description,
            ':filename' => $filename
        ]);
    }

    /**
     * Video ophalen via ID
     */
    public function findById(int $id): ?array
    {
        // Video + gebruiker ophalen
        $sql = "SELECT videos.*, users.email
                FROM videos
                JOIN users ON videos.user_id = users.id
                WHERE videos.id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        $video = $stmt->fetch(PDO::FETCH_ASSOC);

        return $video ?: null;
    }

    public function search(string $searchTerm): array
{
    $sql = "SELECT videos.*, users.email
            FROM videos
            JOIN users ON videos.user_id = users.id
            WHERE title LIKE :search
            ORDER BY created_at DESC";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        ':search' => '%' . $searchTerm . '%'
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    /**
     * Alle video's ophalen
     */
    public function all(): array
    {
        $sql = "SELECT videos.*, users.email
                FROM videos
                JOIN users ON videos.user_id = users.id
                ORDER BY videos.created_at DESC";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Alle video's van één gebruiker ophalen
     */
    public function findByUserId(int $userId): array
    {
        $sql = "SELECT *
                FROM videos
                WHERE user_id = :user_id
                ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Weergaven verhogen met 1
     */
    public function addView(int $id): bool
    {
        $sql = "UPDATE videos
                SET weergaven = weergaven + 1
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    /**
     * Video verwijderen
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM videos WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}