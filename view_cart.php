<?php 
    session_start();
    require './connectDB.php';

    if(isset($_COOKIE['save_amount_cart'])){
        $_SESSION['cart'] = json_decode($_COOKIE['save_amount_cart'], true);
        $sum_amount_product  = $_SESSION['cart']['sum_amount_product'];

        $cart = $_SESSION['cart'];
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z Books</title>

    <!--Insert Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <?php require_once './layout/header.php'?>    
    <?php require_once './layout/category.php'?>    

    <div id="container_view_cart">
        <h2>GIỎ HÀNG</h2> 
        <span>
            (<?= $sum_amount_product;?> sản phẩm)
        </span>
        <div id="wrap_cart_view">
            <table>
                <thead>
                    <th>Bìa sản phẩm</th>
                    <th>Thông tin sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá tiền</th>
                    <th>Xóa sản phẩm</th>
                </thead>
                <tbody>
                    <?php foreach($cart as $id => $value){?>
                        <tr>
                            <td>
                                <img src="./admin/upload/<?= $cart[$id]['book_image']?>" alt="">
                            </td>
                            <td>
                                <p>
                                    <?= $cart[$id]['title']?>
                                </p>
                                <p>
                                    <?= $cart[$id]['price'].' đ'?>
                                </p>
                            </td>
                            <td>
                                <?=  $cart[$id]['amount']?>
                            </td>
                            <td>
                                <?php 
                                    $price = number_format(($cart[$id]['amount'] * $cart[$id]['price']),3,'.','.');
                                    echo $price.' đ';
                                ?>
                            </td>
                            <td>
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>

    <?php require_once './layout/footer.php'?>    
</body>