<?php session_start();
    if(isset($_SESSION['admin_signin'])){
        require '../../connectDB.php';
        require '../handle_getData.php';
        require './handleFunc.php';

        //Get data from books
        $books = get_data($connect, 'books');

        //Get data from authors
        $authors = get_data($connect, 'authors');

        //Get data from categories
        $categories = get_data($connect, 'categories');

        //Get data from type of category
        $type_of_categories = get_data($connect, 'type_of_category');

        if(isset($_GET['add_new'])){
            if(isset($_POST['book_name']) && isset($_POST['author_name_choose']) && isset($_POST['category_name_choose'])
                && isset($_POST['typeofcategory_name_choose']) && isset($_FILES['image_book']['name']) && isset($_POST['price']) && isset($_POST['description'])
                ){

                $book_name = $_POST['book_name'];
                $author_name_choose = $_POST['author_name_choose'];
                $category_name_choose = $_POST['category_name_choose'];
                $typeofcategory_name_choose = $_POST['typeofcategory_name_choose'];
                $image_name = $_FILES['image_book']['name'];
                $price = $_POST['price'];
                $description = $_POST['description'];

                //Xử lí trùng dữ liệu
                $data_add = $_POST['book_name'];
                $data_from_table = 'title';
                $table_name = 'books';

                //Hàm xử lí trùng data
                $check_dupliacted = duplicatedData($connect, $data_add, $data_from_table, $table_name);

                if($check_dupliacted == 0){
                    //Hàm Xử lí upload file
                    $path_img = basename($image_name);

                    $target_dir = "../upload/";
                    $target_file = $target_dir.$path_img;

                    //Hàm Xử lí upload tác giả, danh mục, thể loại
                    //Tác giả
                    foreach($authors as $author){
                        if($author['author_name'] == $author_name_choose){
                            $id_author_name_choose = $author['id_author'];
                        }
                    }
                    //Danh mục
                    foreach($categories as $category){
                        if($category['category_name'] == $category_name_choose){
                            $id_category_name_choose = $category['id_category'];
                        }
                    }
                    //Thể loại
                    foreach($type_of_categories as $type_of_category){
                        if($type_of_category['name_of_type'] == $typeofcategory_name_choose){
                            $id_typeofcategory_name_choose = $type_of_category['id_typeofcategory'];
                        }
                    }


                    if(move_uploaded_file($_FILES['image_book']['tmp_name'], $target_file)){
                        $check_correct_type = check_type_of_category($connect,  $typeofcategory_name_choose, $id_category_name_choose);
                        if($check_correct_type == 1){
                            $sql = "insert into books(book_image, title, id_author, id_category, id_typeofcategory, description, price) values(?,?,?,?,?,?,?)";
                            $stmt = $connect -> prepare($sql);
                            $stmt -> execute([$image_name, $book_name, $id_author_name_choose, $id_category_name_choose, $id_typeofcategory_name_choose, $description, $price]);
                            header("Location: ?success");
                        }
                        else{
                            header("Location: ?error_type_category");
                            exit();
                        }    
                    }else{
                        header("Location: ?fail_upload");
                        exit();
                    }
                }else{
                    header("Location: ?duplicated");
                }
            }
            else{
                header("Location: ?fail");
            }
        }
        
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <!--Insert Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/style_admin.css">
    <style>
        #bottom_admin_book form #btn_submit, #btn_reset{
            height: 34px;
            border: 0;
            color: var(--white-color);
            border-radius: 3px;
            margin-top: 10px;
            cursor: pointer;
        }

        #btn_submit{
            width: 67px;
            background-color: var(--main-color);
            margin-right: 5px;
        }

        #btn_reset{
            width: 54px;
            background-color: #ff9b8a;
        }


        #top_admin_book{
            padding-left: 11px;
        }

        #top_admin_book h2{
            font-size: 1.400em;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <div class="top_sidebar">
                <div class="top_sidebar_left">
                    <img src="../../assets/img/agenda.png" alt="" width="41px" height="39px">
                    <h3 style="color:var(--main-color);">Z Books</h3>
                </div>
                <div style="color:var(--main-color);">
                    <i class="fa fa-bars" aria-hidden="true" style="font-size:30px;"></i>
                </div>
              
            </div>
            <div class="content_sidebar">
                <div id="admin_sidebar"  style="color: var(--main-color);">
                        <div style="height: 45px;background-color:#fbfcff;margin-left:6px;border-right: 3px solid; line-height: 45px;">
                            <i class="fa fa-home" aria-hidden="true"></i>  
                            <span style="color: var(--main-color);">
                                Quản trị Admin
                            </span> 
                        </div>
                       

                        <div id="admin_detail_sidebar" >
                            <div class="admin_function_item" style="color: var(--main-color);">
                                <i class="fa fa-book" aria-hidden="true"></i>
                                <span>
                                    <a href="../admin_books.php" style="text-decoration:none;color:var(--main-color); ">Sách</a>
                                </span>    
                            </div>
                            <div class="admin_function_item" >
                                <i class="fa fa-th" aria-hidden="true"></i>
                                <span>
                                    <a href="../admin_category.php" style="text-decoration:none;color: var(--second-color);">Danh mục sách</a>   
                                </span> 
                            </div>
                            <div class="admin_function_item" style="margin-left:40px;">
                                <i class="fa fa-info" aria-hidden="true"></i>
                                <span>
                                    <a href="../admin_typeofcategory.php" style="text-decoration:none;color:var(--second-color);">Thể loại</a>   
                                </span> 
                            </div>
                            <div class="admin_function_item" >
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                <span>
                                    <a href="../admin_author.php" style="text-decoration:none;color:var(--second-color);">Tác giả</a>
                                </span> 
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div id="content">
            <div id="top_content">
                <div id="left_content">
                    <h5>Sách</h5>
                    <div id="link_page">
                        <span id="header_link">Admin </span>/ Sách / Thêm sách
                    </div>
                </div>
                <div id="right_content" style="display:flex">
                    <div id="img_admin">
                        <img src="../../assets/img/admin.png" alt="anh_dai_dien_admin" style="width: 50px; height: 50px;margin-right:30px;">
                    </div>
                    <?php if(isset($_SESSION['admin_signin'])){
                        echo '<div><h6 style="font-size:1em;color:var(--main-color);">'.$_SESSION['admin_signin'].'</h6>'.'<a href="../logout.php?type=admin" id="btn_logout" style="font-size:14px; text-decoration:none;color:var(--black-color);opacity:0.7">Đăng xuất</a></div>';
                    }?>
                </div>
            </div>
            <div id="bottom_content">
                <div id="wrap_content">
                    <div id="top_admin_book">
                        <h2>Thêm Sách
                        <?php 
                            if(isset($_GET['success'])){
                                echo '<span style="display: inline-block;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #dff0d8;
                                padding: 10px; color: #67864a;">Thêm thành công !</span>';
                            }elseif(isset($_GET['fail'])){
                                echo '<span style="display: inline-block;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #f2dede;
                                padding: 10px; color: #be6455;">Thêm thất bại !</span>';
                            }elseif(isset($_GET['duplicated'])){
                                echo '<span style="display: inline-block;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #f2dede;
                                padding: 10px; color: #be6455;">Đã tồn tại tên sách. Không thể thêm vào !</span>';
                            }elseif(isset($_GET['error_type_category'])){
                                echo '<span style="display: inline-block;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #f2dede;
                                padding: 10px; color: #be6455;">Thể loại bạn chọn không thuộc đúng danh mục. Hãy chọn lại!</span>';
                            }elseif(isset($_GET['fail_upload'])){
                                echo '<span style="display: inline-block;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #f2dede;
                                padding: 10px; color: #be6455;">Ảnh không thể upload được lên server !</span>';
                            }
                        ?>
                        </span>
                        </h2>
                        
                    </div>
                    <div id="bottom_admin_book">
                        <form action="?add_new" method="POST"  enctype="multipart/form-data">
                            <label for="book_name">Tên sách</label>
                            <br>
                            <input type="text" name="book_name" id="book_name" style="width:50%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px" required>
                            <br>
                            <br>
                            <label for="author_name">Tác giả</label>
                            <br>
                            <select name="author_name_choose" id="author_selected" style="width:15%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px" required>
                                <?php 
                                    foreach($authors as $author){
                                ?>
                                    <option value="<?php echo $author['author_name']?>">
                                        <?php echo $author['author_name']?>
                                    </option>
                                <?php } ?>
                            </select>
                            <br>
                            <br>
                            <div style="display:flex;">
                                <div>
                                    <label for="category_name">Danh mục</label>
                                    <br>
                                    <select name="category_name_choose" id="category_selected" style="min-width:115px; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;margin-right: 20px;padding:10px" required>
                                        <?php 
                                            foreach($categories as $category){
                                        ?>
                                            <option value="<?php echo $category['category_name']?>">
                                                <?php echo $category['category_name']?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="type_of_category">Thể loại</label>
                                    <br>
                                    <select name="typeofcategory_name_choose" id="type_of_category_selected" style="min-width:115px; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;margin-right: 20px;padding:10px" required>
                                        <?php 
                                            foreach($type_of_categories as $type_of_category){
                                        ?>
                                            <option value="<?php echo $type_of_category['name_of_type']?>">
                                                <?php echo $type_of_category['name_of_type']?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
        
                            </div>
                         
                            <br>

                            <label for="book_name">Ảnh bìa sách</label>
                            <br>
                            <input type="file" name="image_book" id="image_book" required>
                            <br>
                            <br>

                           

                            <label for="price">Giá tiền</label>
                            <br>
                            <input type="number" name="price" id="price" style="width:50%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px" required>
                            <br>

                            <br>

                            <label for="description">Mô tả</label>
                            <br>
                            <textarea name="description" id="description" cols="30" rows="10"  style="width:100%; height: 150px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px" required></textarea>
                            <br>


                            <input type="submit" value="Xác Nhận" id="btn_submit">
                            <input type="reset" value="Reset" id="btn_reset">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php }else 
    header("Location: ../index.php");
?>