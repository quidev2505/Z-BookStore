<?php session_start();
    if(isset($_SESSION['admin_signin'])){
        require '../connectDB.php';
        require './handle_getData.php';
        require './add_new/handleFunc.php';

        //Get data from books
        $books = get_data($connect, 'books');

        //Get data from authors
        $authors = get_data($connect, 'authors');

        //Get data from categories
        $categories = get_data($connect, 'categories');

        //Get data from type of category
        $type_of_categories = get_data($connect, 'type_of_category');

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "select * from books where id = ?";
            $stmt = $connect -> prepare($sql);
            $stmt -> execute([$id]);
            $stmt_all = $stmt->fetch();

            $book_name = $stmt_all['title'];
            $id_author = $stmt_all['id_author'];
            $id_category = $stmt_all['id_category'];
            $id_typeofcategory = $stmt_all['id_typeofcategory'];
            $img_old_name = $stmt_all['book_image'];
            $price = $stmt_all['price'];
            $description = $stmt_all['description'];
            
            //Get author name
            $stmt_author = $connect -> prepare("select * from authors where id_author = ?");
            $stmt_author->execute([$id_author]);
            $author_name = $stmt_author->fetch()['author_name'];

            //Get category name
            $stmt_category = $connect -> prepare("select * from categories where id_category = ?");
            $stmt_category->execute([$id_category]);
            $category_name = $stmt_category->fetch()['category_name'];

             //Get type of category name
            $stmt_typeofcategory = $connect -> prepare("select * from type_of_category where id_typeofcategory = ?");
            $stmt_typeofcategory->execute([$id_typeofcategory]);
            $typeofcategory_name = $stmt_typeofcategory->fetch()['name_of_type'];
        }

        if(isset($_GET['edit'])){
            if(isset($_POST['book_name']) && isset($_POST['author_name_choose']) && isset($_POST['category_name_choose'])
            && isset($_POST['typeofcategory_name_choose']) && isset($_FILES['image_book']['name']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['id_books'])
            ){
                $id_book = $_POST['id_books'];
                $book_name = $_POST['book_name'];
                $author_name_choose = $_POST['author_name_choose'];
                $category_name_choose = $_POST['category_name_choose'];
                $typeofcategory_name_choose = $_POST['typeofcategory_name_choose'];
                $image_name = $_FILES['image_book']['name'];
                $price = $_POST['price'];
                $description = $_POST['description'];

                //Find info about old book name
                $sql = "select * from books where id = ?";
                $stmt = $connect -> prepare($sql);
                $stmt -> execute([$id_book]);
                $img_old_name = $stmt->fetch()['book_image'];

                //H??m X??? l?? upload t??c gi???, danh m???c, th??? lo???i
                //T??c gi???
                foreach($authors as $author){
                    if($author['author_name'] == $author_name_choose){
                        $id_author_name_choose = $author['id_author'];
                    }
                }
                //Danh m???c
                foreach($categories as $category){
                    if($category['category_name'] == $category_name_choose){
                        $id_category_name_choose = $category['id_category'];
                    }
                }
                //Th??? lo???i
                foreach($type_of_categories as $type_of_category){
                    if($type_of_category['name_of_type'] == $typeofcategory_name_choose){
                        $id_typeofcategory_name_choose = $type_of_category['id_typeofcategory'];
                    }
                }
                

                $sql = "select * from books where id = ?  and book_image = ? and title = ?  and id_author = ? and id_category = ? and id_typeofcategory = ? and description = ? and price = ?";

                $stmt = $connect -> prepare($sql);  
                $stmt->execute([$id_book, $img_old_name, $book_name, $id_author_name_choose, $id_category_name_choose, $id_typeofcategory_name_choose, $description, $price]);
                
                if($stmt -> rowCount() == 0){
                        if($image_name == ''){
                            $image_name = $img_old_name;
                        }
                        else{
                            if($img_old_name != $image_name){
                                // H??m x??a ???nh
                                unlink('./upload/'.$img_old_name);
                            }
                        }
                      
                        //H??m X??? l?? upload file
                        $path_img = basename($image_name);

                        $target_dir = "./upload/";
                        $target_file = $target_dir.$path_img;

                        move_uploaded_file($_FILES['image_book']['tmp_name'], $target_file);

                        $check_correct_type = check_type_of_category($connect,  $typeofcategory_name_choose, $id_category_name_choose); 
                        if($check_correct_type == 1){
                            $sql = "update books set book_image = ?, title = ?, id_author = ?, id_category = ?, id_typeofcategory = ?, description = ?, price = ? where id = ?";
                            $stmt = $connect -> prepare($sql);
                            $stmt -> execute([$image_name, $book_name, $id_author_name_choose, $id_category_name_choose, $id_typeofcategory_name_choose, $description, $price, $id_book]);
                            header("Location: ?success&id=$id_book");
                        } else{
                            header("Location: ?error_type_category&id=$id_book");
                            exit();
                        }    
                }else{
                    header("Location: ?duplicated&id=$id_book");
                }
            }
            else{
                header("Location: ?fail&id=$id_book");
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
    <link rel="stylesheet" href="../css/style_admin.css">
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
                    <img src="../assets/img/agenda.png" alt="" width="41px" height="39px">
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
                                Qu???n tr??? Admin
                            </span> 
                        </div>
                       

                        <div id="admin_detail_sidebar" >
                            <div class="admin_function_item" style="color: var(--main-color);">
                                <i class="fa fa-book" aria-hidden="true"></i>
                                <span>
                                    <a href="./admin_books.php" style="text-decoration:none;color:var(--main-color); ">S??ch</a>
                                </span>    
                            </div>
                            <div class="admin_function_item" >
                                <i class="fa fa-th" aria-hidden="true"></i>
                                <span>
                                    <a href="./admin_category.php" style="text-decoration:none;color: var(--second-color);">Danh m???c s??ch</a>   
                                </span> 
                            </div>
                            <div class="admin_function_item" style="margin-left:40px;">
                                <i class="fa fa-info" aria-hidden="true"></i>
                                <span>
                                    <a href="./admin_typeofcategory.php" style="text-decoration:none;color:var(--second-color);">Th??? lo???i</a>   
                                </span> 
                            </div>
                            <div class="admin_function_item" >
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                <span>
                                    <a href="./admin_author.php" style="text-decoration:none;color:var(--second-color);">T??c gi???</a>
                                </span> 
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div id="content">
            <div id="top_content">
                <div id="left_content">
                    <h5>S??ch</h5>
                    <div id="link_page">
                        <span id="header_link">Admin </span>/ S??ch / Ch???nh s???a s??ch
                    </div>
                </div>
                <div id="right_content" style="display:flex">
                    <div id="img_admin">
                        <img src="../assets/img/admin.png" alt="anh_dai_dien_admin" style="width: 50px; height: 50px;margin-right:30px;">
                    </div>
                    <?php if(isset($_SESSION['admin_signin'])){
                        echo '<div><h6 style="font-size:1em;color:var(--main-color);">'.$_SESSION['admin_signin'].'</h6>'.'<a href="../logout.php?type=admin" id="btn_logout" style="font-size:14px; text-decoration:none;color:var(--black-color);opacity:0.7">????ng xu???t</a></div>';
                    }?>
                </div>
            </div>
            <div id="bottom_content">
                <div id="wrap_content">
                    <div id="top_admin_book">
                        <h2>Ch???nh s???a s??ch
                        <?php 
                            if(isset($_GET['success'])){
                                echo '<span style="display: inline-block;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #dff0d8;
                                padding: 10px; color: #67864a;">Ch???nh s???a th??nh c??ng !</span>';
                            }elseif(isset($_GET['fail'])){
                                echo '<span style="display: inline-block;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #f2dede;
                                padding: 10px; color: #be6455;">Ch???nh s???a th???t b???i !</span>';
                            }elseif(isset($_GET['duplicated'])){
                                echo '<span style="display: inline-block;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #f2dede;
                                padding: 10px; color: #be6455;">Ch??a ch???nh s???a b???t k?? th??ng tin n??o !</span>';
                            }elseif(isset($_GET['error_type_category'])){
                                echo '<span style="display: inline-block;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #f2dede;
                                padding: 10px; color: #be6455;">Th??? lo???i b???n ch???n kh??ng thu???c ????ng danh m???c. H??y ch???n l???i!</span>';
                            }elseif(isset($_GET['fail_upload'])){
                                echo '<span style="display: inline-block;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #f2dede;
                                padding: 10px; color: #be6455;">???nh kh??ng th??? upload ???????c l??n server !</span>';
                            }
                        ?>
                        </span>
                        </h2>
                        
                    </div>
                    <div id="bottom_admin_book">
                        <form action="?edit" method="POST"  enctype="multipart/form-data">
                            <label for="book_name">T??n s??ch</label>
                            <br>
                            <input type="text" name="book_name" id="book_name" style="width:50%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px" value="<?php if(isset($_GET['id'])) echo $book_name;?>">
                            <br>
                            <br>
                            <div style="display: flex;
                            align-items: center;
                            justify-content: space-between;">
                                <label for="old_author_name">T??c gi??? hi???n t???i</label>
                                <br>
                                <input type="text" name="book_name" id="book_name" style="width:25%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px"  value="<?php if(isset($_GET['id'])) echo $author_name;?>" disabled>
                                <br>
                                <br>
                                <label for="author_name">Ch???n t??c gi???</label>
                                <br>
                                <select name="author_name_choose" id="author_selected" style="width:55%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px" >
                                    <?php 
                                        foreach($authors as $author){
                                    ?>
                                        <option value="<?php echo $author['author_name']?>">
                                            <?php echo $author['author_name']?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <br>
                  
                            <div style="display: flex;
                            align-items: center;
                            justify-content: space-between;">
                                <label for="old_author_name">Danh m???c hi???n t???i</label>
                                <br>
                                <input type="text" name="book_name" id="book_name" style="width:25%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px"  value="<?php if(isset($_GET['id'])) echo $category_name;?>" disabled>
                                <br>
                                <label for="category_name" style="margin-left:16px;">Ch???n danh m???c</label>
                                <br>
                                <select name="category_name_choose" id="category_selected" style="width:55%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;margin-right: 20px;padding:10px" >
                                    <?php 
                                        foreach($categories as $category){
                                    ?>
                                        <option value="<?php echo $category['category_name']?>">
                                            <?php echo $category['category_name']?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div style="display: flex;
                            align-items: center;
                            justify-content: space-between;margin-top:10px;">
                                <label for="type_of_category">Th??? lo???i hi???n t???i</label>
                                <br>
                                <br>
                                <input type="text" name="book_name" id="book_name" style="width:25%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px"  value="<?php if(isset($_GET['id'])) echo $typeofcategory_name;?>" disabled>

                                <label for="type_of_category">Th??? lo???i</label>
                                <br>
                                <select name="typeofcategory_name_choose" id="type_of_category_selected" style="width:55%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;margin-right: 20px;padding:10px" >
                                    <?php 
                                        foreach($type_of_categories as $type_of_category){
                                    ?>
                                        <option value="<?php echo $type_of_category['name_of_type']?>">
                                            <?php echo $type_of_category['name_of_type']?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
        
                
                
                            <br>

                            <label for="book_name">???nh b??a s??ch hi???n t???i</label>
                            <br>
                            <img src="./upload/<?= $img_old_name?>" alt="" width="120px" height="120px">


                            <br>
                            <br>

                            <label for="book_name">???nh b??a s??ch</label>
                            <br>
                            <input type="file" name="image_book" id="image_book"> 

                            <br>
                            <br>

                           
                            <label for="price">Gi??  ti???n</label>
                            <br>
                            <input type="text" name="price" id="price" style="width:50%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px" value="<?php echo $price?>" >

                            <br>


                            <br>
                            <label for="description">M?? t???</label>
                            <br>
                            <input type="text" name="description" id="price" style="width:50%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px" value="<?php echo $description?>" >
                            <br>

                            <input type="hidden" name="id_books" value="<?php echo $_GET['id']?>">
                            <input type="submit" value="X??c Nh???n" id="btn_submit" >
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