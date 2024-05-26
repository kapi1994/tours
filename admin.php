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
           case 'categories':
            include 'includes/pages/admin/categories.php';
            break;  
            case 'posts':   
                include 'includes/pages/admin/posts.php';
                break;
            case 'dates':
                include 'includes/pages/admin/dates.php';   
                break;
            case 'survey':
                include 'includes/pages/admin/survey.php';
                break;  
            case 'messages':
                include 'includes/pages/admin/messages.php';
                break; 
            case 'home':
                include 'includes/pages/admin/home.php';
                break;
            case 'add-question':
                include 'includes/pages/admin/questions.php';  
                break;  
            case 'add-answer':
                include 'includes/pages/admin/answers.php';
                break;    
            default:
                include 'includes/pages/errors.php';      
        }
    }else{
        include 'includes/pages/admin/home.php';
    }
    include 'includes/partials/footer.php';