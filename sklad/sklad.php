<div class="WareHouse">
   <div class="Details">
   		<div class="material_data">
   			<div class="material_img">
   				<img src="sklad/img/587687.jpg">
   			</div>
   			<div class="material_info">
   				Здесь информация о min-max категории и другое
   			</div>
   		</div>
   		<div class="material_chart">
   			<div><img src="sklad/img/chart.jpg"></div>
   		</div>
   </div>
      
   <div class="NavMat">
    
       <!--<div class="NavBar">
        <form method="post" action="http://localhost/Barmill_Portal/index.php?page=sklad">
            <!--Выбор типа отображения материалов*-- >
            <input type="number" id="selTypeId"/>
            <input type="button" onclick="ChangeMatItem(0)" value="a"/>
            <input type="button" onclick="ChangeMatItem(1)" value="b"/>
            <input type="button" onclick="ChangeMatItem(2)" value="c"/>
            <!--Меньше чем мин*-- >
            <label><input type="checkbox" id="MinQtyCB" name="minQty"/>Мин</label>
            <!--Поиск материалов*-- >
            <input type="text" name="searchMat" id="searchMatId"/>
            <input type="submit" name="searchMatsBut" value="Поиск"/>
        </form>
    </div> -->

<div class="MatBar" id="MatBarId">

</div>
</div>
</div>


