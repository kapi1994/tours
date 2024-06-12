<?php
    $codeError = isset($_GET['code']) ? $_GET['code'] : '';
    $code = '';
    $message = '';
    switch($codeError){
        case '403':
            $code = 403;
            $message='Neovlasceni pristup';
        default:
        $code = 404;
        $message = "Stranica nije pronadjena";
    }
?>
<main>
    <section class="container">
        <div class="row mt-5 text-center">
            <h1><?=$code?></h1>
            <p><?=$message?></p>
        </div>
    </section>
</main>
