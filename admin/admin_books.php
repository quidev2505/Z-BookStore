<?php session_start();
    if(isset($_SESSION['admin_signin'])){
        require '../connectDB.php';
        require './handle_getData.php';
       
        
        // Get data from books
        // $books = get_data($connect, 'books');

        //Get data from authors
        $authors = get_data($connect, 'authors');

        //Get data from categories
        $categories = get_data($connect, 'categories');

        //Get data from type of category
        $type_of_categories = get_data($connect, 'type_of_category');

        $sql_count = "select * from books";
        $stmt_count = $connect -> prepare($sql_count);
        $stmt_count->execute();

        

        //Phân trang
        $so_sach_tren_trang = 10;
        $so_sach = $stmt_count->rowCount();
        $so_trang = ceil($so_sach / $so_sach_tren_trang);

   
        $trang_hien_tai = isset($_GET['page']) ? $_GET['page'] : 1;

        $hang_bat_dau = $so_sach_tren_trang * ($trang_hien_tai - 1);
        
        if(isset($_GET['search_book'])){
            $search_book = $_GET['search_book'];
            $sql = "select * from books where title LIKE '%$search_book%' order by id LIMIT $so_sach_tren_trang offset $hang_bat_dau";
        }else{
            $sql = "select * from books order by id LIMIT $so_sach_tren_trang offset $hang_bat_dau";
        }
        
        
        $stmt = $connect -> prepare($sql);
    
        $stmt -> execute();

        $books = $stmt->fetchAll();
        

        
        if(isset($_GET['del_success'])){
            echo("<script>alert('Xóa thành công')</script>");
        }else if(isset($_GET['del_fail'])){
            echo("<script>alert('Xóa thất bại do lỗi truy vấn !')</script>");
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
                            <div class="admin_function_item"  style="color: var(--main-color);">
                                <i class="fa fa-book" aria-hidden="true"></i>
                                <span>
                                    <a href="./admin_books.php" style="text-decoration:none; color: var(--main-color);">Sách</a>
                                </span>    
                            </div>
                            <div class="admin_function_item">
                                <i class="fa fa-th" aria-hidden="true"></i>
                                <span>
                                    <a href="./admin_category.php" style="text-decoration:none;color:var(--second-color);">Danh mục sách</a>   
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
                    <h5>Sách</h5>
                    <div id="link_page">
                        <span id="header_link">Admin </span>/ Sách
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
                        <h2>Quản lí Sách</h2>
                        <a href="./add_new/admin_add_book.php" id="btn_add_book" style="    min-width: 125px;">Thêm sách mới</a>
                    </div>
                    <div id="bottom_admin_book">
                        <div id="search_book_position">
                            <form action="">
                                <label for="search_book">Tìm kiếm sách: &nbsp;</label>
                                <input type="text" id="search_book" name="search_book">
                            </form>
                        </div>
                        <div id="show_books">
                            <table width="100%">
                                <thead>
                                <tr>
                                    <th style="width: 65px;">STT</th>
                                    <th style="width: 130px;">Ảnh bìa sách</th>
                                    <th style="width: 163px;">Tên sách</th>
                                    <th style="width: 163px;">Tác giả</th>
                                    <th>Danh mục</th>
                                    <th>Thể Loại</th>
                                    <th style="width: 195px;">Mô tả</th>
                                    <th>Giá tiền</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                   
                                    <?php 
                                    $number = $hang_bat_dau + 1;
                                    foreach($books as $book){?>
                                        <tr>
                                            <td style="text-align:center"><?php echo $number;?></td>
                                            <td>
                                                <img src="./upload/<?php echo $book['book_image']?>" alt="">
                                            </td>
                                            <td><?php echo $book['title'];?></td>
                                            <td>
                                                <?php foreach($authors as $author){ 
                                                    if($author['id_author'] == $book['id_author']){
                                                        echo $author['author_name'];
                                                    }    
                                                }?>
                                            </td>
                                            <td>
                                                <?php foreach($categories as $category){ 
                                                    if($category['id_category'] == $book['id_category']){
                                                        echo $category['category_name'];
                                                    }    
                                                }?>
                                            </td>
                                            <td>
                                                <?php foreach($type_of_categories as $type_of_category){ 
                                                    if($type_of_category['id_typeofcategory'] == $book['id_typeofcategory']){
                                                        echo $type_of_category['name_of_type'];
                                                    }    
                                                }?>
                                            </td>
                                            <td>
                                                <p style="overflow: hidden;
                                                text-overflow: ellipsis;
                                                display: -webkit-box;
                                                -webkit-line-clamp: 2;
                                                -webkit-box-orient: vertical;">
                                                <?php echo $book['description']?>
                                                </p>
                                            </td>
                                            <td><?php echo $book['price'].' đ'?></td>
                                            <td style="text-align:center;">
                                                <div style="display:flex;">
                                                    <a href="./admin_edit_books.php?id=<?php echo $book['id'];?>" style="margin-right:20px;">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="./delete_item.php?id=<?php echo $book['id']?>&page=books&table_name=books&column_id=id">
                                                        <i class="fa fa-trash" aria-hidden="true" width="20px"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php $number++;}?>                               
                                </tbody>
                            </table>
                        
                            <?php if(isset($_GET['search_book'])){if($stmt->rowCount() == 0){
                                echo '<span style="color: var(--main-color);font-weight:bold;text-align:center;display:block;"> Không có sản phẩm phù hợp với từ khóa tìm kiếm!</span>';    
                            }}?> 
                           
                            <div id="pagination" style="text-align: center; margin-top: 20px;">
                                <?php for($i=1; $i<=$so_trang; $i++){?>
                                    <a  class="page_choose" style="text-decoration: none;
                                            border: 1px solid var(--main-color);
                                            padding: 5px;
                                            margin-right: 5px;
                                            border-radius: 3px;color:var(--second-color);" href="?page=<?php echo $i?>&search_book=<?php if(isset($_GET['search_book'])) echo $_GET['search_book']; ?>"><?php echo $i?></a>
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
            </div>
        </div>
    </div>
</body>
</html>

<?php }else 
    header("Location: ../index.php");
?>