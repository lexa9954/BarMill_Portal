<div class="content">
<?php
    $page = $_SERVER['REQUEST_URI'];
	switch($page){
    	case "/index.php?page=profile":
			require "profile/profile.php";
			break;
    	case "/BarMill_Portal/index.php":
            echo "
                <div class=\"wrapper\">
                <img src=\"../SPC_Photos/1.jpg\"/>
                </div>
            ";
            
			echo "<div class=\"text\">1 октября 1942 г. распоряжением Совета народных комиссаров СССР Наркомчермету предложено разработать проектное задание на строительство Карагандинского металлургического завода на базе железных руд Атасуйского месторождения;
			2012 г. – выполнен запуск нового блока разделения воздуха, построенного ТОО «Линде Газ Казахстан»</div>";
			echo "<div class=\"text\">1 октября 1942 г. распоряжением Совета народных комиссаров СССР Наркомчермету предложено разработать проектное задание на строительство Карагандинского металлургического завода на базе железных руд Атасуйского месторождения;
			2012 г. – выполнен запуск нового блока разделения воздуха, построенного ТОО «Линде Газ Казахстан»</div>";
            echo "<div class=\"text\">1 октября 1942 г. распоряжением Совета народных комиссаров СССР Наркомчермету предложено разработать проектное задание на строительство Карагандинского металлургического завода на базе железных руд Атасуйского месторождения;
			2012 г. – выполнен запуск нового блока разделения воздуха, построенного ТОО «Линде Газ Казахстан»</div>";
			break;
		case "/index.php?page=AllMaterials":
			require "sklad/sklad.php";
			break;
        case "/index.php?page=AllEngines":
			require "sklad/sklad.php";
			break;
        case "/index.php?page=history":
			require "sklad/history.php";
			break;
        case "/index.php?page=materialMore":
			require "sklad/materialMore.php";
			break;
		case "/index.php?page=ExamPage":
			require "Exam/ExamPage.php";
			break;
        case "/index.php?page=EditorWarehouse":
			require "sklad/EditorWhPage.php";
			break;
    	default: 
            readSerialPort();
			echo "<div class=\"text\">1 октября 1942 г. распоряжением Совета народных комиссаров СССР Наркомчермету предложено разработать проектное задание на строительство Карагандинского металлургического завода на базе железных руд Атасуйского месторождения;
			2012 г. – выполнен запуск нового блока разделения воздуха, построенного ТОО «Линде Газ Казахстан»</div>";
			break;
	}
        require "Push_notifications/MainNotification.php";
    
    function readSerialPort(){
        include "libs/SerialCom.js";
    }
?>
</div>