<?php
$uploaddir = '../../foto/identitas/'; 
$file = $uploaddir ."gb_".basename($_FILES['uploadfile']['name']); 
$file_name= "gb_".$_FILES['uploadfile']['name']; 
 
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
  echo "success"; 
} else {
	echo "error";
}
?>