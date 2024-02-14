<?php 
include_once "./service/reservationServices.php";
include_once "./class/reservation.php";


class ReservationController {

    private $service;

    function __construct() {
        $this->service = new ReservationService();
    }

    function dispatch($req, $res) {
        switch ($req->method) {
            case "POST":
                $this->reserve_appartement($req, $res);
            break;

        }

    }

    function reserve_appartement($req, $res) {
        $reservation_object = new Reservation(
            $req->body->client_id,
            $req->body->appartement_id,
            $req->body->date_debut,
            $req->body->date_fin
        );



        $new_reservation = $this->service->reserve_appartement($reservation_object);
    }


}

?>
