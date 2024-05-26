<?php 

try {
    require_once 'config.php';
    $connection = new PDO("mysql:host=".HOST.';dbname='.DBNAME, USERNAME, PASSWORD);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (PDOException $th) {
    echo $th->getMessage();
}