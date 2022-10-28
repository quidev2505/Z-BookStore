<?php
    session_start();
    if(isset($_GET['type'])){
        $type = $_GET['type'];
        if($type == 'admin'){
            unset($_SESSION['admin_signin']);
        }
        else{
            setcookie("user_signin_remember","",time()-3600);
            unset($_SESSION['user_signin']);
        }
    }
    header("Location: index.php");