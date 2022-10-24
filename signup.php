<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    
    <!--Insert Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <style>
        #form_signup{
            margin: 0 140px;
        }
        #form_signup label{
            font-weight: bold;
        }

        #form_signup input{
            width: 590px;
            height: 40px;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        #form_signup #btn_signup{
            width: 110px;
            height: 40px;
            background-color: var( --main-color);
            color: #fefefe;
            margin-right: 40px;
            cursor: pointer;
            transition:all 0.25s linear;
        }

        #btn_signup:hover{
            opacity: 0.9;
        }
    </style>
    <?php include './css/notification_css.php'?>

</head>
<body>
    <?php include './layout/header.php'?>
    <main>
        <?php include './layout/category.php'?>

        <div id="form_signup">
            <br>
            <br>
            <h3>ĐĂNG KÝ TÀI KHOẢN</h3>
            <br>
            <?php 
                if(isset($_GET['signup_status'])){
                    if($_GET['signup_status'] == 'true'){
                        echo '<p id="success"><span id="mess_noti_success">Bạn đã đăng ký thành công.</span> Chuyển hướng đăng nhập tại <a href="./signin.php">đây</a></p>';
                    }elseif($_GET['signup_status'] == 'false'){
                        echo '<p id="fail"><span id="mess_noti_fail">Bạn chưa nhập thông tin đầy đủ !</span></p>';
                    }else{
                        echo '<p id="fail"><span id="mess_noti_fail">Đã tồn tại tên đăng nhập hoặc tên đầy đủ !</span></p>';
                    }
                }
                else{
                    echo  '<p>Nếu chưa có tài khoản, vui lòng đăng ký tại đây.</p>';
                }    
            ?>


            <form action="process_signup.php" method="POST">
                <br>
                <label for="fullname">Tên đầy đủ: *</label>
                <br>
                <input type="text" name="fullname"  id="fullname" required>
                <br>
                <br>
                <label for="username">Tên đăng nhập:</label>
                <br>
                <input type="text" name="username"  id="username" required>
                <br>
                <br>
                <label for="password">Mật khẩu:</label>
                <br>
                <input type="password" name="password"  id="password" required>
                <br>
                <br>
                <input type="submit" value="Đăng ký" id="btn_signup">
                <a href="./signin.php" style="color:var(--second-color);">Đăng nhập</a>
            </form>
        </div>
        <br>
    </main>
    <?php include './layout/footer.php'?>
</body>
</html>