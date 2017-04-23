<?php
error_reporting(0);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../index.php?code=2");
}

else{
	if ($_GET['mod'] == 'identitas' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		$tgl_lahir = $_POST['tgl_lahir'];
		$tgl_mulai_masuk = $_POST['tgl_masuk'];
		//$tanggal_keluar_sertifikasi_identitas = $_POST['tgl_sertifikasi'];
		$password = md5(123456);
		if (isset($_POST["filename"]) or !empty($_POST["filename"])){
			//$_POST["filename1"]=$_POST["filename"];

			$file = "../../foto/identitas/".$_POST['filename'];
			$gbr_asli = imagecreatefromjpeg($file);
			$lebar = imagesx($gbr_asli);
			$tinggi = imagesy($gbr_asli);
			
			$tum_lebar = 252;
			$tum_tinggi = 310;
			
			$gbr_thumb = imagecreatetruecolor($tum_lebar, $tum_tinggi);
			imagecopyresampled($gbr_thumb, $gbr_asli, 0, 0, 0, 0, $tum_lebar, $tum_tinggi, $lebar, $tinggi);
			
			imagejpeg($gbr_thumb, "../../foto/identitas/thumb/small_".$_POST['filename']);
			
			imagedestroy($gbr_asli);
			imagedestroy($gbr_thumb);
		}
		$id_unit_kerja = explode(" : ", $_POST['id_unit_kerja']);
				$cabang = explode(" : ", $_POST['cabang']);
						$ranting = explode(" : ", $_POST['ranting']);
								$koja = explode(" : ", $_POST['koja']);
		$kecamatan = explode("*", $_POST['kecamatan']);
		$kabupaten = explode("*", $_POST['kabupaten']);
		$desa = explode("*", $_POST['desa']);

		$db->database_prepare("INSERT INTO master_data (	nik,
													nik_lama,
													tgl_masuk,
													tempat_daftar,
													no_ktp,
													nama,
													gelar_akademik,
													pendidikan_tertinggi,
													tempat_lhr,
													tgl_lahir,
													kode_jk,
													status,
													status_ikatan_kerja,
													cabang,
													ranting,
													koja,
													lahan,
													foto,
													alamat_ktp,
													jalan,
													no_rumah,
													rt,
													rw,
													dukuh,
													desa,
													kecamatan,
													kabupaten,
													propinsi,
													kode_pos,
													negara,
													telepon,
													hp,
													email,
													password,
													last_login,
													ip,
													created_date,
													created_userid,
													modified_date,
													modified_userid)
										VALUES	(	?,?,?,?,?,?,?,?,?,?,
													?,?,?,?,?,?,?,?,?,?,
													?,?,?,?,?,?,?,?,?,?,
													?,?,?,?,?,?,?,?,?,?)")
										->execute(	$_POST["nik"],
													$_POST["nik_lama"],
													$tgl_mulai_masuk,
													$_POST["tempat_daftar"],
													$_POST["no_ktp"],
													$_POST["nama"],
													$_POST["gelar_akademik"],
													$_POST["pendidikan_tertinggi"],
													$_POST["tempat_lhr"],
													$tgl_lahir,
													$_POST["kode_jk"],
													$_POST["status"],
													$_POST["status_ikatan_kerja"],
													$cabang[1],
													$ranting[1],
													$koja[1],
													$_POST["lahan"],
													$_POST["filename"],
													$_POST["alamat_ktp"],
													$_POST["jalan"],
													$_POST["no_rumah"],
													$_POST["rt"],
													$_POST["rw"],
													$_POST["dukuh"],
													$desa[0],
													$kecamatan[0],
													$kabupaten[0],
													$_POST["propinsi"],
													$_POST["kode_pos"],
													$_POST["negara"],
													$_POST["telepon"],
													$_POST["hp"],
													$_POST["email"],
													$password,
													"",
													"",
													$created_date,
													$_SESSION["userid"],
													"",
													"");
		
		header("Location: ../../index.php?mod=identitas&code=1");
	} 

	elseif($_GET['mod'] == 'identitas' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		$tgl_lahir = $_POST['tgl_lahir'];
		$tgl_mulai_masuk = $_POST['tgl_masuk'];
		if (isset($_POST["filename"]) or !empty($_POST["filename"])){
			$_POST["filename1"]=$_POST["filename"];

			$file = "../../foto/identitas/".$_POST['filename'];
			$gbr_asli = imagecreatefromjpeg($file);
			$lebar = imagesx($gbr_asli);
			$tinggi = imagesy($gbr_asli);
			
			$tum_lebar = 252;
			$tum_tinggi = 310;
			
			$gbr_thumb = imagecreatetruecolor($tum_lebar, $tum_tinggi);
			imagecopyresampled($gbr_thumb, $gbr_asli, 0, 0, 0, 0, $tum_lebar, $tum_tinggi, $lebar, $tinggi);
			
			imagejpeg($gbr_thumb, "../../foto/identitas/thumb/small_".$_POST['filename']);
			
			imagedestroy($gbr_asli);
			imagedestroy($gbr_thumb);
		}
		//$tanggal_keluar_sertifikasi_identitas = $_POST['tgl_sertifikasi'];
		//KDPTIMSKARY = ?,
		//KDPSTMSKARY = ?,
		//KDJENMSKARY = ?,
		$cabang = explode(" : ", $_POST['cabang']);
		$ranting = explode(" : ", $_POST['ranting']);
		$koja = explode(" : ", $_POST['koja']);
		$kecamatan = explode("*", $_POST['kecamatan']);
		$kabupaten = explode("*", $_POST['kabupaten']);
		$desa = explode("*", $_POST['desa']);
		$db->database_prepare("UPDATE master_data SET nik_lama = ?,
													tgl_masuk = ?,
													tempat_daftar = ?,
													no_ktp = ?,
													nama = ?,
													gelar_akademik = ?,
													pendidikan_tertinggi = ?,
													tempat_lhr = ?,
													tgl_lahir = ?,
													kode_jk = ?,
													status = ?,
													status_ikatan_kerja = ?,
													cabang = ?,
													ranting = ?,
													koja = ?,
													lahan = ?,
													foto = ?,
													alamat_ktp = ?,
													jalan = ?,
													no_rumah = ?,
													rt = ?,
													rw = ?,
													dukuh = ?,
													desa = ?,
													kecamatan = ?,
													kabupaten = ?,
													propinsi = ?,
													kode_pos = ?,
													negara = ?,
													telepon = ?,
													hp = ?,
													email = ?,
													modified_date = ?,
												modified_userid = ?
												WHERE id_identitas = ?")
									->execute(	$_POST["nik_lama"],
													$tgl_mulai_masuk,
													$_POST["tempat_daftar"],
													$_POST["no_ktp"],
													$_POST["nama"],
													$_POST["gelar_akademik"],
													$_POST["pendidikan_tertinggi"],
													$_POST["tempat_lhr"],
													$tgl_lahir,
													$_POST["kode_jk"],
													$_POST["status"],
													$_POST["status_ikatan_kerja"],
													$cabang[1],
													$ranting[1],
													$koja[1],
													$_POST["lahan"],
													$_POST["filename1"],
													$_POST["alamat_ktp"],
													$_POST["jalan"],
													$_POST["no_rumah"],
													$_POST["rt"],
													$_POST["rw"],
													$_POST["dukuh"],
													$desa[0],
													$kecamatan[0],
													$kabupaten[0],
													$_POST["propinsi"],
													$_POST["kode_pos"],
													$_POST["negara"],
													$_POST["telepon"],
													$_POST["hp"],
													$_POST["email"],
												$modified_date,
												$_SESSION["userid"],
												$_POST["id"]);
		header("Location: ../../index.php?mod=identitas&code=2");
	}

	elseif ($_GET['mod'] == 'identitas' && $_GET['act'] == 'delete'){
		$dataimage = $db->database_fetch_array($db->database_prepare("SELECT foto FROM master_data WHERE id_identitas = ?")->execute($_GET["id"]));
		if ($dataimage['foto'] != ''){
			$del_image = unlink("../../foto/identitas/".$dataimage['foto']);
		}
		
		$db->database_prepare("DELETE FROM master_data WHERE id_identitas = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=identitas&code=3");
	}
}
?>