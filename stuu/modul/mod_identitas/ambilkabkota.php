<?php
error_reporting(0);
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";

$sql_propinsi = $db->database_prepare("SELECT * FROM master_ref_kabkota WHERE id_prov = ? order by nama")->execute($_GET['propinsi']);
echo "<option value=''></option>";
while($k = $db->database_fetch_array($sql_propinsi)){
    echo "<option value='$k[id]*$k[id_prov]*$k[nama]'>$k[id] - $k[nama]</option>";
}
?>