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
   		<!-- Навигационная панель под картинкой -->
   			<form class="material_navigation" action="">
   			<!-- Кнопка отображения каталога -->
  				<label for="catalog_chkBox" id="catalog_btn" class="material_nav_btn openTab">
  					<input type="checkbox" id="catalog_chkBox" checked>
  					<?php	require "sklad/sys_img/catalog1.svg";?>
				</label>
   			<!-- Кнопка отображения информации о материале -->
  				<label for="info_chkBox" id="info_btn" class="material_nav_btn openTab">
   					<input type="checkbox" id="info_chkBox" checked>
  					<?php	require "sklad/sys_img/info1.svg";?>
					</label>
   			<!-- Кнопка отображения характеристики материала --> 
  				<label for="spec_chkBox" id="spec_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="spec_chkBox" disabled>
  					<?php	require "sklad/sys_img/spec.svg";?>
					</label>
   			<!-- Кнопка отображения графика перемещения материала -->
  				<label for="chart_chkBox" id="chart_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="chart_chkBox" disabled>
  					<?php	require "sklad/sys_img/chart1.svg";?>
					</label>
   			<!-- Кнопка отображения таблицы перемещения материала --> 
  				<label for="trans_chkBox" id="trans_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="trans_chkBox" disabled>
  					<?php	require "sklad/sys_img/trans1.svg";?>
					</label>
			</form>
  			
  			<div class="material_img">
   				<img id="material_image" src="sklad/sys_img/noimg.jpg">
   				<div id="material_name">
   					Выберите материал из таблицы
   				</div> <!-- Сюда выводить имя выбранного материала -->
			</div>  		  			
   		</div>
   		<div class="material_info">
   				Здесь информация о min-max категории и другое
   		</div>
   		<div class="material_spec slide hidden">
   				Здесь будет спецификация материала в зависимости от категории (мощность, кол-во оборотов, рабочее напряжение для электродвигателей; длина, количество жил, сечение для кабеля и т.д.)
   		</div>
   	</div>
	<div class="WH_right_column">
   		<div id="myChartParent" class="material_chart slide hidden">
                <canvas id="myChart"></canvas>
   		</div>
  		<div class="material_trans slide hidden" id="transactions_table">
  		<!-- В данный блок интегрируется "selectedMaterial.php" посредством AJAX -->
  		</div>
		<div class="material_catalog" id="material_table">
		<!-- В данный блок интегрируется "tableGeneratorMaterials.php" посредством AJAX -->
		</div>
   	</div>
</div>

<script type="text/javascript">
    var selRowNow;
    var selCatId =-1;
    var minQty = "";
    var sortType = "";
    var matInfoForGrafic;
    
    $(document).ready(function(){
        StartDocument();
    });
    function DocumentReady(){
        close_all_sidebar();
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
        var catalog_btn = document.getElementById('catalog_btn');
        catalog_chkBox.addEventListener("change",function(){displayBlockOrNone(catalog_btn,catalog,this);});
        // Управление отображением плитки с информацией о материале
        var info = document.querySelector('.material_info');
        var info_btn = document.getElementById('info_btn');
        info_chkBox.addEventListener("change",function(){displayBlockOrNone(info_btn,info,this);});
        // Управление отображением плитки с характеристиками материала
        var spec = document.querySelector('.material_spec');
        var spec_btn = document.getElementById('spec_btn');
        spec_chkBox.addEventListener("change",function(){displayBlockOrNone(spec_btn,spec,this);});
        // Управление отображением плитки с графиком
        var material_chart = document.querySelector('.material_chart');
        var material_chart_btn = document.getElementById('chart_btn');
        chart_chkBox.addEventListener("change",function(){displayBlockOrNone(material_chart_btn,material_chart,this);
            myChartParent.innerHTML = '<canvas id="myChart"></canvas>';
            if(this.checked)
                setTimeout(() => { createGrafik(matInfoForGrafic); }, 350);                             
        });
        // Управление отображением плитки с информацией о перемещении материала
        var trans = document.querySelector('.material_trans');
        var trans_btn = document.getElementById('trans_btn');
        trans_chkBox.addEventListener("change",function(){displayBlockOrNone(trans_btn,trans,this);});
        
        //
        filtrUnselectSelect(0);
        //
        if($('#material_table').hasScrollBar())
            material_table.style.margin = "0 8 0 0";
        //
        window.addEventListener("resize", displayWindowSize);
        displayWindowSize();
    }
    function filtrUnselectSelect(U_S){
        var allDropDowns = document.getElementsByClassName("filtr");
        for(var i=0;i<allDropDowns.length;i++){
            if(U_S==0){
                allDropDowns[i].addEventListener("click",function(){this.classList.add('selected');});
            }else{
                allDropDowns[i].classList.remove('selected');
            }
        }


    }
    function displayWindowSize(){
        let rootCss = document.documentElement;
        var heightMatTable = document.querySelector('#material_table').offsetHeight;
        rootCss.style.setProperty('--transAnim', (heightMatTable/1.5)+"ms");
    }
	//Здесь функция скрытие/открытие плиток кнопками навигационной панели под картинкой
    function displayBlockOrNone(_btn,_block,_chk){
  			if (_chk.checked) {
    			 _block.classList.remove ('hidden');
				setTimeout(function () {
      				_block.classList.remove('slide');
    				}, 
					20);
                 _btn.classList.add ('openTab');
			     _btn.classList.remove ('closeTab');
  			} else {
    			_block.classList.add ('slide');
				_block.addEventListener('transitionend', function(e) {
      				_block.classList.add('hidden');
   				 	}, {
     				 capture: false,
    				  once: true,
     				 passive: false
    				});
				_btn.classList.remove ('openTab');
				_btn.classList.add ('closeTab');
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
                   matInfoForGrafic = result;
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
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'CreateTableTransaction', nameMat:selNameMat},
               success: function(result){
                   $( "#transactions_table" ).html( result );
               }
           });
        trans_chkBox.disabled  = false;
        chart_chkBox.disabled  = false;
        spec_chkBox.disabled  = false;
        selRowNow = selNameMat;
    }
    
    /*Рисуем график*/
    function createGrafik(selMatInfo){
        myChartParent.innerHTML = '<canvas id="myChart"></canvas>';
        
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
            	data: _qty,
          		};

        var dataSpisanie = {
            	label: "Списание",
				backgroundColor: gradientSpisanie,
				pointBackgroundColor: 'white',
				borderWidth: 1,			
            	borderColor: '#37b2ff',
            	data: _qtyS,
          		};
		
        var dataVnesenie = {
            	label: "Внесение",
				backgroundColor: gradientVnesenie,
				pointBackgroundColor: 'white',
				borderWidth: 1,			
          		borderColor: '#282933',
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
                    text: "Макс "+_max[0] //данные из БД
                    },{
                    y: _min[0],
                    style: "rgba(255, 0, 0, .4)",
                    text: "Мин "+_min[0] //данные из БД
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
    function SelectCat(id){
        //selCatId = id;
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
    function SelectQty(id){
        minQty = id;
        //minQty = document.querySelector('input[name=ListQty]:checked').value;
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
