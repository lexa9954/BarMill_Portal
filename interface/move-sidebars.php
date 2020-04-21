	<!-- Для скрытия выезжающих менюшек слева и справа по нажатию в рабочем поле -->
	<div class="interface__overlay" onclick="close_all_sidebar()"></div>
	 <!-- Скрипт для "выезда" меню слева по нажатию кнопки бургер меню, при нажатии устаналивает свойства для slidebar'a из класса active, при повторном нажатии восстанавливает свойства slidebar'a, при открытом меню нажатие на пункт из меню или нажатие на поле контента приводит к скрытию меню --> 
	<script>	
		
		//скрипт движения левой менюшки
		function move_left_sidebar() {
			document.getElementById("interface").classList.toggle('move_left_sidebar');
		}
		
		//скрипт движения менюшки		
		function move_right_sidebar() {
			document.getElementById("interface").classList.toggle('move_right_sidebar');
		}
		
		//скрипт скрывания менюшек	
		function close_all_sidebar() {
			document.getElementById("interface").classList.remove('move_left_sidebar', 'move_right_sidebar', 'show_overlay');
		}
		
		//если в контенте нажата кнопка с вызовом меню, затемняет фон	
		function show_overlay() {
			document.getElementById("interface").classList.remove('move_left_sidebar', 'move_right_sidebar');
			document.getElementById("interface").classList.add('show_overlay');
		}
		
	</script>