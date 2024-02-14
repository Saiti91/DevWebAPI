<?php 
include_once "./repository/appartementRepository.php";

class AppartementService {

    private $repository;

    function __construct() {
        $this->repository = new AppartementRepository();
    }

    function create_appartement($appartement_object) {
        return $this->repository->create_appartement($appartement_object);
    }
//add Reserve appartement
    function get_appartement($id) {
        return $this->repository->get_appartement($id);
    }

    function get_appartements() {
        return $this->repository->get_appartements();
    }

    function delete_appartement($id) {
        $this->repository->delete_appartement($id);
    }

    function update_appartement($id, $appartement_object) {
        return $this->repository->update_appartement($id, $appartement_object);

    }
}


?>
