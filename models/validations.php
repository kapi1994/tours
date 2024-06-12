<?php 

include 'utilities.php';

function registerFormValidation($first_name, $last_name, $email, $password){
    $errors = [];

    $reFirstLastName = "/^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/";
    $rePassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";

    inputValidation($errors,"Ime nije u redu",$first_name, $reFirstLastName);
    inputValidation($errors,"Prezime nije u redu",$last_name, $reFirstLastName);
    inputValidation($errors,"Email nije u redu", $email);
    inputValidation($errors,"Lozinka nije u redu", $password,$rePassword);

    return $errors;
}


function loginFormValidation($email, $password){
    $errors = [];

    $rePassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";

    inputValidation($errors, "Email nije validan", $email);
    inputValidation($errors,"Lozinka nije validna", $password,$rePassword);

    return $errors;
}

function categoryFormValidation($name){
    $errors = [];
    $reName = "/[A-Z][\w\s\-,.!?']+/";
    inputValidation($errors,"Naziv nije u redu", $name, $reName);
    return $errors;
}

function tourFormValidation($name, $price, $duration, $categories, $shortDescription, $longDescription, $image= ""){
    $errors = [];

    $reName = "/[A-Z][\w\s\-,.!?']+/";
    $rePrice = "/^[1-9][\d]{2,}$/";
    $reDuration = "/^[1-9]([\d]{1,})*$/";

    inputValidation($errors, "Naziv nije u redu", $name, $reName);
    inputValidation($errors, "Cena nije u redu", $price, $rePrice);
    checkBoxValidation($categories, $errors, "Morate odabrati barem jednu kategoriju");
    $image != "" ?   imageFileValidation($image, $errors, ["Morate odabrati sliku", "Tip slike nije u redu","Velicina slikemora biti manja od 3mb"]) : "";
    inputValidation($errors, "Period tranajanja nije u redu", $duration, $reDuration);
    inputValidation($errors, "Opis nije u redu", $shortDescription, $reName);
    if(strlen($longDescription) == 0){
        array_push($errors, "Opis nije u redu");
    }

    return $errors;
}

function dateFormValidation($date){
    $errors = [];

    validateInputDate($date, $errors, ["Morate odabrati datum", "Datum nije validan"]);

    return $errors;
}

function contactFormValidation($first_name, $last_name, $email, $message){
    $errors = [];

    $reFirstLastName = "/^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/";
    $reMessage = "/[A-Z][\w\s\-,.!?']+/";

    inputValidation($errors, "Ime nije u redu", $first_name, $reFirstLastName);
    inputValidation($errors, "Prezime nije u redu", $last_name, $reFirstLastName);
    inputValidation($errors, "Email nije validan", $email);
    inputValidation($errors, "Poruka nije u redu", $message, $reMessage);

    return $errors;
}

function questionFormValidation($name){
    $errors = [];
    $reName = "/[A-Z][\w\s\-,.!?']+/";
    inputValidation($errors, "Pitanje nije validno", $name, $reName);
    return $errors;
}

function optionFormValidation($name){
    $errors = [];
    $reName = "/[A-Z][\w\s\-,.!?']+/";
    inputValidation($errors, "Odgovor nije validan", $name, $reName);
    return $errors;
}

function surveyFormValidation($date, $question, $answers){
    $errors = [];
    validateInputDate($date, $errors, ["Morate odabrati datum", "Datum nije validan"]);
    validateInputSelect($question, $errors, "Odaberite pitanje");
    checkBoxValidation($answers, $errors, "Morate odabrati barem jedan odgovor");
    return $errors;
}

function tourFormResValidation($date){
    $errors = [];
    validateInputSelect($date, $errors, "Morate odabrati datum polaska");
    return $errors;
}

function surveyVoteValidation($vote){
    $errors= [];
    radioINputValidation($vote, $errors, "Odaberite jednu od opcija");
    return $errors;
}