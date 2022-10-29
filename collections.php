<?php 
    include './connectDB.php';

    //Get category
    $sql = "select * from categories";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $categories = $stmt -> fetchAll();

    //Get type of category
    $sql = "select * from type_of_category";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $typeofcategory = $stmt -> fetchAll();

    $product_heading = '';
    $data_name = '';
    $books = '';
    $count_books = '';




    //Phân trang
    $so_sach_tren_trang = 12;

    $trang_hien_tai = isset($_GET['page']) ? $_GET['page'] : 1;

    $hang_bat_dau = $so_sach_tren_trang * ($trang_hien_tai - 1);
    

    if(isset($_GET['category_name'])){
        $product_heading = 'Tất Cả Các Sách';

        //Get book origin
        $sql_old = "select * from books";
        $stmt = $connect->prepare($sql_old);
        $stmt->execute();
        $count_books = $stmt->rowCount();

        $so_sach = $count_books;
        $so_trang = (int)ceil((int)$so_sach / $so_sach_tren_trang);


        //Get type of book
        $sql = "select * from books order by id LIMIT $so_sach_tren_trang offset $hang_bat_dau";
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $books = $stmt -> fetchAll();
    }
    else if(isset($_GET['category_id'])){
        foreach($categories as $category){
            if($category['id_category'] == $_GET['category_id']){
                $product_heading = 'Sách '.($category['category_name']);
            }
        }

        //Get book origin
        $sql_old = "select * from books where id_category=?";
        $stmt = $connect->prepare($sql_old);
        $stmt->execute([$_GET['category_id']]);
        
        $count_books = $stmt->rowCount();

        $so_sach = $count_books;
        $so_trang = (int)ceil((int)$so_sach / $so_sach_tren_trang);


         //Get type of categoories
        $sql = "select * from books where id_category=? order by id LIMIT $so_sach_tren_trang offset $hang_bat_dau";
        $stmt = $connect->prepare($sql);
        $stmt->execute([$_GET['category_id']]);

        $books= $stmt -> fetchAll();

    }else if(isset($_GET['typeofcategory_id'])){
        foreach($typeofcategory as $typecategory){
            if($typecategory['id_typeofcategory'] == $_GET['typeofcategory_id']){
                $product_heading = 'Sách '.($typecategory['name_of_type']);
            }
        }

        //Get book origin
        $sql_old = "select * from books where id_typeofcategory=?";
        $stmt = $connect->prepare($sql_old);
        $stmt->execute([$_GET['typeofcategory_id']]);
        
        $count_books = $stmt->rowCount();

        $so_sach = $count_books;
        $so_trang = (int)ceil((int)$so_sach / $so_sach_tren_trang);

        //Get type of book
        $sql = "select * from books where id_typeofcategory=? order by id LIMIT $so_sach_tren_trang offset $hang_bat_dau";
        $stmt = $connect->prepare($sql);
        $stmt->execute([$_GET['typeofcategory_id']]);

        $books= $stmt -> fetchAll();
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
            min-height: 800px;
        }
        #container_all{
            margin: 0 140px;
            padding-top: 40px;
        }

        #category_menu{
            width: 280px;
            height: 615px;
            background-color: var(--white-color);
            padding: 15px;
            border-radius: 5px;
            color: var(--second-color);
        }

        #category_menu h2{
            font-size: 20px;
            font-weight: 600;
        }

        #category_menu > hr{
            border: 1.5px solid #ccc;
            margin-top: 5px;
            border-radius: 5px;
        }

        .category_main_list{
            text-decoration: none;
            color: var(--second-color);
        }
        
        
        .category_main_list h4{
            border-bottom: 1px solid #ccc;
            padding: 7px;
            margin: 4px;
        }

        .category_main_list p{
            border-bottom: 1px solid #ccc;
            padding: 7px;
            padding-left: 24px;
        }

        .category_main_list h4:hover, p:hover{
            color:var(--main-color);
        }

        .color_show{
            color:red;
        }

        #container_category{
            opacity: 0;
        }

        #container_collections{
            display: flex;
        }

        #show_products{
            margin-left: 30px;
            width: 912px;
        }

        #show_products h2{
            color:var(--second-color);
            font-size: 22px;
            font-weight: 400;
            margin-bottom:30px;
        }

        #right_book{
            display: flex;
            flex-wrap: wrap;
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

        #breadcrumb{
            margin: -21px 0 23px 0;
            font-size: 14px;
            color: var(--second-color);
        }
        
        #breadcrumb a{
            text-decoration: none;
            color: var(--main-color);
        }
    </style>
