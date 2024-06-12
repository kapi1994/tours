<?php 
session_start();
header("Content-type:Application/json");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user_id = $_SESSION['user']->id;
    $tour_id = $_POST['tour_id'];
    $date = $_POST['date'];

    include '../validations.php';
    $tourReservationFormValidation = tourFormResValidation($date);
    if(count($tourReservationFormValidation)>0)
        printErrorsMessage($tourReservationFormValidation);
    else {
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            storeNewReservation($tour_id, $user_id);
            echo json_encode("Hvala vam sto ste rezervisali");
            http_response_code(201);   
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
}
else http_response_code(404);