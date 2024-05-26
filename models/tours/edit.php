<?php 
header("Content-type:application/json");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = $_GET['id'];

    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        echo json_encode(getOneTour($id));
    } catch (PDOException $th) {
        echo json_encode($th->getMessage());
        http_response_code(500);
    }
}
else{
    http_response_code(404);
}