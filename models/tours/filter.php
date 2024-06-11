<?php
session_start();
header("Content-type:Application/json");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $text = isset($_GET['text']) ? $_GET['text'] : '';
    $categories = isset($_GET['selectedCheckboxes']) ? implode(",", $_GET['selectedCheckboxes']) : '';
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
        
  
    try {
        require_once '../../config/connection.php';
        include '../functions.php';

        $tours = '';
        $pages = '';
        $offset = '';

        if(!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION['user']->role_id == 2){
            $tours = getAvailableTours($limit, $text, $categories);
            $pages = getAvaliableToursPagination($text, $categories);
        }else if(isset($_SESSION['user']) && $_SESSION['user']->role_id == 1){
            $tours = getAllTours($limit);
            $pages = getAllToursPagination();
            $offset = ADMIN_OFFSET;
        }

        echo json_encode([
            'tours' => $tours,
            'pages' => $pages,
            'offset' => $offset
        ]);
    } catch (PDOException $th) {
        echo json_encode($th->getMessage());
        http_response_code(500);
    }
   

}else http_response_code(404);