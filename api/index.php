<?php
include_once "./common/request.php";
include_once "./common/response.php";
include_once "./controller/appartement.php";
include_once "./controller/reservation.php";
include_once "./controller/user.php";

header("Content-Type: application/json; charset=utf8");
header("Access-Control-Allow-Origin: *");

$response = new Response();

$request = new Request();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request->uri = explode( '/', $uri );

$request->method = $_SERVER['REQUEST_METHOD'];

$body = file_get_contents("php://input");
$request->body = json_decode($body);

function router($req, $res) {

    switch ($req->uri[2]) {
        case "appartement":
            $controller = new AppartementController();
            $controller->dispatch($req, $res);
            break;

            case "reservation":
                $controller = new ReservationController(); 
                $controller->dispatch($req, $res);
                break;
    
            case "user":
                    $controller = new UserController(); 
                    $controller->dispatch($req, $res);
                    break;
    
        default:
            $res->status = 404;
            $res->content = '{"message": "Url not found"}';
    }
}
try {
    router($request, $response);
} catch (BddNotFoundException $e) {
    $response->status = 404;
    $response->content = '{"message":"'.$e->getMessage().'"}';
}

$response->send();

?>
