<?php
    include './connectDB.php';
    session_start();
    if(isset($_GET['id'])){
        $id_book = $_GET['id'];

        $sql = "select * from books b join authors a on b.id_author = a.id_author join categories cate on b.id_category = cate.id_category where id = ?";
        $stmt = $connect -> prepare($sql);
        $stmt->execute([$id_book]);
        $book_products = $stmt -> fetch(); 


        //Lấy dữ liệu sách tương tự dựa theo id danh mục
        $sql_relation = "select * from books where id_category = ?";
        $stmt = $connect -> prepare($sql_relation);
        $stmt->execute([$book_products['id_category']]);
        $book_relation = $stmt -> fetchAll();
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
            padding-top: 60px;
        }
        #container_detail_book{
            display: flex;
            background-color: white;
            padding: 50px 140px 0;
            justify-content: space-around;
        }


        #left_img_book{
            margin-right: 50px;
        }

        #left_img_book img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            image-rendering: pixelated;
        }

        #btn_cart_and_order{
            display: flex;
            margin-top: 70px;
        }


        #btn_addtoCart{
            margin-right: 40px;
        }


        #btn_order{
            width: 257px;
        }

        #btn_addtoCart div, #btn_order div{
            width: 247px;
            min-height: 50px;
            cursor: pointer;
        }

        #btn_addtoCart div{
            background-color: #07a185;
            color: #fefefe;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            padding: 5px;
        }
        #btn_order div{
            background-color: var(--main-color);
            color: #fefefe;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            padding: 5px;
        }
        
        #btn_addtoCart i, #btn_order i{
            margin-top: 15px;
        }

        #btn_addtoCart i+span, #btn_order i+span{
            color: var(--second-color);
            font-size: 15px;
        }

        #description_book_detail{
            padding: 30px 140px 30px;
            background-color: #fff;
        }

        #description_book_detail h3{
            font-weight: 600;
            font-size: 20px;
            border: 1px solid var(--main-color);
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }

        #description_book_detail p{
            width: fit-content;
        }

        #description_book_detail div{
            height: 150px;
            overflow-y: scroll;
        }

        #relation_book{
            margin-top: 20px;
        }

        #relation_book h3{
            text-align: center;
            color: var(--main-color);
            padding: 10px;
            border: 1px solid;
        }

        
        #right_book{
            display: flex;
            flex-wrap: wrap;
            padding: 0 140px;
            justify-content: space-between;
        }

        #name_book{
            margin: 12px 0px;
            height: 38.4px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        #price_book{
            color:var(--main-color);
            font-weight: bold;
        }

      
        #add_cart{
            margin-top: 9px;
            background-color: var(--main-color);
            padding: 5px;
            border-radius: 5px;
            padding: 10px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 35px;
            cursor: pointer;
            font-size: 14px;
            width: 162px;
            color: var(--white-color);
            position: relative;
        }


        #add_cart i{
            position: absolute;
            left: 13px;
        }


        #add_cart a{
            width: 100%;
            z-index: 999;
            text-align: center;
        }

        #add_cart:hover a{
            color: rgba(0,0,0,0.5);
            font-weight: bold;
            line-height: 35px;
        }

          /*Văn học */

          #van_hoc_book{
            display: flex;
            justify-content: space-between;
        }

        .van_hoc_book_item{
            width:208px;
            min-height: 340px;
            border: 0.5px solid var(--other-color);
            background-color: #fff;
            margin-right: 20px;
            display: flex;
            justify-content: center;
            border-radius: 3px;
            margin-bottom: 20px;
        }

        .img_book_van_hoc{
            width: 160px;
            height: 180px;
            margin: 10px 0;
        }

        .img_book_van_hoc img{
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .img_book_show{
            transition: all 0.3s linear;
        }

        .see_detail:hover .img_book_show{
            transform: scale(1.1);
            opacity: 0.9;
        }
    
        .add_to_cart{
            text-decoration: none;
            color: var(--white-color);
        }

        
        #breadcrumb{
            margin: -42px 0 17px 139px;
            font-size: 14px;
            color: var(--second-color);
        }
        
        #breadcrumb a{
            text-decoration: none;
            color: var(--main-color);
        }

        #amount_add_to_cart{
            font-size: 17px;
            margin-top: 41px;
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

        #overlay{
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #2e26267d;
            /* opacity: 0.6; */
            z-index: 999;
        }

        #content_overlay{
            position: absolute;
            top: 15%;
            left: 36%;
            background-color: white;
            padding: 52px;
            border-radius: 10px;
        }


        #content_overlay h2{
            margin-bottom: 25px;
        }

        #content_overlay a{
            text-decoration: none;
            margin-right: 10px;
            border: 10px;
            background-color: var(--main-color);
            border-radius: 5px;
            padding: 10px;
            margin-top: 0px;
            color: white;
        }

        #content_overlay p{
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include './layout/header.php'?>
    <?php include './layout/category.php'?>

    <main>
        <div id="breadcrumb">
                <a href="./index.php">Trang chủ</a> /
                <?php if(!empty($_GET['name'])){?>
                    <a href="./collections.php?category_id=<?php echo $book_products['id_category']?>"><?php echo $_GET['name'].' /';?></a> 
                <?php }?>
                <?= $book_products['title']; ?>
        </div>
        <div id="container_detail_book">
            <div id="left_img_book">
                <img src="./admin/upload/<?= $book_products['book_image'];?>" alt="">
            </div>
            <div id="description_book">
                <h1 style="font-weight:400"><?= $book_products['title']?></h1> 
                <br>
                <p style="font-weight:bold;display:inline-block;margin-bottom:20px;">Tác giả:</p>
                <span style="color:var(--main-color);">
                <?= $book_products['author_name'];?></span>
                
                <hr>
                <br>
                <p style="font-weight:bold;display:inline;">Giá bán:</p>
                <span style="color:var(--main-color);font-size:20px;font-weight:bold;"><?= $book_products['price']." đ"?></span>

                <?php if(isset($_GET['success_addToCart'])){?>
                    <div id="show_notify_addTocart">
                        <div id="overlay">
                            <div id="content_overlay">
                                <h2>Thêm vào giỏ hàng thành công !</h2>
                                <p>Giỏ hàng bạn hiện tại có <span style="color:var(--main-color);"><?=     $_SESSION['cart']['sum_amount_product']; ?></span> sản phẩm </p>
                                <a id="continue_addtoCart" href="./detail_book.php?id=<?= $_GET['id'];?>">Tiếp tục mua hàng <i class="fa-solid fa-arrow-right"></i></a>
                                <a href="./check_out.php?id=<?= $_GET['id'];?>">Đặt hàng và thanh toán <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php }?>


                <div id="amount_add_to_cart">
                    Số lượng:
                    <button id="decrease">-</button>
                    <input type="text" id="show_amount" value="1" min="1" max="50" name="amount_product">
                    <button id="increase">+</button>
                </div>
                
                <div id="btn_cart_and_order">
                    <div id="btn_addtoCart">
                        <div>
                            <h4>THÊM VÀO GIỎ</h4>
                            <p>Thêm sản phẩm vào giỏ hàng</p>
                        </div>
                        <i class="fa fa-check-circle"></i>
                        <span>Gọi mua hàng <span style="color:var(--main-color);">0907532754</span></span>
                        <br>
                        <i class="fa fa-check-circle"></i>
                        <span>Giao hàng toàn quốc</span>
                    </div>
                    <div id="btn_order">
                        <div>
                            <h4>MUA NGAY</h4>
                            <p>Mua online giao hàng tận nơi</p>
                        </div>
                        <i class="fa fa-check-circle"></i>
                        <span>Thanh toán bằng hình thức chuyển khoản trước hoặc COD</span>
                        <br>
                        <i class="fa fa-check-circle"></i>
                        <span>Phí ship có thể phát sinh theo cân nặng hàng hóa</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description_book -->
        <div id="description_book_detail">
            <h3>MÔ TẢ SẢN PHẨM</h3>
            <br>
            <div>
                <p>
                    <?= $book_products['description'];?>
                </p>
            </div>
        </div>

          <!-- Sản phẩm tương tự -->
          <div id="relation_book">
            <h3>SÁCH CÙNG LOẠI</h3>
            <br>
            <div id="book_relation">
                <div id="right_book">
                    <?php foreach($book_relation as $book_rlt){?>
                        <div class="van_hoc_book_item">
                            <div class="img_book_van_hoc">
                                <a href="./detail_book.php?id=<?= $book_rlt['id']?>&name=<?php if(isset($_GET['name'])) echo $_GET['name']; ?>" class="see_detail" class="see_detail">
                                    <img src="./admin/upload/<?= $book_rlt['book_image'] ?>" alt="" class="img_book_show" title="Xem chi tiết">
                                </a>
                                <p id="name_book"><?= $book_rlt['title']?></p>
                                Giá: 
                                <span id="price_book">
                                    <?php echo("{$book_rlt['price']} đ") ?>
                                </span>
                                <div id="add_cart">
                                    <i class="fas fa-book-open"></i>
                                    <a href="./detail_book.php?id=<?= $book_rlt['id']?>" class="add_to_cart">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </main>


    <?php include './layout/footer.php'?>
    
    <?php require './amount_addtoCart.php'?>
    
</body>