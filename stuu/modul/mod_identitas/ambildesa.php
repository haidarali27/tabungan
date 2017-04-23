<?php
error_reporting(0);
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";

$kecamatan = explode("*", $_GET['kecamatan']);
$sql_desa = $db->database_prepare("SELECT * FROM master_ref_desa WHERE id_kecamatan = ? order by nama ")->execute($kecamatan[0]);
echo "<option value=''></option>";
while($k = $db->database_fetch_array($sql_desa)){
    echo "<option value='$k[id]*$k[id_kecamatan]*$k[nama]'>$k[id] - $k[nama]</option>";
}
?>