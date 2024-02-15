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
        //ajouter la vérification propietaire ou deja reserver
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (!$data) {
            $res->content = json_encode(array('error' => 'Invalid JSON data'));
            return;
        }
        $reservation_object = new Reservation();
        $reservation_object->client_id = $data['client_id'];
        $reservation_object->appartement_id = $data['appartement_id'];
        $reservation_object->date_debut = $data['date_debut'];
        $reservation_object->date_fin = $data['date_fin'];
        $new_reseration = $this->service->reserve_appartement($reservation_object);

    }
    function get_right($req, $res)
    {
        $this->service->get_right($req->body->token);
    }

}

?>
