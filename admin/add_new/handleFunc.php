<?php 
    function duplicatedData($connect, $data_add, $data_from_table, $table_name){
        $sql = "select * from $table_name where $data_from_table = ?";

        $stmt = $connect -> prepare($sql);
        $stmt->execute([$data_add]);
        if($stmt->rowCount() >= 1){
            return 1;
        }else{
            return 0;
        }
    }

    function check_type_of_category($connect,  $typeofcategory_name_choose, $id_category_name_choose){
        $sql = "select * from type_of_category where name_of_type = ? and id_category = ?";
        $stmt = $connect -> prepare($sql);
        $stmt -> execute([$typeofcategory_name_choose, $id_category_name_choose]);
        if($stmt -> rowCount() > 0)
            return 1;
        else 
            return 0;
    }

 