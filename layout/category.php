<?php 
    include './connectDB.php';
    include './admin/handle_getData.php';

    //Get category
    $categories = get_data($connect, 'categories');

    //Get type of category
    $typeofcategory = get_data($connect, 'type_of_category');

?>
<!-- Category  bar -->
<div id="category_bar">
        <div class="category_general">
            <div id="category">
                <i class="fa fa-bars" aria-hidden="true"></i>
                &nbsp;
                <span id="list_category"> DANH MỤC SẢN PHẨM</span>
                &nbsp;
                &nbsp;
                <i class="fa fa-caret-down" aria-hidden="true"></i>
                <div id="container_category">
                    <div id="category_list">
                        <?php foreach($categories as $category){?>
                            <a href="?category_id=<?= $category['id_category']?>">
                                <h4>
                                    <?php echo $category['category_name'];?>
                                </h4>
                            </a>
                            <?php foreach($typeofcategory as $typecategory){
                                if($typecategory['id_category'] == $category['id_category']){    
                            ?>
                                <a href="?typeofcategory_id=<?= $typecategory['id_typeofcategory']?>"><p><?= $typecategory['name_of_type']?></p></a>
                            <?php }}?>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div id="right_category">
                <ul>
                    <li>
                        <a href="./index.php">TRANG CHỦ</a>
                    </li>
                    <li>
                        <a href="./hethongnhasach.php">HỆ THỐNG NHÀ SÁCH</a>
                    </li>
                    <li>
                        <a href="./gioithieu.php">GIỚI THIỆU</a>
                    </li>
                    <li>
                        <a href="./lienhe.php">LIÊN HỆ</a>
                    </li>
                </ul>
            </div>
            <div id="hotline">
                <i class="fa fa-phone" aria-hidden="true"></i>
                &nbsp; HOTLINE: 0907532754
            </div>
            <div id="time-open">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                8:00 - 20:00
            </div>
        </div>
</div>