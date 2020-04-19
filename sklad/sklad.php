<!-- WMS Warehouse Management System / Страница о материалах -->
<div class="WareHouse">

<!-- Доступ на страницу только после авторизации -->
<?php
	if(empty($_COOKIE['name'])){
    	header('Location:/Barmill_Portal/index.php');
    }
?>
<!-- Доступ на страницу только после авторизации -->

	<div class="WH_left_column">
   		<div class="material_main_panel">
  			<div class="material_img">
   				<img id="material_image" src="sklad/noimg.jpg">
   				<div id="material_name">Выберите материал из таблицы</div> <!-- Сюда выводить имя выбранного материала -->
			</div>
			
  		<!-- Навигационная панель под картинкой -->
   			<form class="material_navigation" action="">
   			<!-- Кнопка отображения каталога -->
  				<label for="mat_catalog_btn" class="material_nav_btn" title="Каталог">
  					<input type="checkbox" id="mat_catalog_btn" checked>1
				</label>
   			<!-- Кнопка отображения информации о материале -->
  				<label for="mat_info_btn" class="material_nav_btn" title="Информация">
   					<input type="checkbox" id="mat_info_btn" checked>2
					</label>
   			<!-- Кнопка отображения характеристики материала --> 
  				<label for="mat_spec_btn" class="material_nav_btn" title="Характеристики">
   					<input type="checkbox" id="mat_spec_btn">3
					</label>
   			<!-- Кнопка отображения графика перемещения материала -->
  				<label for="mat_chart_btn" class="material_nav_btn" title="График">
   					<input type="checkbox" id="mat_chart_btn">4
					</label>
   			<!-- Кнопка отображения таблицы перемещения материала --> 
  				<label for="mat_trans_btn" class="material_nav_btn" title="Перемещения">
   					<input type="checkbox" id="mat_trans_btn">5
					</label>
			</form>  			
   		</div>
   		<div class="material_info">
   			Здесь информация о min-max категории и другое
   		</div>
   		<div class="material_spec">
   			Здесь будет спецификация материала в зависимости от категории (мощность, кол-во оборотов, рабочее напряжение для электродвигателей; длина, количество жил, сечение для кабеля и т.д.)
   		</div>
   	</div>
	<div class="WH_right_column">
   		<div class="material_chart">
                <canvas id="myChart"></canvas>
   		</div>
		<div class="material_catalog" id="material_table">
		<!-- В данный блок интегрируется "tableGeneratorMaterials.php" посредством AJAX -->
		</div>
  		<div class="material_trans">
  			
  		</div>
   	</div>
</div>

