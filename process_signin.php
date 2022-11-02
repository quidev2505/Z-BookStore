<?php
    session_start();
    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        require './connectDB.php';

        if($username == 'admin'){
            $stmt = $connect -> prepare("select * from account where username=?");
            $stmt->execute([$username]);
            $password_hash_fromDB = $stmt->fetch()['password'];

            if(password_verify($password , $password_hash_fromDB)){
                $_SESSION['admin_signin'] = 'Tài khoản Admin';
                header("Location: ./admin/admin_books.php?page=1");
            }else{
                header("Location: signin.php?signin_status=false");
                exit();
            }
        }else{
            $stmt = $connect -> prepare("select * from account where username=? and password=?");

            $stmt->execute([$username, $password]);
    
            $data = $stmt->fetch();

    
            $fullname = $data['fullname'];
            $priority = $data['priority'];

            if($stmt->rowCount() == 1){
                if($priority == 0){
                    if(isset($_POST['remember_signin'])){
                        SETCOOKIE("user_signin_remember", $fullname, time()+86400); //1 Day
                    }else{
                        $_SESSION['user_signin'] = $fullname; 
                    }  
                    header("Location: index.php");
                    exit();
                }
            }else{
                header("Location: signin.php?signin_status=false");
                exit();
            }
        }
    }