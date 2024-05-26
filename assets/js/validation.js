function registerValidationForm(first_name, last_name, email, password){

    let errors = []

    const reFirstLastName = /^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/;
    const regEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
    const rePassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/

    inputValidation(first_name, reFirstLastName, errors, "first_name_error","First name isn't valid");
    inputValidation(last_name, reFirstLastName, errors, "last_name_error","Last name isn't valid");
    inputValidation(email, regEmail, errors, "email_error", "Last name isn't valid");
    inputValidation(password, rePassword, errors, "password_error", "Password isn't valid");

    return errors;

}

function loginFormValidation(email, password){

    const errors =[];

    const regEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
    const rePassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/

    inputValidation(email, regEmail, errors, "email_error", "Last name isn't valid");
    inputValidation(password, rePassword, errors, "password_error", "Password isn't valid");

    return errors;
}

function categoryFormValidation(name){
    let errors = []
    const reName = /^[A-Z][a-z]{3,}$/;
    inputValidation(name, reName, errors, "name_error","Name isn't valid")
    return errors
}

function tourFormValidation(name, price, duration, category, short_description, long_description, image = ""){
    let errors = [];

    const reName = /^[A-Z][a-z]{1,}$/;
    const rePrice = /^[1-9][\d]{2,}$/
    const reDuration = /^[1-9]([\d]{1,})*$/

    inputValidation(name, reName, errors, "name_error","Name isn't valid")
    inputValidation(price, rePrice, errors, "price_error", "Price isn't valid")
    image.length != "" ?  inputFileValidation(image, errors, 'image_error',['Please choose image!',"Image format isn't valid","Image size isn't valid"]) : ""
    inputValidation(duration, reDuration, errors, 'duration_error',"Duration isn't valid")
    validateCheckBox(category, errors, "category_error","Choose at least one category")
    inputValidation(short_description, reName, errors, "short_description_error","Short description isn't valid")


    if(long_description.length == 0){
        errors.push("Description isn't valid")
        createValidationMessage('tour_desciption_error',"Description isn't valid")
    }else 
        removeValidationMessage('tour_desciption_error')

    return errors
}

function dateFormValidation(date){
  const errors = []

  validateInputDate(date, errors, 'date_error', ["Date can't be empty","Invalid date"])

  return errors;  
}

function contactFormValidation(first_name, last_name, email, message){

const errors = [];

const reName = /^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/
const regEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
const reMessage = /^[A-Z][a-z]{3,}$/;

inputValidation(first_name, reName, errors, "first_name_error", "First name isn't valid")
inputValidation(last_name, reName,errors, "last_name_error", "Last name isn't valid")
inputValidation(email, regEmail, errors, "email_error", "Email isn't valid")
inputValidation(message, reMessage, errors, "message_error", "Message isn't valid")

return errors;

}

function questionFormValidation(name){
    let errors = [];

    const reName = /^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/
    inputValidation(name, reName, errors,"question_error", "Question isn't valid")
    return errors
}

function answerFormValidation(name){
    let errors= [];
    const reName = /^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/
    inputValidation(name,reName, errors, "answer_error","Answer isn't valid")
    return errors;  
}

function surveyFormValidation(date, question, answers){
    let errors = [];
    validateInputDate(date, errors, 'date_error',["Date can't be empty","Invalid date"])
    selectFormValidation(question, errors,'question_error',"Please choose question")
    validateCheckBox(answers, errors,"answer_error","select at least one")

    return errors;
}