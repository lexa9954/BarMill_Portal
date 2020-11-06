<?php
	session_start();
	$AMEI = filter_var(trim($_POST['AMEI']), FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

$hash_pass = $pass;

require "../sql_connect.php";


$sql = "SELECT login.id,amei,first_name FROM login join peoples on peoples.id=login.people_id WHERE AMEI = $AMEI AND pass = '$pass'";
$stmt = mysqli_query( $conn, $sql);

if( $stmt === false) {
    //die( print_r( mysqli_connect_error(), true) );
    //die( print_r( sqlsrv_errors(), true) );
}

$user = mysqli_fetch_array( $stmt);

	if(empty($user['amei'])){
	   unset($_SESSION['wrongPass']);
	   $_SESSION['correctPass'] = "Пароль изменён спешно!";
	   $_SESSION['loginError'] = "Не верный пароль<br>или имя пользователя.";
	   echo "Такой пользователь не найден";
	}else{
	   unset($_SESSION['loginError']);
	   $_SESSION['loginError'] = "Не верный пароль<br>или имя пользователя.";
	   echo "Success";
	}
//exit();

setcookie('name', $user['first_name'], time() + 36000, "/");
setcookie('AMEI', $user['amei'], time() + 36000, "/");

header('Location:../index.php');
?>