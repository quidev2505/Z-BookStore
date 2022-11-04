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
            color: var(--second-color);
        }


        #btn_change input{
            height: 30px;
            border-radius: 5px;
            width: 52px;
            /* border: none; */
            font-size: 15px;
            font-weight: bold;
            text-align: center;
        }


        #amount_add_to_cart{
            font-size: 17px;
            font-weight: bold;
        }


        #amount_add_to_cart input{
            height: 30px;
            border-radius: 5px;
            width: 63px;
            /* border: none; */
            font-size: 15px;
            text-align: center;
        }

        #amount_add_to_cart button{
            height: 30px;
            font-size: 15px;
            cursor: pointer;
            width: 40px;
            /* background: var(--second-color); */
            border: none;
            border-radius: 5px;
            }


        #right_cart{
            width: calc(100% - 1000px);
            background-color: white;
            border-radius: 10px;
            margin: 10px 10px 10px 0px;
            padding: 10px;
            /* min-height: 75px; */
            height: 144px;
            text-align: center;
        }

        #sum_price h4{
            color: black;
        }

        #sum_price span{
            font-size: 30px;
            color: var(--main-color);
        }

        #btn_sum_price{
            width: 222px;
            margin-top: 20px;
            height: 40px;
            color: white;
            border-radius: 10px;
            background-color: var(--main-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
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
                (<?php if(isset($_COOKIE['cart_sum_amount_product'])){echo $cart_sum_amount_product;}else echo 0;?> sản phẩm)
            </span>
            <div id="wrap_cart_view">
                <div id="left_cart">
                    <table>
                        <thead style="height: 47px;">
                            <th>Bìa sản phẩm</th>
                            <th style="width:460px;">Thông tin sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá tiền</th>
                            <th>Xóa sản phẩm</th>
                        </thead>
                        <tbody>
                            <?php if(isset($cart) && (count($cart) > 0)){?>
                                <?php $sum_price_all_product = 0; foreach($cart as $id => $value){
                                    ?>
                                    <tr style="height: 169px;">
                                        <td>
                                            <img src="./admin/upload/<?= $cart[$id]['book_image']?>" alt="" width="100px" height="135px">
                                        </td>
                                        <td style="text-align:left;padding-left:20px;">
                                            <p style="margin-bottom: 63px; width:460px;">
                                                <?= $cart[$id]['title']?>
                                            </p>
                                            <p style="color:black;font-weight:bold;">
                                                <?= $cart[$id]['price'].' đ'?>
                                            </p>
                                        </td>
                                        <td id="btn_change">
                                            <a href="change_amount.php?type=decrease&id=<?= $id?>">-</a>
                                            <input class="input_change" type="text" min="1" max="100"  data-id="<?=$id?>"  value="<?php echo $cart[$id]['amount']?>" disabled>
                                            <a href="change_amount.php?type=increase&id=<?= $id?>">+</a>
                                        </td>
                                        <td style="color:var(--main-color);font-weight:bold">
                                            <?php 
                                                $price = number_format(($cart[$id]['amount'] * $cart[$id]['price']),3,'.','.');
                                                $sum_price_all_product += $price;
                                                echo $price.' đ';
                                            ?>
                                        </td>
                                        <td>
                                            <a href="change_amount.php?type=delete_cart&id=<?=$id?>" style="color:var(--second-color)">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }?>
                            <?php }else echo '<h4 style="text-align: center;
                                            display: block;
                                            color: var(--second-color);">Không có sản phẩm nào trong giỏ hàng<h4>
                                            <a style="    text-decoration: none;
                                            color: var(--main-color);
                                            text-align: center;
                                            display: block;
                                            margin-top: 14px;" href="./collections.php?category_name=all">
                                            <i class="fa fa-arrow-circle-left" aria-hidden="true" ></i> Tiếp tục mua sắm </a>'?>
                        </tbody>
                    </table>
                </div>
                <div id="right_cart">
                    <div id="container_sum_price">
                        <div id="sum_price">
                            <h4>Tổng Số Tiền</h4>
                            <span><?php if(isset($sum_price_all_product)) {echo number_format($sum_price_all_product,3,'.','.').' đ';} else echo '0 đ';?></span>
                        </div>
                        <div id="btn_sum_price">
                            THANH TOÁN
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </main>

    <?php require_once './layout/footer.php'?>    
</body>