<!-- ↓ Меню изменения аватарки пользователя ↓ -->
<div class="menu_img">
	<div  id="btnChangeImg" class="txtInline">
		<div>Фотография профиля</div>
		<div id="profile_img_lbl">Изменить</div>
	</div>
	
	<form id="profile_form_img" action="" method="post" enctype="multipart/form-data">	
		<div class="preview">
    		<p></p>
  		</div>
  		<input type="file" name="image" id="image" class="input_image" accept=".jpg, .jpeg,">
  		<?php
			/* Загрузка картинки */
			if(isset($_FILES['image'])){
				$errors = array();
				$file_name = $_FILES['image']['name'];
				$file_size = $_FILES['image']['size'];
				$file_tmp = $_FILES['image']['tmp_name'];
				$file_type = $_FILES['image']['type'];
	
				$exploded = explode('.',$file_name);
 				$file_ext=strtolower(end($exploded));	
		
				if($file_size> 2097151){
					$errors[] = 'Файл должен быть не более 2 Мб';
				}
			
				/* Если нет ошибок грузим файл на сервер, присваивая имя файла AMEI */
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"img/avatar/"."$COOKIE_AMEI.$file_ext");
					$sql = "UPDATE img_ava SET img_name = '$COOKIE_AMEI.$file_ext' WHERE id = (SELECT 		imgId FROM login_img WHERE loginAMEI = '$COOKIE_AMEI')";
	
                    $stmt = mysqli_query( $conn, $sql);
				}else{
					print $errors;
				}	
			}
		?>
		<div class="btnInline">
			<label class="knopka" for="image">Выбрать файл</label>
			<button class="knopka" type="submit" id="btn_change_img">Применить</button>
		</div>
	</form>		
</div>
<script>	
		var input = document.querySelector('.input_image');
		var preview = document.querySelector('.preview');
		input.addEventListener('change', updateImageDisplay);
	
function updateImageDisplay() {
  while(preview.firstChild) {
    preview.removeChild(preview.firstChild);
  }

  var btn_send = document.getElementById("btn_change_img")
  var curFiles = input.files;
  if(curFiles.length === 0) {
    var para = document.createElement('p');
	btn_send.classList.remove('show');
    para.textContent = ' ';
    preview.appendChild(para);
  } else {
    var list = document.createElement('ol');
    preview.appendChild(list);
    for(var i = 0; i < curFiles.length; i++) {
      var listItem = document.createElement('li');
      var para = document.createElement('p');
      if(validFileType(curFiles[i])) {
        para.textContent = 'File name ' + curFiles[i].name + ', file size ' + returnFileSize(curFiles[i].size) + '.';
        var image = document.createElement('img');
		image.classList.add('prev_image');
        image.src = window.URL.createObjectURL(curFiles[i]);
		
		btn_send.classList.add('show');

        listItem.appendChild(image);
        listItem.appendChild(para);

      } else {
        para.textContent = 'File name ' + curFiles[i].name + ': Not a valid file type. Update your selection.';
		btn_send.classList.remove('show');
        listItem.appendChild(para);
      }

      list.appendChild(listItem);
    }
  }
}
var fileTypes = [
  'image/jpeg',
  'image/pjpeg',
//  'image/png'
]

function validFileType(file) {
  for(var i = 0; i < fileTypes.length; i++) {
    if(file.type === fileTypes[i]) {
      return true;
    }
  }

  return false;
}
	
function returnFileSize(number) {
  if(number < 1024) {
    return number + 'bytes';
  } else if(number > 1024 && number < 1048576) {
    return (number/1024).toFixed(1) + 'KB';
  } else if(number > 1048576) {
    return (number/1048576).toFixed(1) + 'MB';
  }
}

	var reload = document.getElementById("btn_change_img");
		/*в место onclick в html лучше использовать  addEventListener */
		reload.addEventListener('click', function() {
  			 window.location.reload();
		})
	
</script>