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
    <title>Z Books</title>

    <!--Insert Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <style>
        #content_show_book{
            margin: 0 140px;
            margin-top: 10px;
        }

        #content_index_page{
            margin: 0 140px;
            margin-top: 10px;
            display: flex;
        }
        #img_container{
            width: 835px;
            height: 415px;
            border-radius: 5px;
            position: relative;
            margin-right: 10px;
        }
        #img_slider{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #left-control, #right-control{
            width: 25px;
            height: 25px;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            padding:10px;
            border-radius: 50%;
            background-color: #fff;
            color: var(--second-color);
            box-shadow: 1px 2px #ccc;
            cursor: pointer;
            user-select: none;
        }

        #left-control{
            top: 50%;
            left: -10px;
        }

        #right-control{
            top: 50%;
            right: -10px;
        }

        #banner{
            display: flex;
            flex-direction: column;
        }

        .img_banner{
            width: 395px;
            height: 203px;
            margin-bottom: 10px;
            border-radius: 5px;
            overflow: hidden;
        }

        .img_banner img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #content_show_book #left_img{
            width: 290px;
            height: 350px;
        }

        #left_img img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            image-rendering: pixelated;
        }

        #left_img{
            margin-top: 10px;
        }


        /*Văn học */

        #van_hoc_book{
            display: flex;
            justify-content: space-between;
        }

        .van_hoc_book_item{
            width: 200px;
            height: 330px;
            border: 1px solid #ccc;
            padding: 5px 10px;
            display: flex;
            justify-content: center;
        }

        .img_book_van_hoc{
            width: 125px;
            height: 180px;
        }
        .img_book_van_hoc img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include './layout/header.php'?>
    <main>
        <?php include './layout/category.php'?>
        <div id="content_index_page">
            <div id="slider">
                <div id="img_container">
                    <div id="left-control"><</div>
                    <img src="./assets/img/slideshow_1.webp" alt="" id="img_slider">
                    <div id="right-control">></div>
                </div>
            </div>
            <div id="banner">
                <div class="img_banner">
                    <img src="./assets/img/img_banner_1.webp" alt="">
                </div>
                <div class="img_banner">
                    <img src="./assets/img/img_banner_2.webp" alt="">
                </div>
            </div>
        </div>
        <div id="content_show_book">
            <h2>SÁCH VĂN HỌC</h2>
            <div id="van_hoc_book">
                <div id="left_img">
                    <img src="./assets/img/vanhoc_banner.webp" alt="">
                </div>
                <div id="right_book">
                    <div class="van_hoc_book_item">
                        <div class="img_book_van_hoc">
                            <img src="./assets/img/img_banner_2.webp" alt="">
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </main>
    <?php include './layout/footer.php'?>
    <script>
     
        const list_img_name = ['slideshow_1.webp', 'slideshow_2.webp','slideshow_3.webp','slideshow_4.webp','slideshow_5.webp'];
        const img = document.querySelector('#img_slider');
        const next_img = document.querySelector('#right-control');
        const pre_img = document.querySelector('#left-control');

        var index = 0;

        next_img.onclick = ()=>{
            index ++;
            if(index == list_img_name.length){
                index = 0;
            }
            img.setAttribute("src",`./assets/img/${list_img_name[index]}`);
        }

        pre_img.onclick = ()=>{
            index --;
            if(index < 0){
                index = list_img_name.length - 1;
            }
            img.setAttribute("src",`./assets/img/${list_img_name[index]}`);
        }

        setInterval(()=>{
            index++;
            if(index == list_img_name.length){
                index = 0;
            }
            img.setAttribute("src",`./assets/img/${list_img_name[index]}`);
        },3000)

    </script>
</body>
</html>