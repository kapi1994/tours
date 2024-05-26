<?php 
    session_start();

    require_once 'config/connection.php';
    include 'includes/partials/head.php';
    include 'includes/partials/navigation.php';
    $page = '';
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        switch($page){
            case 'login':
                include 'includes/pages/auth/login.php';
                break;
            case 'register':
                include 'includes/pages/auth/register.php';
                break;
            case 'home':
                include 'includes/pages/user/home.php';
                break;
            case 'tours':
                include 'includes/pages/user/tours.php';
                break;
            case 'contact':
                include 'includes/pages/user/contact.php';
                break;
            default :
                include 'includes/pages/errors.php';
                break;     
        }
    }
    include 'includes/partials/footer.php';