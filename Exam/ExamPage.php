<?php
	// Exam Page / Страница о результатах тестиования
?>

<div class="Exam">

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
  			<div class="material_img">
   				<img id="material_image" src="sklad/sys_img/noimg.jpg">
   				<div id="material_name">
   					ФИО
   				</div> <!-- Сюда выводить имя выбранного результата -->
			</div>  		  			
   		</div>
   		
   		<!-- Плитка с подробной информацией -->
   		<div class="bar" id="info">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/info.svg";?>
				</div>
				<div class="barTitle">Подробная информация</div>
			</div>
			<div class="barContent" id="infoContent">
   				Подробная информация о пользователе				
			</div>
   		</div>
   	</div>
   	
   	<!-- Правая колонка с плитками -->
	<div class="WH_right_column" id="column_review">  		
  		<!-- Плитка с результатами -->
		<div class="bar" id="catalog">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/catalog.svg";?>
				</div>
				<div class="barTitle">Результаты экзаменов</div>
			</div>
			<div class="barContent" id="catalogContent">
				<!-- В данный блок интегрируется "tableGeneratorMaterials.php" посредством AJAX -->		
			</div>
		</div>  	
   	</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        ajaxGenerateTable();
    });
    function DocumentReady(){
        close_all_sidebar();
    }
    
    //Функция для создания таблицы посредством Ajax
    function ajaxGenerateTable(){
        pageUrl= window.location.href;
            $.ajax({
               type: "POST",
               url: "Exam/ExamTableGenerator.php",
               data: {page:pageUrl},
               success: function(result,status,xhr){
                   $( "#catalogContent" ).html( result );
                   console.log("Success "+result+" Status "+status);
                   DocumentReady();
               }
           });
    }
</script>