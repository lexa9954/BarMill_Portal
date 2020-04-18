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
							<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"resetSort\">
							
							<label class=\"resetSort\" for=\"resetSort\">
								<svg id=\"resetSort-svg\" class=\"thead-svg\" alt=\"RESET\" width=\"15\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 22 22\">
									<path d=\"m120.6 38.723c-3.312-7.713-7.766-14.367-13.36-19.961-5.595-5.594-12.248-10.05-19.962-13.361-7.713-3.314-15.805-4.97-24.278-4.97-7.984 0-15.71 1.506-23.18 4.521-7.468 3.01-14.11 7.265-19.92 12.751l-10.593-10.511c-1.63-1.684-3.503-2.064-5.622-1.141-2.173.924-3.259 2.527-3.259 4.808v36.5c0 1.412.516 2.634 1.548 3.666 1.033 1.032 2.255 1.548 3.667 1.548h36.5c2.282 0 3.884-1.086 4.807-3.259.923-2.118.543-3.992-1.141-5.622l-11.162-11.243c3.803-3.585 8.148-6.341 13.04-8.27 4.889-1.928 9.994-2.893 15.317-2.893 5.649 0 11.04 1.101 16.17 3.3 5.133 2.2 9.572 5.174 13.32 8.922 3.748 3.747 6.722 8.187 8.922 13.32 2.199 5.133 3.299 10.523 3.299 16.17 0 5.65-1.1 11.04-3.299 16.17-2.2 5.133-5.174 9.573-8.922 13.321-3.748 3.748-8.188 6.722-13.32 8.921-5.133 2.2-10.525 3.3-16.17 3.3-6.464 0-12.574-1.412-18.332-4.236-5.757-2.824-10.618-6.816-14.583-11.977-.38-.543-1-.87-1.874-.979-.815 0-1.494.244-2.037.733l-11.162 11.244c-.434.436-.665.991-.692 1.67-.027.68.15 1.29.53 1.833 5.921 7.17 13.09 12.724 21.509 16.661 8.419 3.937 17.3 5.907 26.642 5.907 8.473 0 16.566-1.657 24.279-4.97 7.713-3.313 14.365-7.768 19.961-13.361 5.594-5.596 10.05-12.248 13.361-19.961 3.313-7.713 4.969-15.807 4.969-24.279 0-8.474-1.657-16.564-4.97-24.277\" transform=\"matrix(.12785 0 0 .12786 2.95 2.948)\"/>
								</svg>
							</label>
							
							<label for=\"select2\" class=\"select2\">	
							
							<svg id=\"searchOZM\" class=\"thead-svg\" alt=\"SEARCH\" width=\"13\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 1000\">
								<path d=\"M688.5,424.6c0-72.6-25.8-134.8-77.4-186.4s-113.8-77.4-186.4-77.4s-134.8,25.8-186.4,77.4S160.8,352,160.8,424.6c0,72.6,25.8,134.8,77.4,186.4c51.6,51.6,113.8,77.4,186.4,77.4S559.4,662.6,611,611C662.6,559.4,688.5,497.3,688.5,424.6L688.5,424.6z M990,914.6c0,20.4-7.5,38.1-22.4,53c-14.9,14.9-32.6,22.4-53,22.4c-21.2,0-38.9-7.5-53-22.4l-202-201.4c-70.3,48.7-148.6,73-235,73c-56.1,0-109.8-10.9-161.1-32.7s-95.4-51.2-132.5-88.3c-37.1-37.1-66.5-81.3-88.3-132.5C20.9,534.5,10,480.8,10,424.6s10.9-109.8,32.7-161.1S93.9,168.1,131,131c37.1-37.1,81.3-66.6,132.5-88.3S368.5,10,424.6,10s109.8,10.9,161.1,32.7c51.2,21.8,95.4,51.2,132.5,88.3c37.1,37.1,66.6,81.3,88.3,132.5c21.8,51.2,32.7,104.9,32.7,161.1c0,86.4-24.3,164.7-73,235l202,202C982.7,876.1,990,893.8,990,914.6L990,914.6z\"/>
							</svg>
							
							<input type=\"radio\" name=\"listQty\" value=\"not_changed\" id=\"bg\" checked />
							<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"select2\">
    						<label class=\"bg\" for=\"bg\"></label>
							<input type=\"number\" id=\"lname\" name=\"lname\" onkeydown=\"searchOzmEnter(event)\" min=\"111\" max=\"9999999999\">
							</label> 
							
							<div class=\"columnHeader\">ОЗМ</div>
							
							<svg id=\"sortByOZM\" class=\"thead-svg\" alt=\"SORT\" width=\"15\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 1000\" transform=\"rotate(180)\">
								<path d=\"M749.8,401.8H248.7c-11.1,0.4-22.2-4.1-30.6-14c-16.2-18.9-16.2-49.7,0-68.7L469.9,24.2c16.2-18.9,42.4-18.9,58.7,0l251.8,294.9c16.2,19,16.2,49.7,0,68.7C772,397.8,760.9,402.2,749.8,401.8z M250.2,598.3h501.1c11.1-0.4,22.2,4.1,30.7,13.9c16.2,18.9,16.2,49.7,0,68.7L530.1,975.8c-16.2,18.9-42.4,18.9-58.7,0L219.6,680.9c-16.2-19-16.2-49.7,0-68.7C228,602.3,239.1,597.9,250.2,598.3z\"/>
							</svg>
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