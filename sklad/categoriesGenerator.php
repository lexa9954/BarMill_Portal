<?php
//Фильтр категорий / Генератор для создания категорий в выпадающем списке
//function GenerateCategories(){ 
//    require "../sql_connect.php";
//    echo "
//    <label for=\"select\" class=\"filtr\" onclick=\"show_overlay()\" id=\"select_btn\">";  								
//		require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';	echo "
//    	<input type=\"radio\" name=\"ListCat\" value=\"not_changed\" id=\"select\">";
//    		echo "<div class=\"items\" onclick=\"close_all_sidebar()\">";
//    		$query_select_categor ="select  id,nameC from categories";
//    		$stmt = sqlsrv_query($conn,$query_select_categor);
//    		$counter = 0;
//    		/*Генерация кнопок категорий*/
//    		createListItem(-1,"Все",0,"SelectCat();","ListCat");
//    		while($row = sqlsrv_fetch_array($stmt)){
//    		    $counter++;
//				createListItem($row['id'],$row['nameC'],$counter,"SelectCat();		","ListCat");
//    		}
//    		sqlsrv_close($conn);
//       		echo "</div>
//	</label>	
//	<div class=\"columnHeader\">Категория</div>	
//	<label  id=\"sortByCatName\">";
//  		require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
//	</label>";
//}
//Создание одного экземпляра Option
//function createListItem($id,$name,$count,$functionName,$listName){ 
//    echo "<input onclick=\"$functionName\" type=\"radio\" name=\"$listName\" value=\"",$id,"\" id=\"",$listName,"[",$count,"]\">
//     <label for=\"",$listName,"[",$count,"]\">$name</label>";
//}
// Фильтр по количеству
//function GenerateQty(){
//    echo "
//    <label for=\"select1\" class=\"filtr\" onclick=\"show_overlay()\"  id=\"select1_btn\">";  								
//		require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';	echo "
//    	<input type=\"radio\" name=\"ListQty\" value=\"not_changed\" id=\"select1\">";
//    		echo "<div id=\"itemsDD\" onclick=\"close_all_sidebar()\" class=\"items\">";
//    		createListItem(0,"Все",0,"SelectQty();","ListQty");
//    		createListItem(1,"> min",1,"SelectQty();","ListQty");
//    		createListItem(2,"⩽ min",2,"SelectQty();","ListQty");
//    		createListItem(3,"отсутствует",3,"SelectQty();","ListQty");
//    		echo "</div>
//	</label>	
//	<div class=\"columnHeader\">Количество</div>	
//	<label id=\"sortByQty\">";
//  		require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
//	</label>";
//}

function GenerateCategories(){ 
    require "../sql_connect.php";
    echo "
    <div class=\"filtr\" onclick=\"show_overlay()\">";					
		require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';
        echo "<div style=\"background:red; position\">";
    		$query_select_categor ="select  id,nameC from categories";
    		$stmt = sqlsrv_query($conn,$query_select_categor);
    		/*Генерация кнопок категорий*/
            CreateItem("Все","SelectCat(-1);");
    		while($row = sqlsrv_fetch_array($stmt)){
				CreateItem($row['nameC'],"SelectCat(",$row['id'],");");
    		}
    		sqlsrv_close($conn);
        echo "</div>";

        echo "<div class=\"columnHeader\">Категория</div>";
        echo "<label id=\"sortByCatName\">";
            require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	
        echo "</label>";
        echo"</div>";
}

function GenerateQty(){
    echo "
    <div class=\"filtr\" onclick=\"show_overlay()\">";
        require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';
    
    echo "<div style=\"background:red; position\">";
        CreateItem("Все","SelectQty(0);");
        CreateItem("> min","SelectQty(1);");
        CreateItem("⩽ min","SelectQty(2);");
        CreateItem("отсутствует","SelectQty(3);");
    echo "</div>";
    
    echo "<div class=\"columnHeader\">Количество</div>";
    echo "<label id=\"sortByQty\">";
  		require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	
    echo "</label>";
    echo"</div>";
}

function CreateItem($name,$funcName){
    echo "<div onclick=\"$funcName\">";
        echo $name;
    echo "</div>";
}

?>