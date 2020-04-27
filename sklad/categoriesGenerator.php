<?php
function GenerateCategories(){ 
    require "../sql_connect.php";
		echo "	
		<div class=\"items\">";
    		$query_select_categor ="select  id,nameC from categories";
    		$stmt = sqlsrv_query($conn,$query_select_categor);
	
    		/*Генерация кнопок категорий*/
            CreateItem("Все","SelectCat(-1);");
	
    		while($row = sqlsrv_fetch_array($stmt)){
                $id = $row['id'];
                $func = "SelectCat($id);";
				CreateItem($row['nameC'],$func);
    		}
    		sqlsrv_close($conn);
        echo "
		</div>";
}

function GenerateQty(){
    echo "
    	<div class=\"items\">";
        	CreateItem("Все","SelectQty(0);");
        	CreateItem("> min","SelectQty(1);");
        	CreateItem("⩽ min","SelectQty(2);");
        	CreateItem("отсутствует","SelectQty(3);");
    	echo "
		</div>";
}

function CreateItem($name,$funcName){
    echo "<div onclick=\"$funcName\">";
        echo $name;
    echo "</div>";
}

?>
<script type="text/javascript">
    /*Применение выбираемой категории полю с id*/
    function SelectCat(id){
        selCatId = id;
        $(document).ready(function(){
           $.ajax({
               type: "POST",
               url: "sklad/tableGeneratorMaterials.php",
               data: {sort:sortType,categor:selCatId, minQty:minQty},
               success: function(result,status,xhr){
                   $( "#catalogContent" ).html( result );
                   DocumentReady();
               }
           });
        });
    }
    /*Выбор отображения по количеству*/
    function SelectQty(id){
        minQty = id;
        $(document).ready(function(){
           $.ajax({
               type: "POST",
               url: "sklad/tableGeneratorMaterials.php",
               data: {sort:sortType,categor:selCatId, minQty:minQty},
               success: function(result,status,xhr){
                   $( "#catalogContent" ).html( result );
                   console.log("Success "+result+" Status "+status);
                   DocumentReady();
               }
           });
        });
    }
</script>