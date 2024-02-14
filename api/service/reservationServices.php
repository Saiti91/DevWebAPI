<?php

namespace Sevices;

use ReservationRepository;

include_once "./repository/appartementRepository.php";
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
        $origin = date_create($reservation_object->date_debut);
        $target = date_create($reservation_object->date_fin);
        $interval = date_diff($origin, $target);

        $prixAppart = $this->repository->get_price($reservation_object->appartement_id);
        $reservation_object->prix = $prixAppart*($interval+1);

        return $this->repository->create_reservation($reservation_object);
    }

/*    function get_appartement($id)
    {
        return $this->repository->get_appartement($id);
    }

    function get_appartements()
    {
        return $this->repository->get_appartements();
    }

    function delete_appartement($id)
    {
        $this->repository->delete_appartement($id);
    }

    function update_appartement($id, $appartement_object)
    {
        return $this->repository->update_appartement($id, $appartement_object);

    }*/
}

?>