<?php
error_reporting(0);
include "config/class_database.php";
include "config/serverconfig.php";
include "config/debug.php";

$username = $_POST['username'];
$password = md5($_POST['password']);

//if ($_POST["dosen"] == 1){
	$sql = $db->database_prepare("SELECT * FROM master_data WHERE email = ? AND password = ? ")->execute($username,$password);
//}
//else{
//	$sql = $db->database_prepare("SELECT * FROM as_users WHERE email = ? AND password = ? AND aktif = 'Y' AND blokir = 'N'")->execute($username,$password);
//}
$nums = $db->database_num_rows($sql);

$data = $db->database_fetch_array($sql);

if ($nums > 0){
	session_start();
	$last_login = date('Y-m-d H:i:s');
	
	//if ($_POST['dosen'] == 1){
		$_SESSION['nama_lengkap'] = $data['nama']." ".$data['gelar_akademik'];
		$_SESSION['username'] = $data['email'];
		$_SESSION['password'] = $data['password'];
		$_SESSION['userid'] = $data['id_karyawan'];
		//$_SESSION['useri'] = $data['IDDOSMSDOS'];
		$_SESSION['level'] = $data['level_login'];
		$_SESSION['last_login'] = date('Y-m-d H:i:s');
		$_SESSION['ip'] = $_SERVER["REMOTE_ADDR"];
		//$_SESSION['aktif'] = $data['STDOSMSDOS'];
		$db->database_prepare("UPDATE master_data SET last_login = ?, ip = ? WHERE id_karyawan = ?")->execute($last_login,$_SERVER["REMOTE_ADDR"],$data["id_karyawan"]);
	/*}
	elseif ($data['level'] == '2'){
		header("Location: index.php?code=1");
	}
	else{
		$_SESSION['username'] = $data['email'];
		$_SESSION['password'] = $data['password'];
		$_SESSION['userid'] = $data['user_id'];
		$_SESSION['level'] = $data['level'];
		$_SESSION['nama_lengkap'] = $data['nama_lengkap'];
		$_SESSION['nama_panggil'] = $data['nama_panggil'];
		$_SESSION['aktif'] = $data['aktif'];
		$_SESSION['blokir'] = $data['blokir'];
		$_SESSION['last_login'] = date('Y-m-d H:i:s');
		$_SESSION['ip'] = $_SERVER["REMOTE_ADDR"];
		$db->database_prepare("UPDATE as_users SET last_login = ?, ip = ? WHERE user_id = ?")->execute($last_login,$_SERVER["REMOTE_ADDR"],$data["user_id"]);
	}*/
	
	header("Location: stuu/index.php?code=1");
}
else{
	header("Location: index.php?code=1");
}
?>