<div id="profile" class="<?php
	 //Здесь присваивается класс "change_pass" блоку "profile" для отоброжения меню изменения пароля с результатом запроса изменения пароля через глобальные переменные посредством сессии
	 if(!empty($_SESSION['wrongPass'])){
		 echo "change_pass";
	 }
	 if(!empty($_SESSION['correctPass'])){
		 echo "change_pass";
	 }
?>"
>

<?php
//Если время существования кукисов закончилось пользователя выкидывает и переотправляет на индексную страницу
if(empty($_COOKIE['name'])){
	header('Location:/index.php');
}
	
// ↓ Блок кода для отображения существующей аватарки (возможно выводить информацию о пользователе сюда же)↓
	//Подключение к БД
	require "sql_connect.php";	
	//создаем переменную и присваиваем значение поля AMEI кукисов для облегчения запроса к БД
	$COOKIE_AMEI = $_COOKIE['AMEI'];
	//запрос в БД для получения пути и имени файла картинки профиля
	$sql = "SELECT * FROM img_ava WHERE id = (SELECT imgId FROM login_img WHERE loginAMEI = 	'$COOKIE_AMEI')";	
	//$stmt = mysqli_query( $conn, $sql);
	$stmt = mysqli_query( $conn, $sql);
    
	//формирование массива со зачениями пути и имени файла картинки из ответа от БД
	$img = mysqli_fetch_array( $stmt);
	//создания переменной пути к файлу
	$target = $img['img_tmp'];
	//создание переменной имени файла
	$fName = $img['img_name'];
		
	//создаем на странице тег с путем к файлу из переменных пути и имени файла
	echo "<img class=\"profile_img\" src=\"$target$fName\" alt=\"Avatar\">";
// ↑ Блок кода для отображения существующей аватарки (возможно выводить информацию о пользователе сюда же) ↑
?>


<!--Вызов блока меню изменения изображения профиля-->
	<?php	require "profile/menu_img.php";?>
	
<!--Вызов блока меню изменения пароля профиля-->
	<?php	require "profile/menu_pass.php";?>
    
    <!--Вызов блока меню изменения уведомлений профиля-->
	<?php	require "profile/menu_notification.php";?>

</div>

<script>	/*Скрипт для открытия/скрытия окон меню по нажатию на вкладку*/
		var profile = document.getElementById("profile"),
  		btnChangeImg = document.getElementById("btnChangeImg"),
		btnChangePass = document.getElementById("btnChangePass"),
        btnChangeNotification = document.getElementById("btnChangeNotific"),
		profile_img_lbl = document.getElementById("profile_img_lbl"),
		profile_pass_lbl = document.getElementById("profile_pass_lbl");
	    profile_notific_lbl = document.getElementById("profile_notific_lbl");
    
        var classSelectedNow,lblSelectedNow;
    
		/* При нажатии на вкладку "фотография профиля" */
		btnChangeImg.addEventListener('click', function() {
            changeDisplayViewBtn(profile_img_lbl,'change_img');
		})
		/* При нажатии на вкладку "Пароль" */
		btnChangePass.addEventListener('click', function() {
            changeDisplayViewBtn(profile_pass_lbl,'change_pass');
		})
        /* При нажатии на вкладку "Уведомления" */
        btnChangeNotification.addEventListener('click', function() {
            changeDisplayViewBtn(profile_notific_lbl,'change_notific');
		})
    
    function changeDisplayViewBtn(Lbl_elem,Toggle_elem){
            /* удалить у блока с id 'profile' класс 'change_img' для скрытия вкладки "Пароль" */
            if(classSelectedNow !=null && classSelectedNow !=Toggle_elem ){
                profile.classList.remove(classSelectedNow);
                lblSelectedNow.innerHTML = 'Изменить';
            }
                
			/* добавить блоку с id 'profile' класс 'change_pass' для раскрытия вкладки "Фотография профиля" */
			profile.classList.toggle(Toggle_elem);
			/* Далее тернарник для изменения текста "изменить/отменить" вкладки "Пароль" в зависимости состояния вкладки "скрыта/раскрыта"*/
			Lbl_elem.innerHTML == 'Изменить' ?
			Lbl_elem.innerHTML = 'Отмена' :
			Lbl_elem.innerHTML = 'Изменить';
        
            classSelectedNow = Toggle_elem;
            lblSelectedNow = Lbl_elem;
    }
</script>