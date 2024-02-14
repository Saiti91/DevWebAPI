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
        $result = pg_query($this->connection, "INSERT INTO users (nom,prenom) VALUES (!!)");

        if (!$result) {
            throw new Exception(pg_last_error());
        }

        return;
    }
}
?>