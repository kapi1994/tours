<?php 
    header("Content-type:application/json");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST['id'];
        $tour_id = $_POST['tour_id'];
        $date = $_POST['date'];

        include '../validations.php';
        $dateFormValidation = dateFormValidation($date);
        if(count($dateFormValidation) > 0)
            printErrorsMessage($dateFormValidation);
        else{
            try {
                require_once '../../config/connection.php';
                include '../functions.php';
                $checkDate = checkTourDate($date, $tour_id);
                if($checkDate && $checkDate->date == $date && $checkDate->tour_id == $tour_id && $checkDate->id != $id){
                    echo json_encode("Tour with this date allready exists");
                    http_response_code(409);
                }else{
                    updateTourDate($date, $id);
                    echo json_encode(getOneDateFullRow($id));
                }

            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);    
            }
        }
    }
    else http_response_code(404);