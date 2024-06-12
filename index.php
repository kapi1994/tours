<?php 
    session_start();

    require_once 'config/connection.php';
    include 'models/functions.php';


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
            case 'pocetna':
                include 'includes/pages/user/home.php';
                break;
            case 'destinacije':
                include 'includes/pages/user/tours.php';
                break;
            case 'kontakt':
                include 'includes/pages/user/contact.php';
                break;
            case 'tour':
                include 'includes/pages/user/tour.php';
                break;
            case 'autor':
                include 'includes/pages/user/author.php';
                break;
            default :
                include 'includes/pages/errors.php';
                break;     
        }
    }else{
        include 'includes/pages/user/home.php';
    }
    include 'includes/partials/footer.php';