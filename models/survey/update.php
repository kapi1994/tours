<?php 
header("Content-type:application/json");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];
    $question = $_POST['question'];
    $date= $_POST['date'];
    $answers = explode(",", $_POST['answers']);

    include '../validations.php';
    $surveyValidation = surveyFormValidation($date, $question, $answers );
    if(count($surveyValidation) > 0)
        printErrorsMessage($surveyValidation);
    else{
        try {
            include '../../config/connection.php';
            include '../functions.php';

            $connection->beginTransaction();
            updateSurvey($id, $date, $question, $answers);
            echo json_encode(getSurveyOneFullRow($id));
            $connection->commit();

        } catch (PDOException $th) {
            $connection->rollback();
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
}
else http_response_code(404);