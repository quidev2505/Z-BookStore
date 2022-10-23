<?php session_start();
    if(isset($_SESSION['user_signin'])){
        include './connectDB.php';
        include './admin/handle_getData.php';

        //Get category
        $categories = get_data($connect, 'categories');

        //Get type of category
        $typeofcategory = get_data($connect, 'type_of_category');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản</title>

    <!--Insert Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <style>
        #user_account{
            background-color:var(--white-color);
            margin: 30px 140px;
            padding: 10px;
            height: 370px;
        }

        h4{
            display: inline-block;
            color: var(--second-color);
        }
        
        span{
            color: var(--main-color);
        }

        #info_user{
            margin-top: 30px;
            margin-bottom: 50px;
        }

        a{
            text-decoration: none;
            color:var(--main-color);
        }
    </style>
</head>
<body>
    <?php include './layout/header.php'?>
    <main>
        <?php include './layout/category.php'?>
        <div id="user_account">
            <div id="top_info">
                <h4>TÀI KHOẢN CỦA BẠN</h4>
                &nbsp;
                <a href="./logout.php?type=user">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                    <span>Thoát</span>
                </a>
               
            </div>
            <hr>
            <div id="bottom_info">
                <div id="info_user">
                    <h3><?= $_SESSION['user_signin']?></h3>
                    <span id="location">Việt Nam</span>
                </div>
                <div id="product_order">
                    Bạn chưa đặt mua sản phẩm nào.
                </div>
            </div>
        </div>
    </main>
    <?php include './layout/footer.php'?>
</body>
</html>

<?php }?>