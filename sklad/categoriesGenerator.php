<?php
//Генератор для создания категорий в выпадающем списке
function GenerateCategories(){ 
    require "../sql_connect.php";
    $query_select_categor ="select  id,nameC from categories";
    $stmt = sqlsrv_query($conn,$query_select_categor);
    $counter = 0;
    /*Генерация кнопок категорий*/
    createCategor(-1,"Все",-1,0);
    while($row = sqlsrv_fetch_array($stmt)){
        $counter++;
        createCategor($row['id'],$row['nameC'],$counter);
    }
    sqlsrv_close($conn);
}
//Создание одного экземпляра Option
function createCategor($id,$name,$count){ 
        echo "<input onclick=\"SelectCat();\" type=\"radio\" name=\"list\" value=",$id," id=\"list[",$count,"]\">
              <label for=\"list[",$count,"]\">$name</label>";
}

?>