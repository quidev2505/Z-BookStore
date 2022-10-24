<?php session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iên Hệ</title>

    <!--Insert Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <style>
        main{
            height: 1000px;
        }
    </style>
</head>
<body>
    <?php include './layout/header.php'?>
    <main>
        <?php include './layout/category.php'?>
        <div id="hethong_zbook">
            <h2>LIÊN HỆ</h2>
            <hr>
            <div id="content_page_system_book">
                <div id="gg_map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.8414543437398!2d105.76842661474039!3d10.02993897527015!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0895a51d60719%3A0x9d76b0035f6d53d0!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBD4bqnbiBUaMah!5e0!3m2!1svi!2s!4v1666367067982!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <h2>Viết nhận xét</h2>
            <hr>
            <form action="#" id="form_contact">
                <input type="text" placeholder="Tên của bạn" required>
                <textarea name="" id="" cols="30" rows="10" placeholder="Viết bình luận" required></textarea>
                <input type="submit" value="Gửi liên hệ">
            </form>
        </div>
    </main>
    <?php include './layout/footer.php'?>
</body>
</html>