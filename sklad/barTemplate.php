<?php
	// Здесь шаблон для плиток идентичный для всех, создание плиток нужно сделать вызовом функции с передачей переменных из sklad.php
		//Это сократит код в sklad.php и снизит риск некорректной правки кода

//	$bar1_id = "info";
//	$bar1_content_id = "infoContent";
//	$bar1_hide = false;
//
//	$bar2_id = "spec";
//	$bar2_content_id = "specContent";
//	$bar2_hide = true;
//
//	$bar3_id = "chart";
//	$bar3_content_id = "chartContent";
//	$bar3_hide = false;
//
//	$bar4_id = "trans";
//	$bar4_content_id = "transContent";
//	$bar4_hide = true;
//
//	$bar5_id = "spec";
//	$bar5_content_id = "catalogContent";
//	$bar5_hide = true;

	// !не нужно весь код в php переводить это лишит подсветки html синтаксиса и лишит быстрой ориентации, в php только переменные
?>
   		<div class="bar переменная1" id="<?php $bar_id; ?>">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/$bar_id.svg";?>
				</div>
				<div class="barTitle">График</div>
				<div class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="<?php $bar_content_id; ?>"></div>
   		</div>