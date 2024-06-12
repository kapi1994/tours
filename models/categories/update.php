<?php 
header("Content-type:application/json");
if($_SERVER['REQUEST_METHOD'] =='POST'){
    $name = $_POST['name'];
    $id = $_POST['id'];
    include '../validations.php';
    $categoryFormValidation = categoryFormValidation($name);
    if(count($categoryFormValidation) >0)
        printErrorsMessage($categoryFormValidation);
    else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            $checkCategoryName = checkCategoryName($name);
            if($checkCategoryName && $checkCategoryName->name == $name && $checkCategoryName->id != $id){
                echo json_encode("Kategorija sa takvim nazivom vec postoji");
                http_response_code(409);
            }else{
                updateCategory($id,$name);
                echo json_encode(getOneCategoryFullRow($id));
            }
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
}

else http_response_code(404);