<?php
//Генератор для создания категорий в выпадающем списке
function GenerateCategories(){ 
    require "../sql_connect.php";
    echo "
    <label for=\"select\" class=\"select\">
	
		<svg class=\"thead-svg\" alt=\"FILTR\" width=\"15\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"-2 -256 1792 1792\" transform=\"rotate(180)\">
			<path d=\"m 1403,1241 q 17,-41 -14,-70 L 896,678 V -64 q 0,-42 -39,-59 -13,-5 -25,-5 -27,0 -45,19 L 531,147 q -19,19 -19,45 V 678 L 19,1171 q -31,29 -14,70 17,39 59,39 h 1280 q 42,0 59,-39 z\"/>
		</svg>
		
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
				createListItem($row['id'],$row['nameC'],$counter,"SelectCat();		","ListCat");
    		}
    		sqlsrv_close($conn);
       		echo "</div>
	</label>
	
	<div class=\"columnHeader\">Категория</div>
	
	<svg class=\"thead-svg\" alt=\"SORT\" width=\"15\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 1000\" transform=\"rotate(180)\">
		<path d=\"M749.8,401.8H248.7c-11.1,0.4-22.2-4.1-30.6-14c-16.2-18.9-16.2-49.7,0-68.7L469.9,24.2c16.2-18.9,42.4-18.9,58.7,0l251.8,294.9c16.2,19,16.2,49.7,0,68.7C772,397.8,760.9,402.2,749.8,401.8z M250.2,598.3h501.1c11.1-0.4,22.2,4.1,30.7,13.9c16.2,18.9,16.2,49.7,0,68.7L530.1,975.8c-16.2,18.9-42.4,18.9-58.7,0L219.6,680.9c-16.2-19-16.2-49.7,0-68.7C228,602.3,239.1,597.9,250.2,598.3z\"/>
	</svg>
	";
}
//Создание одного экземпляра Option
function createListItem($id,$name,$count,$functionName,$listName){ 
    echo "<input onclick=\"$functionName\" type=\"radio\" name=\"$listName\" value=\"",$id,"\" id=\"",$listName,"[",$count,"]\">
     <label for=\"",$listName,"[",$count,"]\">$name</label>";
}

function GenerateQty(){
    echo "
    <label for=\"select1\" class=\"select1\">
								
		<svg class=\"thead-svg\" alt=\"FILTR\" width=\"15\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"-2 -256 1792 1792\" transform=\"rotate(180)\">
			<path d=\"m 1403,1241 q 17,-41 -14,-70 L 896,678 V -64 q 0,-42 -39,-59 -13,-5 -25,-5 -27,0 -45,19 L 531,147 q -19,19 -19,45 V 678 L 19,1171 q -31,29 -14,70 17,39 59,39 h 1280 q 42,0 59,-39 z\"/>
		</svg>
	
    	<input type=\"radio\" name=\"ListQty\" value=\"not_changed\" id=\"bg\" checked />
    	<input type=\"radio\" name=\"ListQty\" value=\"not_changed\" id=\"select1\">
    	<label class=\"bg\" for=\"bg\"></label>";
    		echo "<div class=\"items\">";
    		createListItem(0,"Все",0,"SelectQty();","ListQty");
    		createListItem(1,"> min",1,"SelectQty();","ListQty");
    		createListItem(2,"⩽ min",2,"SelectQty();","ListQty");
    		createListItem(3,"отсутствует",3,"SelectQty();","ListQty");
    		echo "</div>
	</label>
	
	<div class=\"columnHeader\">Количество</div>
	
	<svg class=\"thead-svg\" alt=\"SORT\" width=\"15\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 1000\" transform=\"rotate(180)\">
		<path d=\"M749.8,401.8H248.7c-11.1,0.4-22.2-4.1-30.6-14c-16.2-18.9-16.2-49.7,0-68.7L469.9,24.2c16.2-18.9,42.4-18.9,58.7,0l251.8,294.9c16.2,19,16.2,49.7,0,68.7C772,397.8,760.9,402.2,749.8,401.8z M250.2,598.3h501.1c11.1-0.4,22.2,4.1,30.7,13.9c16.2,18.9,16.2,49.7,0,68.7L530.1,975.8c-16.2,18.9-42.4,18.9-58.7,0L219.6,680.9c-16.2-19-16.2-49.7,0-68.7C228,602.3,239.1,597.9,250.2,598.3z\"/>
	</svg>
	";
}

?>