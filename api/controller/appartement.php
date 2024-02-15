<?php 
include_once "./service/appartementService.php";
include_once "./class/appartement.php";


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
        $json = file_get_contents('php://input');

        $data = json_decode($json, true);

        if (!$data) {
            $res->content = json_encode(array('error' => 'Invalid JSON data'));
            return;
        }

        if($this->get_right($data['token'])==1){
        $appartement_object = new Appartement();
        $appartement_object->superficie = $data['superficie'];
        $appartement_object->nb_occupant = $data['nb_occupant'];
        $appartement_object->rue = $data['rue'];
        $appartement_object->ville = $data['ville'];
        $appartement_object->cp = $data['cp'];
        $appartement_object->prix = $data['prix'];
        $appartement_object->proprietaire = $data['proprietaire'];

        $new_appartement = $this->service->create_appartement($appartement_object);

        // Envoyer une réponse au client
        $res->content = json_encode($new_appartement);
        }
        else{
            $res->status = 401;
            $res->content = '{"message":"Not enough permission"}';
        }
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

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (!$data) {
            $res->content = json_encode(array('error' => 'Invalid JSON data'));
            return;
        }

        if($this->get_right($data['token'])==1) {
            if (!isset($req->uri[3])) {
                $res->status = 400;
                $res->content = '{"message":"Cannot delete without ID"}';
            }

            $this->service->delete_appartement($req->uri[3]);
            $res->status = 200;
            $res->content = '{"message":"Appartement Correctly deleted"}';
        }
    }

    function update_appartement($req, $res) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (!$data) {
            $res->content = json_encode(array('error' => 'Invalid JSON data'));
            return;
        }

            if($this->get_right($data['token'])==1) {
                if (!isset($req->uri[3])) {
                    $res->status = 400;
                    $res->content = '{"message":"Cannot update without ID"}';
                }

                $json = file_get_contents('php://input');

                $data = json_decode($json, true);

                if (!$data) {
                    $res->content = json_encode(array('error' => 'Invalid JSON data'));
                    return;
                }

                // Créer un nouvel objet Appartement en utilisant les données JSON
                $appartement_object = new Appartement();
                $appartement_object->superficie = $data['superficie'];
                $appartement_object->nb_occupant = $data['nb_occupant'];
                $appartement_object->rue = $data['rue'];
                $appartement_object->ville = $data['ville'];
                $appartement_object->cp = $data['cp'];
                $appartement_object->prix = $data['prix'];
                $appartement_object->proprietaire = $data['proprietaire'];

                $new_appartement = $this->service->update_appartement($req->uri[3], $appartement_object);
            }
        $res->status = 200;
        $res->content = $new_appartement;
        }

    function get_right($token)
    {
       $droit = $this->service->get_right($token);
        return $droit;
    }

}

?>
