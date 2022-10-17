<?php 
    include '../connectDB.php';


    if(isset($_GET['id'])&& isset($_GET['page']) && isset($_GET['table_name'])){
        $id = $_GET['id'];
        $page = $_GET['page'];
        $table_name = $_GET['table_name'];
        
        $sql = "delete from $table_name where id = $id";
        $stmt = $connect -> prepare($sql);
        $stmt -> execute();

        header("Location: ./admin_$page.php");
    }