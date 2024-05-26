<?php 
header("Content-type:application/json");
if($_SERVER['REQUEST_METHOD'] =='POST'){
    $name = $_POST['name'];
    include '../validations.php';
    $categoryFormValidation = categoryFormValidation($name);
    if(count($categoryFormValidation) >0)
        printErrorsMessage($categoryFormValidation);
    else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            $checkCategoryName = checkCategoryName($name);
            if($checkCategoryName){
                echo json_encode("Category with this name allready exists");
                http_response_code(409);
            }else{
                storeNewCategory($name);
                echo json_encode([
                    'categories' => getAllCategories(),
                    'message' => "New category has been inserted"
                ]);
            }
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
}

else http_response_code(404);