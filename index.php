<?php 
    session_start();
    include './connectDB.php';

    // Lấy dữ liệu sách Văn học
    $stmt_vanhoc = $connect -> prepare("select * from books where id_category = 1 limit 4");
    $stmt_vanhoc->execute();
    $books_vanhoc = $stmt_vanhoc -> fetchAll();

    // Lấy dữ liệu sách Kinh tế
    $stmt_kinhte = $connect -> prepare("select * from books where id_category = 2 limit 4");
    $stmt_kinhte->execute();
    $books_kinhtes = $stmt_kinhte -> fetchAll();

    // Lấy dữ liệu sách Tâm lý
    $stmt_tamly = $connect -> prepare("select * from books where id_category = 4 limit 4");
    $stmt_tamly->execute();
    $books_tamlys = $stmt_tamly -> fetchAll();

    
    // Lấy dữ liệu sách Tiếu sử
    $stmt_tieusu = $connect -> prepare("select * from books where id_category = 3 limit 4");
    $stmt_tieusu->execute();
    $books_tieusus = $stmt_tieusu -> fetchAll();
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
        .content_show_book{
            margin: 0 140px;
            margin-top: 20px;
            background-color: white;
            border-radius: 5px;
            padding: 0 10px 10px 10px;
        }

        #content_index_page{
            margin: 0 140px;
            margin-top: 10px;
            display: flex;
        }
        #img_container{
            width: 835px;
            height: 415px;
            border-radius: 5px;
            position: relative;
            margin-right: 10px;
        }
        #img_slider{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #left-control, #right-control{
            width: 25px;
            height: 25px;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            padding:10px;
            border-radius: 50%;
            background-color: #fff;
            color: var(--second-color);
            box-shadow: 1px 2px #ccc;
            cursor: pointer;
            user-select: none;
        }

        #left-control{
            top: 50%;
            left: -10px;
        }

        #right-control{
            top: 50%;
            right: -10px;
        }

        #banner{
            display: flex;
            flex-direction: column;
        }

        .img_banner{
            width: 395px;
            height: 203px;
            margin-bottom: 10px;
            border-radius: 5px;
            overflow: hidden;
        }

        .img_banner img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .content_show_book #left_img{
            width: 290px;
            height: 350px;
        }

        #left_img img{
            width: 100%;
            height: 100%;
            object-fit: scale-down;
            image-rendering: pixelated;
        }

        #left_img{
            margin-top: 10px;
        }

        .content_show_book h2{
            font-size: 16px;
            display: inline-block;
            border-top: 3px solid var(--other-color);
            padding-top: 9px;
        }

        /*Văn học */

        #van_hoc_book{
            display: flex;
            justify-content: space-between;
        }

        .van_hoc_book_item{
            width:187px;
            min-height: 340px;
            border: 0.5px solid var(--other-color);
            margin-right: 20px;
            display: flex;
            justify-content: center;
            border-radius: 3px;
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
        main{
            height: 300vh;
        }


        #right_book{
            display: flex;
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

        /* Branch Book */
        #branch_book{
            background: var(--white-color);
            margin: 0 140px;
            margin-top: 30px;
            display: flex;
            height: 90px;
            align-items: center;
            justify-content: space-around;
            border-radius: 5px;
        }

        #branch_book h2{
            font-size: 18px;
        }

        /* Devide book container */
        #divide_book_container{
            display: flex;
            align-items: center;
            margin: 0 140px;
            margin-top: 40px;
        }

        #divide_book_container #left_book{
            width: 259px;
            height: 315px;
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 20px;
            border-top: 2px solid var(--main-color);
            margin-right: 20px;
            background-color: var(--white-color);
        }

        #divide_book_container #right_book_side{
            width: 458px;
            height: 550px;
            border:1px solid #ccc;
            border-radius: 3px;
            padding: 20px;
            border-top: 2px solid var(--main-color);
            margin-right: 20px;
            background-color: var(--white-color);
        }


        #divide_book_container #right_book{
            width: 458px;
            height: 762px;
            display: flex;
            flex-direction: column;
            border: 1px solid #ccc;
            border-radius: 3px;
            /* padding: 20px; */
            padding: 20px 0 20px 32px;
            padding-right: -20px;
            border-top: 2px solid var(--main-color);
            margin-right: 20px;
            background-color: var(--white-color);
        }

        #divide_book_container #right_book_2{
            width: 458px;
            height: 762px;
            display: flex;
            flex-direction: column;
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 20px 0 20px 32px;
            border-top: 2px solid var(--main-color);
            margin-right: 20px;
            background-color: var(--white-color);
        }


        #pointer {
            width: 200px;
            height: 40px;
            position: relative;
            background: red;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white-color);
        }
        #pointer:after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 0;
            border-top: 20px solid transparent;
            border-bottom: 20px solid transparent;
        }
        #pointer:before {
            content: "";
            position: absolute;
            right: -20px;
            bottom: 0;
            width: 0;
            height: 0;
            border-left: 20px solid red;
            border-top: 20px solid transparent;
            border-bottom: 20px solid transparent;
        }

        #divide_book_container #left_book #left_img{
            margin-top: 10px;
            width: 100%;
            height: 100%;
            margin-bottom: 10px;
        }

        #side_book{
            display: flex;
            flex-wrap: wrap;
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
    </style>
