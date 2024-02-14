<?php 
include_once "./service/appartementService.php";
include_once "./class/appartementUser.php";


class AppartementController {

    private $service;

    function __construct() {
        $this->service = new AppartementService();
    }

    function dispatch($req, $res) {
        switch ($req->method) {
            case "GET":
                if (isset($req->uri[3])) {
                    $this->get_appartement($req, $res);
                    break;
                }
                $this->get_appartements($req, $res);
                
            break;

            case "PATCH":
                $res->content = $this->update_appartement($req, $res); 
            break;

            case "PUT":
                 $res->content = $this->update_appartement($req, $res);
            break;

            case "DELETE":
                $this->delete_appartement($req, $res);
            break;

            case "POST":
                $this->create_appartement($req, $res);
            break;
           
        }


    }

    function create_appartement($req, $res) {
        $appartement_object = new Appartement();

        $new_appartement = $this->service->create_appartement($appartement_object);
    }


    // un appartement spécifique
    function get_appartement($req, $res) {
        $appartement = $this->service->get_appartement($req->uri[3]);
        
        $res->content = $appartement;
    }
    
    //tous les appartement!!!
    function get_appartements($req, $res) {
        $appartements = $this->service->get_appartements();

        $res->content = $appartements;
    }

    function delete_appartement($req, $res) {
        if (!isset($req->uri[3])) {
            $res->status = 400;
            $res->content = '{"message":"Cannot delete without ID"}';
        }

        $this->service->delete_appartement($req->uri[3]);
    }

    function update_appartement($req, $res) {
        if (!isset($req->uri[3])) {
            $res->status = 400;
            $res->content = '{"message":"Cannot update without ID"}';
        }

        $appartement = new Appartement($req->body->description, $req->body->date, $req->body->done);

        $this->service->delete_appartement($req->uri[3], $appartement);
    }

}

?>
