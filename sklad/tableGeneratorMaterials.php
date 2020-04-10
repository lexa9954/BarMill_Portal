<?php
$selCategor = $_POST['categor'];
$searchName = $_POST['searchName'];
$minQty = $_POST['minQty'];

SelectMats($selCategor,$searchName,$minQty);

/*Запрос на получение материалов по фильтру*/
function SelectMats($categor,$searchName,$minQty){
    require "../sql_connect.php";
    
    $query_select_categor ="";
    $query_search_name ="";
    $query_select_min ="";
    /*Вывод по категории*/
    if($categor != -1)
        $query_select_categor = "and categor =$categor";
    /*Поиск по имени*/
    if($searchName != "")
        $query_search_name = "and name_mat LIKE '%$searchName%'";
    /*Минимальное кол-во*/
    if($minQty !="")
        $query_select_min = "and mat_box_polka.qty<min";
    
    $query_select_mats = "select distinct name_mat,mat_box_polka.qty,min,max,mat_box_polka.id_box,mat_box_polka.id_polka,ozm,ediniciIzmerenija.edinica_izmerenija,nameC,max(mat_date) 'mat_date' from materials join history on history.mat_id = materials.id 
    inner join ediniciIzmerenija on ediniciIzmerenija.id = materials.edinica_izmerenija 
    inner join mat_box_polka on mat_box_polka.id_mat = materials.id 
    inner join categories on categories.id = materials.categor 
    where spisanie_or_dobavlenie=1 and (deleted_mat is null or deleted_mat = 0) $query_select_categor $query_search_name $query_select_min 
    group by materials.name_mat,mat_box_polka.qty,min,max,mat_box_polka.id_box,mat_box_polka.id_polka,ozm,ediniciIzmerenija.edinica_izmerenija,nameC";
    CreateTable(sqlsrv_query($conn,$query_select_mats));
    sqlsrv_close($conn);
}
    
/*Создание таблицы*/
function CreateTable($stmt){
    echo "
        <div class=\"tableMats\">
            <table class=\"tableMats\">
                <thead>
                <tr>
                    <th class=\"columnOZM\">ОЗМ</th>
                    <th class=\"columnName\">Наименование</th>
                    <th class=\"columnQty\">Количество</th>
                    <th class=\"columnCategory\">Категория
                    <select id=\"selectCategorDD\" onchange=\"SelectCat();\">";
                    include "categoriesGenerator.php";
                    GenerateCategories($_POST['categor']);
              echo "</select>
              
                    </th>
                    <th class=\"columnDate\" >Последнее поступление</th>
                </tr>
                </thead>
                <tbody id=\"containerItems\">";
    while($row = sqlsrv_fetch_array($stmt)){
        $classMin = "itemMatTR";
        if($row['qty']<$row['min']){
            $classMin = "minItemMatTR";
            echo "<script>
            notifSet('Материал на исходе',","'",$row['name_mat'],"','sklad/img/",$row['ozm'],".jpg');
            </script>";
        }
        echo "
                <tr class=\"$classMin\" onclick=\"selectTd(this)\">
                    <td class=\"columnOZM\">",$row['ozm'],"</td>					
                    <td class=\"itemNameTD\">",$row['name_mat'],"</td>
                    <td class=\"columnQty\">",$row['qty'],"</td>
                    <td class=\"columnCategory\">",$row['nameC'],"</td>
                    <td class=\"columnDate\">",$row['mat_date']->format('d-m-Y H:i:s'),"</td>
                </tr>
        ";
        /* Нужно вместо itemNameTD установить columnName */
    }
    echo "  </tbody>
            </table>
        </div>";
}

?>