<?php 
    header("Content-type:applciation/json");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $status = $_POST['status'];
        

        
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
        
            if($status == 0){
                if(checkIfIsAnyActive()->numberOfSurveys == 0){
                  changeStatusSurvey($id, $status);
                  echo json_encode(getSurveyOneFullRow($id));  
                }else{
                    echo json_encode('We allready have active survey!');
                    http_response_code(409);
                }
            }else{
               changeStatusSurvey($id, $status);
               echo json_encode(getSurveyOneFullRow($id));  
            }
          
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
    else http_response_code(404);