<div class="WareHouseHistory">
        <form method="post" class="history_bar">
            <ul class="history_container">
                <li><input type="submit" class="history_but"  name="HistoryEnterExit" value="История посещений"/></li>
                <li><input type="submit" class="history_but" name="HistoryVsklad" value="История поступления материала"/></li>
                <li><input type="submit" class="history_but" name="HistoryIzSklada" value="История получения со склада"/></li>
            </ul>
        </form>
    
    <div class="historyContainer">
        <table class="historyTable">
            <thead>
            <tr>
                <th>
                    Дата прихода
                </th>
                <th>
                    Дата ухода
                </th>
                <th>
                    Кто посещал
                </th>
            </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($_POST['HistoryEnterExit'])){ //Имя элемента
                        echo SelectTypeHistory(0);
                    }
                    if(isset($_POST['HistoryVsklad'])){ //Имя элемента
                        echo SelectTypeHistory(1);
                    }
                    if(isset($_POST['HistoryIzSklada'])){ //Имя элемента
                        echo SelectTypeHistory(2);
                    }

                    function SelectTypeHistory($typeHistory){
                        
                        $query_type_enter_exit = "select door_controll.date_enter 'enterDate',
                       door_controll.date_enter 'enterTime',
                        door_controll.date_exit 'exitDate',
                        door_controll.date_exit 'exitTime',
                        First_name,second_name,last_name,TabNumberSap from peoples right join door_controll on peoples.id=door_controll.people";
                        CreateMatRow($query_type_enter_exit);
                    }
                    function CreateMatRow($queryArray){
                        require "sql_connect.php";
                        $result = mysqli_query( $conn, $queryArray);
                        while($row = mysqli_fetch_array($result)){
                            if($row['second_name']==null){
                                echo "<tr class=\"historyItemTR\" style=\"background-color:hotpink\">";
                            }else{
                                echo "<tr class=\"historyItemTR\">";
                            } 
                            echo 
                            "<td>",$row['enterDate'],"<br>",
                            $row['enterTime'],"</td>
                            <td>",$row['exitDate'],"<br>",
                            $row['exitTime'],"</td>
                            <td>",$row['second_name'],"</td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
  

<script> 
    
    function GenerateTable(){

    }
</script>
