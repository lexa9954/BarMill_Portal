<?php
Start();

function Start(){
    
    $query_select_peoples = "select first_name,last_name,second_name,Type_quest_text,success_quest_percent,last_date,time_exam,TabNumberSap from Exam_date join peoples on peoples.id=exam_date.people_id join Exam_typeQuest on Exam_typeQuest.id=exam_date.type_quest_id where Exam_date.last_date=(select max(Exam_date.last_date) from Exam_date where peoples.id=Exam_date.people_id)";

    CreateTableResultsExam($query_select_peoples);
}


/* ▼ Создание таблицы ▼ */
function CreateTableResultsExam($query){
    echo "
            <table class=\"tableMats\">
                <thead id=\"material_table_head\" class=\"material_table_head\">
                	<tr>
                        <th class=\"columnTabNum\">
							<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"resetSort\">
							
							<label for=\"resetSort\" class=\"resetSort\" onclick=\"close_all_sidebar()\" id=\"resetSort-svg\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/resetSort.svg';	echo "							
							</label>
							
							<label for=\"select2\" class=\"select2\"  onclick=\"show_overlay()\" id=\"searchOZM\">";				
  								require dirname(__FILE__) . '/../sklad/sys_img/searchOZM.svg';	echo "
							<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"select2\">
							<input type=\"number\" id=\"lname\" name=\"lname\" onkeydown=\"searchOzmEnter(event)\" min=\"111\" max=\"9999999999\">
							</label> 
							
							<div class=\"columnHeader\">Таб№</div>	
							<label  id=\"sortByOZM\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
                    
                    	<th class=\"columnLN\">
							<div class=\"columnHeader\">Фамилия</div>	
							<label  id=\"sortByLN\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
						
                    	<th class=\"columnFN\">
							<div class=\"columnHeader\">Имя</div>	
							<label  id=\"sortByFN\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
						
                    	<th class=\"columnSN\">
							<div class=\"columnHeader\">Отчество</div>
							<label id=\"sortBySN\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>							
                    	</th>
						
                        <th class=\"columnDateExam\">
							<div class=\"columnHeader\">Дата</div
                            <label id=\"sortByDate\">";
        					    require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "    
							</label>	
						</th>
						
                    	<th class=\"columnExamType\">
    						<div class=\"filtr\" onclick=\"show_overlay()\">					
								<label>";
									require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';	echo "
								</label>";
              						echo "
							</div>
							<div class=\"columnHeader\">Экзамен</div>				
                    	</th>
						
                    	<th class=\"columnPercent\" >
							<div class=\"columnHeader\">% Сдачи</div>	
							<label  id=\"sortByPercent\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
                        <th class=\"columnTimeExam\" >
							<div class=\"columnHeader\">Время затрачено</div>	
							<label  id=\"sortByExamTime\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";
    require "../sql_connect.php";
                    $result = mysqli_query($conn,$query);
                    
                    while($row = mysqli_fetch_array($result) ){
                        $classMin = "itemMatTR";
                        echo "
                		<tr id=\"item\" class=\"tableRow $classMin\" onclick=\"selectTd(this)\">
                            <td id=\"id_mat\" class=\"unvisibleElement\">",$row['id'],"</td>
                            <td class=\"columnTabNum\">",$row['TabNumberSap'],"</td>
                            <td class=\"columnLN\">",$row['last_name'],"</td>
                            <td class=\"columnFN\">",$row['first_name'],"</td>
                    		<td class=\"columnSN\">",$row['second_name'],"</td>	
                    		
                            <td class=\"columnDateExam\">",$row['last_date'],"</td>
                    		<td class=\"columnExamType\">",$row['Type_quest_text'],"</td>
                    		<td class=\"columnPercent\">",$row['success_quest_percent'],"</td>
                            <td class=\"columnTimeExam\">",date('i:s',$row['time_exam']),"</td>
               	 		</tr>
        				";                    
                    }
    				echo "
				</tbody>
            </table>";	
}
/* ▲ Создание таблицы ▲ */

?>