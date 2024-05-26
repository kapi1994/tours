<?php 
session_start();
if($_SESSION['user']){
    unset($_SESSION['user']);   
    session_destroy();
    header("Location:../../index.php");
}