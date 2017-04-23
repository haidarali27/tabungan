<?php
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
$q=$_GET['q'];
$my_data=mysql_real_escape_string($q);
$like = "%".$my_data."%";
$sql = $db->database_prepare("SELECT * FROM master_data WHERE nama LIKE ? ORDER BY nama ASC")->execute($like);
while ($row = $db->database_fetch_array($sql)){
	$npt = $row['nama']." : ".$row['nik']." : ".$row['id_karyawan'];
	echo $npt."\n";
}
?>