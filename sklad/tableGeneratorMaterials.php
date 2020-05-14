<?php

$selCategor =-1;
$searchOzm ="";
$minQty = "";
$sortMat = "";
$catalogType = "Sklad1";
$pageURL = "";    

if (!empty($_POST["categor"]))
    $selCategor = $_POST['categor'];
if (!empty($_POST["searchOzm"]))
    $searchOzm = $_POST['searchOzm'];
if (!empty($_POST["minQty"]))
    $minQty = $_POST['minQty'];
if (!empty($_POST["sort"]))
    $sortMat = $_POST['sort'];
if (!empty($_POST["page"]))
    $pageURL = $_POST['page'];

switch($pageURL){
    case "http://localhost/BarMill_Portal/index.php?page=AllMaterials":
        SelectMats($selCategor,$searchOzm,$minQty,$sortMat);
    break;
    case "http://localhost/BarMill_Portal/index.php?page=AllEngines":
        SelectEngines($selCategor,$searchOzm,$minQty,$sortMat);
    break;
}


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
                $query_select_min = "and material_objects.qty>min ";
            break;
            case 2:
                $query_select_min = "and material_objects.qty<=min ";
            break;
            case 3:
                $query_select_min = "and material_objects.qty=0 ";
            break;
        }
    }
    /**/
    if($sort !=""){
        $query_sort_by = "order by $sort";
    }
        
    
    $query_select_mats = "select materials.id,name_mat,min,max,ozm,sum(qty)'qty',ediniciIzmerenija.ei_name,categories.cg_name, 
    (select max(mat_date) from history where mat_id=materials.id and spisanie_or_dobavlenie=1)  'mat_date' 
from materials 
inner join material_objects on materials.id = material_objects.id_mat
inner join ediniciIzmerenija on ediniciIzmerenija.id = materials.edinica_izmerenija 
inner join categories on categories.id = materials.categor 

$query_select_categor $query_search_name $query_select_min 

group by name_mat,ozm,ediniciIzmerenija.ei_name,categories.cg_name,min,max,materials.id  
    $query_sort_by";
    CreateTableAllMaterials(sqlsrv_query($conn,$query_select_mats));
    sqlsrv_close($conn);
}
    
/*Запрос на получение материалов по фильтру*/
function SelectEngines($categor,$search,$min,$sort){
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
                $query_select_min = "and material_objects.qty>min ";
            break;
            case 2:
                $query_select_min = "and material_objects.qty<=min ";
            break;
            case 3:
                $query_select_min = "and material_objects.qty=0 ";
            break;
        }
    }
    /**/
    if($sort !=""){
        $query_sort_by = "order by $sort";
    }
        
    
    $query_select_mats = "select materials.id, inv_num,type_engine,power,status_name,wh_name,ceh_name,agregat_name,hran_name,remPloshadka_name,agregatUzel_name,mesto 
from material_objects 
left join engines on engines.id_mat = material_objects.id_mat
left join status_mat on status_mat.id = material_objects.status
left join all_wh on all_wh.id = material_objects.mesto_wh
left join all_ceh on all_ceh.id = material_objects.mesto_ceh
left join all_agregats on all_agregats.id = material_objects.mesto_agregat
left join all_mesto_hran on all_mesto_hran.id = material_objects.mesto_hran
left join all_remPloshadka on all_remPloshadka.id = material_objects.mesto_rem_ploshadka
left join all_agrUzel on all_agrUzel.id = material_objects.mesto_agregat_uzel
join materials on materials.id = material_objects.id_mat
where categor = 5018 

$query_select_categor $query_search_name $query_select_min 
 
    $query_sort_by";
    CreateTableAllEngines(sqlsrv_query($conn,$query_select_mats));
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
						
                    	<th class=\"columnQty\">
							<div class=\"filtr\" onclick=\"show_overlay()\">
    							<label>";
									require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';	echo "
								</label>";
                                	GenerateQty();
              						echo "
							</div>
							<div class=\"columnHeader\">Количество</div>
							<label id=\"sortByQty\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>							
                    	</th>
						
                        <th class=\"columnEdIzm\">
							<div class=\"columnHeader\">Ед.Изм.</div
						</th>
						
                    	<th class=\"columnCategory\">
    						<div class=\"filtr\" onclick=\"show_overlay()\">					
								<label>";
									require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';	echo "
								</label>";
                    				GenerateCategories();
              						echo "
							</div>
							<div class=\"columnHeader\">Категория</div>
							<label id=\"sortByCatName\">";
        					    require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "    
							</label>							
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
                        $date = "";
                        
        				if($row['qty']<=$row['min'] && $row['qty']!=0){
            				$classMin = "minItemMatTR";
        				}else if($row['qty']==0){
            				$classMin = "zeroItemMatTR";
                        }
                        //Проверка на историю
                        if($row['mat_date'] !=null){
                            $date = $row['mat_date']->format('d-m-Y H:i:s');
                        }
        				echo "
                		<tr id=\"item\" class=\"tableRow $classMin\" onclick=\"selectTd(this)\">
                            <td id=\"id_mat\" class=\"unvisibleElement\">",$row['id'],"</td>
                    		<td class=\"columnOZM value\">",$row['ozm'],"</td>					
                    		<td class=\"columnName value\">",$row['name_mat'],"</td>
                    		<td class=\"columnQty value\">",$row['qty'],"</td>
                            <td class=\"columnEdIzm\">",$row['ei_name'],"</td>
                    		<td class=\"columnCategory\">",$row['cg_name'],"</td>
                    		<td class=\"columnDate value\">",$date,"</td>
               	 		</tr>
        				";
    				}
    				echo "
				</tbody>
            </table>";	
}
/* ▲ Создание таблицы ▲ */

