<?php 
header("Content-type:application/json");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $option = $_POST['option'];
    include '../validations.php';
    $optionValidation = optionFormValidation($option);
    if(count($optionValidation)  > 0)
        printErrorsMessage($optionValidation);
    else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            $checkAnswers = checkAnswers($option);
            if($checkAnswers){
                echo json_encode("Same option allready exists!");
                http_response_code(409);
            }else{
                insertNewOption($option);
                echo json_encode([
                    'message' => "New option has been inserted",
                    'options' => getAllAnswers()
                ]);
            }
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
}
else http_response_code(404);