<?php
    session_start();
    if(isset($_SESSION['save_cart']) && isset($_GET['id'])){
        $cart = $_SESSION['save_cart'];
        $id = $_GET['id'];

        switch($_GET['type']){
            case 'decrease':
                $cart[$id]['amount'] = $cart[$id]['amount'] - 1 ;
                break;
            case 'increase':
                $cart[$id]['amount'] = $cart[$id]['amount'] + 1;
                break;
        }
        echo $cart[$id]['amount'];

        $_SESSION['save_cart'][$id]['amount'] =  15 ;

        // header("Location: ./view_cart.php");
        
    }