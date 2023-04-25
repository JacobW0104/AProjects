<?php

    $db_host = 'localhost';
    $db_name = 'u_220219442_portfolio3';
    $username = 'u-220219442';
    $password = 'fGxPyxI0He9XHXx';

    try{
        $db = new PDO("mysql:dbname=$db_name;host=$db_host", $username, $password);
    } catch(PDOException $ex){
        echo("Failed to connect to the database.<br>");
        echo($ex->getMessage());
        exit;
    }

?>