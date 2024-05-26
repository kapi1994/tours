<?php 

include 'utilities.php';

function registerFormValidation($first_name, $last_name, $email, $password){
    $errors = [];

    $reFirstLastName = "/^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/";
    $rePassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";

    inputValidation($errors,"First name isn't valid",$first_name, $reFirstLastName);
    inputValidation($errors,"Last name isn't valid",$last_name, $reFirstLastName);
    inputValidation($errors,"Email isn't valid", $email);
    inputValidation($errors,"Password isn't valid", $password,$rePassword);

    return $errors;
}


function loginFormValidation($email, $password){
    $errors = [];

    $rePassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";

    inputValidation($errors, "Email isn't valid", $email);
    inputValidation($errors,"Password isn't valid", $password,$rePassword);

    return $errors;
}

function categoryFormValidation($name){
    $errors = [];
    $reName = "/^[A-Z][a-z]{3,}$/";
    inputValidation($errors,"Name isn't valid", $name, $reName);
    return $errors;
}

function tourFormValidation($name, $price, $duration, $categories, $shortDescription, $longDescription, $image= ""){
    $errors = [];

    $reName = "/^[A-Z][a-z]{1,}$/";
    $rePrice = "/^[1-9][\d]{2,}$/";
    $reDuration = "/^[1-9]([\d]{1,})*$/";

    inputValidation($errors, "Name isn't valid", $name, $reName);
    inputValidation($errors, "Price isn't valid", $price, $rePrice);
    checkBoxValidation($categories, $errors, "Pick at least category");
    $image != "" ?   imageFileValidation($image, $errors, ["Image can't be empty", "Image file isn't ok","Image must be less than 3mb"]) : "";
    inputValidation($errors, "Duraction isn't valid", $duration, $reDuration);
    inputValidation($errors, "Short duration isn't valid", $shortDescription, $reName);
    if(strlen($longDescription) == 0){
        array_push($errors, "Long description isn't valid");
    }

    return $errors;
}

function dateFormValidation($date){
    $errors = [];

    validateInputDate($date, $errors, ["Date can't be empty", "Invalid date"]);

    return $errors;
}

function contactFormValidation($first_name, $last_name, $email, $message){
    $errors = [];

    $reFirstLastName = "/^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/";
    $reMessage = "/^[A-Z][a-z]{3,}$/";

    inputValidation($errors, "Fisrt name isn't valid", $first_name, $reFirstLastName);
    inputValidation($errors, "Last name isn't valid", $last_name, $reFirstLastName);
    inputValidation($errors, "", $email);
    inputValidation($errors, "Message isn't valid", $message, $reMessage);

    return $errors;
}

function questionFormValidation($name){
    $errors = [];
    $reName = "/^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/";
    inputValidation($errors, "Question isn't valid", $name, $reName);
    return $errors;
}

function optionFormValidation($name){
    $errors = [];
    $reName = "/^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/";
    inputValidation($errors, "Question isn't valid", $name, $reName);
    return $errors;
}

function surveyFormValidation($date, $question, $answers){
    $errors = [];
    validateInputDate($date, $errors, ["Pick a date", "Invalid date"]);
    validateInputSelect($question, $errors, "Pick a question");
    checkBoxValidation($answers, $errors, "Pick a least one answer");
    return $errors;
}