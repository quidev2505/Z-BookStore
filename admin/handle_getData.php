<?php
    function get_data($conn, $tableName){
        $sql = "select * from $tableName";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt -> fetchAll();
    }