// validation functions

function inputValidation(input, regInput, errorArray, elementId, message){
    if(!regInput.test(input)){
        errorArray.push(message)
        createValidationMessage(elementId, message)
    }
    else
        removeValidationMessage(elementId)
}
function validateCheckBox(checkboxArray ,errorArray, errorElement, errorMessage){
    if(checkboxArray.length == 0){
        errorArray.push(errorMessage)
        createValidationMessage(errorElement, errorMessage)
    }else
        removeValidationMessage(errorElement)
}

function selectFormValidation(select, errorArray, errorElement, errorMessage){
    if(select == 0 || select == 'default'){
        errorArray.push(errorMessage)
        createValidationMessage(errorElement, errorMessage)
    }else
        removeValidationMessage(errorElement)
}

function inputFileValidation(image, errors, errorElement, errorMessage){
    const [imageEmptyError, imageFormatError, imageSizeError] = errorMessage
  
    if(image.length == 0){
        errors.push(imageEmptyError)
        createValidationMessage(errorElement, imageEmptyError)
    }else{

        const allowedType = ['image/png','image/jpeg','image/png'];

        const imageType = image[0]['type']
        const imageSize = image[0]['size']

        if(imageSize > 3 * 1024 * 1024){
            errors.push(imageSizeError)
            createValidationMessage(errorElement, imageSizeError)
        }else if(!allowedType.includes(imageType)){
            errors.push(imageFormatError)
            createValidationMessage(errorElement, imageFormatError)
        }else {
            removeValidationMessage(errorElement)
        }
      

    }
}

function extractValuesFromCheckboxes(checkBoxArray, valuesArray){
    checkBoxArray.forEach(checkbox => {
        valuesArray.push(checkbox.value)
    })
    return valuesArray
}

function validateInputDate(date,errorArray, errorElement, errorMessage){

    const [emptyMessage, invalidDate] = errorMessage

    const currentDate  = new Date()
    currentDate.setHours(0,0,0,0)
    const currentTimeStamp = currentDate.getTime();
    const myDate= new Date(date)
    myDate.setHours(0,0,0,0)
    const myDateTimeStamp = myDate.getTime()
    if(date == ""){
        errorArray.push(emptyMessage)
        createValidationMessage(errorElement, emptyMessage)
    }else if(currentTimeStamp > myDateTimeStamp) {
        errorArray.push(invalidDate)
        createValidationMessage(errorElement, invalidDate)
    }else{
        removeValidationMessage(errorElement)
    }
}


// messages functions

const validationClasses = ['text-danger'];
function createValidationMessage(elementId, message){
    const element = $(`#${elementId}`)
    element.text(message)
    element[0].classList.add(...validationClasses)
}

function removeValidationMessage(elementId){
    const element = $(`#${elementId}`)
    element.text('')
    element[0].classList.remove(...validationClasses)
    element.removeAttr('class')
}

function createResponseMessages(color, text, whereToPlace){
    let content = `<div class="alert alert-${color} text-center alert-dismissible fade show" role="alert">
    ${text}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>`
    $(`#${whereToPlace}`).html(content)
}

function formatDate(dateD){
   console.log(dateD)
    const date = dateD.split(" ")[0].split("-")
    const time = dateD.split(" ")[1] != null ? dateD.split(" ")[1] :''  
   
    return date[2] + '/' + date[1] + '/' + date[0] + " " + time
}


function printPagination(pages, limit, whereToPlace, cls){
    let content= ''

    if(pages > 0){
        for(let i = 0; i<pages; i++){
           
            let activeClass = parseInt(i) === parseInt(limit) ? 'active'  :''
            content+= `<li class="page-item"><a class="${cls} page-link ${activeClass}" href="#" data-limit = "${i}">${parseInt(i)+1}</a></li>`
        }
    }
    $(`#${whereToPlace}`).html(content)
}

function radioInputValidation(radio,errorArray, errorElement, errorMessage){
    if(radio == null){
        errorArray.push(errorMessage)
        createValidationMessage(errorElement, errorMessage)
    }else{
        removeValidationMessage(errorElement)
    }
}