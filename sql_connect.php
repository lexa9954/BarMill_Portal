<?php
//phpinfo();

////Соединение с БД Алексея
//$serverName = "DESKTOP-03CJ4S4"; 

//Соединение с БД Олега
$serverName = "DESKTOP-08NAQ0K\SQLEXPRESS";

$connectionInfo = array ("Database"=>"WareHouseBM", "CharacterSet"=>"UTF-8");
$conn = sqlsrv_connect( $serverName, $connectionInfo);


/*
//по необходимость проверка связи с БД
if($conn){
	echo "соединение с БД установлено!";
}else{
	echo "FAIL соединение с БД НЕ установлено!";
}
*/
?>