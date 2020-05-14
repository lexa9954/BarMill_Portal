<div style="display:grid">
    <label>1) Инвентарный №
        <input type="text" id="inv_num_field"/>
    </label>
    <label>2) ОЗМ
        <input type="text" id="ozm_num_field"/>
    </label>
    <label>3) Наименование
        <input type="text" id="name_mat_field"/>
    </label>
    <label>4) Тип двигателя
        <input type="text" id="type_engine_field"/>
    </label>
    <label>5) Мощность двигателя
        <input type="text" id="power_engine_field"/>
    </label>
    
    <div class="filtr" onclick="show_overlay()">
        <label>6) Статус:  </label>
        <label id="statusId"></label>
        <label id="statusLabel"></label>
        
        <div class="items" style="position: inherit;">
            <?php include "categoriesGenerator.php";  GenerateStatus();?>
        </div>
    </div>
    
    <div class="filtr" onclick="show_overlay()">
        <label>7) Место нахождение:  </label>
        <label id="metoNahId"></label>
        <label id="metoNahLabel"></label>
        
        <div class="items" style="position: inherit;" id="mestoNah"></div>
    </div>
    
    <label>
    <div class="filtr" onclick="show_overlay()">
        <label>8) Подробное место:  </label>
        <label id="mestoMoreId"></label>
        <label id="mestoMoreLabel"></label>
        
        <div class="items" style="position: inherit;" id="mestoMore" ></div>
    </div>
        <input type="text" id="mestoMoreField" style="visibility: collapse;"/>
    </label>
        
    <div>
        <input type="button" onclick="AddMaterial();" value="Добавить"/>
    </div>
    
    <div id="progress"></div>
</div>

<script type="text/javascript">
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