<?php 
    function inputValidation(&$errorArray, $errorMessage, $input, $regInput =''){
        if(str_contains($input, "@")){
            if(!filter_var($input, FILTER_VALIDATE_EMAIL))
            array_push($errorArray , $errorMessage);
        }else{
            if(!preg_match($regInput, $input))
                array_push($errorArray , $errorMessage);    
        }
    }

    function printErrorsMessage($errorArray){
        foreach($errorArray as $error)
            {  
                echo json_encode($error);
                http_response_code(422);
            }
    }

    function checkBoxValidation($checkBoxArray, &$errorsArray, $errorMessage){
        if(count($checkBoxArray) == 0){
            array_push($errorsArray, $errorMessage);
        }
    }

    function imageFileValidation($image, &$errorsArray, $errorMessage){
        list($imageEmptyError, $imageTypeError, $imageSizeError) = $errorMessage;
        $image_size = $image['size'];
        $image_type = $image['type'];

        $image_type_array = ["image/png","image/jpeg","image/jpg"];


        if($image == "")
            array_push($errorsArray, $imageEmptyError);
        else if($image_size > 3 * 1024 * 1024)
            array_push($errorsArray, $imageSizeError);
        else if(!in_array($image_type, $image_type_array))
            array_push($errorsArray, $imageTypeError);

    }

    function uploadImage($image){
        $image_name = $image["name"];
        $image_tmp = $image["tmp_name"];

        $new_image_name = time()."_".$image_name;
        $image_path = "../../assets/img/$new_image_name";
        move_uploaded_file($image_tmp, $image_path);
        return $new_image_name;
    }

    function validateInputDate($date, &$errorArray, $errorMessages){
        $currentDate = date("Y-m-d");
        $currentDateTimeStamp = strtotime($currentDate);
        $myDateTimeStamp  = strtotime($date);

        list ($emptyDate, $invalidDate) = $errorMessages;
        if($date== ""){
            array_push($errorArray, $emptyDate);
        }else if($currentDateTimeStamp > $myDateTimeStamp){
            array_push($errorArray, $invalidDate);
        }

    }

    function validateInputSelect($select, &$errors, $errorMessage){
        if($select == 0 || $select=="choose")
            array_push($errors, $errorMessage);
    }