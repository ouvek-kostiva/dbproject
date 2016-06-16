<?php

    $dbhost = '127.0.0.1';   
    $dbuser = 'Signupuser';   
    $dbpass = '';   
    $dbname = 'c9';   
    try{
    $conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname,$dbuser,$dbpass);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES UTF8');
    } catch (PDOException $e) {
        throw new PDOException("Error  : " .$e->getMessage());
    }

?>