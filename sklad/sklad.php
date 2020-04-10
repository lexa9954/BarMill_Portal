<div class="WareHouse">
   	<div class="Details">
   		<div class="material_data">
   			<div class="material_img">
   				<img id="imgMatId" class="img_mat" src="sklad/img/587687.jpg">
   			</div>
   			<div class="material_info">
   				Здесь информация о min-max категории и другое
   			</div>
   		</div>
   		<div class="material_chart">
            <div class="chartWrapper">
                <div class="chartAreaWrapper">
                    <canvas id="myChart"></canvas>
                </div>
                <canvas id="myChartAxis"></canvas>
            </div>
   		</div>
   	</div>
	<div class="MatBar" id="MatBarId"> <!-- Предлагаю переименовать в "material_table" -->
	<!-- В данный блок интегрируется "tableGeneratorMaterials.php" посредством AJAX -->
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        StartDocument();
    });
    /*Функция запускается при прогрузке страницы*/
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
    /*Выбор материала в таблице*/
    function selectTd(e){
        var selNameMat = e.querySelector('.itemNameTD').innerHTML;
        var imgMat = document.getElementById("imgMatId");
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'infoMatGrafic', nameMat:selNameMat},
               success: function(result){
                   createGrafik(result);
               }
           });
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'imgSelMat', nameMat:selNameMat},
               success: function(result){
                   if(result != "")
                    imgMat.src = "sklad/img/"+result+".jpg";
                   else
                    imgMat.src = "img/error_pictures/noImg.jpg";
               }
           });
    }
    /*Рисуем график*/
    function createGrafik(selMatInfo){
        var infoMat = selMatInfo;
        var ctx = document.querySelector('#myChart');
        
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
</script>
