<!--
<div class="MaterialPage">
    <div class="barMaterial">
        <Label id="nameMat" class="preview">Материал</Label>
        <div class="containerIconAndGraf">
            <div >
                <img id="matIcon" class="img_mat" src="sklad/img",$row['ozm'],".jpg" onerror="this.onerror=null;this.src='img/error_pictures/noImg.jpg';">
                <input type="button" value="Изменить"/>
            </div>
            <div class="chartWrapper">
                <div class="chartAreaWrapper">
                    <canvas id="myChart"></canvas>
                </div>
                <canvas id="myChartAxis" height="200" width="0"></canvas>
            </div>
        </div>
    </div>
    <div id="matInfo" class="notVisibleElements">
        
    </div>
</div>

<script>
var nameMat = document.querySelector("#nameMat").innerHTML = sessionStorage.getItem("selNameMat");
           $.ajax({
               type: "POST",
               url: "sklad/materialVariables.php",
               data: {nameMat:nameMat},
               success: function(result,status,xhr){
                   $( "#matInfo" ).html( result );
                   console.log("Success "+result+" Status "+status);
               },
               error: function(e){
                   console.log("Error "+e);
               }
           });
    
    $(document).ready(function() {
        createGrafik();
    });
    
function createGrafik(){
    
        var infoMat = document.querySelector('#matInfo').innerHTML;
        while(infoMat.length ==0)
            infoMat = document.querySelector('#matInfo').innerHTML;
    
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
</script>
-->