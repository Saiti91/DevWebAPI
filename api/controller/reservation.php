<?php
use Sevices\ReservationServices;
include_once "./service/reservationServices.php";
include_once "./class/reservation.php";


class ReservationController {

    private $service;

    function __construct() {
        $this->service = new ReservationServices();
    }

    function dispatch($req, $res) {
        switch ($req->method) {
            case "POST":
                $this->reserve_appartement($req, $res);
            break;

        }

    }

    function reserve_appartement($req, $res) {
        $json = file_get_contents('php://input');

        // Décoder le JSON en un tableau associatif
        $data = json_decode($json, true);

        // Vérifier si les données JSON sont valides
        if (!$data) {
            // Gérer l'erreur de données JSON malformées
            // Par exemple, renvoyer une réponse d'erreur JSON au client
            $res->content = json_encode(array('error' => 'Invalid JSON data'));
            return;
        }

        // Créer un nouvel objet Appartement en utilisant les données JSON
        $reservation_object = new Reservation();
        $reservation_object->client_id = $data['client_id'];
        $reservation_object->appartement_id = $data['appartement_id'];
        $reservation_object->date_debut = $data['date_debut'];
        $reservation_object->date_fin = $data['date_fin'];

        // Appeler la méthode create_appartement du service
        $new_reseration = $this->service->reserve_appartement($reservation_object);

    }


}

?>
