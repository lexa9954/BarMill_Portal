<?php
$action = "";
if (!empty($_POST["action"]))
    $action = $_POST['action'];

switch($action){
    case "generateMestoNah":
        GenerateMestoNah();
    break;
    case "generateMestoMore":
        GenerateMestoMore();
    break;
    case "generateMaterials":
        GenerateMaterials();
    break;
}

function GenerateCategories(){ 
    require "../sql_connect.php";
		echo "	
		<div class=\"items\">";
    		$query_select_categor ="select  id,cg_name from categories";
    		$stmt = sqlsrv_query($conn,$query_select_categor);
	
    		/*Генерация кнопок категорий*/
            CreateItem("Все","SelectCat(-1);",-1,"categor");
	
    		while($row = sqlsrv_fetch_array($stmt)){
                $id = $row['id'];
                $func = "SelectCat($id);";
				CreateItem($row['cg_name'],$func,$id,"categor");
    		}
    		sqlsrv_close($conn);
        echo "
		</div>";
}

function GenerateCategoriesFromValue($categor){ 
    require "../sql_connect.php";
    $categorWhere = "id='$categor'";
    $query_select_categor ="select  id,cg_name from categories ";
    if($categor!=0)
        $query_select_categor.= ' where '.$categorWhere;
    
    $stmt = sqlsrv_query($conn,$query_select_categor);
	
    		/*Генерация кнопок категорий*/
            CreateItem("Новоя категория","SelectCategorCreatorPanel(-1);",-1,"categorCreatorPanel");
	
    		while($row = sqlsrv_fetch_array($stmt)){
                $id = $row['id'];
                $func = "SelectCategorCreatorPanel($id);";
				CreateItem($row['cg_name'],$func,$id,"categorCreatorPanel");
    		}
    		sqlsrv_close($conn);
}

function GenerateQty(){
    echo "
    	<div class=\"items\">";
        	CreateItem("Все","SelectQty(0);",1,"qty");
        	CreateItem("> min","SelectQty(1);",2,"qty");
        	CreateItem("⩽ min","SelectQty(2);",3,"qty");
        	CreateItem("отсутствует","SelectQty(3);",4,"qty");
    	echo "
		</div>";
}

function GenerateStatus(){
    require "../sql_connect.php";
    $query_select_categor ="select id,status_name from status_mat";
    $stmt = sqlsrv_query($conn,$query_select_categor);
    
    while($row = sqlsrv_fetch_array($stmt)){
        $id = $row['id'];
        $func = "SelectStatus($id);";
        CreateItem($row['status_name'],$func,$id,"status");
    }
    sqlsrv_close($conn);
}

function GenerateMestoNah(){
    require "../sql_connect.php";
    $statusId;
    $column = "";
    $table = "";
    if (!empty($_POST["_idStatus"]))
        $statusId = $_POST['_idStatus'];
    
    switch($statusId){
        case 1:
            $column = "wh_name";
            $table = "all_wh";
        break;
        case 2:
            $column = "ceh_name";
            $table = "all_ceh";
        break;
        case 3:
            $column = "agregat_name";
            $table = "all_agregats";
        break;
        default:
            return;
    }
    
    $query_select_categor ="select id,$column from $table";
    $stmt = sqlsrv_query($conn,$query_select_categor);
    while($row = sqlsrv_fetch_array($stmt)){
        $id = $row['id'];
        $func = "SelectMestoNah($statusId,$id);";
        CreateItem($row[$column],$func,$id,"mestoNah");
    }
    sqlsrv_close($conn);
}

function GenerateMestoMore(){
    require "../sql_connect.php";
    $statusId;
    $mestoNahId;
    $column = "";
    $table = "";
    if (!empty($_POST["_idStatus"]))
        $statusId = $_POST['_idStatus'];
    if (!empty($_POST["_idMestoNah"]))
        $mestoNahId = $_POST['_idMestoNah'];
    
    switch($statusId){
        case 1:
            $column = "hran_name";
            $table = "all_mesto_hran";
        break;
        case 2:
            $column = "remPloshadka_name";
            $table = "all_remPloshadka";
        break;
        case 3:
            $column = "agregatUzel_name";
            $table = "all_agrUzel";
        break;
        default:
            return;
    }
    
    $query_select_categor ="select id,$column from $table";
    $stmt = sqlsrv_query($conn,$query_select_categor);
    while($row = sqlsrv_fetch_array($stmt)){
        $id = $row['id'];
        $func = "SelectMestoMore($id);";
        CreateItem($row[$column],$func,$id,"mestoMore");
    }
    sqlsrv_close($conn);
}

function GenerateMaterials(){
    require "../sql_connect.php";
    $query_materials;
    $categorId;
    $column;
    if (!empty($_POST["_idCategor"]))
        $categorId = $_POST['_idCategor'];
    if (!empty($_POST["_typeColumn"]))
        $column = $_POST['_typeColumn'];

    $query_materials = "select id,$column from materials where categor = $categorId";
    $stmt = sqlsrv_query($conn,$query_materials);
    while($row = sqlsrv_fetch_array($stmt)){
        $id = $row['id'];
        $func = "SelectMatrialCreatorPanel($id);";
        CreateItem($row[$column],$func,$id,$column);
    }
    sqlsrv_close($conn);
}

function CreateItem($name,$funcName,$id,$type){
    echo "<div id=\"",$type,"_",$id,"\" onclick=\"$funcName\">";
        echo $name;
    echo "</div>";
}

?>
<script type="text/javascript">
    /*Применение выбираемой категории полю с id*/
    function SelectCat(id){
        selCatId = id;
        ajaxGenerateTable();
    }
    /*Выбор отображения по количеству*/
    function SelectQty(id){
        minQty = id;
        ajaxGenerateTable();
    }
</script>