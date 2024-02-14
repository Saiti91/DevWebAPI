<?php 
include_once "./service/userService.php";
include_once "./class/user.php";

class UserController {

    private $service;

    function __construct() {
        $this->service = new UserService();
    }

    function dispatch($req, $res) {
        switch ($req->method) {
            case "POST":
                $this->create_user($req, $res);
            break;
           
        }

    }

    function create_user($req, $res) {
        $reservation_object = new User(
            $req->body->prenom,
            $req->body->nom
        );


        $new_reservation = $this->service->create_user($reservation_object);
    }


}

?>
