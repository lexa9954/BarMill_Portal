<?php
	// WMS Warehouse Management System / Страница о материалах
?>
<div class="WareHouse">

<?php
	// Доступ на страницу только после авторизации
	if(empty($_COOKIE['name'])){
    	header('Location:/index.php');
    }
?>
<!-- Доступ на страницу только после авторизации -->

	<!-- Левая колонка с плитками -->
	<div class="WH_left_column">  		   		
   		<!-- Плитка с фотографией и навигационной панелью -->
   		<div class="material_main_panel">
   		<!-- Навигационная панель под картинкой -->
   			<form class="material_navigation" action="">
   			<!-- Кнопка отображения каталога -->
  				<label for="catalog_chkBox" id="catalog_btn" class="material_nav_btn openTab">
  					<input type="checkbox" id="catalog_chkBox" checked>
  					<?php	require "sklad/sys_img/catalog.svg";?>
				</label>
   			<!-- Кнопка отображения информации о материале -->
  				<label for="info_chkBox" id="info_btn" class="material_nav_btn openTab">
   					<input type="checkbox" id="info_chkBox" checked>
  					<?php	require "sklad/sys_img/info.svg";?>
					</label>
   			<!-- Кнопка отображения характеристики материала --> 
  				<label for="spec_chkBox" id="spec_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="spec_chkBox" disabled>
  					<?php	require "sklad/sys_img/spec.svg";?>
					</label>
   			<!-- Кнопка отображения графика перемещения материала -->
  				<label for="chart_chkBox" id="chart_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="chart_chkBox" disabled>
  					<?php	require "sklad/sys_img/chart.svg";?>
					</label>
   			<!-- Кнопка отображения таблицы перемещения материала --> 
  				<label for="trans_chkBox" id="trans_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="trans_chkBox" disabled>
  					<?php	require "sklad/sys_img/trans.svg";?>
					</label>
   			<!-- Кнопка добавления перемещения материала --> 
  				<label for="create_chkBox" id="create_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="create_chkBox">
  					<?php	require "sklad/sys_img/create.svg";?>
					</label>
   			<!-- Кнопка редактирования перемещения материала --> 
  				<label for="edit_chkBox" id="edit_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="edit_chkBox">
  					<?php	require "sklad/sys_img/edit.svg";?>
					</label>
			</form>
  			
  			<div class="material_img">
   				<img id="material_image" src="sklad/sys_img/noimg.jpg">
   				<div id="material_name">
   					Выберите материал из каталога
   				</div> <!-- Сюда выводить имя выбранного материала -->
			</div>  		  			
   		</div>
   		
   		<!-- Плитка с подробной информацией -->
   		<div class="bar" id="info">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/info.svg";?>
				</div>
				<div class="barTitle">Подробная информация</div>
				<div id="infoCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="infoContent">
   				Здесь информация о min-max категории и другое				
			</div>
   		</div>
   		
   		<!-- Плитка с характеристиками -->
   		<div class="bar slide hidden" id="spec">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/spec.svg";?>
				</div>
				<div class="barTitle">Характеристики</div>
				<div id="specCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="specContent">
   				Здесь будет спецификация материала в зависимости от категории (мощность, кол-во оборотов, рабочее напряжение для электродвигателей; длина, количество жил, сечение для кабеля и т.д.)
   			</div>
   		</div>
   	</div>
   	
   	<!-- Правая колонка с плитками -->
	<div class="WH_right_column" id="column_review">  		
   		<!-- Плитка с графиком -->
   		<div class="bar slide hidden" id="chart">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/chart.svg";?>
				</div>
				<div class="barTitle">График</div>
				<div id="chartCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="chartContent">
                <!--canvas id="myChart"></canvas-->
            </div>
   		</div>
   		
   		<!-- Плитка с транзакциями (инф. о перемещении материалов) -->
  		<div class="bar slide hidden" id="trans">
  			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/trans.svg";?>
				</div>
				<div class="barTitle">История перемещений</div>
				<div id="transCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="transContent">
  				<!-- В данный блок интегрируется "selectedMaterial.php" посредством AJAX -->			
			</div>
  		</div>
  		
  		<!-- Плитка с каталогом -->
		<div class="bar" id="catalog">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/catalog.svg";?>
				</div>
				<div class="barTitle">Каталог</div>
				<div id="catalogCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="catalogContent">
				<!-- В данный блок интегрируется "tableGeneratorMaterials.php" посредством AJAX -->		
			</div>
		</div>  	
   	</div>
   	
	<div class="WH_right_column column_hide" id="column_create">
	<!-- Плитка с созданием/добавлением -->
   		<div class="bar slide hidden" id="create">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/create.svg";?>
				</div>
				<div class="barTitle">Добавление / создание</div>
				<div id="creatorCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>		
				</div>
			</div>
			<div class="barContent" id="createContent">
                <!-- В данный блок интегрируется "createContent.php" посредством AJAX -->
            </div>
   		</div>
	</div>
   	
	<div class="WH_right_column column_hide" id="column_edit">
	<!-- Плитка с графиком -->
   		<div class="bar slide hidden" id="edit">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/edit.svg";?>
				</div>
				<div class="barTitle">Редактирование</div>
				<div id="editorCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>		
				</div>
			</div>
			<div class="barContent" id="ownContent">
                
            </div>
   		</div>
	</div>
