<?php 
include_once "./reservation/service.php";

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
        $reservation_object = new Reservation();


        $new_reservation = $this->service->reserve_appartement($reservation_object);
    }


}

?>
