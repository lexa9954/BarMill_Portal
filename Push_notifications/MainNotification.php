<?php
AllMaterials();
function AllMaterials(){
    require "sql_connect.php";
    $query_select_mats = "select distinct name_mat,mat_box_polka.qty,min,max,mat_box_polka.id_box,mat_box_polka.id_polka,ozm,ediniciIzmerenija.edinica_izmerenija,nameC,max(mat_date) 'mat_date' from materials join history on history.mat_id = materials.id 
    inner join ediniciIzmerenija on ediniciIzmerenija.id = materials.edinica_izmerenija 
    inner join mat_box_polka on mat_box_polka.id_mat = materials.id 
    inner join categories on categories.id = materials.categor 
    where spisanie_or_dobavlenie=1 and (deleted_mat is null or deleted_mat = 0) 
    group by materials.name_mat,mat_box_polka.qty,min,max,mat_box_polka.id_box,mat_box_polka.id_polka,ozm,ediniciIzmerenija.edinica_izmerenija,nameC";
    $query_select_notifications = "";
    $allMats = sqlsrv_query($conn,$query_select_mats);
    $allNotifications = sqlsrv_query($conn,$query_select_notifications);
    
    
    while($row = sqlsrv_fetch_array($allMats)){
//    echo $row['name_mat'];
    }
    
    sqlsrv_close($conn);
}
//    echo "<script>
//    notifSet('Материал на исходе',","'",$row['name_mat'],"','sklad/img/",$row['ozm'],".jpg');
//    </script>";
?>