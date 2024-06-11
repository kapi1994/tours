<?php 
header("Content-type:application/json");
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image'];
    $duration = $_POST['duration'];
    $categories = explode(",",$_POST['categories']);
    $short_description = $_POST['short_description'];
    $long_description= $_POST['long_description'];
    $limit = $_POST['limit'];

   
    include '../validations.php';


    $tourFormValidation = tourFormValidation($name, $price, $duration, $categories, $short_description, $long_description, $image);
    if(count($tourFormValidation) > 0)
        printErrorsMessage($tourFormValidation);
    else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';

            $image_name = uploadImage($image);
            $checkTourName = checkTourName($name);
            if($checkTourName){
                echo json_encode("Destinacija sa tim nazivom vec postoji");
                http_response_code(409);
            }else{
               $connection->beginTransaction();
               insertTour($name, $short_description, $long_description, $image_name, $duration , $price, $categories);
               $connection->commit();
               echo json_encode([
                'message' => "Nova destinacija je dodata",
                'tours' => getAllTours($limit),
                'pages' => getAllToursPagination(),
                'offset' => ADMIN_OFFSET
               ]);
               http_response_code(201);
            }

        } catch (PDOException $th) {
            $connection->rollBack();
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
}else{
    http_response_code(404);
}