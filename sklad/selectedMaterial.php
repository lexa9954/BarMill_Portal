<?php

$action = $_POST['action'];
switch($action){
    case 'infoMatGrafic':
        SelectMatVariables($_POST['nameMat']);
    break;
    case 'imgSelMat':
        imgSelMat($_POST['nameMat']);
    break;
    case 'CreateTableTransaction':
        SelectedMatTransactions($_POST['nameMat']);
    break;
}

function SelectMatVariables($name){
    include   "../sql_connect.php";
    $matDateArr = array();
    $spisanieDobavlenieArr = array();
    $matQtyArr = array();
    $minArr = array();
    $maxArr = array();
    $query_ = "select mat_date,spisanie_or_dobavlenie,mat_qty,min,max from history join materials on materials.id=history.mat_id where name_mat ='$name'";
    $stmt = sqlsrv_query($conn,$query_);
    while($row = sqlsrv_fetch_array($stmt)){
        $mat_date = $row['mat_date']->format('d.m.Y');
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
    sqlsrv_close($conn);
}
function imgSelMat($name){
    include   "../sql_connect.php";
    $query_ = "select ozm from materials where name_mat ='$name'";
    $stmt = sqlsrv_query($conn,$query_);
    while($row = sqlsrv_fetch_array($stmt)){
        echo $row['ozm'];
    }
    sqlsrv_close($conn);
}

function SelectedMatTransactions($name){
    include   "../sql_connect.php";
    $query_ = "select peoples.Second_name,peoples.First_name,peoples.Last_name,mat_date,mat_qty,spisanie_or_dobavlenie 
    from history join peoples on history.people = peoples.id join materials on history.mat_id = materials.id where name_mat='$name'";
    
    CreateTableTransactions(sqlsrv_query($conn,$query_));
    sqlsrv_close($conn);
}
function CreateTableTransactions($stmt){
    echo "<table class=\"tableMats\">
                <thead id=\"material_table_head\">
                	<tr>
                        <th>Дата</th>
                        <th>Действие</th>
                        <th>Количество</th>
                        <th>ФИО</th>
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";
                    $rows = sqlsrv_has_rows( $stmt );
                    if ($rows === false)
                        echo "<tr><td>Транзакций не обнаружено</td</tr";    
                        
    				while($row = sqlsrv_fetch_array($stmt)){
                        $sod = "";
                        if($row['spisanie_or_dobavlenie'])
                            $sod="Внёс"; 
                        else
                            $sod="Забрал";
  
        				echo "
                		<tr class=\"transactionRow\" onclick=\"selectTd(this)\">
                            <td class=\"colDate\">",$row['mat_date']->format('d-m-Y H:i:s'),"</td>
                            <td class=\"colSod\">",$sod,"</td>
                            <td class=\"colQty\">",$row['mat_qty'],"</td>
                    		<td class=\"colFio\">",$row['Second_name']," ",$row['First_name']," ",$row['Last_name'],"</td>	
               	 		</tr>
        				";
    				}
    				echo "
				</tbody>
            </table>";
}
?>