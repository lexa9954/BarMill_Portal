<?php
	$AMEI = filter_var(trim($_POST['AMEI']), FILTER_SANITIZE_STRING);
	$name = filter_var(trim($_POST['name']), 	FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), 	FILTER_SANITIZE_STRING);

	if(mb_strlen($login) < 5 || mb_strlen($login) >90){
		echo "Недопустимая длина логина";
		exit();
	}
	if(mb_strlen($name) < 3 || mb_strlen($name) >50){
		echo "Недопустимая длина имени";
		exit();
	}
	if(mb_strlen($pass) < 2 || mb_strlen($pass) >6){
		echo "Недопустимая длина пароля";
		exit();
	}

$pass = md5($pass);

//require "C:\xampp\htdocs\gamburger\sql_connect.php"; для вывода подключения к БД в отдельный файл. Нужно доделывать!

require "../sql_connect.php";

if( $conn === false ) {
//	echo "gangratulations motherfucker!!!";
//}else{
	echo "fuck you!!!<br />";
	die( print_r( sqlsrv_errors(), true));
}

$sql = "INSERT INTO login (AMEI, name, pass) VALUES ('$AMEI',  '$name', '$pass')";

$stmt = mysqli_query( $conn, $sql);
//$stmt = mysqli_query( $conn, $sql);
if( $stmt === false ) {
	die( print_r( sqlsrv_errors(), true));
}
else{echo "gangratulations motherfucker!!!";}
sqlsrv_free_stmt( $stmt);
header('Location:/gamburger/index.php');
?>