</head>
<body>
    <?php include './layout/header.php'?>
    <main>
        <?php include './layout/category.php'?>
        <div id="content_index_page">
            <div id="slider">
                <div id="img_container">
                    <div id="left-control"><</div>
                    <img src="./assets/img/slideshow_1.webp" alt="" id="img_slider">
                    <div id="right-control">></div>
                </div>
            </div>
            <div id="banner">
                <div class="img_banner">
                    <img src="./assets/img/img_banner_1.webp" alt="">
                </div>
                <div class="img_banner">
                    <img src="./assets/img/img_banner_2.webp" alt="">
                </div>
            </div>
        </div>
        <div class="content_show_book">
            <h2>SÁCH VĂN HỌC</h2>
            <div id="van_hoc_book">
                <div id="left_img">
                    <img src="./assets/img/vanhoc_banner.webp" alt="">
                </div>
                <div id="right_book">
                    <?php foreach($books_vanhoc as $book_vanhoc){?>
                        <div class="van_hoc_book_item">
                            <div class="img_book_van_hoc">
                                <a href="./detail_book.php?id=<?= $book_vanhoc['id']?>" class="see_detail">
                                    <img src="./admin/upload/<?= $book_vanhoc['book_image'] ?>" alt="" class="img_book_show" title="Xem chi tiết">
                                </a> 
                                <p id="name_book"><?= $book_vanhoc['title']?></p>
                                Giá: 
                                <span id="price_book">
                                    <?php echo("{$book_vanhoc['price']} đ") ?>
                                </span>
                                <div id="add_cart">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <a href="addToCart.php?id=<?= $book_vanhoc['id'] ?>" class="add_to_cart">
                                        Thêm vào giỏ hàng
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>    
        </div>
        <div class="content_show_book">
            <h2>SÁCH KINH TẾ</h2>
            <div id="van_hoc_book">
                <div id="left_img">
                    <img src="./assets/img/Banner-sach-kinh-te.jpg" alt="">
                </div>
                <div id="right_book">
                    <?php foreach($books_kinhtes as $book_kinhte){?>
                        <div class="van_hoc_book_item">
                            <div class="img_book_van_hoc">
                                <a href="./detail_book.php?id=<?= $book_kinhte['id']?>" class="see_detail">
                                    <img src="./admin/upload/<?= $book_kinhte['book_image'] ?>" alt="" class="img_book_show" title="Xem chi tiết">
                                </a>
                                <p id="name_book"><?= $book_kinhte['title']?></p>
                                Giá: 
                                <span id="price_book">
                                    <?php echo("{$book_kinhte['price']} đ") ?>
                                </span>
                                <div id="add_cart">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <a href="addToCart.php?id=<?= $book_kinhte['id'] ?>" class="add_to_cart">
                                        Thêm vào giỏ hàng
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>    
        </div>
        <div id="branch_book">
            <h2>THƯƠNG HIỆU</h2>
            <div id="img_branch">
                <img src="./assets/img/branch1.jpg" alt="">
                <img src="./assets/img/branch2.jpg" alt="">
                <img src="./assets/img/branch3.jpg" alt="">
                <img src="./assets/img/branch4.jpg" alt="">
                <img src="./assets/img/branch5.jpg" alt="">
                <img src="./assets/img/branch6.jpg" alt="">
               
            </div>
        </div>
        <div id="divide_book_container">
            <div id="left_book">
                <div id="left_img">
                    <img src="./assets/img/banner-sach-tam-ly.jpg" alt="">
                </div>
            </div>
            <div id="right_book">
                <div><h3 id="pointer">SÁCH TÂM LÝ</h3></div>
                

                <div id="side_book">
                    <?php foreach($books_tamlys as $book_tamly){?>
                        <div class="van_hoc_book_item">
                            <div class="img_book_van_hoc">
                                <a href="./detail_book.php?id=<?= $book_tamly['id']?>" class="see_detail">
                                    <img src="./admin/upload/<?= $book_tamly['book_image'] ?>" alt="" class="img_book_show" title="Xem chi tiết">
                                </a>
                                <p id="name_book"><?= $book_tamly['title']?></p>
                                Giá: 
                                <span id="price_book">
                                    <?php echo("{$book_tamly['price']} đ") ?>
                                </span>
                                <div id="add_cart">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <a href="addToCart.php?id=<?= $book_tamly['id'] ?>" class="add_to_cart">
                                        Thêm vào giỏ hàng
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>

            <div id="right_book_2">
                <div><h3 id="pointer" style="width: 209px">SÁCH TIỂU SỬ - HỒI KÝ</h3></div>
                

                <div id="side_book">
                    <?php foreach($books_tieusus as $book_tieusu){?>
                        <div class="van_hoc_book_item">
                            <div class="img_book_van_hoc">
                                <a href="./detail_book.php?id=<?= $book_tieusu['id']?>" class="see_detail">
                                    <img src="./admin/upload/<?= $book_tieusu['book_image'] ?>" alt="" class="img_book_show" title="Xem chi tiết"> 
                                </a>
                                <p id="name_book"><?= $book_tieusu['title']?></p>
                                Giá: 
                                <span id="price_book">
                                    <?php echo("{$book_tieusu['price']} đ") ?>
                                </span>
                                <div id="add_cart">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <a href="addToCart.php?id=<?= $book_tieusu['id'] ?>" class="add_to_cart">
                                        Thêm vào giỏ hàng
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
    <script>
     
        const list_img_name = ['slideshow_1.webp', 'slideshow_2.webp','slideshow_3.webp','slideshow_4.webp','slideshow_5.webp'];
        const img = document.querySelector('#img_slider');
        const next_img = document.querySelector('#right-control');
        const pre_img = document.querySelector('#left-control');

        var index = 0;

        next_img.onclick = ()=>{
            index ++;
            if(index == list_img_name.length){
                index = 0;
            }
            img.setAttribute("src",`./assets/img/${list_img_name[index]}`);
        }

        pre_img.onclick = ()=>{
            index --;
            if(index < 0){
                index = list_img_name.length - 1;
            }
            img.setAttribute("src",`./assets/img/${list_img_name[index]}`);
        }

        setInterval(()=>{
            index++;
            if(index == list_img_name.length){
                index = 0;
            }
            img.setAttribute("src",`./assets/img/${list_img_name[index]}`);
        },3000)

    </script>
</body>
</html>