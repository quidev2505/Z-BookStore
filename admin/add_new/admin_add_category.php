<?php session_start();
    if(isset($_SESSION['admin_signin'])){
        require '../../connectDB.php';
        require '../handle_getData.php';
        require './handleFunc.php';

        if(isset($_GET['add_new'])){
            if(isset($_POST['name_category'])){
                $data_add = $_POST['name_category'];
                $data_from_table = 'category_name';
                $table_name = 'categories';

                $check_dupliacted = duplicatedData($connect, $data_add, $data_from_table, $table_name);

                if($check_dupliacted == 0){
                    $sql = "insert into categories(category_name) values(?)";
                    $stmt = $connect -> prepare($sql);
                    $stmt -> execute([$_POST['name_category']]);
                    header("Location: ?success");
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
                       

                        <div id="admin_detail_sidebar">
                            <div class="admin_function_item">
                                <i class="fa fa-book" aria-hidden="true"></i>
                                <span>
                                    <a href="../admin_books.php" style="text-decoration:none;color:var(--second-color); ">Sách</a>
                                </span>    
                            </div>
                            <div class="admin_function_item" style="color: var(--main-color);">
                                <i class="fa fa-th" aria-hidden="true"></i>
                                <span>
                                    <a href="../admin_category.php" style="text-decoration:none;color: var(--main-color);">Danh mục sách</a>   
                                </span> 
                            </div>
                            <div class="admin_function_item" style="margin-left:40px;">
                                <i class="fa fa-info" aria-hidden="true"></i>
                                <span>
                                    <a href="../admin_typeofcategory.php" style="text-decoration:none;color:var(--second-color);">Thể loại</a>   
                                </span> 
                            </div>
                            <div class="admin_function_item">
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
                    <h5>Danh mục sách</h5>
                    <div id="link_page">
                        <span id="header_link">Admin </span>/ Danh mục sách / Thêm danh mục
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
                        <h2>Thêm Danh Mục 
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
                                padding: 10px; color: #be6455;">Đã tồn tại tên danh mục. Không thể thêm vào !</span>';
                            }
                        ?>
                        </h2>
                        
                    </div>
                    <div id="bottom_admin_book">
                        <form action="?add_new" method="POST">
                            <label for="name_category">Tên danh mục</label>
                            <br>
                            <input type="text" name="name_category" id="name_category" style="width:50%; height: 40px; margin-top:10px; border-radius:10px; border:1px solid #ccc;padding:10px" required>
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