<?php
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
$q=$_GET['q'];
$kecamatan = explode(" : ", $_GET['kecamatan']);
$ada=mysql_real_escape_string($kecamatan[1]);
$my_data=mysql_real_escape_string($q);
$like = "%".$my_data."%";
$sql = $db->database_prepare("SELECT * FROM as_desa WHERE nama LIKE ? and id_kecamatan=? ORDER BY nama ASC")->execute($like, $ada);
while ($row = $db->database_fetch_array($sql)){
	$npt = $row['nama']." : ".$row['id'];
	echo $npt."\n";
}
?>