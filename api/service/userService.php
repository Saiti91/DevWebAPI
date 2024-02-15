<?php

namespace Sevices;

use UserRepository;

include_once "./repository/userRepository.php";

class UserService
{

    private $repository;

    function __construct()
    {
        $this->repository = new UserRepository();
    }
    function create_user($user_object)
    {
        return $this->repository->create_user($user_object);
    }
    function get_user($id)
    {
        return $this->repository->get_user($id);
    }
    function get_users()
    {
        return $this->repository->get_users();
    }

    function get_right($token)
    {
        return $this->repository->get_right($token);
    }



//    function get_appartement($id)
//    {
//        return $this->repository->get_appartement($id);
//    }
//
//    function get_appartements()
//    {
//        return $this->repository->get_appartements();
//    }
//
//    function delete_appartement($id)
//    {
//        $this->repository->delete_appartement($id);
//    }
//
//    function update_appartement($id, $appartement_object)
//    {
//        return $this->repository->update_appartement($id, $appartement_object);
//
//    }
}

?>