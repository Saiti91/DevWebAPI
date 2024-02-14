<?php
include_once "./common/exceptions/repository_exceptions.php";

class UserRepository {

    private $connection = null;

    public function __construct() {
        try {
            $this->connection = pg_connect("host=database port=5432 dbname=appartement_db user=appartement password=password");
            if (  $this->connection == null ) {
                throw new Exception("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new Exception("Database connection failed :".$e->getMessage());
        }
    }

    public function create_user($user_object): void {
        var_dump($user_object);

        // Access object properties explicitly
        $nom = $user_object->nom;
        $prenom = $user_object->prenom;

        // Using prepared statements to avoid SQL injection
        $query = "INSERT INTO users (nom, prenom) VALUES ($1, $2)";
        $result = pg_query_params($this->connection, $query, array($nom, $prenom));

        if (!$result) {
            throw new Exception(pg_last_error());
        }

        return;
    }
    public function get_users(): array {
        $result = pg_query($this->connection, "SELECT * FROM users");
        $users = [];

        if (!$result) {
            throw new Exception("Error fetching users: " . pg_last_error());
        }

        while ($row = pg_fetch_assoc($result)) {
            $users[] = $row;
        }

        return $users;
    }

    public function get_user($id): ?array {
        $result = pg_query($this->connection, "SELECT * FROM users WHERE id = $id");

        if (!$result) {
            throw new Exception("Error fetching user: " . pg_last_error());
        }

        $user = pg_fetch_assoc($result);

        return $user ?: null;
    }
}
?>