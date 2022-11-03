<?php
    session_start();

    if(isset($_GET['type'])&&isset($_GET['id'])){
        $type = $_GET['type'];
        $id = $_GET['id'];

        if($type == 'increase'){
            $_SESSION['cart'][$id]['amount'] ++;
            $_SESSION['cart_sum_amount_product']++;
        }else if($type == 'decrease'){
            $_SESSION['cart'][$id]['amount'] --;
            $_SESSION['cart_sum_amount_product']--;
            if($_SESSION['cart'][$id]['amount'] < 1){
                $_SESSION['cart_sum_amount_product'] -=  $_SESSION['cart'][$id]['amount'];
                unset($_SESSION['cart'][$id]);
            }
        }else if($type == 'input_change'){
            $_SESSION['cart'][$id]['amount']  = $_GET['value'];
            $_SESSION['cart_sum_amount_product'] = $_GET['value'];
        }else if($type == 'delete_cart'){
            $_SESSION['cart_sum_amount_product'] -=  $_SESSION['cart'][$id]['amount'];
            unset($_SESSION['cart'][$id]);
        }


        //Set cookie cho tổng số lượng sản phẩm của giỏ hàng
        setcookie('cart_sum_amount_product',$_SESSION['cart_sum_amount_product'], time() + 86400);


        // //Set cookie cho gio hang
        setcookie('save_cart',json_encode($_SESSION['cart']), time() + 86400);

      
        header("Location:  view_cart.php");
    }
