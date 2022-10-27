<?php
    if(isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['password'])){
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        require './connectDB.php';
        $stmt = $connect->prepare("select * from account where fullname = ? or username = ?");
        $stmt -> execute([$fullname, $username]);

        if($stmt->rowCount() > 0){
            header("Location: signup.php?signup_status=duplicated");
        }else{
            $stmt = $connect -> prepare("insert into account(fullname, username, password) values(?,?,?)");

            $stmt->execute([$fullname, $username, $password]);
    
            header("Location: signup.php?signup_status=true");
        }
    }
    else{
        header("Location: signup.php?signup_status=false");
    }
