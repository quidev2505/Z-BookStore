<?php
    include './connectDB.php';

    if(isset($_GET['search_book'])){
        $search_info = $_GET['search_book'];
        $sql = "select * from books where title LIKE '%$search_info%'";

        $stmt = $connect -> prepare($sql);
        $stmt->execute();
        $books = $stmt->fetchAll();
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
         #right_book{
            display: flex;
            flex-wrap: wrap;
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
            justify-content: space-between;
            align-items: center;
            height: 35px;
            cursor: pointer;
            font-size: 14px;
            width: 162px;
            color: var(--white-color);
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
            object-fit: cover;
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

        #search_container{
            margin:20px 140px;
        }

        #top_content_search{
            margin-bottom: 20px;
        }
    </style>
<body>
    <?php include './layout/header.php'?>
    <?php include './layout/category.php'?>

    <div id="search_container">
        <div id="top_content_search">
            <h2>Tìm kiếm</h2>
            <p>Kết quả tìm kiếm cho <span style="font-weight:bold;">
            <?php if(isset($_GET['search_book'])) echo "\"".$search_info."\".";?>
        </span></p>
        </div>
        <div id="bottom_search_book">
            <?php if($stmt->rowCount() > 0){?>
            <div id="right_book">
                <?php foreach($books as $book){?>
                    <div class="van_hoc_book_item">
                        <div class="img_book_van_hoc">
                            <a href="./detail_book.php?id=<?= $book['id']?>" class="see_detail">
                                <img src="./admin/upload/<?= $book['book_image'] ?>" alt="" class="img_book_show" title="Xem chi tiết">
                            </a>
                            <p id="name_book"><?= $book['title']?></p>
                            Giá: 
                            <span id="price_book">
                                <?php echo("{$book['price']} đ") ?>
                            </span>
                            <div id="add_cart">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <a href="addToCart.php?id=<?= $book['id'] ?>" class="add_to_cart">
                                    Thêm vào giỏ hàng
                                </a>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
            <?php } else echo '<h2 style="color:var(--main-color);">Không có sản phẩm cần tìm !</h2>'?>
        </div>
    </div>

    <?php include './layout/footer.php'?>
</body>
</html>