<script type="text/javascript">

    var selRowNow;
    var selCatId =-1;
    var minQty = "";
    var sortType = "";
    $(document).ready(function(){
        StartDocument();
    });
    function DocumentReady(){
        select2.addEventListener("click", searchOzm);
        /*Инициализация кнопок для сортировки*/
        sortByName.addEventListener("click",function(){sortMats("name_mat");});
        sortByDate.addEventListener("click",function(){sortMats("mat_date");});
        sortByCatName.addEventListener("click",function(){sortMats("nameC");});
        sortByQty.addEventListener("click",function(){sortMats("qty");});
        sortByOZM.addEventListener("click",function(){sortMats("ozm");});
        resetSort.addEventListener("click",resetFiltr);
        
        // Управление отображением плитки с каталогом (таблица материалов)
        var catalog = document.querySelector('.material_catalog');
        mat_catalog_btn.addEventListener("change",function(){displayBlockOrNone(mat_catalog_btn,catalog);});
        // Управление отображением плитки с информацией о материале
        var info = document.querySelector('.material_info');
        mat_info_btn.addEventListener("change",function(){displayBlockOrNone(mat_info_btn,info);});
        // Управление отображением плитки с характеристиками материала
        var spec = document.querySelector('.material_spec');
        mat_spec_btn.addEventListener("change",function(){displayBlockOrNone(mat_spec_btn,spec);});
        // Управление отображением плитки с графиком
        var material_chart = document.querySelector('.material_chart');
        mat_chart_btn.addEventListener("change",function(){displayBlockOrNone(mat_chart_btn,material_chart);});
        // Управление отображением плитки с информацией о перемещении материала
        var trans = document.querySelector('.material_trans');
        mat_trans_btn.addEventListener("change",function(){displayBlockOrNone(mat_trans_btn,trans);});
    }
	//Здесь функция скрытие/открытие плиток кнопками навигационной панели под картинкой
    function displayBlockOrNone(_btn,_block){
  			if (_btn.checked) {
    			_block.style.display = 'block';
  			} else {
    			_block.style.display = 'none';
  			}
    }
    /*Сортировка*/
    function sortMats(sortName){
        if (sortType.search("desc") != -1) {//слово не найдено
            sortType = sortName;
        }else{
            sortType = sortName+" desc";
        }
           $.ajax({
               type: "POST",
               url: "sklad/tableGeneratorMaterials.php",
               data: {sort:sortType, categor:selCatId, minQty:minQty},
               success: function(result,status,xhr){
                   $( "#material_table" ).html( result );
                   DocumentReady();
               }
           });
    }
    /*Поис по ОЗМ*/
    function searchOzmEnter(e){
        if (e.keyCode === 13) {
            searchOzm();
        }
    }
    function searchOzm(){
            var searchMat = document.querySelector('#lname').value;
            if(searchMat.length>9 || searchMat.length<3)
                return;
            $.ajax({
                   type: "POST",
                   url: "sklad/tableGeneratorMaterials.php",
                   data: {searchOzm:searchMat},
                   success: function(result,status,xhr){
                       $( "#material_table" ).html( result );
                       DocumentReady();
                   }
            });
    }
    /*Функция запускается при прогрузке страницы*/
    function StartDocument(){
        $.ajax({
            type: "POST",
            url: "sklad/tableGeneratorMaterials.php",
            data: {categor:-1, searchName:"", minQty:""},
            success: function(result,status,xhr){
            $( "#material_table" ).html( result );
                console.log("Success "+result+" Status "+status);
                DocumentReady();
            },
            error: function(e){
                console.log("Error "+e);
            }
        });
        
    }
    /*Выбор материала в таблице*/
    function selectTd(e){
		// ?? элементов с классом .itemNameTD я не нашел !!
        var selNameMat = e.querySelector('.itemNameTD').innerHTML;
        var imgMat = document.getElementById("material_image");
        
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'infoMatGrafic', nameMat:selNameMat},
               success: function(result){
                   createGrafik(result);
                   DocumentReady();
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
        
        selRowNow = selNameMat;
    }
	
    /*Рисуем график*/
    function createGrafik(selMatInfo){
        var infoMat = selMatInfo;
        var ctx = document.querySelector('#myChart');
        var chart    = document.getElementById('myChart').getContext('2d'),
    		gradientSpisanie = chart.createLinearGradient(0, 0, 0, 450),
    		gradientVnesenie = chart.createLinearGradient(0, 0, 0, 450),
    		gradientQty = chart.createLinearGradient(0, 0, 0, 450);
		gradientSpisanie.addColorStop(0, 'rgba(55, 178, 255, 0.5)');
		gradientSpisanie.addColorStop(0.5, 'rgba(55, 178, 255, 0.2)');
		gradientSpisanie.addColorStop(1, 'rgba(55, 178, 255, 0)');
		
		gradientVnesenie.addColorStop(0, 'rgba(40, 41, 51, 0.5)');
		gradientVnesenie.addColorStop(0.5, 'rgba(40, 41, 51, 0.2)');
		gradientVnesenie.addColorStop(1, 'rgba(40, 41, 51, 0)');
		
		gradientQty.addColorStop(0, 'rgba(255, 0,0, 0.5)');
		gradientQty.addColorStop(0.5, 'rgba(255, 0, 0, 0.2)');
		gradientQty.addColorStop(1, 'rgba(255, 0, 0, 0.2)');
		
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
		
        var dataQty = {
            	label: "Наличие",
				backgroundColor: gradientQty,
				pointBackgroundColor: 'white',
				borderWidth: 1,
          		borderColor: '#ff4f4f',			
//            	lineTension: 0.3,
//            	fill: false,
            	data: _qty,
          		};

        var dataSpisanie = {
            	label: "Списание",
				backgroundColor: gradientSpisanie,
				pointBackgroundColor: 'white',
				borderWidth: 1,			
            	borderColor: '#37b2ff',
//            	lineTension: 0.3,
//            	fill: false,
            	data: _qtyS,
          		};
		
        var dataVnesenie = {
            	label: "Внесение",
				backgroundColor: gradientVnesenie,
				pointBackgroundColor: 'white',
				borderWidth: 1,			
          		borderColor: '#282933',
//            	lineTension: 0.3,
//            	fill: false,
            	data: _qtyV,
          		};
		
        var allData = {
          		labels: _date,
          		datasets: [dataQty, dataSpisanie, dataVnesenie]
        		};

        var chartOptions = {
            	responsive: true,
            	maintainAspectRatio: false,
			
				animation: {				
					easing: 'easeInOutQuad',
					duration: 1000
					},
			
				horizontalLine: [{
                    y: _max[0],
                    text: _max[0] //Сюда нужно подвязать данные из БД
                    },{
                    y: _min[0],
                    style: "rgba(255, 0, 0, .4)",
                    text: _min[0] //Сюда нужно подвязать данные из БД
                    }],
			
				elements: {
					line: {
						tension: 0.4
						}
					},
			
          		legend: {
            		//display: true,
            		position: 'top',            
					labels: {
              			boxWidth: 15,
              			fontColor: '#6c7279',
						fontFamily: 'Roboto',
						fontSize: 14
            			}
          			},			
			
          		scales: {
            		yAxes: [{
                		ticks: {
							fontColor: '#6c7279',
							fontFamily: 'Roboto',
                    		suggestedMin: _min[0],
                    		suggestedMax: _max[0],
//							maxTicksLimit: 1,
                    		display: true
                			},
                		gridLines: {
                    		color: 'rgba(200, 200, 200, 0.08)',
							lineWidth: 1
                			},
                		scaleLabel: {
                    		display: true,
              				fontColor: '#6c7279',
							fontFamily: 'Roboto',
                    		labelString: "Количество",
                  			}
            			}],
            		xAxes: [{
                		ticks: {
              				fontColor: '#6c7279',
							fontFamily: 'Roboto',							
                    		display: true
                			},
                		gridLines: {
                			color: "rgba(200, 200, 200, 0.05)",
							lineWidth: 1
            				},
            			}]
        			},
			
				point: {
					backgroundColor: 'white'
					},
			
				tooltips: {
					titleFontFamily: 'Open Sans',
					backgroundColor: 'rgba(0,0,0,0.3)',
					titleFontColor: 'red',
					caretSize: 5,
					cornerRadius: 2,
					xPadding: 10,
					yPadding: 10
					}			
        		};
		
		var horizonalLinePlugin = {
                afterDraw: function (chartInstance) {
                    var yScale = chartInstance.scales["y-axis-0"];
                    var canvas = chartInstance.chart;
                    var ctx = canvas.ctx;
                    var index;
                    var line;
                    var style;
					var labelSize;

                    if (chartInstance.options.horizontalLine) {
                        for (index = 0; index < chartInstance.options.horizontalLine.length; index++) {
                            line = chartInstance.options.horizontalLine[index];

                            if (!line.style) {
                                style = "rgba(169,169,169, .6)";
                            } else {
                                style = line.style;
                            }

                            if (line.y) {
                                yValue = yScale.getPixelForValue(line.y);
                            } else {
                                yValue = 0;
                            }

                            ctx.lineWidth = 1;

                            if (yValue) {
          						ctx.beginPath();
          						ctx.moveTo(yScale.width, yValue);
          						ctx.lineTo(canvas.width-35, yValue);
          						ctx.strokeStyle = style;
          						ctx.stroke();
        						}
          
          					if (chartInstance.options.scales.yAxes[0].ticks.fontSize != undefined){
              					labelSize = parseInt(chartInstance.options.scales.yAxes[0].ticks.fontSize);
          					} else {
          					    labelSize = parseInt(chartInstance.config.options.defaultFontSize);
          					}

        					if (line.text) {
          					ctx.fillStyle = style;
          					ctx.textBaseline = 'hanging'; //<-- set this
          					ctx.fillText(line.text, 70, yValue-labelSize-4);
        					}
                        }
                        return;
                    };
                }
            };
            Chart.pluginService.register(horizonalLinePlugin);
        
        var lineChart = new Chart(ctx, {
          		type: 'line',
          		data: allData,
          		options: chartOptions
        		});
    	}
	
    /*Применение выбираемой категории полю с id*/
    function SelectCat(){
        selCatId = document.querySelector('input[name=ListCat]:checked').value;
        $(document).ready(function(){
           $.ajax({
               type: "POST",
               url: "sklad/tableGeneratorMaterials.php",
               data: {sort:sortType,categor:selCatId, minQty:minQty},
               success: function(result,status,xhr){
                   $( "#material_table" ).html( result );
                   DocumentReady();
               }
           });
        });
    }
    /*Выбор отображения по количеству*/
    function SelectQty(){
        minQty = document.querySelector('input[name=ListQty]:checked').value;
        $(document).ready(function(){
           $.ajax({
               type: "POST",
               url: "sklad/tableGeneratorMaterials.php",
               data: {sort:sortType,categor:selCatId, minQty:minQty},
               success: function(result,status,xhr){
                   $( "#material_table" ).html( result );
                   console.log("Success "+result+" Status "+status);
                   DocumentReady();
               }
           });
        });
    }
    /*Сброс фильтра*/
    function resetFiltr(){
        selCatId =-1;
        minQty = "";
        sortType = "";
           $.ajax({
               type: "POST",
               url: "sklad/tableGeneratorMaterials.php",
               data: {searchOzm:"",sort:sortType,categor:selCatId, minQty:minQty},
               success: function(result,status,xhr){
                   $( "#material_table" ).html( result );
                   console.log("Success "+result+" Status "+status);
                   DocumentReady();
               }
           });
    }
</script>
