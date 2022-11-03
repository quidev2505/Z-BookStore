<?php
    include './connectDB.php';

    session_start();

    if(isset($_GET['id'])&&isset($_GET['amount_product'])){
        $id = $_GET['id'];
        $amount_product = $_GET['amount_product'];

        //Kiểm tra xem còn tồn tại giỏ hàng cũ không?
        if(isset($_COOKIE['save_cart'])){
            $_SESSION['save_cart'] = json_decode($_COOKIE['save_cart'], true);
        }

        //Kiểm tra xem còn tồn tại tổng số lượng sản phẩm giỏ hàng cũ không ?
        if(isset($_COOKIE['cart_sum_amount_product'])){
            $_SESSION['cart_sum_amount_product'] = $_COOKIE['cart_sum_amount_product'];
        }

        if(empty($_SESSION['cart'][$id])){
            $sql = "select * from books where id = ?";
            $stmt = $connect -> prepare($sql);
            $stmt->execute([$id]);
            $books = $stmt -> fetch();

            $_SESSION['cart'][$id]['title'] = $books['title'];
            $_SESSION['cart'][$id]['book_image'] = $books['book_image'];
            $_SESSION['cart'][$id]['amount'] = $amount_product;
            $_SESSION['cart'][$id]['price'] = $books['price'];
        }else{
            $_SESSION['cart'][$id]['amount'] = $_SESSION['cart'][$id]['amount'] + $amount_product;
        }

    
        //Them SESSION tong so luong san pham
        $_SESSION['cart_sum_amount_product'] += $amount_product;

        //Set cookie cho gio hang
        setcookie('save_cart',json_encode($_SESSION['cart']), time() + 86400);

        //Set cookie cho tổng số lượng sản phẩm của giỏ hàng
        setcookie('cart_sum_amount_product',$_SESSION['cart_sum_amount_product'], time() + 86400);

        header("Location: ./detail_book.php?id=$id&success_addToCart");
    }


