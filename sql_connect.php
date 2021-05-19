<?php
//phpinfo();
$userName = "BarMill_Admin";
$userPass = "7ygvcft6ALEX9954";

////MySQL
$serverName = "DESKTOP-03CJ4S4"; 

////Соединение с БД Алексея
//$serverName = "DESKTOP-03CJ4S4"; 


//Соединение с БД Олега
//$serverName = "DESKTOP-08NAQ0K\SQLEXPRESS";

$conn = mysqli_connect("localhost", 'root', '',"WareHousebm" );
//$conn = mysqli_connect("10.21.186.101", $userName, $userPass,"WareHousebm" );
//$connectionInfo = array ("UID"=>$userName, "PWD"=>$userPass,"Database"=>"WareHouseBM", "CharacterSet"=>"UTF-8");
//$conn = sqlsrv_connect( $serverName, $connectionInfo);


/*
//по необходимость проверка связи с БД
if($conn){
	echo "соединение с БД установлено!";
}else{
	echo "FAIL соединение с БД НЕ установлено!";
    die( print_r( mysqli_connect_error(), true));
}*/

?>