<script type="text/javascript">
    var item_type = sessionStorage.getItem("typeItem");
    var minCB = document.getElementById("MinQtyCB");
    var mat_date = new Array()
    var selectedMaterialRow;
    
    $(document).ready(function(){
        StartDocument();
    });
    function StartDocument(){
        $.ajax({
            type: "POST",
            url: "sklad/tableGeneratorMaterials.php",
            data: {categor:-1, searchName:"", minQty:""},
            success: function(result,status,xhr){
            $( "#MatBarId" ).html( result );
                console.log("Success "+result+" Status "+status);
            },
            error: function(e){
                console.log("Error "+e);
            }
        });
    }
    
    start();
    
    minCB.onclick = function(){
        localStorage.setItem("MinQtyB",minCB.checked);
    }
    
    function start(){
        minCB.checked = JSON.parse(localStorage.getItem("MinQtyB"));
        getItemType();
    }
    
    /*Выбор типа отображения материалов с куков*/
    function getItemType(){
        if(item_type ==""){
            ChangeMatItem(0);
        }else{
            ChangeMatItem(parseInt(item_type));
        }   
    }

    /*Выбор материала в таблице*/
    function selectTd(e){
        var tableItems = document.getElementById('containerItems').children;
        var childIndex;
        
        if(selectedMaterialRow !=null){
            selectedMaterialRow.className = sessionStorage.getItem("selectMaterialRowClass");
        }
        
        for(var i=0;i<tableItems.length;i++){
            if(tableItems[i].className == "openedItemClose" || tableItems[i].className == "openedItemOpen"){
                tableItems[i].className = "openedItemClose";
            }
            if(e == tableItems[i]){
                childIndex = i;
            }
        }
        
        if(tableItems[childIndex+1].className == "openedItemClose"){
           tableItems[childIndex+1].className = "openedItemOpen";
        }else if(tableItems[childIndex+1].className == "openedItemOpen"){
           tableItems[childIndex+1].className = "openedItemClose";
        }
        sessionStorage.setItem("selectMaterialRowClass",e.className);
        
        e.className ="selectedMaterialRow";
        //alert(e.querySelector('.itemNameTD').innerHTML);
        
        createGrafik(tableItems[childIndex+1]);
        selectedMaterialRow = e;
    }
    /*Рисуем график*/
    function createGrafik(_parent){
        var infoMat = _parent.querySelector('#matInfo').innerHTML;
        var ctx = _parent.querySelector('#myChart');
        
        var res = infoMat.split(";");
        
        var _sod =new Array();
        var _date = new Array();
        var _qty =  new Array();
        var qtyNow = 0;
        var _qtyS = new Array();
        var _qtyV = new Array();
        var _min= new Array();
        var _max= new Array();
        
        
        for(var i=0;i<res.length-1;i++){
            _sod.push(res[i].split(" ")[0]);
            _date.push(res[i].split(" ")[1]);
            if(_sod[i]==0){
               _qtyS.push(res[i].split(" ")[2]);
                _qtyV.push(0);
                qtyNow -=Number(res[i].split(" ")[2]);
            }else{
                _qtyS.push(0);
               _qtyV.push(res[i].split(" ")[2]);
                qtyNow +=Number(res[i].split(" ")[2]);
            }
            _qty.push(qtyNow);
            _min.push(res[i].split(" ")[3]);
            _max.push(res[i].split(" ")[4]);
        }
        
        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 14;

        var dataSpisanie = {
            label: "Списание",
            data: _qtyS,
            lineTension: 0.3,
            fill: false,
            borderColor: '#FF7373'
          };
        var dataVnesenie = {
            label: "Внесение",
            data: _qtyV,
            lineTension: 0.3,
            fill: false,
          borderColor: '#5CCCCC'
          };
        var dataQty = {
            label: "Остаток",
            data: _qty,
            lineTension: 0.3,
            fill: false,
          borderColor: '#C9F76F'
          };

        var allData = {
          labels: _date,
          datasets: [dataSpisanie, dataVnesenie,dataQty]
        };

        var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
          legend: {
            //display: true,
            position: 'top',
            labels: {
              boxWidth: 15,
              fontColor: 'black'
            }
          },
          scales: {
            yAxes: [{
                ticks: {
                    suggestedMin: _min[0],
                    suggestedMax: _max[0],
                    display: false
                },
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                },
                scaleLabel: {
                    display: true,
                    labelString: "Количество",
                  }
            }],
            xAxes: [{
                gridLines: {
                color: "rgba(0, 0, 0, 0)",
            }
            }]
        }
        };
        
        var lineChart = new Chart(ctx, {
          type: 'line',
          data: allData,
          options: chartOptions
        });
    }
    
    function moreMaterialInfo(nameMat){
        console.log(nameMat);
        sessionStorage.setItem("selNameMat",nameMat);

        window.open('/Barmill_Portal/index.php?page=materialMore',nameMat);

    }
    
    /*Применение выбираемой категории полю с id*/
    function SelectCat(){
        var e = document.getElementById("selectCategorDD");
        var nameCategor = e.options[e.selectedIndex].value;
        var searchMat = "";
        var minQty = "";
        $(document).ready(function(){
           $.ajax({
               type: "POST",
               url: "sklad/tableGeneratorMaterials.php",
               data: {categor:nameCategor, searchName:searchMat, minQty:minQty},
               success: function(result,status,xhr){
                   $( "#MatBarId" ).html( result );
                   console.log("Success "+result+" Status "+status);
               },
               error: function(e){
                   console.log("Error "+e);
               }
           });
        });
    }
    /*Выбор стиля контейнера с материалами*/
    function ChangeMatItem(typeItem){
        sessionStorage.setItem("typeItem",typeItem);
        
        var table = document.getElementById("tableMats");
        var plitka_or_list = document.getElementById("mats_contID");
        plitka_or_list.style.display = "grid";
        //if(table != null)
            //table.parentNode.removeChild(table);
            
        var item_mat = document.querySelectorAll("#itemID");
        var item_cont = document.getElementById("mats_contID");
        switch(typeItem){
            case 0:
                item_cont.style.gridTemplateColumns="repeat(auto-fill,80%)";
                for(i=0;i<item_mat.length;i++){
                    item_mat[i].classList.replace('item_mat_plitka','item_mat_list');
                }
            break;
            case 1:
                item_cont.style.gridTemplateColumns="repeat(auto-fill,230px)";
                for(i=0;i<item_mat.length;i++){
                    item_mat[i].classList.replace('item_mat_list','item_mat_plitka');
                }
            break;
            case 2:
                plitka_or_list.style.display = "none";
                
                var container = document.getElementById("MatBarId");
                var div = document.createElement("div");
                var table = document.createElement("table");
                table.id = "tableMats";
                var tr1 = document.createElement("tr");

                var th1 = document.createElement("th");
                var th2 = document.createElement("th");
                var th3 = document.createElement("th");
                var th4 = document.createElement("th");
                
                th1.innerHTML = "ОЗМ";
                th2.innerHTML = "Наименование";
                th3.innerHTML = "Количество";
                th4.innerHTML = "Последнее поступление";
                
                tr1.appendChild(th1);
                tr1.appendChild(th2);
                tr1.appendChild(th3);
                tr1.appendChild(th4);
                table.appendChild(tr1);
                div.appendChild(table);
                
                var item_name = document.getElementsByClassName("name_mat");
                var item_ozm = document.getElementsByClassName("item_ozm");
                var item_qty = document.getElementsByClassName("item_count");
                var item_lastDate = document.getElementsByClassName("item_date");
                
                for(i=0;i<item_mat.length;i++){
                    var tr = document.createElement("tr");
                    var itemName = document.createElement("td");
                    var itemOzm = document.createElement("td");
                    var itemQty = document.createElement("td");
                    var itemLastDate = document.createElement("td");
                    
                    itemName.innerHTML = item_name[i].innerHTML;
                    itemOzm.innerHTML = item_ozm[i].innerHTML;
                    itemQty.innerHTML = item_qty[i].innerHTML;
                    itemLastDate.innerHTML = item_lastDate[i].innerHTML;
                    
                    tr.onclick = function(){
                        pressItem(""+i); 
                    };
                    
                    itemName.className = "itemNameTD";
                    itemOzm.className = "itemOzmTD";
                    itemQty.className = "itemQtyTD";
                    itemLastDate.className = "itemLD_TD";
                    
                    tr.appendChild(itemOzm);
                    tr.appendChild(itemName);
                    tr.appendChild(itemQty);
                    tr.appendChild(itemLastDate);
                    table.appendChild(tr);
                }
                container.appendChild(table);
            break;
        }
        
    }
       
    /*Запись и чтение с куков*/
    function setCookie(cname,cvalue){
        document.cookie = cname+"="+cvalue+";";
    }
    function getCookie(cname){
        var name = cname+"=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i =0;i<ca.length;i++){
            var c = ca[i];
            while(c.charAt[0]==''){
                c = c.substring(1);
            }
            if(c.indexOf(name)==0)
                return c.substring(name.length,c.length);
        }
        return "";
    }
</script>
