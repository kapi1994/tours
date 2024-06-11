$(document).ready(function () {
    $('#btnRegister').click(function (e) { 
        e.preventDefault();
       
        const first_name = $('#first_name').val()
        const last_name = $('#last_name').val()
        const email = $('#email').val()
        const password = $('#password').val()

        if(registerValidationForm(first_name, last_name, email, password).length == 0){
            $.ajax({
                type: "post",
                url: "models/auth/register.php",
                data: {first_name, last_name, email, password},
                dataType: "json",
                success: function (response) {
                  window.location.href='index.php?page=login'
                },error:function(jqXHR, statusTxt, xhr){
                    createResponseMessages('danger', jqXHR.responseJSON, 'register_response_message')
                }
            });
        }

    });

    $('#btnLogin').click(function (e) { 
        e.preventDefault();
       
        const email = $('#email').val()
        const password = $('#password').val()

        if(loginFormValidation(email, password).length == 0){
            $.ajax({
                type: "post",
                url: "models/auth/login.php",
                data: {email, password},
                dataType: "json",
                success: function (response) {
              
                  response == 1 ? window.location.href='admin.php' : window.location.href='index.php'
                },error:function(jqXHR, statusTxt, xhr){
                    createResponseMessages('danger', jqXHR.responseJSON, 'login_response_message')
                }
            });
        }
    });

});