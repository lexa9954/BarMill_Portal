<?php 
    $pageURL = "";
    $categorPage;
    if (!empty($_POST["page"]))
        $pageURL = $_POST['page'];
    switch($pageURL){
        case "http://localhost/BarMill_Portal/index.php?page=AllMaterials":
            $categorPage=0;
        break;
        case "http://localhost/BarMill_Portal/index.php?page=AllEngines":
            $categorPage=5018;
        break;
    }

    function categorDropDownCreate($categor){
        include "categoriesGenerator.php";
        GenerateCategoriesFromValues($categor);
    }
?>

<script type="text/javascript">
    function SelectCategorCreatorPanel(id){
            $.ajax({
               type: "POST",
               url: "sklad/categoriesGenerator.php",
               data: {action:"generateMaterials",_idCategor:id,_typeColumn:"ozm"},
               success: function(result,status,xhr){
                   $( "#ozmCreatorPanel" ).html( result );
                   close_all_sidebar();
               }
           });
            $.ajax({
               type: "POST",
               url: "sklad/categoriesGenerator.php",
               data: {action:"generateMaterials",_idCategor:id,_typeColumn:"name_mat"},
               success: function(result,status,xhr){
                   $( "#nameCreatorPanel" ).html( result );
                   close_all_sidebar();
               }
           });
        if(id!=-1)
            selectMaterial.style.display = "grid";
        else
            alert("Функция по добавлению категорий в прогрессе!");
    }
    function SelectMatrialCreatorPanel(id){
        
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:"QueryGetValues",_idMat:id},
               success: function(result,status,xhr){
                   //$( "#ozmCreatorPanel" ).html( result );
                   alert(result);
                   close_all_sidebar();
               }
           });
    }
    
    function SelectStatus(id){
        var statusId = document.getElementById("statusId");
        var statusLabel = document.getElementById("statusLabel");
        var statusSelect = document.getElementById("status_"+id);
        statusId.innerHTML = id;
        statusLabel.innerHTML = statusSelect.innerHTML;
            $.ajax({
               type: "POST",
               url: "sklad/categoriesGenerator.php",
               data: {action:"generateMestoNah",_idStatus:id},
               success: function(result,status,xhr){
                   $( "#mestoNah" ).html( result );
                   console.log("Success "+result+" Status "+status);
                   close_all_sidebar();
               }
           });

     }
    function SelectMestoNah(idStatus,idMesto){
        var mestoNahId = document.getElementById("metoNahId");
        var mestoNahLabel = document.getElementById("metoNahLabel");
        var mestoNahSelect = document.getElementById("mestoNah_"+idMesto);
        mestoNahId.innerHTML = idMesto;
        mestoNahLabel.innerHTML = mestoNahSelect.innerHTML;
            $.ajax({
               type: "POST",
               url: "sklad/categoriesGenerator.php",
               data: {action:"generateMestoMore",_idStatus:idStatus,_idMestoNah:idMesto},
               success: function(result,status,xhr){
                   $( "#mestoMore" ).html( result );
                   console.log("Success "+result+" Status "+status);
                   close_all_sidebar();
               }
           });
    }
    function SelectMestoMore(id){
        var statusId = document.getElementById("statusId").innerHTML;
        var mestoMoreId = document.getElementById("mestoMoreId");
        var mestoMoreLabel = document.getElementById("mestoMoreLabel");
        var mestoMoreSelect = document.getElementById("mestoMore_"+id);
        mestoMoreId.innerHTML = id;
        mestoMoreLabel.innerHTML = mestoMoreSelect.innerHTML;
        if(statusId == 1)
            mestoMoreField.style.visibility = "visible";
        close_all_sidebar();
    }
    
    function AddMaterial(){
        var inv_num = document.getElementById("inv_num_field").value;
        var ozm = document.getElementById("ozm_num_field").value;
        var name_mat = document.getElementById("name_mat_field").value;
        var type_engine = document.getElementById("type_engine_field").value;
        var power_engine = document.getElementById("power_engine_field").value;
        
        var idStatus = document.getElementById("statusId").innerHTML;
        var idMesto = document.getElementById("metoNahId").innerHTML;
        var idMestoMore = document.getElementById("mestoMoreId").innerHTML;
            $.ajax({
               type: "POST",
               url: "sklad/creatorMaterial.php",
               data: {action:"createMaterial",_idStatus:idStatus,_idMestoNah:idMesto,_idMestoMore:idMestoMore,_inv_num:inv_num,_ozm:ozm,_name_mat:name_mat,_type_engine:type_engine,_power_engine:power_engine},
               success: function(result,status,xhr){
                   $( "#progress" ).html( result );
                   console.log("Success "+result+" Status "+status);
               }
           });
    }
