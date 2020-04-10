<div class="testTable">
<!--	Создание таблицы-->
<?php
    echo "
        <div classs=\"tableMats\">
            <table id=\"tableMats\">
                <thead>
                <tr>
                    <th class=\"headTB\">ОЗМ</th>
                    <th class=\"headTB\">Наименование</th>
                    <th class=\"headTB\">Количество</th>
                    <th class=\"headTB\">Последнее поступление</th>
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
                    <td class=\"itemOzmTD\">",$row['ozm'],"</td> 
                    <td class=\"itemNameTD\">",$row['name_mat'],"</td>
                    <td class=\"itemQtyTD\">",$row['qty'],"</td>
                    <td class=\"itemLD_TD\">",$row['mat_date']->format('d-m-Y H:i:s'),"</td>
                </tr>
                
                <tr  id=\"itemInfo\" class=\"openedItemClose\">
                    <td>
                        <img class=\"img_mat\" src=\"sklad/img/",$row['ozm'],".jpg\" onerror=\"this.onerror=null;this.src='img/error_pictures/noImg.jpg';\">
                        
                        <input type=\"button\" onclick=\"moreMaterialInfo('",$row['name_mat'],"');\" value=\"Подробно\"/>
                        
                    </td>
                    <td colspan=3>
                        <div class=\"chartWrapper\">
                            <div class=\"chartAreaWrapper\">
                                <canvas id=\"myChart\"></canvas>
                            </div>
                            <canvas id=\"myChartAxis\" height=\"200\" width=\"0\"></canvas>
                        </div>
                    </td >
                    <td id=\"matInfo\" class=\"notVisibleElements\">",SelectMatVariables($row['name_mat']),"
                    </td>
                </tr>
        ";
        
    }
    echo "  </tbody>
            </table>
        </div>";
?>  
</div>