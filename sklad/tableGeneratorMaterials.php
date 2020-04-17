<?php
$selCategor =-1;
$searchOzm ="";
$minQty = "";
$sortMat = "";
if (!empty($_POST["categor"]))
    $selCategor = $_POST['categor'];
if (!empty($_POST["searchOzm"]))
    $searchOzm = $_POST['searchOzm'];
if (!empty($_POST["minQty"]))
    $minQty = $_POST['minQty'];
if (!empty($_POST["sort"]))
    $sortMat = $_POST['sort'];

SelectMats($selCategor,$searchOzm,$minQty,$sortMat);

/*Запрос на получение материалов по фильтру*/
function SelectMats($categor,$search,$min,$sort){
    require "../sql_connect.php";
    
    $query_select_categor ="";
    $query_search_name ="";
    $query_select_min ="";
    $query_sort_by = "";
    /*Вывод по категории*/
    if($categor != -1)
        $query_select_categor = "and categor =$categor";
    /*Поиск по озм*/
    if($search !="")
        $query_search_name = "and ozm =$search";
    /*Минимальное кол-во*/
    if($min !=""){
        switch($min){
            case 1:
                $query_select_min = "and mat_box_polka.qty>min ";
            break;
            case 2:
                $query_select_min = "and mat_box_polka.qty<=min ";
            break;
            case 3:
                $query_select_min = "and mat_box_polka.qty=0 ";
            break;
        }
    }
    /**/
    if($sort !=""){
        $query_sort_by = "order by $sort";
    }
        
    
    $query_select_mats = "select distinct name_mat,mat_box_polka.qty,min,max,mat_box_polka.id_box,mat_box_polka.id_polka,ozm,ediniciIzmerenija.edinica_izmerenija,nameC,max(mat_date) 'mat_date' from materials join history on history.mat_id = materials.id 
    inner join ediniciIzmerenija on ediniciIzmerenija.id = materials.edinica_izmerenija 
    inner join mat_box_polka on mat_box_polka.id_mat = materials.id 
    inner join categories on categories.id = materials.categor 
    where spisanie_or_dobavlenie=1 and (deleted_mat is null or deleted_mat = 0) $query_select_categor $query_search_name $query_select_min 
    group by materials.name_mat,mat_box_polka.qty,min,max,mat_box_polka.id_box,mat_box_polka.id_polka,ozm,ediniciIzmerenija.edinica_izmerenija,nameC
    $query_sort_by";
    CreateTable(sqlsrv_query($conn,$query_select_mats));
    sqlsrv_close($conn);
}
    
