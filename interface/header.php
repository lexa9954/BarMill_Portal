<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">

        <link href="https://fonts.googleapis.com/css?family=Roboto:300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <title>BarMill Portal</title>
	   <script language="JavaScript" type="text/javascript" src="/barmill_portal/libs/chart.js"></script>
    <script language="JavaScript" type="text/javascript" src="/barmill_portal/Push_notifications/Notifications.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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
            <a href="index.php"><img src="img/logo.svg" alt="LOGO" class="svg-logo"></a>
        </div> 
	</header>