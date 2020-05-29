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
    var createNewMaterialBool;//создаётся ли новый материал
    var createNewCategorBool;//создаётся ли новая категория
    var statusId = -1;//статус текущего материала
    var mestoNahId = -1;//место нахождения материала
    var mestoMoreId = -1;//
    
    var matObjectCreate;//если создаётся обьект материала
    
    var readyForAdd; //готов ли материал к добавлению
    
    
    Start();
    
    function Start(){
        switch(pageUrl){
            case "http://localhost/BarMill_Portal/index.php?page=AllMaterials":
                selectCategor.style.display = "grid";
            break;
            case "http://localhost/BarMill_Portal/index.php?page=AllEngines":
                SelectCategorCreatorPanel(5018);
            break;
        }
    }
    
    function SelectCategorCreatorPanel(id){
            //Фильтр по озмoo
            $.ajax({
               type: "POST",
               url: "sklad/categoriesGenerator.php",
               data: {action:"generateMaterials",_idCategor:id,_typeColumn:"ozm"},
               success: function(result,status,xhr){
                   $( "#ozmCreatorPanel" ).html( result );
                   close_all_sidebar();
               }
           });
            //Фильтр по наименованию
            $.ajax({
               type: "POST",
               url: "sklad/categoriesGenerator.php",
               data: {action:"generateMaterials",_idCategor:id,_typeColumn:"name_mat"},
               success: function(result,status,xhr){
                   $( "#nameCreatorPanel" ).html( result );
                   close_all_sidebar();
               }
           });
        //поля для отображения выбранной категории
        var categorLabel = document.getElementById("catSel");
        var categorSelect = document.getElementById("categorCreatorPanel_"+id);
        
        //СБРОС
        paremsAllMats.style.display = "none";
        selectMaterial.style.display = "none";
        paramsCreatedMaterial.style.display = "none";
        matObjectCreate = false;
        
        //если категория соответсвует созданию нового обьекта
        switch(id){
            case 5018:
                matObjectCreate = true;
            break;
        }
        
        //если нажимаем новая категория
        createNewCategorBool =id==-1;
        if(id==-1){
            alert("Функция по добавлению категорий находится в разработке!");
            categorLabel.innerHTML = "";
        }
        else{//если нажимаем выбираем любую категорию
            selectMaterial.style.display = "grid";
            var categorLabel = document.getElementById("catSel");
            var categorSelect = document.getElementById("categorCreatorPanel_"+id);
            categorLabel.innerHTML = categorSelect.innerHTML;
        }
    }
    function SelectMatrialCreatorPanel(id){
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:"QueryGetValues",_idMat:id},
               success: function(result,status,xhr){
                   close_all_sidebar();
                    var matOzmLabel = document.getElementById("ozmSel");
                   var matNameLabel = document.getElementById("nameSel");
                    var matOzmSelect = document.getElementById("ozm_"+id);
                   var matNameSelect = document.getElementById("name_mat_"+id);
                    matOzmLabel.innerHTML = matOzmSelect.innerHTML;
                   matNameLabel.innerHTML = matNameSelect.innerHTML;
                   
                   //alert(result);
                   //Сброс
                   paremsAllMats.style.display = "none";
                   paramsCreatedMaterial.style.display = "none";
                   statusCreatedMaterial.style.display = "none";
                   paramsEngine.style.display = "none";
                   paramsAllObj.style.display = "none";
                   
                   createNewMaterialBool = id == -1;
                    if(id == -1){//если нажимаем на новый материал
                        paremsAllMats.style.display = "grid";
                        if(matObjectCreate){
                            paramsEngine.style.display = "grid";
                            paramsAllObj.style.display = "grid";
                        }else{
                            paramsCreatedMaterial.style.display = "grid";
                        }
                    }else{//если выбираем материал
                        if(matObjectCreate){
                            paramsAllObj.style.display = "grid";
                        }else{
                            paramsCreatedMaterial.style.display = "grid";
                        }
                    }
                   statusCreatedMaterial.style.display = "grid";
               }
           });
    }
    
    function SelectStatus(id){
        statusId = id;
        var statusSelect = document.getElementById("status_"+id);
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
        mestoNahId = idMesto;
        var mestoNahSelect = document.getElementById("mestoNah_"+idMesto);
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
        mestoMoreId = id;
        var mestoMoreSelect = document.getElementById("mestoMore_"+id);
        mestoMoreLabel.innerHTML = mestoMoreSelect.innerHTML;
        if(statusId == 1)
            mestoMoreField.style.display = "grid";
        else
            mestoMoreField.style.display = "none";
        close_all_sidebar();
        
        addButton.style.display = "grid";
    }
    
    function AddMaterial(){
        //Поля для добавления обьекта материала
        var inv_num = document.getElementById("inv_num_field").value;
        var serial_num = document.getElementById("serial_num_field").value;
        
        //поля для создания материала
        var ozm = document.getElementById("ozm_num_field").value;
        var name_mat = document.getElementById("name_mat_field").value;
        var min = document.getElementById("min_mat_field").value;
        var max = document.getElementById("max_mat_field").value;
        
        //поля для создания нового двигателя
        var type_engine = document.getElementById("type_engine_field").value;
        var power_engine = document.getElementById("power_engine_field").value;
        
        //поля для добавления материала
        var qty = document.getElementById("qty_mat_field").value;

        //если создаётся новый материала
        if(createNewMaterialBool){
            //проверка полей ввода
            if(ozm.length == 0 && name_mat.length == 0 && min.length == 0 && max.length == 0){
                alert("Проверте правильность введенных полей");
                return;
            }
            //Создание класса материала
             $.ajax({
               type: "POST",
               url: "sklad/creatorMaterial.php",
               data: {_typeCreate:"CreateNewMaterial", _ozm:ozm,_name_mat:name_mat,_min:min,_max:max},
               success: function(result,status,xhr){
                   if(matObjectCreate){//если создаётся обьект материала
                       //проверка полей ввода
                       if(inv_num.length == 0 && serial_num.length == 0 && type_engine.length == 0 && power_engine.length == 0){
                           alert("Проверте правильность введенных полей");
                           return;
                       }
                       
                       //Создание нового двигателя  
                       CreateObjectEngine(result,inv_num,serial_num,type_engine,power_engine);
                    }else{
                        //проверка полей ввода
                        if(qty.length == 0){
                           alert("Проверте правильность введенных полей");
                           return;
                        }
                    }
               }
            });
        }else{//Добавление материала
            if(matObjectCreate){//если создаётся обьект материала
                //проверка полей ввода
                if(inv_num.length == 0 && serial_num.length == 0){
                    alert("Проверте правильность введенных полей");
                    return;
                }
                
                var result = confirm("Вы действительно хотите добавить "+catSel.innerHTML+" Наименование "+nameSel.innerHTML);
                if(result){
                    AddObjectEngine(inv_num,serial_num);
                }
            }else{//если добавляется материал
                //проверка полей ввода
                if(qty.length == 0){
                    alert("Проверте правильность введенных полей");
                    return;
                }
                
                var result = confirm("Вы действительно хотите добавить "+catSel.innerHTML+" Наименование "+nameSel.innerHTML);
                if(result){
                    alert("Добавлен!");
                }
            }
        }
    }
    function CreateObjectEngine(id_mat,inv_num,serial_num,type_engine,power_engine){//Создание нового двигателя
        $.ajax({
               type: "POST",
               url: "sklad/creatorMaterial.php",
               data: {_typeCreate:"CreateObjectEngine",_inv_num:inv_num,_serial_num:serial_num,_type_engine:type_engine,_power_engine:power_engine},
               success: function(result,status,xhr){
                   alert("Добавлен!");
                   $( "#progress" ).html( result );
                   console.log("Success "+result+" Status "+status);
               }
        });
    }
               
    function AddObjectEngine(inv_num,serial_num){//добавление существующего двигателя
        $.ajax({
               type: "POST",
               url: "sklad/creatorMaterial.php",
               data: {_typeCreate:"AddObjectEngine",_inv_num:inv_num,_serial_num:serial_num},
               success: function(result,status,xhr){
                   alert("Добавлен!");
                   $( "#progress" ).html( result );
                   console.log("Success "+result+" Status "+status);
               }
        });
    }
               
               
               
