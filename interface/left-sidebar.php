	<div id="left_sidebar">
 		<!-- Кнопка бургер меню -->  
    	<div class="toggle-btn" onclick="move_left_sidebar()">
        	<span>Menu</span>
    	</div>		
		<ul>
			<li><a href="index.php" onclick="close_all_sidebar()">Главное меню</a></li>	
			<li><a href="#">Контейнер №1 &#9662;</a>
            <ul class="Sklad1">
                <li>
                   <!-- WMS Warehouse Management System / Страница о материалах -->
                    <a href="index.php?page=AllMaterials" onclick="close_all_sidebar()">Обзор материалов</a>
                </li>
                <?php
                	if(empty($_COOKIE['name'])){
                        header('Location:/index.php');
                    }else{
                        echo "                
                        <li>
                            <a href=\"index.php?page=AllEngines\" onclick=\"close_all_sidebar()\">Обзор двигателей</a>
                        </li>";
                    }

                
                ?>

                </ul>
            </li>	
            <?php
                    if(empty($_COOKIE['name'])){
                        header('Location:/index.php');
                    }else{
                        echo "                
                        <li><a href=\"index.php?page=ExamPage\" onclick=\"close_all_sidebar()\">Тестирование</a></li>";
                    }
            ?>
            
		</ul> 	
	</div>	