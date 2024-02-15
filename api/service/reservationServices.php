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
        $start_date = date_create_from_format('d/m/Y', $reservation_object->date_debut);
        $end_date = date_create_from_format('d/m/Y', $reservation_object->date_fin);

        $interval = $start_date->diff($end_date);
        $num_days = $interval->days + 1; // Adding 1 to include the end date

        $prixAppart = $this->repository->get_price($reservation_object->appartement_id);
        $reservation_object->prix = $prixAppart * $num_days;

        return $this->repository->create_reservation($reservation_object);
    }
    function get_right($token)
    {
        return $this->repository->get_right($token);
    }

}

?>