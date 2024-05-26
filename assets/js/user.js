$(document).ready(function () {
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
});