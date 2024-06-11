<?php 
header("Content-type:application/json");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $question = $_POST['question'];
    $date= $_POST['date'];
    $answers = explode(',', $_POST['answers']);

    include '../validations.php';
    $surveyValidation = surveyFormValidation($date, $question, $answers);
    if(count($surveyValidation) > 0)
        printErrorsMessage($surveyValidation);
    else{
        try {
           
            require_once '../../config/connection.php';
            include '../functions.php';

            $connection->beginTransaction();

            insertSurvey($date, $question, $answers);
            $connection->commit();
            echo json_encode([  
                'message' => "Nova anketa je postavljena",
                'surveys' => getAllSurveys()
            ]);
        } catch (PDOException $ex) {
            $connection->rollBack();
            echo json_encode($ex->getMessage());
            http_response_code(500);
        }
    }
}
else http_response_code(404);