<!-- Category  bar -->
<div id="category_bar">
        <div class="category_general">
            <div id="category">
                <i class="fa fa-bars" aria-hidden="true"></i>
                &nbsp;
                DANH MỤC SẢN PHẨM
                &nbsp;
                &nbsp;
                <i class="fa fa-caret-down" aria-hidden="true"></i>
                <div id="list_category">
                    <?php foreach($categories as $category){?>
                        <div>
                            <span>
                                <?php echo $category['category_name']; $id_category = $category['id'];?>
                                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                            </span>
                            <div class="container_typeofcategory">
                                <?php foreach($typeofcategory as $typecategory){ if($typecategory['id_category'] == $id_category){?>
                                    <a href="">
                                        <?php echo $typecategory['name_of_type']?>
                                    </a>
                                <?php }}?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div id="right_category">
                <ul>
                    <li>
                        <a href="../index.php">TRANG CHỦ</a>
                    </li>
                    <li>
                        <a href="">HỆ THỐNG NHÀ SÁCH</a>
                    </li>
                    <li>
                        <a href="">GIỚI THIỆU</a>
                    </li>
                    <li>
                        <a href="">LIÊN HỆ</a>
                    </li>
                </ul>
            </div>
            <div id="hotline">
                <i class="fa fa-phone" aria-hidden="true"></i>
                HOTLINE: 0907532754
            </div>
            <div id="time-open">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                8:00 - 20:00
            </div>
        </div>
</div>