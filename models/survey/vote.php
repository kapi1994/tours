<?php 
session_start();
header("Content-type:application/json");
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $survey_id = $_POST['survey_id'];
    $option_id = $_POST['radio_value'];
    $user_id = $_SESSION['user']->id;


    include '../validations.php';
    $surveyVoteValidation = surveyVoteValidation($option_id);
    if(count($surveyVoteValidation)>0)
        printErrorsMessage($surveyVoteValidation);
    else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            insertVote($survey_id, $option_id, $user_id);
            echo json_encode("Hvala sto se glasali");
            http_response_code(201);
        } catch (PDOException $th) {
           echo json_encode($th->getMessage());
           http_response_code(500);
        }
    }
}