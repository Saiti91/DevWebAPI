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
        $user_object->nom = $data['nom'];
        $user_object->prenom = $data['prenom'];

        $new_user = $this->service->create_user($user_object);
    }
    function get_user($req, $res){
        $this->service->get_user($req->uri[3]);
    }
    function get_users($req, $res){
        $this->service->get_users();
    }
}

?>
