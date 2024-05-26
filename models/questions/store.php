<?php 
header("Content-type:application/json");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    include '../validations.php';

    $questionValidation = questionFormValidation($name);
    if(count($questionValidation)>0)
        printErrorsMessage($questionValidation);
    else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            $checkQuestion = checkQuestion($name);
            if($checkQuestion){
                echo json_encode("Question allready exsits");
                http_response_code(409);
            }else{
                insertQuestion($name);
                echo json_encode([
                    'questions' => getAllQuestions(),
                    'message' => 'New question has been inserted'
                ]);
            }
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }

}
else http_response_code(404);