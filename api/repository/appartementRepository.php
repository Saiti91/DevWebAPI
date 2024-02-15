<?php
include_once "./common/exceptions/repository_exceptions.php";

class AppartementRepository {

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
    public function get_appartements(): array {
            $result = pg_query($this->connection, "SELECT * FROM appartements");
            $appartements = [];

            if (!$result) {
                throw new Exception(pg_last_error());
            }

            while ($row = pg_fetch_assoc($result)) {
                $appartements[] = $row;
            }

            return $appartements;
    }

    public function get_appartement($id): mixed {
        $result = pg_query($this->connection, "SELECT * FROM appartements where id = $id");

        if (!$result) {
            throw new Exception(pg_last_error());
        }

        $appartement = pg_fetch_assoc($result); 

        if (!$appartement) {
            throw new BddNotFoundException("Requested to-do does not exist");        
        }

        return $appartement;

    }

    public function delete_appartement($id): void {
       $query = pg_prepare($this->connection,"","DELETE FROM appartements WHERE id = $1");

       $result = pg_execute($this->connection, "",[$id]);
    }

    public function create_appartement($appartement_object): void {

        $result = pg_query($this->connection, "INSERT INTO appartements (superficie,nb_occupant,rue,ville,cp,prix,proprietaire) 
        VALUES ($appartement_object->superficie,
                $appartement_object->nb_occupant,
                '$appartement_object->rue',
                '$appartement_object->ville',
                $appartement_object->cp,
                $appartement_object->prix,
                '$appartement_object->proprietaire')");


        if (!$result) {
            throw new Exception(pg_last_error());
        }

        return;
    }

    public function update_appartement($id , $appartement_object ): void {
        $query = "UPDATE appartements set ";


        if (isset($appartement_object->superficie)) {
            $query .= " superficie = '".$appartement_object->superficie."' ";
        }
        if (isset($appartement_object->nb_personne)) {
            $query .= " nb_personne = '".$appartement_object->nb_occupant."' ";
        }
        if (isset($appartement_object->rue)) {
            $query .= " rue = '".$appartement_object->rue."' ";
        }
        if (isset($appartement_object->ville)) {
            $query .= " ville = '".$appartement_object->ville."' ";
        }
        if (isset($appartement_object->cp)) {
            $query .= " cp = '".$appartement_object->cp."' ";
        }
        if (isset($appartement_object->prix)) {
            $query .= " prix = '".$appartement_object->prix."' ";
        }
        if (isset($appartement_object->proprietaire)) {
            $query .= " proprietaire = '".$appartement_object->proprietaire."' ";
        }

        $query .= " where id = $id; ";
        $result = pg_query($this->connection,$query); 

        if (!$result) {
           throw new Exception(pg_last_error());
        }
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

}
?>