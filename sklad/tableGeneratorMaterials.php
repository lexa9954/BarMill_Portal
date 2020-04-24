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
        
    
    $query_select_mats = "select distinct name_mat,mat_box_polka.qty,min,max,mat_box_polka.id_box,mat_box_polka.id_polka,ozm,ediniciIzmerenija.edinica_izmerenija,nameC,max(mat_date) 'mat_date',ediniciIzmerenija.edinica_izmerenija  from materials join history on history.mat_id = materials.id 
    inner join ediniciIzmerenija on ediniciIzmerenija.id = materials.edinica_izmerenija 
    inner join mat_box_polka on mat_box_polka.id_mat = materials.id 
    inner join categories on categories.id = materials.categor 
    where spisanie_or_dobavlenie=1 and (deleted_mat is null or deleted_mat = 0) $query_select_categor $query_search_name $query_select_min 
    group by materials.name_mat,mat_box_polka.qty,min,max,mat_box_polka.id_box,mat_box_polka.id_polka,ozm,ediniciIzmerenija.edinica_izmerenija,nameC,ediniciIzmerenija.edinica_izmerenija 
    $query_sort_by";
    CreateTableAllMaterials(sqlsrv_query($conn,$query_select_mats));
    sqlsrv_close($conn);
}
    
/* ▼ Создание таблицы ▼ */
function CreateTableAllMaterials($stmt){
    include "categoriesGenerator.php";
    echo "
            <table class=\"tableMats\">
                <thead id=\"material_table_head\" class=\"material_table_head\">
                	<tr>
                    	<th class=\"columnOZM\">
							<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"resetSort\">
							
							<label for=\"resetSort\" class=\"resetSort\" onclick=\"close_all_sidebar()\" id=\"resetSort-svg\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/resetSort.svg';	echo "							
							</label>
							
							<label for=\"select2\" class=\"select2\"  onclick=\"show_overlay()\" id=\"searchOZM\">";				
  								require dirname(__FILE__) . '/../sklad/sys_img/searchOZM.svg';	echo "
							<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"select2\">
							<input type=\"number\" id=\"lname\" name=\"lname\" onkeydown=\"searchOzmEnter(event)\" min=\"111\" max=\"9999999999\">
							</label> 
							
							<div class=\"columnHeader\">ОЗМ</div>	
							<label  id=\"sortByOZM\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
						
                    	<th class=\"columnName\">
							<div class=\"columnHeader\">Наименование</div>	
							<label  id=\"sortByName\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
						
                    	<th class=\"columnQty\">";
                                	GenerateQty();
              						echo "							
                    	</th>
                        <th class=\"columnEdIzm\">
							<div class=\"columnHeader\">Ед.Изм.</div
						</th>
                    	<th class=\"columnCategory\">";
                    				GenerateCategories();
              						echo "							
                    	</th>
						
                    	<th class=\"columnDate\" >
							<div class=\"columnHeader\">Последнее поступление</div>	
							<label  id=\"sortByDate\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
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
                		<tr id=\"item\" class=\"tableRow $classMin\" onclick=\"selectTd(this)\">
                    		<td class=\"columnOZM value\">",$row['ozm'],"</td>					
                    		<td class=\"itemNameTD value\">",$row['name_mat'],"</td>
                    		<td class=\"columnQty value\">",$row['qty'],"</td>
                            <td class=\"columnEdIzm\">",$row['edinica_izmerenija'],"</td>
                    		<td class=\"columnCategory\">",$row['nameC'],"</td>
                    		<td class=\"columnDate value\">",$row['mat_date']->format('d-m-Y H:i:s'),"</td>
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