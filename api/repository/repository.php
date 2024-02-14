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
//add Reserve appartement
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
        $result = pg_query($this->connection, "INSERT INTO appartements (done, description, date_time) VALUES (!!!')");

        if (!$result) {
            throw new Exception(pg_last_error());
        }

        return;
    }

    public function update_appartement($id , $appartement_object ): void {
        $query = "UPDATE appartements set ";

        if (isset($appartement_object->done)) {
            if ($appartement_object->done == "true") {
                $query .= " done = TRUE ";
            } else if ($appartement_object->done == "false") {
                $query = " done = FALSE ";
            }
        }

        if (isset($appartement_object->done) && isset($appartement_object->description)) {
            $query .= " , ";
        }

        if (isset($appartement_object->description)) {
            $query .= " description = '".$appartement_object->description."' ";
        }

        $query .= " where id = $id; ";
        $result = pg_query($this->connection,$query); 

        if (!$result) {
           throw new Exception(pg_last_error());
        }
    }
}
