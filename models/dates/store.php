<?php 
header("Content-type:application/json");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $tour_id=$_POST['tour_id'];
    $date = $_POST['date'];

    include '../validations.php';
    $dateFormValidation = dateFormValidation($date);
    if(count($dateFormValidation)> 0)
        printErrorsMessage($dateFormValidation);
    else{
        try {
            
            require_once '../../config/connection.php';
            include '../functions.php';

            $checkDate = checkTourDate($date, $tour_id);
            if($checkDate){
                echo json_encode("Tura koja je planirana da se odrzi na taj datum vec postoji");
                http_response_code(409);
            }else{
                insertTourDate($date, $tour_id);
                echo json_encode([
                    'tours' => getTourDates($tour_id),
                    'message' => 'Novi termin je dodat'
                ]);
            }
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
}
else http_response_code(404);