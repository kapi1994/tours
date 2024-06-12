<?php 
header("Contact-type:application/json");
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    include '../validations.php';
    $contactValidation = contactFormValidation($first_name,$last_name,$email,$message);
    if(count($contactValidation)> 0)
        printErrorsMessage($contactValidation);
    else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            storeNewMessage($first_name, $last_name, $email, $message);
            echo json_encode("Hvala sto ste nas kontaktirali");
        } catch (PDOException $th) {
           echo json_encode($th->getMessage());
           http_response_code(500);
        }
    }
}


else http_response_code(404);