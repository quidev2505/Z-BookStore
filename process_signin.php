<?php
    session_start();
    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        require './connectDB.php';

        $stmt = $connect -> prepare("select * from account where username=? and password=?");

        $stmt->execute([$username, $password]);

        $data = $stmt->fetch();

        if($stmt->rowCount() == 1){
            $fullname = $data['fullname'];
            $priority = $data['priority'];
            if($priority == 0){
                $_SESSION['user_signin'] = $fullname;
                header("Location: index.php");
                exit();
            }elseif($priority == 1){
                $_SESSION['admin_signin'] =  $fullname;
                header("Location: ./admin/admin_books.php?page=1");
                exit();
            }
        }
        else{
            header("Location: signin.php?signin_status=false");
            exit();
        }
    }
    else{
        header("Location: signin.php?signin_status=false");
        exit();
    }

