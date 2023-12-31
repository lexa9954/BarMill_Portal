<?php

$action = $_POST['action'];
switch($action){
    case 'infoMatGrafic':
        SelectMatVariables($_POST['idMat']);
    break;
    case 'imgSelMat':
        imgSelMat($_POST['idMat']);
    break;
    case 'CreateTableTransaction':
        SelectedMatTransactions($_POST['idMat']);
    break;
    case 'QueryGetValues':
        SelectMatVariablesCreatorPanel($_POST['_idMat']);
    break;
}

function SelectMatVariables($id){
    include   "../sql_connect.php";
    $matDateArr = array();
    $spisanieDobavlenieArr = array();
    $matQtyArr = array();
    $minArr = array();
    $maxArr = array();
    $query_ = "select mat_date,spisanie_or_dobavlenie,mat_qty,min,max from history join materials on materials.id=history.mat_id where mat_id =$id";
    $stmt = mysqli_query($conn,$query_);
    while($row = mysqli_fetch_array($stmt)){
        $mat_date = $row['mat_date'];
        $spisanie_or_dobavlenie = $row['spisanie_or_dobavlenie'];
        $mat_qty = $row['mat_qty'];
        $min = $row['min'];
        $max = $row['max'];
        
        $matDateArr = $mat_date;
        $spisanieDobavlenieArr = $spisanie_or_dobavlenie;
        $matQtyArr = $mat_qty;
        $minArr = $min;
        $maxArr = $max;
        echo "$spisanieDobavlenieArr $matDateArr $matQtyArr $minArr $maxArr;";
    }
    mysqli_close($conn);
}
function imgSelMat($id){
    include   "../sql_connect.php";
    $query_ = "select ozm from materials where id ='$id'";
    $stmt = mysqli_query($conn,$query_);
    
    while($row = mysqli_fetch_array($stmt)){
        echo $row['ozm'];
    }

    mysqli_close($conn);
}


function SelectedMatTransactions($id){
    $query_ = "select peoples.Second_name,peoples.First_name,peoples.Last_name,mat_date,mat_qty,spisanie_or_dobavlenie,ediniciIzmerenija.ei_name   
    from history join peoples on history.people = peoples.id join materials on history.mat_id = materials.id 
    join ediniciIzmerenija on materials.ei_id=ediniciIzmerenija.id 
    where mat_id=$id";
    
    CreateTableTransactions($query_);
}


function CreateTableTransactions($stmt){
    echo "<table class=\"tableMats\">
                <thead id=\"material_table_head\" class=\"material_table_head\">
                	<tr>
                        <th class=\"columnDate\">
							<div class=\"columnHeader\">Дата</div>
							</th>
                        <th class=\"colSod\">
							</label>
							<div class=\"columnHeader\">Действие</div>
							</th>
                        <th class=\"columnQty\">
							<div class=\"columnHeader\">Количество</div>
							</th>
                        <th class=\"columnEdIzm\">
							<div class=\"columnHeader\">Ед.Изм.</div>
							</th>
                        <th class=\"colFio\">
							<div class=\"columnHeader\">ФИО</div>
							</th>
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";
                    include   "../sql_connect.php";
                    $resQuery = mysqli_query($conn,$stmt);
                    
    				while($row = mysqli_fetch_array($resQuery)){
                        $sod = "";
                        if($row['spisanie_or_dobavlenie'])
                            $sod="Внёс"; 
                        else
                            $sod="Забрал";
  
        				echo "
                		<tr class=\"tableRow\" onclick=\"selectTd(this)\">
                            <td class=\"columnDate\">",$row['mat_date'],"</td>
                            <td class=\"colSod\">",$sod,"</td>
                            <td class=\"columnQty value\">",$row['mat_qty'],"</td>
                            <td class=\"columnEdIzm\">",$row['ei_name'],"</td>
                    		<td class=\"colFio\">",$row['Last_name']," ",$row['First_name']," ",$row['Second_name'],"</td>	
               	 		</tr>
        				";
    				}
                    mysqli_close($conn);
    				echo "
				</tbody>
            </table>";
}


function SelectMatVariablesCreatorPanel($id){
    include   "../sql_connect.php";
    
    $query_ = "select id_mat,status,status_name,wh_name,ceh_name,agregat_name,hran_name,remPloshadka_name,agregatUzel_name,mesto 
from material_objects 
join status_mat on status_mat.id = status
left join all_wh on all_wh.id = mesto_wh
left join all_ceh on all_ceh.id = mesto_ceh
left join all_agregats on all_agregats.id = mesto_agregat
left join all_mesto_hran on all_mesto_hran.id = mesto_hran
left join all_remPloshadka on all_remPloshadka.id = mesto_rem_ploshadka
left join all_agrUzel on all_agrUzel.id = mesto_agregat_uzel where id_mat =$id";
    $stmt = mysqli_query($conn,$query_);
    while($row = mysqli_fetch_array($stmt)){
        echo $row['status_name'];
        switch($row['status']){
            case 1:
                echo $row['wh_name'];
                echo $row['hran_name'];
            break;
            case 2:
                echo $row['ceh_name'];
                echo $row['remPloshadka_name'];
            break;
            case 3:
                echo $row['agregat_name'];
                echo $row['agregatUzel_name'];
            break;
            case 4:
                echo "Утиль";
            break;
        }
        echo "</br>";
    }
    mysqli_close($conn);
}


?>