/* ▼ Создание таблицы ▼ */
function CreateTableAllEngines($stmt){
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
							
							<div class=\"columnHeader\">Инв№</div>	
							<label  id=\"sortByOZM\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
						
                    	<th class=\"columnName\">
							<div class=\"columnHeader\">Тип</div>	
							<label  id=\"sortByName\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
						
                        <th class=\"columnName\">
							<div class=\"columnHeader\">Мощьность в кВт</div
						</th>
						
                        <th class=\"columnName\">
							<div class=\"columnHeader\">Статус</div
						</th>
                        
                        <th class=\"columnName\">
							<div class=\"columnHeader\">Место нахождения</div
						</th>
                        
                        <th class=\"columnName\">
							<div class=\"columnHeader\">Подробно</div
						</th>
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";
                    $rows = sqlsrv_has_rows( $stmt );
                    if ($rows === false)
                        echo "<tr><td>материал не найден</td</tr";    
                        
    				while($row = sqlsrv_fetch_array($stmt)){
                        $status =$row['status_name'];
                        $statusClass;
                        $mesto_nah = "";
                        $more ="";
                        
                        
                        switch($status){
                            case "Хранение(Резерв)":
                                $statusClass = "statusRezerv";
                            break;
                            case "Ремонт":
                                $statusClass = "statusRepair";
                            break;
                            case "Установлен":
                                $statusClass = "statusInstall";
                            break;
                            case "Утилизирован":
                                $statusClass = "statusUtil";
                            break;
                        }
                        
                        if($row['wh_name']!=null)
                            $mesto_nah=$row['wh_name'];
                        if($row['ceh_name']!=null)
                            $mesto_nah=$row['ceh_name'];
                        if($row['agregat_name']!=null)
                            $mesto_nah=$row['agregat_name'];
                        if($row['hran_name']!=null)
                            $more=$row['hran_name']." №".$row['mesto'];
                        if($row['remPloshadka_name']!=null)
                            $more=$row['remPloshadka_name'];
                        if($row['agregatUzel_name']!=null)
                            $more=$row['agregatUzel_name'];
                        
        				echo "
                		<tr id=\"item\" class=\"tableRow $statusClass\" onclick=\"selectTd(this)\">
                            <td id=\"id_mat\" class=\"unvisibleElement\">",$row['id'],"</td>
                    		<td class=\"columnOZM value\">",$row['inv_num'],"</td>					
                    		<td class=\"columnName value\">",$row['type_engine'],"</td>
                    		<td class=\"columnName\">",$row['power'],"</td>
                    		<td class=\"columnName\">",$status,"</td>
                    		<td class=\"columnName\">",$mesto_nah,"</td>
                            <td class=\"columnName\">",$more,"</td>
               	 		</tr>
        				";
    				}
    				echo "
				</tbody>
            </table>";	
}
/* ▲ Создание таблицы ▲ */



?>
<script type="text/javascript">

    /*Сортировка*/
    function sortMats(sortName){
        if (sortType.search("desc") != -1) {//слово не найдено
            sortType = sortName;
        }else{
            sortType = sortName+" desc";
        }
        ajaxGenerateTable();
    }
    /*Поис по ОЗМ*/
    function searchOzmEnter(e){
        if (e.keyCode === 13) {
            searchOzm();
        }
    }
    function searchOzm(){
            searchMatOzm = document.querySelector('#lname').value;
            if(searchMatOzm.length>9 || searchMatOzm.length<3)
                return;
            ajaxGenerateTable();
    }
    /*Сброс фильтра*/
    function resetFiltr(){
        selCatId =-1;
        minQty = "";
        sortType = "";
        ajaxGenerateTable();
    }
    

</script>