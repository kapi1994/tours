$(document).ready(function () {

    let editor
    ClassicEditor
    .create( document.contains(document.querySelector( '#tour_description')) ? document.querySelector( '#tour_description' ) :'' )
    .then( newEditor => {
        editor = newEditor;
    } )
    .catch( error => {
        console.error( error );
    } );

    let page = window.location.href.split("/")
    let activePage = page[page.length - 1].split("?")

    if(activePage.length == 1 || activePage[1] == "page=home"){
        getData()
    }else if(activePage.length == 2 && activePage[1] == 'page=destinacije'){
        filterTourBy()
        
    }else if (activePage[1].split('&')[0] != 'page=dates'){
        localStorage.clear()
    }

    // categories
    $(document).on('click','.btn-edit-category',function (e) { 
        e.preventDefault();

        const id = $(this).data("id")
        const index = $(this).data('index')

        $.ajax({
            type: "get",
            url: "models/categories/getOne.php",
            data: {id},
            dataType: "json",
            success: function (response) {
               fillCategoryForm(response,index)
            },error:function(jqXHR,statusTxt, xhr){
                createResponseMessages('danger', jqXHR.responseJSON,'category_response_message')
            }
        });
    });
    $(document).on('click','.btn-delete-category',function(e){ 
        e.preventDefault();
        const id = $(this).data('id')
        const index = $(this).data('index')
        const status = $(this).data('status')
        const whereToPlace = `category_${index}`;
      
        $.ajax({
            type: "post",
            url: "models/categories/delete.php",
            data: {status, id},
            dataType: "json",
            success: function (response) {
               printCategoryRow(response, index, whereToPlace)
            },error:function(jqXHR,statusTxt,xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'category_response_message')
            }
        });
    });
    $('#btnSaveCategory').click(function (e) { 
        e.preventDefault();
        
        const name = $('#name').val()
        const id = $('#category_id').val()
        const index = $('#category_index').val()
        const whereToPlace = `category_${index}`
        let url = '' 
        let formData = new FormData()
        formData.append('name', name)
      

        if(id != ""){
            url= "models/categories/update.php"
            formData.append('id', id)
        }else url ='models/categories/store.php'

        if(categoryFormValidation(name).length == 0){
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData:false,
                contentType:false,
                dataType: "json",
                success: function (response) {
                    if(id == ""){
                        printAllCategories(response.categories)
                        createResponseMessages('success', response.message,'category_response_message')
                    }else
                        printCategoryRow(response, index, whereToPlace)
                    clearCategoryForm()  
                },error:function(jqXHR, statusTxt, xhr){
                    createResponseMessages('danger', jqXHR.responseJSON, 'category_response_message')
                }
            });
        }

    });
    $('#btnResetCategory').click(function(e){
        e.preventDefault()
        clearCategoryForm()
    })
    function printAllCategories(categories){
        let content ='', index = 0
        categories.forEach(category => {
            content+= printCategoryRow(category,index)
            index++
        })
      $(`#categories`).html(content)
    }
    function printCategoryRow(category, index, whereToPlace =''){
        const {id, name, created_at, updated_at, is_deleted } = category
        let content = `
        <tr id="category_${index}">
            <th scope="row">${parseInt(index) + 1}</th>
            <td>${name}</td>
            <td>${formatDate(created_at)}</td>
            <td>${updated_at != null ? formatDate(updated_at) : "-"}</td>
            <td><button class="btn btn-sm btn-success btn-edit-category" type="button" data-id="${id}" data-index="${index}">Edit</button></td>
            <td><button class="btn btn-sm btn-danger btn-delete-category" type="button" data-id="${id}" data-index="${index}" data-status="${is_deleted}">${is_deleted == 0 ? "Delete" : "Activate"}</button></td>
        </tr>
        `
        if(whereToPlace != ""){
            document.querySelector(`#${whereToPlace}`).innerHTML = content
        }
        return content
    }
    function clearCategoryForm(){
        $('#category_id').val('').removeAttr('value')
        $('#category_index').val('').removeAttr("value")
        $("#name").val("").removeAttr('value')
      
    }
    function fillCategoryForm(category, index){
        const {id, name} =category
        $('#category_id').val(id)
        $('#category_index').val(index)
        $('#name').val(name)
    }
        
    // posts
    $(document).on('click','.btn-edit-tour', function(e){
        e.preventDefault()

        const id = $(this).data('id')
        const index = $(this).data('index')

        $.ajax({
            type: "get",
            url: "models/tours/edit.php",
            data: {id},
            dataType: "json",
            success: function (response) {
               fillTourForm(response, index)
            },error:function(jqXHR, statusTxt, xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'tour_response_message')
            }
        });

    })
    $(document).on('click','.btn-delete-tour', function(e){
        e.preventDefault();
        const id = $(this).data('id')
        const index = $(this).data('index')
        const status = $(this).data('status')

        const whereToPlace = `tour_${index}`

        $.ajax({
            type: "post",
            url: "models/tours/delete.php",
            data: {id, status},
            dataType: "json",
            success: function (response) {
               printTourFullRow(response, index, whereToPlace)
            },error:function(jqXHR, statusTxt, xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'tour_response_message')
            }
        });
    })
    $(document).on('click','#btnResetTour',function(e){
        e.preventDefault()
        clearTourForm()
    })
    $(document).on('click','#btnSaveTour', function(e){
        e.preventDefault()
        const id = $('#tour_id').val()
        const index = $('#tour_index').val()
        const name = $('#name').val()
        const short_description = $('#short_description').val()
        const image = $('#image').prop('files')
        const price = $('#price').val()
        const duration = $('#duration').val()
        const long_description = editor.getData()
        const categories = document.querySelectorAll('input[name="categories"]:checked')
       
        let url = '', formData = new FormData(), selectedCheckboxes = []
        formData.append('name', name)
        formData.append('price', price)
        image.length > 0 ? formData.append("image", image[0]) : ''
        console.log(image)
       
        formData.append('duration', duration)
        formData.append('short_description', short_description)
        formData.append('long_description', long_description)
        formData.append('categories', extractValuesFromCheckboxes(categories, selectedCheckboxes))

       let currentIndex = localStorage.getItem('page') != null ? localStorage.getItem('page') : 0

        const whereToPlace = `tour_${index}`

        if(id != ""){
            url = "models/tours/update.php"
            formData.append("id", id)
            let currentImage = document.querySelector('#tour_img').src.split('/')
            let image_name = currentImage[currentImage.length - 1]
            formData.append("currentImage", image_name)
        }else{
            url = "models/tours/store.php"
            formData.append('limit', currentIndex)
        }
    
       

        if(tourFormValidation(name, price, duration, categories, short_description, long_description, image,id).length == 0){
            $.ajax({
                type: "post",
                url: url,
                data: formData,
                processData:false,
                contentType:false,
                dataType: "json",
                success: function (response) {
                    clearTourForm()
                    if(id == ""){
                        createResponseMessages('success', response.message, 'tour_response_message')
                        printAllTours(response.tours, currentIndex, response.offset)
                        printPagination(response.pages, currentIndex,'tour-pages','tour-page')
                    }else{
                        printTourFullRow(response, index, whereToPlace)
                    }
                },error:function(jqXHR, statusTxt,xhr){
                    createResponseMessages('danger', jqXHR.responseJSON, 'tour_response_message')
                }
            });
        }
      
    })
    $(document).on('click','.tour-page',function(e){
        e.preventDefault()
        let limit = $(this).data("limit")
        localStorage.setItem('page', limit)
        filterTourBy()
    })
    function filterTourBy(){
        let limit = localStorage.getItem('page') !== null ? localStorage.getItem('page') : 0    
        $.ajax({
            type: "get",
            url: "models/tours/filter.php",
            data: {limit},
            dataType: "json",
            success: function (response) {
               printAllTours(response.tours, limit, response.offset)
               printPagination(response.pages, limit, 'tour-pages','tour-page')
            }, error:function(jqXHR,statusTxt,xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'tour_response_message')
            }
        });
    }
    function clearTourForm(){
        $('#tour_id').val('').removeAttr('value')
        $('#tour_index').val('').removeAttr('value')
        $("#name").val('').removeAttr('value')
        $('#price').val('').removeAttr('value')
        $('#duration').val('').removeAttr('value')
        $('#short_description').val('')
        editor.setData("")
        let categories = document.querySelectorAll('input[name="categories"]:checked')
        categories.forEach(cat => {
            let cat_id= cat.id
            $(`#${cat_id}`).prop('checked', false)
        })
        $('#image').val('')
        let image = document.querySelector('#tour_img')
        image.src = ''
        image.classList.remove('img-fluid')
        image.classList.add('d-none')
    }
    function fillTourForm(tour, index){
        const {id, name,short_description, long_description,image_path, days, price, categories} = tour
        $('#tour_id').val(id)
        $('#tour_index').val(index)
        $('#name').val(name)
        $('#price').val(price)
        $('#short_description').val(short_description)
        editor.setData(long_description)
        $("#duration").val(days)

        const cat_front = document.querySelectorAll('input[name="categories"]')
        cat_front.forEach(cat_f => {
            let id = cat_f.id
            let value = parseInt(cat_f.value)
            $(`#${id}`).prop('checked',false)
            categories.forEach(cat => {
                let cat_id = parseInt(cat.category_id)
                cat_id === value ? $(`#${id}`).prop("checked", true) : ''
            })
        })
        let image = document.querySelector('#tour_img')
        image.src = `assets/img/${image_path}`
        image.classList.remove('d-none')
        image.classList.add("img-fluid")
    }
    function printAllTours(tours, limit = 0, offset = 0){
        console.log(limit, offset)
        let content = '', index = parseInt(limit) * parseInt(offset)
        tours.forEach(tour => {
            content+= printTourFullRow(tour, index)
            index++
        })
        document.contains(document.querySelector('#tours')) ? document.querySelector('#tours').innerHTML  = content :''
    }
    function printTourFullRow(tour, index, whereToPlace =''){
        const {id, name, days, price, created_at, updated_at, is_deleted, categories} = tour
        let content = `<tr id='tour_${index}'>
        <th scope="row">${parseInt(index)+ 1}</th>
        <td>${name}</td>
        <td>${price}</td>
        <td>${days}</td>
        <td>`
        categories.forEach((category, index, array) => {
           if( index !== array.length - 1)
            content+= `${category.name},<br/>`
           else
           content+= `${category.name}`
        })
        content+=` </td><td><a href="admin.php?page=dates&id=${id}" class="btn btn-sm btn-primary">Dodaj</a></td>
        <td>${formatDate(created_at)}</td>
        <td>${updated_at != null ? formatDate(updated_at):"-"}</td>
        <td><button class="btn btn-sm btn-success btn-edit-tour" data-id="${id}" data-index="${index}">Edit</button></td>
        <td><button class="btn btn-sm btn-danger btn-delete-tour" type="button" data-id="${id}" 
        data-index="${index}" data-status="${is_deleted}">${is_deleted == 0 ? "Delete":"Activate"}</button></td>
    </tr>`
    if(whereToPlace != "")
        document.querySelector(`#${whereToPlace}`).innerHTML =content
    return content    
    }
    // dates 

    $(document).on('click','.btn-edit-date',function(e){
        e.preventDefault()
       
        const id = $(this).data('id')
        const index = $(this).data('index')

        $.ajax({
            type: "get",
            url: "models/dates/edit.php",
            data: {id},
            dataType: "json",
            success: function (response) {
               fillDateForm(response, index)
            },error:function(jqXHR,statusTxt,xhr){
                createResponseMessages('danger', jqXHR.responseJSON,'date_response_message')
            }
        });
    })
    $(document).on('click','.btn-delete-date',function(e){
        e.preventDefault()
        const id = $(this).data("id")
        const index = $(this).data("index")
        const status = $(this).data('status')
        const whereToPlace = `date_${index}`
        $.ajax({
            type: "post",
            url: "models/dates/delete.php",
            data: {id, status},
            dataType: "json",
            success: function (response) {
                printDateFullRow(response, index, whereToPlace)
            },error:function(jqXHR,statusTxt,xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'date_response_message')
            }
        });

    })
    $(document).on('click','#btnResetDate', function(e){
        e.preventDefault()
        $('#date_id').val('').removeAttr('value')
        $('#date_index').val('').removeAttr('value')
        $('#date').val('')
    })
    $(document).on('click','#btnSaveDate', function(e){
        e.preventDefault()

       

        const id = $('#date_id').val()
        const index = $('#date_index').val()
        const tour_id = $('#tour_id').val()
        const date = $('#date').val()
        const whereToPlace = `date_${index}`
        let url = '', formData = new FormData()

        formData.append("tour_id", tour_id)
        formData.append('date', date)

        
        if(id != ""){
            formData.append('id', id)
            url = 'models/dates/update.php'
        }else
            url= 'models/dates/store.php'
           
       

        if(dateFormValidation(date).length == 0){
          $.ajax({
            type: "post",
            url: url,
            data: formData,
            dataType: "json",
            processData:false,
            contentType:false,
            success: function (response) {
              clearDateForm()
              
              if(id == ""){
                createResponseMessages('success', response.message, 'date_response_message')
                printAllTourDates(response.tours)
              }
              printDateFullRow(response, index, whereToPlace)
            },error:function(jqXHR,responseJSON,xhr){
                createResponseMessages('danger', jqXHR.responseJSON,'date_response_message')
            }
          });
        }
    })

    function clearDateForm(){
     $("#date_id").val("").removeAttr('value')
     $("#date_index").val("").removeAttr('value')
     $('#date').val('').removeAttr('value')
    }
    function printAllTourDates(tour_data){
        let content = '', index = 0
        tour_data.forEach(tour => {
            content+= printDateFullRow  (tour, index)
            index++
        })
        $('#dates').html(content)
    }
    function printDateFullRow(dateD, index, whereToPlace = ""){
        const {id, date, tour_id, created_at, updated_at, is_deleted} = dateD
        let content = `<tr id="date_${index}">
        <th scope="row">${parseInt(index)+1}</th>
        <td>${formatDate(date)}</td>
        <td>${formatDate(created_at)}</td>
        <td>${updated_at != null ? formatDate(updated_at) : "-"}</td>
        <td><button class="btn btn-sm btn-success btn-edit-date" type="button" data-id="${id}" data-index="${index}">Edit</button></td>
        <td><button class="btn btn-sm btn-danger btn-delete-date" type='button' data-id="${id}" data-index="${index}" data-status="${is_deleted}">${is_deleted == 0 ? "Delete" : "Activate"}</button></td>
    </tr>`
    if(whereToPlace != "")
        document.querySelector(`#${whereToPlace}`).innerHTML = content
    return content
    }
    function fillDateForm(date_data, index){
        const {id, date} = date_data
        $('#date_id').val(id)
        $('#date_index').val(index)
        $('#date').val(date)
    }

    // messages

    $(document).on("click",'.btn-read-message', function(e){
        e.preventDefault()
        const id = $(this).data('id')
        
        $.ajax({
            type: "get",
            url: "models/messages/getOne.php",
            data:{id},
            dataType: "json",
            success: function (response) {
                const {first_name, last_name, email, message,created_at} = response
                const full_name = `${first_name} ${last_name}`
                $('#user-from').text(full_name)
                $('#email-from').text(email)
                $('#arrived_at').text(formatDate(created_at))
                $('#message').text(message)
            },error:function(jqXHR, statusTxt, xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'message_response_message')
            }
        });
    })
    $(document).on('click','.message-page', function(e){
        e.preventDefault()
       
        const limit = $(this).data('limit')
        $.ajax({
            type: "get",
            url: "models/messages/pagination.php",
            data: {limit},
            dataType: "json",
            success: function (response) {
                printAllMessages(response.messages, limit, response.offset)
                printPagination(response.pages, limit,'message-pages','message-page' )
            },error:function(jqXHR, statusTxt, xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'message_response_message')
            }
        });
    })
    function printAllMessages(messages, limit, offset){
        
        let content = '', index = limit * offset
        
        messages.forEach(message => {
            content+= printMessage(message, index)
            index++
        })
        $('#messages').html(content)
    }
    function printMessage(messageD, index){
        const {id, first_name, last_name, email, message, created_at} = messageD
        
        let content = `<tr id="date_${index}">
        <th scope="row">${parseInt(index)+1}</th>
        <td>${first_name+' '+last_name}</td>
        <td>${email}</td>
        <td>${formatDate(created_at)}</td>
       <td> <button type="button" class="btn btn-primary btn-sm btn-read-message" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="${id}">Read</button>
        </td>
    </tr>`
    return content
    }

    // questions
    $(document).on('click','.btn-edit-question',function(e){
        e.preventDefault()
        const id = $(this).data('id')
        const index = $(this).data("index")


        $.ajax({
            type: "get",
            url: "models/questions/getOne.php",
            data: {id},
            dataType: "json",
            success: function (response) {
                fillQuestionForm(response, index)
            },error:function(jqXHR,statusTxt, xhr){
                createResponseMessages('danger',jqXHR.responseJSON,'question_response_message')
            }
        });
    })
    $(document).on('click','.btn-delete-question', function(e){
        e.preventDefault()
        const id = $(this).data('id')
        const index = $(this).data('index')
        const status = $(this).data('status')
        const whereToPlace = `question_${index}`
        $.ajax({
            type: "post",
            url: "models/questions/delete.php",
            data: {id, status},
            dataType: "json",
            success: function (response) {
               printQuestionFullRow(response, index, whereToPlace)
            },error:function(jqXHR,statusTxt,xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'question_response_message')
            }
        });
    })
    $(document).on('click','#btnSaveQuestion',function(e){
        e.preventDefault()

        const id = $('#question_id').val()
        const index = $('#question_index').val()
        const name = $('#question').val()

        let url = '', data =new FormData()
        const whereToPlace = `question_${index}`

        data.append("name", name)

        if(id != ""){
            url = "models/questions/update.php"
            data.append('id', id)
        }else
            url = "models/questions/store.php"

        

        if(questionFormValidation(name).length == 0){
            $.ajax({
                type: "post",
                url: url,
                data: data,
                contentType:false,
                processData:false,
                dataType: "json",
                success: function (response) {
                    clearQuestionForm()
                    if(id == ""){
                        createResponseMessages('success', response.message, 'question_response_message')
                        printAllQuestions(response.questions)
                    }
                    else
                        printQuestionFullRow(response, index, whereToPlace)
                },error:function(jqXHR,statusTxt,xhr){
                    createResponseMessages('danger', jqXHR.responseJSON, 'question_response_message')
                }
            });
        }
    })
    $(document).on('click','#btnResetQuestion',function (e) {
        e.preventDefault()
        clearQuestionForm()
    })

    function fillQuestionForm(question, index){
        const {id, name} = question
        $('#question_id').val(id)
        $('#question_index').val(index)
        $('#question').val(name)
    }
    function clearQuestionForm(){
        $('#question_id').val('').removeAttr('value')
        $('#question_index').val('').removeAttr('value')
        $('#question').val('').removeAttr('value')
    }
    function printAllQuestions(questions){
        let content = '', index = 0
        questions.forEach(question => {
            content+= printQuestionFullRow(question, index)
        })
        $('#questions').html(content)
    }
    function printQuestionFullRow(question, index, whereToPlace =''){
        const {id, name, created_at, updated_at, is_deleted} = question
        let content = `
        <tr id="question_${index}">
            <th scope="row">${parseInt(index)+1}</th>
            <td>${name}</td>
            <td>${formatDate(created_at)}</td>
            <td>${updated_at != null ? formatDate(updated_at) : '-'}</td>
            <td><button class="btn btn-sm btn-success btn-edit-question" type="button" data-id="${id}" data-index="${index}>">Edit</button></td>
            <td><button class="btn btn-sm btn-danger btn-delete-question"
                type="button" data-index="${index}" data-status = "${is_deleted}" data-id="${id}"
            >${is_deleted == 0 ? "Delete" : "Active"}</button></td>
    </tr>
        `
        if(whereToPlace != ''){
           document.querySelector(`#${whereToPlace}`).innerHTML = content
        }
        return content

    }

    // answers

    $(document).on('click','.btn-edit-answer',function(e){

        e.preventDefault()

        const id  = $(this).data('id')
        const index = $(this).data('index')

        $.ajax({
            type: "get",
            url: "models/answers/getOne.php",
            data: {id},
            dataType: "json",
            success: function (response) {
                fillAnswerForm(response, index)
            },error:function(jqXHR,statusTxt,xhr){
                createResponseMessages('danger', jqXHR.responseJSON, "answer_response_message")
            }
        });
    })
    $(document).on("click",'.btn-delete-answer',function(e){
        e.preventDefault()
        
        const id = $(this).data('id')
        const index = $(this).data('index')
        const status = $(this).data('status')

        const whereToPlace = `answer_${index}`
        $.ajax({
            type: "post",
            url: "models/answers/delete.php",
            data: {id, status},
            dataType: "json",
            success: function (response) {
                printAnswerFullRow(response, index, whereToPlace)
            },error:function(jqXHR,statusTxt,xhr){
                createResponseMessages('daner', jqXHR.responseJSON, 'answer_response_message')
            }
        });
    })
    $(document).on('click','#btnSaveAnswer',function(e){
        e.preventDefault()

        const id = $('#answer_id').val()
        const index = $('#answer_index').val()
        const option = $('#answer').val()

        const whereToPlace = `answer_${index}`

        let url  ='', formData = new FormData()
        formData.append('option', option)
        if(id != ""){
            url = "models/answers/update.php"
            formData.append('id', id)
        }else url = 'models/answers/store.php'
      
        if(answerFormValidation(option).length == 0){
            $.ajax({
                type: "post",
                url: url,
                data: formData,
                contentType:false,
                processData:false,
                dataType: "json",
                success: function (response) {
                    clearAnswerForm()
                    if(id == ""){
                        createResponseMessages('success', response.message, 'anser_response_message')
                        printAllAnswers(response.options)
                    }else 
                        printAnswerFullRow(response, index, whereToPlace)
                },error:function(jqXHR,statusTxt, xhr){
                    createResponseMessages('danger', jqXHR.responseJSON, 'answer_response_message')
                }
            });
        }
    })
    function fillAnswerForm(answer, index){
        const {id, name}  = answer
        $('#answer_id').val(id)
        $('#answer_index').val(index)
        $('#answer').val(name)
    }
    function clearAnswerForm(){
        $('#answer_id').val('').removeAttr('value')
        $('#answer_index').val('').removeAttr('value')
        $('#answer').val('').removeAttr('value')
    }

    function printAllAnswers(answers){
        let content ='', index =0
        answers.forEach(answer => {
            content+= printAnswerFullRow(answer, index)
            index++
        })
        $('#answers').html(content)
    }

    function printAnswerFullRow(answer, index, whereToPlace = ''){
   
        const {id, name, created_at, updated_at, is_deleted} = answer
        let content = ` 
         <tr id="answer_${index}">
            <th scope="row">${parseInt(index)+1}</th>
            <td>${name}</td>
            <td>${formatDate(created_at)}</td>
            <td>${updated_at != null ? formatDate(updated_at)  :'-'}</td>
            <td><button class="btn btn-sm btn-success btn-edit-answer" type="button" data-id="${id}" data-index="${index}">Edit</button></td>
            <td><button class="btn btn-sm btn-danger btn-delete-answer" type="button" data-id ="${id}>" data-index="${index}" data-status="${is_deleted}">${is_deleted == 0 ? "Delete" : "Activate"}</button></td>
            </tr>`
        if(whereToPlace != ""){
            document.querySelector(`#${whereToPlace}`).innerHTML = content
        }
        return content
    }

    // survey

    $(document).on('click','#btnSaveSurvey', function(e){
        e.preventDefault()
        const id = $('#survey_id').val()
        const index = $('#survey_index').val()
        const date= $('#date').val()
        const question = $('#question').val()
        const answers = document.querySelectorAll('input[name="answers"]:checked')
        let selectedCheckboxes = []



        let url = '', data = new FormData()
        const whereToPlace = `survey_${index}`

        if(id != ""){
            url = "models/survey/update.php"
            data.append('id', id)
        }else 
            url = "models/survey/store.php"

        data.append('date', date)
        data.append('question', question)
        data.append("answers", extractValuesFromCheckboxes(answers, selectedCheckboxes))

        if(surveyFormValidation(date, question, selectedCheckboxes).length == 0){
          $.ajax({
            type: "post",
            url: url,
            data: data,
            processData:false,
            contentType:false,
            dataType: "json",
            success: function (response) {
                clearSurveyForm()
                if(id == ""){
                    createResponseMessages('success', response.message, 'survey_message')
                    printAllSurveys(response.surveys)
                }
                else{
                    printSurveyFullRow(response, index, whereToPlace)
                }
            },error:function(jqXHR,statusTxt,xhr){
               createResponseMessages('danger', jqXHR.responseJSON,'survey_message')
            }
          });
        }
    })
    $(document).on('click','.btn-edit-survey', function(e){
        e.preventDefault()
        const id = $(this).data('id')
        const index = $(this).data('index')

        $.ajax({
            type: "get",
            url: "models/survey/getOne.php",
            data: {id},
            dataType: "json",
            success: function (response) {
               fillSurveyForm(response, index)
            },error:function(jqXHR, statusTxt, xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'survey_message')
            }
        });
    })
    $(document).on("click",'.btn-delete-survey',function(e){
        e.preventDefault()
        const status = $(this).data("active")
        const id = $(this).data('id')
        const index = $(this).data('index')
        const whereToPlace = `survey_${index}`
        $.ajax({
            type: "post",
            url: "models/survey/delete.php",
            data: {id, status},
            dataType: "json",
            success: function (response) {
               printSurveyFullRow(response, index, whereToPlace)
            },error:function(jqXHR, statusTxt,xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'survey_message')
            }
        });
    })



    function fillSurveyForm(survey, index){
        const {id, question_id, expire_date, answers} = survey
        $('#survey_id').val(id)
        $('#survey_index').val(index)
        $('#question').val(question_id)
        $('#date').val(expire_date)

        const answersFront = document.querySelectorAll('input[name="answers"]')
        answersFront.forEach(answerF => {
            let answer_value = answerF.value
            let answerId = answerF.id

            $(`#${answerId}`).prop('chceked', true)

            answers.forEach(answer => {
                let answer_id = answer.answer_id
                parseInt(answer_value) === parseInt(answer_id) ? $(`#${answerId}`).prop('checked', true) : ''
            })
        })
    }
    function clearSurveyForm(){
        $('#survey_id').val("").removeAttr('value')
        $('#survey_index').val("").removeAttr('value')
        $('#date').val('')
        $('#question').val(0)
        let answers = document.querySelectorAll('input[name="answers"]:checked')
        answers.forEach(answer => {
            let answer_id = answer.id
            $(`#${answer_id}`).prop('checked',false)
        })
    }
    function printAllSurveys(surveys){
        let content= '', index = 0
        surveys.forEach(survey => {
            content+=printSurveyFullRow(survey, index)
        })
        $('#surveys').html(content)
    }
    function printSurveyFullRow(survey, index, whereToPlace =''){
      
        const {id,expire_date,question_id, created_at, updated_at,is_active, questionName} = survey
        
        let content = ` <tr id="survey_${index}">
        <th scope="row">${parseInt(index)+1}</th>
        <td>${questionName}</td>
        <td>${formatDate(expire_date)}</td>
        <td>${formatDate(created_at)}</td>
        <td>${updated_at != null ? formatDate(updated_at) : ''}</td>
        <td><button class="btn btn-sm btn-success btn-edit-survey"
        type="button" data-id="${id}" data-index="${index}">Edit</button></td>
        <td>
            <button class="btn btn-sm btn-danger btn-delete-survey"
            type="button" data-id="${id}" data-index="${index}"
            data-active="${is_active}">${is_active == 1 ? "Delete" : "Activate"}</button>
        </td>
    </tr>`
        if(whereToPlace != ""){
            document.querySelector(`#${whereToPlace}`).innerHTML = content
        }
        return content
    }


    function getData(){
       $.ajax({
        type: "get",
        url: "models/getData.php",
        dataType: "json",
        success: function (response) {
           document.contains(document.querySelector('#numberOfUsers')) ? document.querySelector('#numberOfUsers')
            .innerHTML = response.numberOfUsers.numberOfUsers : ''
           document.contains(document.querySelector('#numberOfTours')) ? document.querySelector('#numberOfTours')
            .innerHTML = response.numberOfTours.numberOfTours : ''
            printMostVisitedTours(response.mostVisitedTours)
        },error:function(jqXHR,statusTxt,xhr){
            createResponseMessages('danger', jqXHR.responseJSON, 'home_message')
        }
       });
    }
    function printMostVisitedTours(mostVisitedTours){
        let content ='',index = 0
        mostVisitedTours.forEach(tour => {
            content+= printVisitedTour(tour, index)
            index++
        })
        $('#reservations').html(content)
    }
    function printVisitedTour(tour, index){
        const {mostVisitedTours, name, date} = tour
        return `
            <tr>
                <th scope='row'>${parseInt(index)  +1}</th>
                <td>${name}</td>
                <td>${formatDate(date)}</td>
                <td>${mostVisitedTours}</td>
            </tr>
        `
    }
});