<?php
//$host='localhost';
//$user='root';
//$pass=' ';
require "../sql_connect.php";


$imagename=$_FILES["myimage"]["name"];

//Получаем содержимое изображения и добавляем к нему слеш
$imagetmp=addslashes(file_get_contents($_FILES['myimage']['tmp_name']));

//Вставляем имя изображения и содержимое изображения в img_ava
$insert_image="INSERT INTO img_ava VALUES('$imagetmp','$imagename')";

$stmt = mysqli_query($conn, $insert_image);
?>
