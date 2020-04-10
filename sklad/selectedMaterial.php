<?php

$action = $_POST['action'];
switch($action){
    case 'infoMatGrafic':
        SelectMatVariables($_POST['nameMat']);
    break;
    case 'imgSelMat':
        imgSelMat($_POST['nameMat']);
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
?>