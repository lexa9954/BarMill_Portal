<?php
$selCategor ="";
$searchName ="";
$minQty = "";
if (!empty($_POST["categor"]))
    $selCategor = $_POST['categor'];
if (!empty($_POST["searchName"]))
    $searchName = $_POST['searchName'];
if (!empty($_POST["minQty"]))
    $minQty = $_POST['minQty'];

SelectMats($selCategor,$searchName,$minQty);

/*Запрос на получение материалов по фильтру*/
function SelectMats($categor,$searchName,$minQty){
    require "../sql_connect.php";
    
    $query_select_categor ="";
    $query_search_name ="";
    $query_select_min ="";
    /*Вывод по категории*/
    if($categor != -1)
        $query_select_categor = "and categor =$categor";
    /*Поиск по имени*/
    if($searchName != "")
        $query_search_name = "and name_mat LIKE '%$searchName%'";
    /*Минимальное кол-во*/
    if($minQty !=""){
        switch($minQty){
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
        
    
    $query_select_mats = "select distinct name_mat,mat_box_polka.qty,min,max,mat_box_polka.id_box,mat_box_polka.id_polka,ozm,ediniciIzmerenija.edinica_izmerenija,nameC,max(mat_date) 'mat_date' from materials join history on history.mat_id = materials.id 
    inner join ediniciIzmerenija on ediniciIzmerenija.id = materials.edinica_izmerenija 
    inner join mat_box_polka on mat_box_polka.id_mat = materials.id 
    inner join categories on categories.id = materials.categor 
    where spisanie_or_dobavlenie=1 and (deleted_mat is null or deleted_mat = 0) $query_select_categor $query_search_name $query_select_min 
    group by materials.name_mat,mat_box_polka.qty,min,max,mat_box_polka.id_box,mat_box_polka.id_polka,ozm,ediniciIzmerenija.edinica_izmerenija,nameC";
    CreateTable(sqlsrv_query($conn,$query_select_mats));
    sqlsrv_close($conn);
}
    
/* ▼ Создание таблицы ▼ */
function CreateTable($stmt){
    echo "
            <table class=\"tableMats\">
                <thead id=\"material_table_head\">
                	<tr>
                    	<th class=\"columnOZM\">ОЗМ 
							<label for=\"select2\" class=\"select2\">
							<input type=\"radio\" name=\"list\" value=\"not_changed\" id=\"select2\">
    							<label class=\"bg\" for=\"bg\"></label>
								<input type=\"text\" id=\"lname\" name=\"lname\">
							</label>	
						</th>
                    	<th class=\"columnName\">Наименование</th>
                    	<th class=\"columnQty\">
						<div id=\"txtQty\">Количество</div>
							<label for=\"select1\" class=\"select1\">
    							<input type=\"radio\" name=\"listQty\" value=\"not_changed\" id=\"bg\" checked />
    							<input type=\"radio\" name=\"listQty\" value=\"not_changed\" id=\"select1\">
    							<label class=\"bg\" for=\"bg\"></label>
    							
								<div class=\"items\">
                    				<input onclick=\"SelectQty();\" type=\"radio\" name=\"listQty\" value=\"1\" id=\"listQty[0]\">
      								<label for=\"listQty[0]\">> min</label>
									
      								<input onclick=\"SelectQty();\" type=\"radio\" name=\"listQty\" value=\"2\" id=\"listQty[1]\">
      								<label for=\"listQty[1]\">⩽ min</label>
									
      								<input onclick=\"SelectQty();\" type=\"radio\" name=\"listQty\" value=\"3\" id=\"listQty[2]\">
      								<label for=\"listQty[2]\">отсутствует</label>
    							</div>
							</label></th>
                    	</th>
                        
                    	<th class=\"columnCategory\">
						<div id=\"txtCategory\">Категория</div>
							<label for=\"select\" class=\"select\">
    							<input type=\"radio\" name=\"list\" value=\"not_changed\" id=\"bg\" checked />
    							<input type=\"radio\" name=\"list\" value=\"not_changed\" id=\"select\">
    							<label class=\"bg\" for=\"bg\"></label>
    							<div class=\"items\">";
                    			include "categoriesGenerator.php";
                    			GenerateCategories($_POST['categor']);
              					echo "
    							</div>
							</label>
                    	</th>
                    	<th class=\"columnDate\" >Последнее поступление</th>
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";
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
//            				echo "<script>
//            				notifSet('Материал на исходе',","'",$row['name_mat'],"','sklad/img/",$row['ozm'],".jpg');
//            				</script>";
/* ▲ Создание таблицы ▲ */
?>