<div id="right_sidebar">
<!-- Кнопка профиль -->  
    <div class="ava_toggle-btn" onclick="move_right_sidebar()">
		<?php if(empty($_COOKIE['name'])): ?>
			<img class="ava" src="img/noimage-150x150.png" alt="Avatar">
    	<?php else: ?>      	
			<?php 
			//Подключение к БД
			require "sql_connect.php";
	
			$COOKIE_AMEI = $_COOKIE['AMEI'];
			$sql = "SELECT * FROM img_ava WHERE id = (SELECT imgId FROM login_img WHERE loginAMEI = $COOKIE_AMEI)";
			
            $stmt = mysqli_query( $conn, $sql);
			//$stmt = mysqli_query( $conn, $sql);
            $img = mysqli_fetch_array( $stmt);
			//$img = mysqli_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
			$target = $img['img_tmp'];
			$fName = $img['img_name'];
			echo "<img class=\"ava\" src=\"$target$fName\" alt=\"Avatar\">";
			?>       	
		<?php endif;?>        	
    </div> 
    	
	<!-- Авторизация на сайте -->
    <div class="container">
		<?php if(empty($_COOKIE['name'])): ?>
	<!--
		<h1>Форма регистрации</h1>
		<form action="access_control/check.php" method="post">
			<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"><br>
			<input type="text" class="form-control" name="name" id="name" placeholder="Введите имя"><br>
			<input type="text" class="form-control" name="pass" id="pass" placeholder="Введите пароль"><br>
			<button class="btn btn-success" type="submit">Зарегистрировать</button>
		</form>
	-->
			<div class="ask-log-pass">Введите AMEI и пароль</div>
			<form class="auth" action="access_control/auth.php" method="post">
				<input type="text" class="form-control" name="AMEI" id="AMEI" placeholder="AMEI"><br>
				<input type="password" class="form-control" name="pass" id="pass" 	placeholder="password" autocomplete="off"><br>
				<button class="knopka" type="submit">Авторизоваться</button>
				<?php if(!empty($_SESSION['loginError'])){
					$message = $_SESSION['loginError'];
					echo "<div class=\"errorText\">$message</div>";
					}
				?>
			</form>
		<?php else: ?>		 
			<ul>
				<li><p class="exit">Привет <?=$_COOKIE['name']?></p></li>
				<li><a href="index.php?page=profile" onclick="close_all_sidebar()">Профиль</a></li>
				<!--li><a href="#" onclick="close_all_sidebar()">Профиль какойто</a></li-->
				<li><a href="access_control/exit.php">Выйти</a></li>
			</ul>			
		<?php endif;?>
		<?php 
		/* Код необходимый чтобы сбросить ошибку если пользователь покинул страницу с ошибкой */
			if(!empty($_SESSION['loginError'])){
			unset($_SESSION['loginError']);
			}
		?>
	</div>			
</div>	