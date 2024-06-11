$(document).ready(function () {

    let page = window.location.href.split("?")[1];
    if(page == 'page=tours'){
        filterData()
    }else{
        localStorage.clear()
    }

   $(document).on('click','#btnContactUs', function(e){
        e.preventDefault()
  
        const first_name = $('#first_name').val()
        const last_name = $('#last_name').val()
        const email = $('#email').val()
        const message =  $('#message').val()

        if(contactFormValidation(first_name, last_name, email, message).length == 0){
            $.ajax({
                type: "post",
                url: "models/messages/store.php",
                data: {first_name, last_name, email, message},
                dataType: "json",
                success: function (response) {
                    createResponseMessages('success', response, 'contact_response_message')
                    $('#first_name').val('').removeAttr('value')
                    $('#last_name').val('').removeAttr('value')
                    $('#email').val('').removeAttr('value')
                    $('#message').val('').removeAttr('value')
                },error:function(jqXHR, statusTxt, xrh){
                    createResponseMessages('danger', jqXHR.responseJSON, 'contact_response_message')
                }
            });
        }
    })
   $(document).on("keyup",'#search_text', function(e){
        e.preventDefault()
        
        let keyword  = $("#search_text").val()
        localStorage.setItem('keyword', keyword)
        filterData()
   })
   $(document).on("click",'.page-tours', function(e){
    e.preventDefault()
    let limit  = $(this).data('limit')
    localStorage.setItem('tour-page', limit)
    filterData()
   })

   $(document).on('change','input[name="categories"]', function(e){
    e.preventDefault()
    let checks = document.querySelectorAll('input[name="categories"]:checked')

    let selctedCheckes = [];
    filterData()
    localStorage.setItem('checkboxes', extractValuesFromCheckboxes(checks, selctedCheckes));
    
   })
   $(document).on('click','#btnReserveTour',function(e){
    e.preventDefault()
    const tour_id = $("#tour_id").val()
    const date = $('#date').val()
    if(reservationDateTour(date).length == 0){
        $.ajax({
            type: "post",
            url: "models/reservations/store.php",
            data: {tour_id, date},
            dataType: "json",
            success: function (response) {
                createResponseMessages('success', response, 'tour_reservation_response_message')
                $('#date').val(0)
            },error:function(jqXHR,statusTxt,xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'tour_reservation_response_message')
            }
        });
    }

   })
   $(document).on("click",'#btnVote',function(e){
    e.preventDefault()
    let radioInput = document.querySelector('input[name="answers"]:checked')
    let survey_id = $('#survey_id').val()
    if(anketaFormValidation(radioInput).length == 0){
        const radio_value = radioInput.value
       $.ajax({
        type: "post",
        url: "models/survey/vote.php",
        data: {radio_value, survey_id},
        dataType: "json",
        success: function (response) {
            createResponseMessages('success', response, 'tour_reservation_response_message')
            $("#survey")[0].classList.add("d-none")
        },error:function(jqXHR,statusTxt,xhr){
            createResponseMessages('danger', jqXHR.responseJSON, 'tour_reservation_response_message')
        }
       });
    }
   })

   function filterData(){
        let text= $('#search_text').val()
        let checkboxes = document.querySelectorAll('input[name="categories"]:checked')
        let selectedCheckboxes = []
        extractValuesFromCheckboxes(checkboxes, selectedCheckboxes)
        let limit = localStorage.getItem('tour-page') != null ? localStorage.getItem('tour-page') : 0;
        console.log(limit)
        $.ajax({
            type: "get",
            url: "models/tours/filter.php",
            data: {text, selectedCheckboxes, limit},
            dataType: "json",
            success: function (response) {
               printAllTours(response.tours)
               printPagination(response.pages, limit, 'pages-tours','page-tours')
            },error:function(jqXHR,statusTxt,xhr){
                createResponseMessages('danger', jqXHR.responseJSON, 'tours_response_message')
            }
        });
   }

   function printAllTours(tours){
        let content = ``
        if(tours.length > 0){
            tours.forEach(tour => {
                content+= printTour(tour)
            })
        }else {
            content+= `<h1 class='text-center'>Trenutno nemamo u ponudi ni jednu turu</h1>`
            $('#tours-pages').html('')
        }
        $('#tours').html(content)
   }
   function printTour(tour){
    const {id, name, image_path} = tour
    return ` <div class="col-lg-3 mb-2">
    <div class="card h-100">
        <img src="assets/img/${image_path}" class="card-img-top" alt="${name}">
        <div class="card-body text-center">
          <h2 class="fs-5">  <a href="index.php?page=tour&id=${id}" class="nav-link">${name}</a></h2>
        </div>
    </div>
</div>`
   }
});