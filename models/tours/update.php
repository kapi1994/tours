<?php 
header("Content-type:application/json");
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $id = $_POST["id"];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = isset($_FILES['image']) ? $_FILES['image'] : '';
    $duration = $_POST['duration'];
    $categories = explode(",",$_POST['categories']);
    $short_description = $_POST['short_description'];
    $long_description= $_POST['long_description'];
    $currentImage = $_POST['currentImage'];

    include '../validations.php';


    $tourFormValidation = tourFormValidation($name, $price, $duration, $categories, $short_description, $long_description, $image);
    if(count($tourFormValidation) > 0)
        printErrorsMessage($tourFormValidation);
    else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            $oldImagePath = "../../assets/img/$currentImage";
            $image_name = $image != "" ? uploadImage($image) : "";
            $image != "" ? unlink($oldImagePath): "";

            $checkTourName = checkTourName($name);
            if($checkTourName && $checkTourName->name == $name && $checkTourName->id != $id){
                echo json_encode("Destinacija sa tim nazivom vec postoji!");
                http_response_code(409);
            }else{

               $connection->beginTransaction();
               updateTour($name, $short_description, $long_description, $duration, $price, $categories, $id, $image_name);
               $connection->commit();
               echo json_encode(getOneTourFullRow($id));
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