/* ▼ Создание таблицы ▼ */
function CreateTable($stmt){
    include "categoriesGenerator.php";
    echo "
            <table class=\"tableMats\">
                <thead id=\"material_table_head\">
                	<tr>
                    	<th class=\"columnOZM\"> 
							<div class=\"columnHeader\">ОЗМ</div>
							<label for=\"select2\" class=\"select2\">
							
							<svg class=\"thead-svg\" alt=\"SEARCH\" width=\"13\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 1000\">
								<path d=\"M688.5,424.6c0-72.6-25.8-134.8-77.4-186.4s-113.8-77.4-186.4-77.4s-134.8,25.8-186.4,77.4S160.8,352,160.8,424.6c0,72.6,25.8,134.8,77.4,186.4c51.6,51.6,113.8,77.4,186.4,77.4S559.4,662.6,611,611C662.6,559.4,688.5,497.3,688.5,424.6L688.5,424.6z M990,914.6c0,20.4-7.5,38.1-22.4,53c-14.9,14.9-32.6,22.4-53,22.4c-21.2,0-38.9-7.5-53-22.4l-202-201.4c-70.3,48.7-148.6,73-235,73c-56.1,0-109.8-10.9-161.1-32.7s-95.4-51.2-132.5-88.3c-37.1-37.1-66.5-81.3-88.3-132.5C20.9,534.5,10,480.8,10,424.6s10.9-109.8,32.7-161.1S93.9,168.1,131,131c37.1-37.1,81.3-66.6,132.5-88.3S368.5,10,424.6,10s109.8,10.9,161.1,32.7c51.2,21.8,95.4,51.2,132.5,88.3c37.1,37.1,66.6,81.3,88.3,132.5c21.8,51.2,32.7,104.9,32.7,161.1c0,86.4-24.3,164.7-73,235l202,202C982.7,876.1,990,893.8,990,914.6L990,914.6z\"/>
							</svg>
							
							<input type=\"radio\" name=\"listQty\" value=\"not_changed\" id=\"bg\" checked /><input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"select2\">
    						<label class=\"bg\" for=\"bg\"></label>
							<input type=\"number\" id=\"lname\" name=\"lname\" onkeydown=\"searchOzmEnter(event)\" min=\"111\" max=\"9999999999\">
							</label>	
						</th>
						
                    	<th class=\"columnName\">
						<div class=\"columnHeader\">Наименование</div>
						<svg id=\"sortByName\" class=\"thead-svg\" alt=\"SORT\" width=\"15\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 1000\" transform=\"rotate(180)\">
							<path d=\"M749.8,401.8H248.7c-11.1,0.4-22.2-4.1-30.6-14c-16.2-18.9-16.2-49.7,0-68.7L469.9,24.2c16.2-18.9,42.4-18.9,58.7,0l251.8,294.9c16.2,19,16.2,49.7,0,68.7C772,397.8,760.9,402.2,749.8,401.8z M250.2,598.3h501.1c11.1-0.4,22.2,4.1,30.7,13.9c16.2,18.9,16.2,49.7,0,68.7L530.1,975.8c-16.2,18.9-42.4,18.9-58.7,0L219.6,680.9c-16.2-19-16.2-49.7,0-68.7C228,602.3,239.1,597.9,250.2,598.3z\"/>
						</svg>
						</th>
						
                    	<th class=\"columnQty\">";
                                	GenerateQty();
              						echo "							
                    	</th>
                        
                    	<th class=\"columnCategory\">";
                    				GenerateCategories();
              						echo "							
                    	</th>
                    	<th class=\"columnDate\" >
							<div class=\"columnHeader\">Последнее поступление</div>
							<svg id=\"sortByDate\" class=\"thead-svg\" alt=\"SORT\" width=\"15\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 1000\" transform=\"rotate(180)\">
								<path d=\"M749.8,401.8H248.7c-11.1,0.4-22.2-4.1-30.6-14c-16.2-18.9-16.2-49.7,0-68.7L469.9,24.2c16.2-18.9,42.4-18.9,58.7,0l251.8,294.9c16.2,19,16.2,49.7,0,68.7C772,397.8,760.9,402.2,749.8,401.8z M250.2,598.3h501.1c11.1-0.4,22.2,4.1,30.7,13.9c16.2,18.9,16.2,49.7,0,68.7L530.1,975.8c-16.2,18.9-42.4,18.9-58.7,0L219.6,680.9c-16.2-19-16.2-49.7,0-68.7C228,602.3,239.1,597.9,250.2,598.3z\"/>
							</svg>
						</th>
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";
                    $rows = sqlsrv_has_rows( $stmt );
                    if ($rows === false)
                        echo "<tr><td>материал не найден</td</tr";    
                        
    				while($row = sqlsrv_fetch_array($stmt)){
        				$classMin = "itemMatTR";
        				if($row['qty']<=$row['min'] && $row['qty']!=0){
            				$classMin = "minItemMatTR";
        				}else if($row['qty']==0){
            				$classMin = "zeroItemMatTR";
                        }
        				echo "
                		<tr class=\"$classMin\" onclick=\"selectTd(this)\">
                    		<td class=\"columnOZM\">",$row['ozm'],"</td>					
                    		<td class=\"itemNameTD\">",$row['name_mat'],"</td>
                    		<td class=\"columnQty\">",$row['qty'],"</td>
                    		<td class=\"columnCategory\">",$row['nameC'],"</td>
                    		<td class=\"columnDate\">",$row['mat_date']->format('d-m-Y H:i:s'),"</td>
               	 		</tr>
        				";
        				/* Нужно вместо itemNameTD установить columnName */
    				}
    				echo "
				</tbody>
            </table>";
}
/* ▲ Создание таблицы ▲ */
?>