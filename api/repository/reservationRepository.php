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

    public function create_reservation($resevation_object): void {
        var_dump($resevation_object);
        $result = pg_query($this->connection, "INSERT INTO reservation (client_id, appartement_id, prix, date_debut, date_fin) 
    VALUES (
        $resevation_object->client_id,
        $resevation_object->appartement_id,
        $resevation_object->prix,
        to_timestamp('$resevation_object->date_debut', 'DD/MM/YYYY'),
        to_timestamp('$resevation_object->date_fin', 'DD/MM/YYYY')
    )");

        if (!$result) {
            throw new Exception(pg_last_error());
        }

        return;
    }
    public function  get_price($id)
    {
        $result = pg_query($this->connection, "SELECT prix FROM appartements WHERE id = ($id)");

        if (!$result) {
            throw new Exception(pg_last_error());
        }
        $price = pg_fetch_assoc($result);

        return $price["prix"];
    }
    function get_right($token)
    {
        $result = pg_query($this->connection, "SELECT Droit FROM users where token = '$token'");

        if (!$result) {
            throw new Exception(pg_last_error());
        }

        $droit = pg_fetch_assoc($result);

        if (!$droit) {
            throw new BddNotFoundException("Requested right does not exist");
        }
        return $droit['droit'];
    }
}
?>