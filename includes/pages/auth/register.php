<?php 
    if(isset($_SESSION['user'])){
       header("Location:index.php?page=errors&code=403");
    }
?>
<main>
    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mx-auto">
                    <div id="register_response_message"></div>
                    <h2 class="text-center mb-2">Registruj se</h2>
                    <hr>
                    <form action="#">
                        <div class="mb-3">
                            <label for="first_name" class="mb-1">First name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control mb-1">
                            <div id="first_name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="mb-1">Last name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control">
                            <div id="last_name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="mb-1">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                            <div id="email_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="mb-1">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <div id="password_error"></div>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-sm btn-primary" id="btnRegister" name="btnRegister">Registruj se</button>
                            <div class="d-flex justify-content-center gap-2">
                                <span>Vec imate nalog?</span>
                                <a href="index.php>page=login" class="nav-item">Log in</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>