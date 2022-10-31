<?php
    include './connectDB.php';

    session_start();
    if(isset($_GET['id'])&&isset($_GET['amount_product'])){
        $id = $_GET['id'];
        $amount_product = $_GET['amount_product'];

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


        header("Location: ./detail_book.php?id=$id&success_addToCart");
    }
