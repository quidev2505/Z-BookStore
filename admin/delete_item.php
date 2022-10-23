<?php 
    include '../connectDB.php';

   
    if(isset($_GET['id'])&& isset($_GET['page']) && isset($_GET['table_name']) && isset($_GET['column_id'])){
        $id = $_GET['id'];
        $page = $_GET['page'];
        $table_name = $_GET['table_name'];
        $column_name_id = $_GET['column_id'];
        if($column_name_id == 'id'){
            $sql = "delete from $table_name where id = $id";
        }else{
            $sql = "delete from $table_name where id_$column_name_id = $id";
        }
        
        $state = '';
        try{
            $stmt = $connect -> prepare($sql);
            $stmt -> execute();
            $state = 'success';
        }catch(PDOException $e){
            $state = 'fail';
        }
        header("Location: ./admin_$page.php?del_$state");

    }
  