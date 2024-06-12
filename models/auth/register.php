<?php 
    header("Content-type:application/json");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

       $first_name = $_POST['first_name'];
       $last_name = $_POST['last_name'];
       $email = $_POST['email'];
       $password = $_POST['password'];

       include '../validations.php';
       $registerFormValidation = registerFormValidation($first_name, $last_name, $email, $password);
       if(count($registerFormValidation) > 0)
        printErrorsMessage($registerFormValidation);
       else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';

            if(checkEmail($email)){
                echo json_encode("Takav email je vec u upotrebi");
                http_response_code(409);
            }else{
                createNewAccount($first_name, $last_name, $email, $password);
                echo json_encode("Novi nalog je kreiran");
                http_response_code(201);
            }
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
       }
    }
    else http_response_code(404);