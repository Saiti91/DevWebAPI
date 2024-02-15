<?php

namespace Sevices;

use ReservationRepository;

include_once "./repository/reservationRepository.php";
include_once "./class/reservation.php";

class reservationServices
{

    private $repository;

    function __construct()
    {
        $this->repository = new ReservationRepository();
    }


    function reserve_appartement($reservation_object)
    {
        var_dump($reservation_object);
        $start_date = date_create_from_format('d/m/Y', $reservation_object->date_debut);
        $end_date = date_create_from_format('d/m/Y', $reservation_object->date_fin);

        $interval = $start_date->diff($end_date);
        $num_days = $interval->days + 1;
        if(!$this->get_proprioName($reservation_object->token,$reservation_object->appartement_id)){
            $prixAppart = $this->repository->get_price($reservation_object->appartement_id);
        }
        else{
            $prixAppart = 0;
        }
        $reservation_object->prix = $prixAppart * $num_days;

        return $this->repository->create_reservation($reservation_object);
    }
    function get_right($token)
    {
        return $this->repository->get_right($token);
    }
    function get_reservations() {
        return $this->repository->get_reservations();
    }
    function get_proprioName($token,$appart_id)
    {
        return $this->repository->get_proprioName($token,$appart_id);
    }
}

?>