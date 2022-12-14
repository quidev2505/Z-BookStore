<?php 
    if(isset($_COOKIE["user_signin_remember"])){
        $_SESSION["user_signin"] = $_COOKIE["user_signin_remember"];
    }
?>
<header>
        <!-- Welcome-bar -->
        <div id="top_header">
            <div class="welcome_bar">
                <p>Chào mừng bạn đến với Nhà sách Z Books</p>

                <div id="status_login">
                    <?php if(!isset($_SESSION['user_signin'])){?>
                        <ul id="btn_sign">
                            <li><a href="signup.php">Đăng ký</a></li>
                            <li><a href="signin.php">Đăng nhập</a></li>
                        </ul>
                    <?php }else
                        echo '<a href="info_user.php" style="text-decoration: none;color: var(--second-color);">Người dùng <span style="font-weight:bold; font-style:italic;color:var(--main-color);">'.$_SESSION['user_signin']."</span></a>";
                    ?>
                    <?php if(isset($_SESSION['user_signin'])){?>
                        <div class="log_out_btn" style="display: inline-block;">
                        &nbsp; 
                            <a href="logout.php?type=user" style="text-decoration:none;color:var(--main-color);">Đăng xuất</a> 
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>  

        <div id="middle_header">
            <a id="img_logo" href="./index.php">
                <img src="./assets/img/logo_ZBooks.png" alt="anh_logo">
            </a>
            
            <form action="./search.php">
                <div id="search_book">
                    <input type="text" placeholder="Tìm kiếm sản phẩm..." id="input_search" name="search_book">
                    <div id="btn_search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        &nbsp;&nbsp;
                        <input type="submit" value="Tìm kiếm" style="    background-color: transparent;border: none; color: var(--white-color);">
                    </div>
                </div>
            </form>

            <div id="btn_cart" style="cursor:pointer;">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                &nbsp;
                <a href="./view_cart.php" style="  text-decoration: none;
                    color: white;
                    margin-left: 10px;
                    line-height: 40px;
                    display: block;">
                    Giỏ hàng : <span >&nbsp;
                        <?php
                            if(isset($_COOKIE['cart_sum_amount_product'])){
                                echo $_COOKIE['cart_sum_amount_product'];
                            }else{
                                echo 0;
                            }
                        ?>
                    </span>
                </a>
            </div>
        </div>
    </header>