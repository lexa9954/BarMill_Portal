<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <link rel="icon" href="/img/armatera.png" type = "image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <title>BarMill Portal</title>
	   <script language="JavaScript" type="text/javascript" src="/libs/chart.js"></script>
    <script language="JavaScript" type="text/javascript" src="/Push_notifications/Notifications.js"></script>
<script src="libs/ajax.js"></script>
</head>
<body id="interface"
  <?php /* присвоение класса "move_right_sidebar" к блоку с id "interface" для фиксации правого сайдбара в случае если при авторизации были введены неверные АMEI и/или пароль */
	 if(!empty($_SESSION['loginError'])){
		 echo "class=\"move_right_sidebar\"";
	 }else{
		 echo "class=\"\"";
	 }
  ?>
>
 	<!-- Верхняя полоска -->  
	<header class="header">
        <div class="header_logo">
         	<div id="scan_barcode">
          		<?php	require "img/scan_barcode.svg";?>         		
         	</div>
          	<a href="index.php"><img src="img/logo.svg" alt="LOGO" class="svg-logo"></a>
            <div style="margin:100px; color:white;">
                <?php 
                    $page = $_SERVER['REQUEST_URI'];
                    switch($page){
                        case "/index.php?page=profile":
                            echo "ПРОФИЛЬ";
                            break;
                        case "/index.php":
                            echo "ГЛАВНАЯ";
                            break;
                        case "/index.php?page=AllMaterials":
                            echo "МАТЕРИАЛЫ";
                            break;
                        case "/index.php?page=AllEngines":
                            echo "ДВИГАТЕЛЯ";
                            break;
                        case "/index.php?page=ExamPage":
                            echo "ЭКЗАМЕНЫ";
                            break;
                        default: 
                            echo "ГЛАВНАЯ!";
                            break;
                    }
                ?>
            </div>
        </div> 
	</header>