</script>

    <!--Выбор категории-->
    <div>
        <div id="selectCategor" style="display: none;">
            <h1>Выбор категории</h1>
            <div class="filtr" onclick="show_overlay()">
            <label>Категория:  </label>
            <div class="items" style="position: inherit;" id="categoriesCreatorPanel">
                <?php
                    include "categoriesGenerator.php";
                    GenerateCategoriesFromValue($categorPage);
                ?>
            </div>
            <label class="labelSelectedFiltr" id="catSel"></label>
        </div>
        </div>
    
    <!--Фильтры для выбора материала по ОЗМ или наименованию-->
    <div id="selectMaterial" style="display: none;">
        <h1>Выбор материала</h1>
        <div class="filtr" onclick="show_overlay()">
            <label>ОЗМ:  </label>
            <div class="items" style="position: inherit;" id="ozmCreatorPanel">
            </div>
            <label class="labelSelectedFiltr" id="ozmSel"></label>
        </div>
        <div class="filtr" onclick="show_overlay()">
            <label>Наименование:  </label>
            <div class="items" style="position: inherit;" id="nameCreatorPanel">

            </div>
            <label class="labelSelectedFiltr" id="nameSel"></label>
        </div>
    </div>
    
    <!--Поля для создания нового класса материала-->
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
    
    <!--Поле с количеством (будт пооплняться возможно)-->
    <div id="paramsCreatedMaterial" style="display: none;">
        <h1>Основные данные для добавления созданного материала</h1>
        <label>Количестве
            <input type="text" id="qty_mat_field"/>
        </label>
    </div>
    
    <!--Поля для добавления нового двигателя-->
    <div id="paramsEngine" style="display: none;">
        <h1>Параметры для двигателя</h1>
        <label>Тип двигателя
            <input type="text" id="type_engine_field"/>
        </label>
        <label>Мощность двигателя
            <input type="text" id="power_engine_field"/>
        </label>
    </div>
    
    <!--Поля для добавления обьектов материала-->
    <div id="paramsAllObj" style="display: none;">
        <h1>Параметры для любых обьектов материала</h1>
        <label>Инвентарный №
            <input type="text" id="inv_num_field"/>
        </label>
        <label>Серийный №
            <input type="text" id="serial_num_field"/>
        </label>
    </div>
    
    <!--Выбор статуса материала-->
    <div id="statusCreatedMaterial" style="display: none;">
        <h1>Выбор статуса для материала</h1>   
        <div class="filtr" onclick="show_overlay()">
            <label>Статус:  </label>
            <label class="labelSelectedFiltr" id="statusLabel"></label>

            <div class="items" style="position: inherit;">
                <?php GenerateStatus();?>
            </div>
        </div>
        <div class="filtr" onclick="show_overlay()">
            <label>Место нахождение:  </label>
            <label class="labelSelectedFiltr" id="mestoNahLabel"></label>
            
            <div class="items" style="position: inherit;" id="mestoNah"></div>
        </div>
        <div>
            <div class="filtr" onclick="show_overlay()">
                <label>Подробное место:  </label>
                <label class="labelSelectedFiltr" id="mestoMoreLabel"></label>

                <div class="items" style="position: inherit;" id="mestoMore" ></div>
            </div>
            <input type="text" id="mestoMoreField" style="display: none;"/>
        </div>
    </div>
    
    <!--Кнопка добавления материала-->
    <div id="addButton" style="display: none;">
        <input type="button" onclick="AddMaterial();" value="Добавить"/>
    </div>
    
    <div id="progress"></div>
</div>