</script>

<div style="display:grid">
    
    <div>
        <h1>Выбор категории</h1>
        <div class="filtr" onclick="show_overlay()">
        <label>Категория:  </label>
        <div class="items" style="position: inherit;" id="categoriesCreatorPanel">
            <?php
                include "categoriesGenerator.php";
                GenerateCategoriesFromValue($categorPage);
            ?>
        </div>
    </div>
    </div>
    
    <div id="selectMaterial" style="display: none;">
        <h1>Выбор материала</h1>
        <div class="filtr" onclick="show_overlay()">
            <label>ОЗМ:  </label>
            <div class="items" style="position: inherit;" id="ozmCreatorPanel">

            </div>
        </div>
        <div class="filtr" onclick="show_overlay()">
            <label>Наименование:  </label>
            <div class="items" style="position: inherit;" id="nameCreatorPanel">

            </div>
        </div>
    </div>
    
    
    <div id="paremsAllMats" style="display: none;">
        <h1>Параметры для создания класса материалов</h1>
        <label>ОЗМ
            <input type="text" id="ozm_num_field"/>
        </label>
        <label>Наименование
            <input type="text" id="name_mat_field"/>
        </label>
        <label>Минимум
            <input type="text" id="min_mat_field"/>
        </label>
        <label>Максимум
            <input type="text" id="max_mat_field"/>
        </label>
        

    </div>
    
    <div id="paramsCreatedMaterial" style="display: none;">
        <h1>Основные данные для добавления созданного материала</h1>
        <label>Количестве
            <input type="text" id="name_mat_field"/>
        </label>
        
        <div class="filtr" onclick="show_overlay()">
            <label>Статус:  </label>
            <label id="statusId"></label>
            <label id="statusLabel"></label>

            <div class="items" style="position: inherit;">
                <?php GenerateStatus();?>
            </div>
        </div>
        <div class="filtr" onclick="show_overlay()">
            <label>Место нахождение:  </label>
            <label id="metoNahId"></label>
            <label id="metoNahLabel"></label>

            <div class="items" style="position: inherit;" id="mestoNah"></div>
        </div>
        <div>
            <div class="filtr" onclick="show_overlay()">
                <label>Подробное место:  </label>
                <label id="mestoMoreId"></label>
                <label id="mestoMoreLabel"></label>

                <div class="items" style="position: inherit;" id="mestoMore" ></div>
            </div>
            <input type="text" id="mestoMoreField" style="visibility: collapse;"/>
        </div>
    </div>
    
    <div id="paramsEngine" style="display: none;">
        <h1>Параметры для двигателя</h1>
        <label>Тип двигателя
            <input type="text" id="type_engine_field"/>
        </label>
        <label>Мощность двигателя
            <input type="text" id="power_engine_field"/>
        </label>
    </div>
    
    <div id="paramsAllObj" style="display: none;">
        <h1>Параметры для любых обьектов материала</h1>
        <label>Инвентарный №
            <input type="text" id="inv_num_field"/>
        </label>
        <label>Серийный №
            <input type="text" id="serial_num_field"/>
        </label>
    </div>
    
        
    <div>
        <input type="button" style="display: none;" onclick="AddMaterial();" value="Добавить"/>
    </div>
    
    <div id="progress"></div>
</div>

