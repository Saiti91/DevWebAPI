<?php
include_once "./common/exceptions/repository_exceptions.php";

class ReservationRepository {

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

    public function create_resevation($resevation_object): void {
        $result = pg_query($this->connection, "INSERT INTO resevation (client_id,appartement_id,prix,date_debut,date_fin) VALUES (!!!!!)");

        if (!$result) {
            throw new Exception(pg_last_error());
        }

        return;
    }
}
?>