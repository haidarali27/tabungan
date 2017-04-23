<?php
error_reporting(0);
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";

$kabupaten = explode("*", $_GET['kabupaten']);
$sql_kecamatan = $db->database_prepare("SELECT * FROM master_ref_kecamatan WHERE id_kabkota = ? order by nama ")->execute($kabupaten[0]);
echo "<option value=''></option>";
while($k = $db->database_fetch_array($sql_kecamatan)){
    echo "<option value='$k[id]*$k[id_kabkota]*$k[nama]'>$k[id] - $k[nama]</option>";
}
?>