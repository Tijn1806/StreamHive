<?php

class Video
{
    // PDO database connectie
    private PDO $pdo;

    // Constructor
    public function __construct(PDO $pdo)  
    {
        $this->pdo = $pdo;  // Dit slaat de pdo connectie op in een class
    }

    /**
     * Nieuwe video toevoegen
     */
    public function create(
        int $userId,
        string $title,
        ?string $description,  //? zorgt ervoor dat de parameter ook null mag zijn
        string $filename
    ): bool {

        // SQL query
        $sql = "INSERT INTO videos  
                (user_id, title, description, filename, weergaven, created_at)
                VALUES
                (:user_id, :title, :description, :filename, 0, CURDATE())";  //curdate() zorgt ervoor dat de datum automatisch wordt

        // Query voorbereiden
        $stmt = $this->pdo->prepare($sql);  //prepare zorgt ervoor dat de query nog niet wordt uitgevoerd

        // Query uitvoeren
        return $stmt->execute([  //hier wordt de query wel uitgevoerd
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

        $video = $stmt->fetch(PDO::FETCH_ASSOC);  //gegevens terug als een associatieve array dus eigen sleutels

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
    public function all(): array  //function all() geeft een array terug van alle videos
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