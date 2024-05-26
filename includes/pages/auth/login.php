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
                <h2 class="text-center">Prijavi se</h2>
                <hr>
                <div class="col mb-2" id="login_response_message"></div>
                <form action="#">
                    <div class="mb-3">
                        <label for="email" class="mb-1">Email</label>
                        <input type="text" name="email" id="email" class="form-control mb-1">
                        <div id="email_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="mb-1">Password</label>
                        <input type="password" name="password" id="password" class="form-control mb-1">
                        <div id="password_error"></div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-sm btn-primary" id="btnLogin" type="button" name="btnLogin">Log in</button>
                        <div class="d-flex justify-content-center gap-2">
                            <span>Nemate nalog?</span>
                            <a href="index.php?page=register" class="nav-item">Registrujte se</a>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </section>
</main>