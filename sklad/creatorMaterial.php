<?php 

if (!empty($_POST["action"]))
    $action = $_POST['action'];



switch($action){
    case "CreateNewMaterial":
        CreateMaterial();
    break;
}

function CreateMaterial(){
    require "../sql_connect.php";
    $result ="";
    $Add_to_materials_query="";
    
    $_ozm;
    $_name_mat;
    $_min;
    $_max;


    if (!empty($_POST["_ozm"]))
        $_ozm = $_POST['_ozm'];
    if (!empty($_POST["_name_mat"]))
        $_name_mat = $_POST['_name_mat'];
    if (!empty($_POST["_min"]))
        $_min = $_POST['_min'];
    if (!empty($_POST["_max"]))
        $_max = $_POST['_max'];

    
    
    $Search_material_query = "select id from materials where name_mat='$_name_mat'";
    $Search_material_stmt = mysqli_query( $conn, $Search_material_query);
    //$Search_material_stmt = mysqli_query($conn,$Search_material_query);
    echo mysqli_fetch_array($Search_material_stmt);
    
    //Добавление в таблицу материалов
    $Add_to_materials_query = "insert into materials (name_mat,bar_code,categor,min,max,edinica_izmerenija,ozm) values 
    ('$_name_mat',1011$_name_mat,5018,1,5,1,$_ozm)";
    if ($conn->query($Add_to_materials_query) != TRUE) {
        echo "Ошибка: " . $Add_to_materials_query . "<br>" . $conn->error;
        return;
    }
    
    
    echo "Succes $result";
}
function CreateEngine(){
    require "../sql_connect.php";
    
    $_type_engine;
    $_power_engine;
    
    if (!empty($_POST["_type_engine"]))
        $_type_engine = $_POST['_type_engine'];
    if (!empty($_POST["_power_engine"]))
        $_power_engine = $_POST['_power_engine'];
    
    
    AddObjectMaterial();
}
function AddMaterial(){
    require "../sql_connect.php";
    
}
function AddObjectMaterial(){
    require "../sql_connect.php";
    //параметры для обьекта
    $_id_mat;
    $_inv_num;
    $_serial_num;
    $_qty;
    
    //переменные для определения статуса нахождения
    $_idStatus;
    $_idMestoNah;
    $_idMestoMore;
    
    //
    if (!empty($_POST["_id_mat"]))
        $_id_mat = $_POST['_id_mat'];
    if (!empty($_POST["_inv_num"]))
        $_inv_num = $_POST['_inv_num'];
    if (!empty($_POST["_serial_num"]))
        $_serial_num = $_POST['_serial_num'];
    if (!empty($_POST["_qty"]))
        $_qty = $_POST['_qty'];
    //
    if (!empty($_POST["_idStatus"]))
        $_idStatus = $_POST['_idStatus'];
    if (!empty($_POST["_idMestoNah"]))
        $_idMestoNah = $_POST['_idMestoNah'];
    if (!empty($_POST["_idMestoMore"]))
        $_idMestoMore = $_POST['_idMestoMore'];
    
    
    switch($_idStatus){
        case 1://если статус хранение

        break;
        case 2://если статус ремонт
            
        break;
        case 3://если статус установлен
            
        break;
        case 4://если статус утилизирован
            
        break;
    }
    
}
?>