<?php session_start();
    if(isset($_SESSION['admin_signin'])){
        require '../connectDB.php';
        require './handle_getData.php';
        
       
        if(isset($_GET['search_category'])){
            $search_category = $_GET['search_category'];
            $sql = "select * from categories where category_name LIKE '%$search_category%'";

            $stmt = $connect -> prepare($sql);
    
            $stmt -> execute();

            $categories = $stmt->fetchAll();
        }else{
            //Get data from categories
            $categories = get_data($connect, 'categories');
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
                                Quản trị Admin
                            </span> 
                        </div>
                       

                        <div id="admin_detail_sidebar">
                            <div class="admin_function_item">
                                <i class="fa fa-book" aria-hidden="true"></i>
                                <span>
                                    <a href="./admin_books.php" style="text-decoration:none;color:var(--second-color); ">Sách</a>
                                </span>    
                            </div>
                            <div class="admin_function_item" style="color: var(--main-color);">
                                <i class="fa fa-th" aria-hidden="true"></i>
                                <span>
                                    <a href="./admin_category.php" style="text-decoration:none;color: var(--main-color);">Danh mục sách</a>   
                                </span> 
                            </div>
                            <div class="admin_function_item" style="margin-left:40px;">
                                <i class="fa fa-info" aria-hidden="true"></i>
                                <span>
                                    <a href="./admin_typeofcategory.php" style="text-decoration:none;color:var(--second-color);">Thể loại</a>   
                                </span> 
                            </div>
                            <div class="admin_function_item">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                <span>
                                    <a href="./admin_author.php" style="text-decoration:none;color:var(--second-color);">Tác giả</a>
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
                        <span id="header_link">Admin </span>/ Danh mục sách
                    </div>
                </div>
                <div id="right_content" style="display:flex">
                    <div id="img_admin">
                        <img src="../assets/img/admin.png" alt="anh_dai_dien_admin" style="width: 50px; height: 50px;margin-right:30px;">
                    </div>
                    <?php if(isset($_SESSION['admin_signin'])){
                        echo '<div><h6 style="font-size:1em;color:var(--main-color);">'.$_SESSION['admin_signin'].'</h6>'.'<a href="../logout.php?type=admin" id="btn_logout" style="font-size:14px; text-decoration:none;color:var(--black-color);opacity:0.7">Đăng xuất</a></div>';
                    }?>
                </div>
            </div>
            <div id="bottom_content">
                <div id="wrap_content">
                    <div id="top_admin_book">
                        <h2>Quản lí Danh Mục</h2>
                        <a href="./add_new/admin_add_category.php" id="btn_add_book" style="    min-width: 125px;">Thêm danh mục mới</a>
                    </div>
                    <div id="bottom_admin_book">
                        <div id="search_book_position">
                            <form action="">
                                <label for="search_book">Tìm kiếm danh mục: &nbsp;</label>
                                <input type="text" id="search_book" name="search_category">
                            </form>
                        </div>
                        <div id="show_books">
                            <table width="100%">
                                <thead>
                                <tr>
                                    <th style="width: 65px;">STT</th>
                                    <th>Danh mục</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $number = 1;
                                    foreach($categories as $category){?>
                                        <tr style="height:100px">
                                            <td style="text-align:center"><?php echo $number;?></td>
                                            <td style="text-align:center">
                                                <?php 
                                                    echo $category['category_name'];   
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <a href="./admin_edit_category.php?id=<?php echo $category['id']?>">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                <a href="./delete_item.php?id=<?php echo $category['id']?>&page=category&table_name=categories">
                                                    <i class="fa fa-trash" aria-hidden="true" width="20px"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php $number++;}?>
                                </tbody>
                            </table>
                            <?php if(isset($_GET['search_category'])){
                                if($stmt->rowCount() == 0){
                                    echo '<span style="color: var(--main-color);font-weight:bold;text-align:center;display:block;"> Không có sản phẩm phù hợp với từ khóa tìm kiếm!</span>';    
                            }}?> 
                        </div>
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