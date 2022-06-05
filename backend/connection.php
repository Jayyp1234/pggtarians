<?php

    $hostname = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'pgg';

    $connection = mysqli_connect($hostname, $user, $pass, $db);
    try {
        if(!$connection){
            echo "Error: ". mysqli_connect_errno();
        }
    } catch (\Throwable $th) {
        
    }



?>