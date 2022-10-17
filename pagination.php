<?php
        $so_sach_tren_trang = 5;
        $so_sach = 10;
        $so_trang = $so_sach / $so_sach_tren_trang;
    
        // $hang_bat_dau = $so_sach_tren_trang / (trang hien tai - 1);
    
        $sql = "select * from books limit ? offset ?";
    
        $stmt = $connect -> prepare($sql);
    
        $stmt -> execute([$so_sach_tren_trang, $hang_bat_dau]);
   