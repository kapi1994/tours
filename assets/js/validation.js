function registerValidationForm(first_name, last_name, email, password){

    let errors = []

    const reFirstLastName = /^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/;
    const regEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
    const rePassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/

    inputValidation(first_name, reFirstLastName, errors, "first_name_error","Ime nije validno");
    inputValidation(last_name, reFirstLastName, errors, "last_name_error","Prezime nijevalidno");
    inputValidation(email, regEmail, errors, "email_error", "Email nije validan");
    inputValidation(password, rePassword, errors, "password_error", "Lozinka nije validna");

    return errors;

}

function loginFormValidation(email, password){

    const errors =[];

    const regEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
    const rePassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/

    inputValidation(email, regEmail, errors, "email_error", "Email nije validan");
    inputValidation(password, rePassword, errors, "password_error", "Lozinka nije validna");

    return errors;
}

function categoryFormValidation(name){
    let errors = []
    const reName = /[A-Z][\w\s\-,.!?']+/;
    inputValidation(name, reName, errors, "name_error","Naziv kategorije nije validna")
    return errors
}

function tourFormValidation(name, price, duration, category, short_description, long_description, image = "", id=""){
    let errors = [];

    const reName = /[A-Z][\w\s\-,.!?']+/;
    const rePrice = /^[1-9][\d]{2,}$/
    const reDuration = /^[1-9]([\d]{1,})*$/

    inputValidation(name, reName, errors, "name_error","Naziv nije validna")
    inputValidation(price, rePrice, errors, "price_error", "Cena nije validna")
    inputValidation(duration, reDuration, errors, 'duration_error',"Broj dana nije validan")
    validateCheckBox(category, errors, "category_error","Morate izabrati kategoriju")
    inputValidation(short_description, reName, errors, "short_description_error","Opis nije validan")
    if(id==""){
        inputFileValidation(image, errors, 'image_error',['Molimo vas da odaberete sliku!',"Format slike nijevalidan","Velicina slike je velika"])
    }else if(image.length != 0){
        inputFileValidation(image, errors, 'image_error',['Molimo vas da odaberete sliku!',"Format slike nijevalidan","Velicina slike je velika"])
    }

    if(long_description.length == 0){
        errors.push("Opis nije u redu")
        createValidationMessage('tour_desciption_error',"Opis nije u redu")
    }else 
        removeValidationMessage('tour_desciption_error')

    return errors
}

function dateFormValidation(date){
  const errors = []

  validateInputDate(date, errors, 'date_error', ["Morate odabrati datum","Datum nije validan"])

  return errors;  
}

function contactFormValidation(first_name, last_name, email, message){

const errors = [];

const reName = /^([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+$/
const regEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
const reMessage = /[A-Z][\w\s\-,.!?']+/;

inputValidation(first_name, reName, errors, "first_name_error", "Ime nije u redu")
inputValidation(last_name, reName,errors, "last_name_error", "Prezime nije u redu")
inputValidation(email, regEmail, errors, "email_error", "Email nije uredu")
inputValidation(message, reMessage, errors, "message_error", "Poruka nije u redu")

return errors;

}

function questionFormValidation(name){
    let errors = [];

    const reName = /[A-Z][\w\s\-,.!?']+/
    inputValidation(name, reName, errors,"question_error", "Pitanje nije vaildno")
    return errors
}

function answerFormValidation(name){
    let errors= [];
    const reName = /[A-Z][\w\s\-,.!?']+/
    inputValidation(name,reName, errors, "answer_error","Odgovor nije validan")
    return errors;  
}

function surveyFormValidation(date, question, answers){
    let errors = [];
    validateInputDate(date, errors, 'date_error',["Morate odabrti datum","Datum nije validans"])
    selectFormValidation(question, errors,'question_error',"Morate odabrati pitanje")
    validateCheckBox(answers, errors,"answer_error","Morate odabrati odgovor")

    return errors;
}

function reservationDateTour(tour_id){
    let errors =[];
    selectFormValidation(tour_id,errors,"tour_date_error","Izaberite datum polaska")
return errors;
}

function anketaFormValidation(radio){
    let errors = []
   radioInputValidation(radio, errors, "vote_error","Odaberite jednu od opcija")
    return errors
}