</head>
<body>
    <?php include './layout/header.php';?>
    <?php include './layout/category.php';?>
    <main>
        <div id="container_all">
            <div id="breadcrumb">
                <a href="./index.php">Trang chủ</a> /
                <a href="./collections.php?category_name=all">Danh mục</a> /
                <?php 
                    echo '<span style="color:var(--second-color);">'.$product_heading.'</span>';
                ?>
            </div>
            <div id="container_collections">
                <div id="category_menu">
                    <h2>DANH MỤC SÁCH</h2>
                    <hr>
                    <div id="container_list_category">
                        <a href="./collections.php?category_name=all" class="category_main_list">
                            <h4 class="<?php if(isset($_GET['category_name']) == 'all') echo 'color_show';?>">
                                Tất cả các sách
                            </h4>
                        </a>
                        <?php foreach($categories as $category){?>
                            <a href="./collections.php?category_id=<?= $category['id_category']?>" class="category_main_list">
                                <h4 class="<?php if(isset($_GET['category_id'])){
                                    if($_GET['category_id'] == $category['id_category']) echo 'color_show';
                                } ?>">
                                    <?php echo $category['category_name'];?>
                                </h4>
                            </a>
                            <?php foreach($typeofcategory as $typecategory){
                                if($typecategory['id_category'] == $category['id_category']){    
                            ?>
                                <a href="./collections.php?typeofcategory_id=<?= $typecategory['id_typeofcategory']?>" class="category_main_list"><p class="<?php if(isset($_GET['typeofcategory_id'])){
                                    if($_GET['typeofcategory_id'] == $typecategory['id_typeofcategory']) echo 'color_show';
                                } ?>"><?= $typecategory['name_of_type']?></p></a>
                            <?php }}?>
                            </a>
                        <?php }?>
                    </div>
                </div>
                <div id="show_products">
                    <h2>
                        <?php echo $product_heading?>
                    </h2>
                    <div id="right_book">
                    <?php foreach($books as $book){?>
                        <div class="van_hoc_book_item">
                            <div class="img_book_van_hoc">
                                <a href="./detail_book.php?id=<?= $book['id']?>&name=<?= $product_heading;?>" class="see_detail">
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
                <div id="pagination" style="text-align: center; margin-top: 20px;">
                                <?php for($i=1; $i<=$so_trang; $i++){?>
                                    <a  class="page_choose" style="text-decoration: none;
                                            border: 1px solid var(--main-color);
                                            padding: 5px;
                                            margin-right: 5px;
                                            border-radius: 3px;color:var(--second-color);" href="?page=<?php echo $i?><?php if(isset($_GET['category_name'])) echo "&category_name=all";?><?php if(isset($_GET['category_id']))
                                            echo "&category_id=".$_GET['category_id'];?><?php if(isset($_GET['typeofcategory_id']))
                                            echo "&typeofcategory_id=".$_GET['typeofcategory_id'];?>
                                            "><?php echo $i?></a>
                                <?php };?>
                                <br>
                                <br>

                                <div>
                                    <?php  echo '--- Trang <span style="color:var(--main-color);font-weight:bold;">'.$trang_hien_tai.'</span> / '.$so_trang.' ---';?>
                                </div>
                            </div>    
                </div>
            </div>
        </div>
       
    </main>

    <?php include './layout/footer.php';?>
</body>
</html>