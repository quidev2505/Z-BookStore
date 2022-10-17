<?php 
    $servername = 'localhost';
    $dbname = 'z_bookstore';
    $usernameDB = 'root';
    $passwordDB = '';

    try{
        /*Connect to Database */
        $connect = new PDO("mysql:host=$servername;dbname=$dbname", $usernameDB, $passwordDB);
    }catch(PDOException $e){
        echo 'Lỗi kết nối -'.$e;
    }

