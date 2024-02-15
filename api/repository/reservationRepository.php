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

    public function get_reservations(): array {
        $result = pg_query($this->connection, "SELECT * FROM reservation");
        $reservations = [];

        if (!$result) {
            throw new Exception(pg_last_error());
        }

        while ($row = pg_fetch_assoc($result)) {
            $reservations[] = $row;
        }

        return $reservations;
    }
    public function create_reservation($resevation_object): void {
        $result = pg_query($this->connection, "SELECT * FROM reservation WHERE appartement_id = $resevation_object->appartement_id");
        $reservations = [];
        while ($row = pg_fetch_assoc($result)) {
            $reservations[] = $row;
        }

        foreach($reservations as $key => $value){
            if($value['date_debut'] <= $resevation_object->date_debut && $value['date_fin'] >= $resevation_object->date_fin){
                return;
            }
            elseif($value['date_debut'] >= $resevation_object->date_debut && $value['date_fin'] <= $resevation_object->date_fin){
                return;
            }
            elseif($value['date_debut'] <= $resevation_object->date_fin && $value['date_fin'] >= $resevation_object->date_fin){
                return;
            }
            elseif($value['date_debut'] <= $resevation_object->date_debut && $value['date_fin'] >= $resevation_object->date_debut){
                return;
            }
        }

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
            throw new BddNotFoundException("Requested to-do does not exist");
        }
        return $droit['droit'];
    }
    function get_proprioName($token, $appart_id)
    {
        $result = pg_query($this->connection, "SELECT COUNT(*) AS count_match 
                                           FROM appartements a
                                           INNER JOIN users u ON a.proprietaire = u.Nom
                                           WHERE u.token = '$token' 
                                           AND a.id = $appart_id");

        if (!$result) {
            throw new Exception(pg_last_error());
        }

        $row = pg_fetch_assoc($result);
        $count_match = (int)$row['count_match'];
        return $count_match > 0;
    }

}
?>