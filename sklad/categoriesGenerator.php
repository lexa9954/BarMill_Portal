<?php
//Генератор для создания категорий в выпадающем списке
function GenerateCategories(){ 
    require "../sql_connect.php";
    echo "
    <input type=\"radio\" name=\"ListCat\" value=\"not_changed\" id=\"bg\" checked />
    <input type=\"radio\" name=\"ListCat\" value=\"not_changed\" id=\"select\">
    <label class=\"bg\" for=\"bg\"></label>";
    echo "<div class=\"items\">";
    $query_select_categor ="select  id,nameC from categories";
    $stmt = sqlsrv_query($conn,$query_select_categor);
    $counter = 0;
    /*Генерация кнопок категорий*/
    createListItem(-1,"Все",0,"SelectCat();","ListCat");
    while($row = sqlsrv_fetch_array($stmt)){
        $counter++;
        createListItem($row['id'],$row['nameC'],$counter,"SelectCat();","ListCat");
    }
    sqlsrv_close($conn);
        echo "</div></label>";
}
//Создание одного экземпляра Option
function createListItem($id,$name,$count,$functionName,$listName){ 
    echo "<input onclick=\"$functionName\" type=\"radio\" name=\"$listName\" value=\"",$id,"\" id=\"",$listName,"[",$count,"]\">
     <label for=\"",$listName,"[",$count,"]\">$name</label>";
}

function GenerateQty(){
    echo "
    <input type=\"radio\" name=\"ListQty\" value=\"not_changed\" id=\"bg\" checked />
    <input type=\"radio\" name=\"ListQty\" value=\"not_changed\" id=\"select1\">
    <label class=\"bg\" for=\"bg\"></label>";
    echo "<div class=\"items\">";
    createListItem(0,"Все",0,"SelectQty();","ListQty");
    createListItem(1,"> min",1,"SelectQty();","ListQty");
    createListItem(2,"⩽ min",2,"SelectQty();","ListQty");
    createListItem(3,"отсутствует",3,"SelectQty();","ListQty");
    echo "</div></label>";
}

?>