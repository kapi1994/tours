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
                echo json_encode("Takvo pitanje vec postoji");
                http_response_code(409);
            }else{
                insertQuestion($name);
                echo json_encode([
                    'questions' => getAllQuestions(),
                    'message' => 'Novo pitanje je kreirano'
                ]);
            }
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }

}
else http_response_code(404);