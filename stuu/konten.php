<?php
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Jakarta');
include "../config/class_database.php";
include "../config/serverconfig.php";
include "../config/debug.php";
include "../fungsi/timezone.php";
include "../fungsi/fungsi_combobox.php";
include "../fungsi/fungsi_date.php";
include "../fungsi/fungsi_rupiah.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	echo "<meta http-equiv='refresh' content='0; url=../index.php?code=1'>";
}

else{
	if ($_GET['mod'] == 'datapt'){ 
		include "modul/mod_pt/pt.php";
	}
		
	elseif ($_GET['mod'] == 'identitas'){
		include "modul/mod_identitas/identitas.php";
	}
	
		
	elseif($_GET['mod'] == 'user'){
		include "modul/mod_user/user.php";
	}
	
		
	elseif ($_GET['mod'] == 'ubah_password'){
		include "modul/mod_user/password.php";
	}
	
	
	
	elseif ($_GET['mod'] == 'kartu_profil'){
		include "modul/mod_cetak_profil/kartu_profil.php";
	} 
		
	elseif ($_GET['mod'] == 'backup_db'){
		include "modul/mod_backup/backup.php";
	}
	
	
	
	else{
		if ($_GET['code'] == 1){
			echo "
				<div class='message success'>
					<h5>Success!</h5>
					<p>Anda berhasil Login.</p>
				</div>";
		}
		echo "<p><b>$_SESSION[nama_lengkap]</b>, Selamat datang di Sistem Informasi Manajemen, Anda dapat mengolah konten melalui menu di sisi kiri.<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
		Informasi Login:
		Tanggal : $_SESSION[last_login] <br>
		IP : $_SESSION[ip] 
		</p>";
	}
}
?>