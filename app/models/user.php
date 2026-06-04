<?php

class User
{
    // PDO database connectie opslaan
    private PDO $pdo;

    // Constructor ontvangt PDO connectie
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Nieuwe gebruiker aanmaken //
    public function create(string $email, string $wachtwoord, string $role = 'user'): bool
    {
        // SQL query voorbereiden
        $sql = "INSERT INTO users (email, wachtwoord, role, created_at)
                VALUES (:email, :wachtwoord, :role, CURDATE())";

        $stmt = $this->pdo->prepare($sql);    //Stuurt de query naar de database//

        // Query uitvoeren met parameters
        return $stmt->execute([
            ':email' => $email,

            // Wachtwoord veilig hashen
            ':wachtwoord' => password_hash($wachtwoord, PASSWORD_DEFAULT),

            ':role' => $role
        ]);
    }

    // Gebruiker ophalen via ID //
    public function findById(int $id): ?array
    {
        // SQL query
        $sql = "SELECT * FROM users WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);    //Stuurt de query naar de database//

        // Parameter meegeven
        $stmt->execute([
            ':id' => $id
        ]);

        // Resultaat ophalen
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Als geen gebruiker gevonden -> null
        return $user ?: null;
    }

    //Gebruiker ophalen via email//
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);    //Stuurt de query naar de database//

        $stmt->execute([
            ':email' => $email
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    //Alle gebruikers ophalen//
    public function all(): array
    {
        // Alle users ophalen, nieuwste eerst
        $sql = "SELECT * FROM users ORDER BY created_at DESC";

        $stmt = $this->pdo->query($sql);    //Stuurt de query naar de database//

        // Alle resultaten teruggeven
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Gebruiker verwijderen //
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);    //Stuurt de query naar de database//

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}