</div>

<script type="text/javascript">
    var selCatId =-1;
    var minQty = "";
    var sortType = "";
    var searchMatOzm = "";
    var selRowNow;
    var matInfoForGrafic;
    var pageUrl ="";
    var imgMat;
    var allRightBlocks;
    
    $(document).ready(function(){
        StartDocument();
    });
    function DocumentReady(){
        close_all_sidebar();
        switch(pageUrl){
            case "http://10.21.186.101/index.php?page=AllMaterials":
                searchElementsAllMaterialsTable();
            break;
            case "http://10.21.186.101/index.php?page=AllEngines":
                //SelectEngines($selCategor,$searchOzm,$minQty,$sortMat);
            break;
        }
            
        searchPlitkiAndAddEvents();
        //
        filtrUnselectSelect("selected");
        //
        //DynamicMargin(containerItems,"columnDate");
        //
        window.addEventListener("resize", displayWindowSize);
        displayWindowSize();
    }
    //Поиск элементов в таблице всех материалов
    function searchElementsAllMaterialsTable(){
        select2.addEventListener("click", searchOzm);
        /*Инициализация кнопок для сортировки*/
        sortByName.addEventListener("click",function(){sortMats("name_mat");});
        sortByDate.addEventListener("click",function(){sortMats("mat_date");});
        sortByCatName.addEventListener("click",function(){sortMats("cg_name");});
        sortByQty.addEventListener("click",function(){sortMats("qty");});
        sortByOZM.addEventListener("click",function(){sortMats("ozm");});
        resetSort.addEventListener("click",resetFiltr);
    }
    //Поиск и применение действий для кнопок снизу картинки
    function searchPlitkiAndAddEvents(){
        allRightBlocks = document.getElementsByClassName("WH_right_column");
        // Управление отображением плитки с каталогом (таблица материалов)
        var catalog = document.getElementById('catalog');
        var catalog_btn = document.getElementById('catalog_btn');
        catalog_chkBox.addEventListener("change",function(){displayBlockOrNone(catalog_btn,catalog,this);});
        //закрытие панели с каталогом 
        catalogCloseId.addEventListener("click",function(){CloseBar(catalog_btn,catalog,catalog_chkBox);});
        
        // Управление отображением плитки с информацией о материале
        var info = document.getElementById('info');
        var info_btn = document.getElementById('info_btn');
        info_chkBox.addEventListener("change",function(){displayBlockOrNone(info_btn,info,this);});
        //закртыие панели информации
        infoCloseId.addEventListener("click",function(){CloseBar(info_btn,info,info_chkBox);});
        
        // Управление отображением плитки с характеристиками материала
        var spec = document.getElementById('spec');
        var spec_btn = document.getElementById('spec_btn');
        spec_chkBox.addEventListener("change",function(){displayBlockOrNone(spec_btn,spec,this);});
        //закрытие панели с характеристиками
        specCloseId.addEventListener("click",function(){CloseBar(spec_btn,spec,spec_chkBox); });
        
        // Управление отображением плитки с графиком
        var material_chart = document.getElementById('chart');
        var material_chart_btn = document.getElementById('chart_btn');
        chart_chkBox.addEventListener("change",function(){displayBlockOrNone(material_chart_btn,material_chart,this);});
        //закрытие панели графика
        chartCloseId.addEventListener("click",function(){CloseBar(material_chart_btn,material_chart,chart_chkBox);});
        
        // Управление отображением плитки с информацией о перемещении материала
        var trans = document.getElementById('trans');
        var trans_btn = document.getElementById('trans_btn');
        trans_chkBox.addEventListener("change",function(){displayBlockOrNone(trans_btn,trans,this); });
        //закрытие панели транзакций
        transCloseId.addEventListener("click",function(){CloseBar(trans_btn,trans,trans_chkBox); });
        
        // Управление отображением плитки с информацией о перемещении материала
        var create = document.getElementById('create');
        var create_btn = document.getElementById('create_btn');
        create_chkBox.addEventListener("change",function(){displayBlockOrNone(create_btn,create,this); creatorMaterials(); });
        //закрытие панели транзакций
        creatorCloseId.addEventListener("click",function(){CloseBlock(create_btn,create,create_chkBox);});
        
        // Управление отображением плитки с информацией о перемещении материала
        var edit = document.getElementById('edit');
        var edit_btn = document.getElementById('edit_btn');
        edit_chkBox.addEventListener("change",function(){displayBlockOrNone(edit_btn,edit,this);});
        //закрытие панели транзакций
        editorCloseId.addEventListener("click",function(){CloseBlock(edit_btn,edit,edit_chkBox);});
    }
    
    function DynamicMargin(parentTableId,lastColumnClass){
        var vs = parentTableId.scrollHeight > parentTableId.clientHeight; 
        if(!vs){
            var items = parentTableId.querySelectorAll("."+lastColumnClass);
            for(var i=0;i<items.length;i++){
                items[i].style.marginRight = "8px";
            }
        }
    }

    
    //При изменении окна браузера
    function displayWindowSize(){
        let rootCss = document.documentElement;
        var heightMatTable = document.querySelector('#catalogContent').offsetHeight;
        rootCss.style.setProperty('--transAnim', (heightMatTable/1.5)+"ms");
           
    }
	//Здесь функция скрытие/открытие плиток кнопками навигационной панели под картинкой
    function displayBlockOrNone(_btn,_block,_chk){
        if(_block.parentElement.className != "WH_left_column")
        for(var i =0;i<allRightBlocks.length;i++){
            allRightBlocks[i].classList.add("column_hide");
            if(allRightBlocks[i] != _block.parentElement){
                var allChild = allRightBlocks[i].children;
                for(var j=0;j<allChild.length;j++){
                    if(allChild[j] != _block){
                        var btn = document.getElementById(allChild[j].id+"_btn");
                        var chk = document.getElementById(allChild[j].id+"_chkBox");
                        CloseBar(btn,allChild[j],chk); 
                    }
                }
            }
        }
        _block.parentElement.classList.remove("column_hide");
  			if (_chk.checked) {
                
    			 _block.classList.remove ('hidden');
//				setTimeout(function () {
//      				_block.classList.remove('slide');
//    				}, 
//					20);
                _block.classList.remove('slide');
                 _btn.classList.add ('openTab');
			     _btn.classList.remove ('closeTab');
  			} else {
                CloseBar(_btn,_block,_chk);
  			}
        createGrafik(matInfoForGrafic);
        displayWindowSize();
    }
    //Закрытие плиток нажатием на крестик
    function CloseBar(_btn,_block,_chk){
        
//        setTimeout(function () {
//      				_block.classList.add('slide');
//    				}, 
//					20);
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
        _chk.checked = false;
    }
    
    /*Выбор материала в таблице*/
    function selectTd(e){
		// ?? элементов с классом .itemNameTD я не нашел !!
        var selNameMat = e.querySelector('.columnName').innerHTML;
        var selIdMat = e.querySelector('#id_mat').innerHTML;
        imgMat = document.getElementById("material_image");
        switch(pageUrl){
            //если это страница с материалами
            case "http://10.21.186.101/index.php?page=AllMaterials":
                SelectMaterial(selIdMat,selNameMat);
            break;
            //если это страница с двигателями
            case "http://10.21.186.101/index.php?page=AllEngines":
                
            break;
        }
        

        trans_chkBox.disabled  = false;
        chart_chkBox.disabled  = false;
        spec_chkBox.disabled  = false;
        
        if(selRowNow !=null)
            selRowNow.classList.remove("selected");
        
        selRowNow = e;
        e.classList.add("selected");
        material_name.innerHTML = selNameMat;
    }
    
    function SelectMaterial(selIdMat,selNameMat){
        console.log("Select Material Graph");
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'infoMatGrafic', idMat:selIdMat},
               success: function(result){
                   matInfoForGrafic = result;
                    createGrafik(result);
                   console.log("Success Select Material Graph");
                   DocumentReady();
               }
           });
        console.log("Select Material Image");
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'imgSelMat', idMat:selIdMat},
               success: function(result){
                    imgMat.src = "sklad/img/"+result+".jpg";
                    
                    
                    imgMat.onerror = function(e) {
                       imgMat.src = "img/error_pictures/noImg.jpg"; 
                    }
                   
                    console.log("Success Select Material Image!");
               }
           });
        console.log("Generate Table Transaction");
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'CreateTableTransaction', idMat:selIdMat},
               success: function(result){
                   $( "#transContent" ).html( result );
                   console.log("Success Generate Table Transaction!");
               }
           });
    }
    
    /*Функция запускается при прогрузке страницы*/
    function StartDocument(){
        ajaxGenerateTable();
    }
    
    //Функция для создания таблицы посредством Ajax
    function ajaxGenerateTable(){
        pageUrl= window.location.href;
        console.log("Generate Table Materials");
            $.ajax({
               type: "POST",
               url: "sklad/tableGeneratorMaterials.php",
               data: {page:pageUrl, searchOzm:searchMatOzm,sort:sortType,categor:selCatId, minQty:minQty},
               success: function(result,status,xhr){
                   $( "#catalogContent" ).html( result );
                   console.log("Success Generate Table Materials!");
                   DocumentReady();
               }
           });
    }
    
    //Функция создания панели для создания материалов
    function creatorMaterials(){
        pageUrl= window.location.href;
        console.log("Create Materials");
            $.ajax({
               type: "POST",
               url: "sklad/creatorPanel.php",
               data: {page:pageUrl},
               success: function(result,status,xhr){
                   $( "#createContent" ).html( result );
                   console.log("Success Create Materials!");
                   DocumentReady();
               }
           });
    }
    /*Рисуем график*/
    function createGrafik(selMatInfo){
        var oldCanvas = document.getElementById("chartContent");
        oldCanvas.innerHTML = '';
        
        var tag = document.createElement("canvas");
        tag.id = "myChart";
        var element = document.getElementById("chartContent");
        element.appendChild(tag);
        
        
        var infoMat = selMatInfo;
        var ctx = document.querySelector('#myChart');
        
        
        var chart = document.getElementById('myChart').getContext('2d'),
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
               _qtyS.push(res[i].split(" ")[3]);
                _qtyV.push(0);
                qtyNow -=Number(res[i].split(" ")[3]);
                
            }else{
                _qtyS.push(0);
               _qtyV.push(res[i].split(" ")[3]);
                qtyNow +=Number(res[i].split(" ")[3]);
            }
            _qty.push(qtyNow);
            _min.push(res[i].split(" ")[4]);
            _max.push(res[i].split(" ")[5]);
        }
        
        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 12;
		
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
					duration: 0
					},
                hover: {
                    animationDuration: 0 // duration of animations when hovering an item
                    },
                responsiveAnimationDuration: 0, // animation duration after a resize
			
				horizontalLine: [{
                    y: _max[0],
                    text: "Макс "+_max[0] //данные из БД
                    },
                    {
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
					titleFontColor: 'white',
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
          					//ctx.textBaseline = 'hanging'; //<-- set this
          					ctx.fillText(line.text, 70, yValue-labelSize-4);
        					}
                        }
                        return;
                    };
                }
            };
        
        var lineChart = new Chart(ctx, {
          		type: 'line',
          		data: allData,
          		options: chartOptions,
                plugins: [horizonalLinePlugin]
        		});
                
    }
    
    
    

</script>
