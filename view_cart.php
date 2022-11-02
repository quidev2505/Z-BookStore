<?php 
    session_start();
    require './connectDB.php';

    //Kiểm tra tồn tại cookie tổng số lượng giỏ hàng
    if(isset($_COOKIE['cart_sum_amount_product'])){
        $cart_sum_amount_product  = $_COOKIE['cart_sum_amount_product'];
    }

    //Kiểm tra tồn tại giỏ hàng cũ
    if(isset($_COOKIE['save_cart'])){
        $_SESSION['save_cart'] = json_decode($_COOKIE['save_cart'], true);

        $cart = $_SESSION['save_cart'];
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
    <style>
        main{
            padding: 0 140px;
        }

        #container_view_cart{
            padding-top: 10px;
        }

        #container_view_cart h2{
            display: inline-block;
            font-weight: 400;
        }

        #container_view_cart #wrap_cart_view{
            display: flex;
        }

        #wrap_cart_view #left_cart{
            width: 1000px;
            background-color: white;
            border-radius: 10px;
            margin: 10px 10px 10px 0px;
            padding: 10px;
        }

        #wrap_cart_view tbody{
            text-align: center;
        }
        #wrap_cart_view table{
            width: 100%;
        }

        #wrap_cart_view i:hover{
            color: var(--main-color);
            cursor: pointer;
        }

        #wrap_cart_view img{
            object-fit: cover;
        }

        #btn_change a{
            text-decoration: none;
            border: 1px solid #ccc;
            padding: 10px;
            /* width: 19px; */
            font-size: 16px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php require_once './layout/header.php'?>    
    <?php require_once './layout/category.php'?>    

    <main>
        <div id="container_view_cart">
            <h2>GIỎ HÀNG</h2> 
            <span style="font-weight:600">
                (<?= $cart_sum_amount_product;?> sản phẩm)
            </span>
            <div id="wrap_cart_view">
                <div id="left_cart">
                    <table>
                        <thead style="height: 47px;">
                            <th>Bìa sản phẩm</th>
                            <th>Thông tin sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá tiền</th>
                            <th>Xóa sản phẩm</th>
                        </thead>
                        <tbody>
                            <?php foreach($cart as $id => $value){?>
                                <tr style="height: 169px;">
                                    <td>
                                        <img src="./admin/upload/<?= $cart[$id]['book_image']?>" alt="" width="100px" height="135px">
                                    </td>
                                    <td style="text-align:left;padding-left:20px;">
                                        <p style="margin-bottom: 63px;">
                                            <?= $cart[$id]['title']?>
                                        </p>
                                        <p style="color:black;font-weight:bold;">
                                            <?= $cart[$id]['price'].' đ'?>
                                        </p>
                                    </td>
                                    <td id="btn_change">
                                        <a href="handle_amount_product.php?type=decrease&id=<?=$id?>">-</a>
                                        <?=  $cart[$id]['amount']?>
                                        <a href="handle_amount_product.php?type=increase&id=<?=$id?>">+</a>
                                    </td>
                                    <td style="color:var(--main-color);font-weight:bold">
                                        <?php 
                                            $price = number_format(($cart[$id]['amount'] * $cart[$id]['price']),3,'.','.');
                                            echo $price.' đ';
                                        ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-trash-alt"></i>
                                    </td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
                <div id="right_cart">
                    <h2>bên phải</h2>
                </div>
            
            </div>
        </div>
    </main>

    <?php require_once './layout/footer.php'?>    
</body>