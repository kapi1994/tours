<?php 
header("Content-type:application/json");
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name =  $_POST['name'];
    $id = $_POST['id'];

    include '../validations.php';
    $questionValidation = questionFormValidation($name);
    if(count($questionValidation) > 0)
        printErrorsMessage($questionValidation);
    else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            $checkQuestion = checkQuestion($name);
            if($checkQuestion && $checkQuestion->name == $name && $checkQuestion->id != $id){
                echo json_encode("This question allready exists");
                http_response_code(409);
            }else{
                updateQuestion($name, $id);
                echo json_encode(getQuestionFullRow($id));
            }
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
}
else http_response_code(404);