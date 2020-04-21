<?php
//Фильтр категорий / Генератор для создания категорий в выпадающем списке
function GenerateCategories(){ 
    require "../sql_connect.php";
    echo "
    <label for=\"select\" class=\"select\" onclick=\"show_overlay()\" id=\"select_btn\">";  								
		require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';	echo "
    	<input type=\"radio\" name=\"ListCat\" value=\"not_changed\" id=\"select\">";
    		echo "<div class=\"items\" onclick=\"close_all_sidebar()\">";
    		$query_select_categor ="select  id,nameC from categories";
    		$stmt = sqlsrv_query($conn,$query_select_categor);
    		$counter = 0;
    		/*Генерация кнопок категорий*/
    		createListItem(-1,"Все",0,"SelectCat();","ListCat");
    		while($row = sqlsrv_fetch_array($stmt)){
    		    $counter++;
				createListItem($row['id'],$row['nameC'],$counter,"SelectCat();		","ListCat");
    		}
    		sqlsrv_close($conn);
       		echo "</div>
	</label>	
	<div class=\"columnHeader\">Категория</div>	
	<label  id=\"sortByCatName\">";
  		require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
	</label>";
}
//Создание одного экземпляра Option
function createListItem($id,$name,$count,$functionName,$listName){ 
    echo "<input onclick=\"$functionName\" type=\"radio\" name=\"$listName\" value=\"",$id,"\" id=\"",$listName,"[",$count,"]\">
     <label for=\"",$listName,"[",$count,"]\">$name</label>";
}
// Фильтр по количеству
function GenerateQty(){
    echo "
    <label for=\"select1\" class=\"select1\" onclick=\"show_overlay()\"  id=\"select1_btn\">";  								
		require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';	echo "
    	<input type=\"radio\" name=\"ListQty\" value=\"not_changed\" id=\"select1\">";
    		echo "<div class=\"items\">";
    		createListItem(0,"Все",0,"SelectQty();","ListQty");
    		createListItem(1,"> min",1,"SelectQty();","ListQty");
    		createListItem(2,"⩽ min",2,"SelectQty();","ListQty");
    		createListItem(3,"отсутствует",3,"SelectQty();","ListQty");
    		echo "</div>
	</label>	
	<div class=\"columnHeader\">Количество</div>	
	<label id=\"sortByQty\">";
  		require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
	</label>";
}
?>