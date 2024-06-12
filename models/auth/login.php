<?php 
session_start();
header("Content-type:application/json");
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST['email'];
    $password= $_POST['password'];

    include '../validations.php';
    $loginFormValidation = loginFormValidation($email,$password);
    if(count($loginFormValidation) > 0)
        printErrorsMessage($loginFormValidation);
    else{
        try {
           require_once '../../config/connection.php';
           include '../functions.php';

            if(!checkEmail($email)){
                echo json_encode("Nalog sa ovim email-om nepostoji");
                http_response_code(401);
            }else{
               
                $checkAccount = checkAccount($email, $password);
                if($checkAccount){
                    $_SESSION['user'] = $checkAccount;
                    echo json_encode($checkAccount->role_id);
                }else{
                    echo json_encode("Vasi kredencijali nisu u redu! Pokusajte ponovo");
                    http_response_code(401);
                }
            }

        } catch (PDOException  $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }

}
else http_response_code(404);