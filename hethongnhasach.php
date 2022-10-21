<?php session_start();
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
    <title>Hệ thống nhà sách</title>

    <!--Insert Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './layout/header.php'?>
    <main>
        <?php include './layout/category.php'?>
        <div id="hethong_zbook">
            <h2>HỆ THỐNG Z BOOKSTORE</h2>
            <hr>
            <div id="content_page_system_book">
                <h4>TRỤ SỞ CHÍNH</h4>
                <p>- Số 449 Bạch Mai, Hai Bà Trưng, Hà Nội.</p>
                <p>- Chi nhánh 2: Phố Sách - Phố 19 tháng 12, Trần Hưng Đạo, Hoàn Kiếm, Hà Nội</p>

                <h4>Hệ thống nhà sách trong TTTM Vincom</h4>
                <p>- Chi nhánh 3: B2 - R5, TTTM Royal City, 72A Nguyễn Trãi, Thanh Xuân, Hà Nội.</p>
                <p>- Chi nhánh 4: Tầng B1, TTTM Bắc Từ Liêm, 234 Phạm Văn Đồng, Bắc Từ Liêm, Hà Nội.</p>

                <h4>Hệ thống nhà sách trong TTTM  Go</h4>
                <p>- Chi nhánh 5: Tầng 1, TTTM Go Hạ Long, cột 5, Hồng Hà, thành phố Hạ Long, Quảng Ninh.</p>
                <p>- Chi nhánh 6: Tầng 3, TTTM Go Thái Nguyên - Khu dân cư số 1, đường Việt Bắc, phường Tân Lập, thành phố Thái Nguyên, tỉnh Thái Nguyên</p>
            </div>
        </div>
    </main>
    <?php include './layout/footer.php'?>
</body>
</html>