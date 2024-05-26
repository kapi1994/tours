<?php 
header("Content-type:application/json");
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name=  $_POST['option'];
    $id = $_POST['id'];
    include '../validations.php';
    $answerValidation = optionFormValidation($name);
    if(count($answerValidation) > 0)
        printErrorsMessage($answerValidation);
    else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            $checkAnswer = checkAnswers($name);
            if($checkAnswer && $checkAnswer->id != $id && $checkAnswer->name == $name){
                echo json_encode("Same answer allready exists");
                http_response_code(409);
            }else{
                updateOption($name, $id);
                echo json_encode(getAnswerFullRow($id));
            }
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
}
else http_response_code(404);