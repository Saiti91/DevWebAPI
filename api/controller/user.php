<?php

use Sevices\UserService;

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
            case "GET":
                if (isset($req->uri[3])) {
                    $this->get_user($req, $res);
                    break;
                }
                $this->get_users($req, $res);
           
        }

    }

    function create_user($req, $res) {
        $json = file_get_contents('php://input');

        $data = json_decode($json, true);

        if (!$data) {
            $res->content = json_encode(array('error' => 'Invalid JSON data'));
            return;
        }

        $user_object = new User();

        $length = 16; // Longueur du token en bytes (un byte = 2 caractères hexadécimaux)
        $token = bin2hex(random_bytes($length / 2)); // La longueur est divisée par 2 car chaque byte est représenté par 2 caractères hexadécimaux
        $user_object->token =$token;
        $user_object->nom = $data['nom'];
        $user_object->prenom = $data['prenom'];
        $user_object->droit = $data['droit'];

        $new_user = $this->service->create_user($user_object);
        $res->content = $new_user;
    }
    function get_user($req, $res){
        $user = $this->service->get_user($req->uri[3]);
        $res->content = $user;
    }
    function get_users($req, $res){
        $user=$this->service->get_users();
        $res->content = $user;
    }
    function get_right($req, $res)
    {
        $this->service->get_right($req->body->token);
    }
}

?>
