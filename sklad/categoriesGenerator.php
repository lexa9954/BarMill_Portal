<?php
//Генератор для создания категорий в выпадающем списке
function GenerateCategories($selId){ 
    require "../sql_connect.php";
    $query_select_categor ="select  id,nameC from categories";
    $stmt = sqlsrv_query($conn,$query_select_categor);
    /*Генерация кнопок категорий*/
    createCategor(-1,"Показать все",-1);
    while($row = sqlsrv_fetch_array($stmt)){
      createCategor($row['id'],$row['nameC'],$selId);
    }
    sqlsrv_close($conn);
}
//Создание одного экземпляра Option
function createCategor($id,$name,$selId){ 
    if($id == $selId){
        echo "<option value=",$id," selected>$name</option>";
    }else{
        echo "<option value=",$id,">$name</option>";
    }
}

?>