<?php
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
$q=$_GET['q'];
$my_data=mysql_real_escape_string($q);
$like = "%".$my_data."%";
$sql = $db->database_prepare("SELECT * FROM master_ref_koja WHERE nama_unit_koja LIKE ? ORDER BY nama_unit_koja ASC")->execute($like);
while ($row = $db->database_fetch_array($sql)){
	$npt = $row['nama_unit_koja']." : ".$row['id_unit_koja'];
	echo $npt."\n";
}
?>