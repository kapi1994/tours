<?php 
header("Content-type:application/json");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try {
        require_once '../config/connection.php';
        include  'functions.php';
        echo json_encode([
            'numberOfUsers' => numberOfRegistretedUsers(),
            'numberOfTours' => numberOfTours(),
            'mostVisitedTours' => getTheMostVisitedTours()
        ]);
    } catch (PDOException $th) {
        echo json_encode($th->getMessage());    
        http_response_code(500);
    }
}else http_response_code(404);