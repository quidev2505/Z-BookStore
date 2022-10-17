<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    
    <!--Insert Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <style>
        #form_signin{
            margin: 0 140px;
        }
        #form_signin label{
            font-weight: bold;
        }

        #form_signin input{
            width: 590px;
            height: 40px;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        #form_signin #btn_signin{
            width: 110px;
            height: 40px;
            background-color: var( --main-color);
            color: #fefefe;
            margin-right: 40px;
            cursor: pointer;
            transition:all 0.25s linear;
        }

        #btn_signin:hover{
            opacity: 0.9;
        }
    </style>
    <?php include './css/notification_css.php'?>
</head>
<body>
    <?php include './layout/header.php'?>
    <main>
        <?php include './layout/category.php'?>

        <div id="form_signin">
            <br>
            <br>
            <h3>ĐĂNG NHẬP TÀI KHOẢN</h3>
            <br>
            <?php 
                if(isset($_GET['signin_status'])){
                    if($_GET['signin_status'] == 'false'){
                        echo '<p id="fail"><span id="mess_noti_fail">Đăng nhập thất bại do sai tên hoặc mật khẩu !</span></p>';
                    }
                } 
            ?>

            <form action="process_signin.php" method="POST">
                <br>
                <label for="username">Tên đăng nhập:</label>
                <br>
                <input type="text" name="username" id="username" required>
                <br>
                <br>
                <label for="password">Mật khẩu:</label>
                <br>
                <input type="password" name="password"  id="password" required>
                <br>
                <br>
                <input type="submit" value="Đăng nhập" id="btn_signin">
                <a href="./signup.php" style="color:var(--second-color);">Đăng ký</a>
            </form>
        </div>
        <br>
    </main>
    <?php include './layout/footer.php'?>
</body>
</html>