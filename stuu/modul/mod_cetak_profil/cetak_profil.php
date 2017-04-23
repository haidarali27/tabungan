<?php
error_reporting(0);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
include "../../../fungsi/fungsi_date.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../login.php?code=2");
}

else{
	require ("../../../fungsi/html2pdf/html2pdf.class.php");
	$filename="Data_Karyawan.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	$sql_karyawan = $db->database_prepare("SELECT 	nik,
												nama,
												gelar_akademik,
												tempat_lhr,
												tgl_lahir,
												kode_jk,
												alamat_ktp,
												telepon,
												hp
									FROM master_data
									WHERE nik = ? ")->execute($nik);
	$nums = $db->database_num_rows($sql_karyawan);
	$data_karyawan = $db->database_fetch_array($sql_karyawan);
	$sql_pendidikan = $db->database_prepare("SELECT * FROM as_riwayat_pendidikan_karyawan A INNER JOIN as_kode_perguruan_tinggi B ON B.kode_perguruan_tinggi = A.kode_perguruan_tinggi 
									  INNER JOIN as_kode_program_studi C ON C.kode_program_studi=A.kode_program_studi 
									  WHERE karyawan_id=? ORDER BY riwayat_id ASC")->execute($id_kar);
	$nums2 = $db->database_num_rows($sql_pendidikan);
	$sql_jabatan = $db->database_prepare("SELECT as_riwayat_jabatan_karyawan.status_transaksi, as_master_jabatan.nama_jabatan, as_master_unit_kerja.nama_unit_kerja, 
												as_riwayat_jabatan_karyawan.periode_awal, as_riwayat_jabatan_karyawan.periode_akhir 
												FROM as_riwayat_jabatan_karyawan INNER JOIN master_data ON master_data.id_karyawan = as_riwayat_jabatan_karyawan.karyawan_id
												INNER JOIN as_master_jabatan ON as_master_jabatan.id_jabatan = as_riwayat_jabatan_karyawan.jabatan_id
												INNER JOIN as_master_unit_kerja ON as_master_unit_kerja.id_unit_kerja = as_riwayat_jabatan_karyawan.unit_kerja_id
												WHERE as_riwayat_jabatan_karyawan.karyawan_id = ? ORDER BY as_riwayat_jabatan_karyawan.karyawan_id DESC")->execute($id_kar);
	
	
	if ($data_karyawan['KDJENMSPST'] == 'A'){
		$kd_jenjang_studi = "S3";
	}
	elseif ($data_karyawan['KDJENMSPST'] == 'B'){
		$kd_jenjang_studi = "S2";
	}
	elseif ($data_karyawan['KDJENMSPST'] == 'C'){
		$kd_jenjang_studi = "S1";
	}
	elseif ($data_karyawan['KDJENMSPST'] == 'D'){
		$kd_jenjang_studi = "D4";
	}
	elseif ($data_karyawan['KDJENMSPST'] == 'E'){
		$kd_jenjang_studi = "D3";
	}
	elseif ($data_karyawan['KDJENMSPST'] == 'F'){
		$kd_jenjang_studi = "D2";
	}
	elseif ($data_karyawan['KDJENMSPST'] == 'G'){
		$kd_jenjang_studi = "D1";
	}
	elseif ($data_karyawan['KDJENMSPST'] == 'H'){
		$kd_jenjang_studi = "Sp-1";
	}
	elseif ($data_karyawan['KDJENMSPST'] == 'I'){
		$kd_jenjang_studi = "Sp-2";
	}
	else{
		$kd_jenjang_studi = "Profesi";
	}
	$content = "
				<table>
					<tr valign='top'>
						<td><img src='../../../logo.jpg' height='50'></td>
						<td width='10'></td>
						<td>
							<b>KSPSS TUNAS ARTHA MANDIRI</b><br>
							Jl. Dermojoyo, Nganjuk - Indonesia 00000<br>
							Telp. (0358) 000 0000
						</td>
					</tr>
					<tr>
						<td colspan='3'><hr></td>
					</tr>
					<tr>
						<td colspan='3' align='center'><br><p><b><u>DATA KARYAWAN</u></b></p></td>
					</tr>
					<tr>
						<td colspan='3'><p>&nbsp;</p></td>
					</tr>
				</table>
				<table>
					<tr>
						<td width='50'>NIK</td>
						<td width='5'>:</td>
						<td><b>$data_karyawan[nik]</b></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><b>$data_karyawan[nama]</b></td>
					</tr>
					<tr>
						<td>Program Studi</td>
						<td>:</td>
						<td><b>$kd_jenjang_studi - $data_karyawan[NMPSTMSPST]</b></td>
					</tr>
					<tr>
						<td>Kelas - Semester</td>
						<td>:</td>
						<td><b>$data_karyawan[nama_kelas] - $data_karyawan[semester_kelas]</b></td>
					</tr>
					<tr>
						<td>KRS Semester</td>
						<td>:</td>
						<td><b>$data_karyawan[krs_semester]</b></td>
					</tr>
				</table>	<br>
				<table cellpadding=0 cellspacing=0>
					<tr>
						<th width='25' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>No</th>
						<th align='center' width='80' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Kode MTK</th>
						<th align='center' width='330' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Nama MTK</th>
						<th width='120' align='center' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Jumlah SKS</th>
					</tr>
			";
			$i = 1;
			$sql_pendidikan = $db->database_prepare("SELECT * FROM as_krs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id = B.jadwal_id
										INNER JOIN as_makul C ON C.mata_kuliah_id = B.makul_id
										INNER JOIN msdos D ON D.IDDOSMSDOS = B.dosen_id
										WHERE A.id_mhs = ? AND B.semester = ?")->execute($data_karyawan['id_mhs'],$_GET['semester']);
			while ($data_krs = $db->database_fetch_array($sql_pendidikan)){
			$content .= "<tr>
						<td style='border:1px solid #000; padding: 2px;'>$i</td>
						<td style='border:1px solid #000; padding: 2px;'>$data_krs[kode_mata_kuliah]</td>
						<td style='border:1px solid #000; padding: 2px;'>$data_krs[nama_mata_kuliah_eng]</td>
						<td style='border:1px solid #000; padding: 2px;' align='center'>$data_krs[sks_mata_kuliah]</td>
					</tr>";
				$grand_sks += $data_krs['sks_mata_kuliah'];
				$i++;
			}				
			$nip = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_users WHERE user_id = ?")->execute($_SESSION["userid"]));
			$content .= "
					<tr>
						<td colspan='3' align='right' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'><b>Total SKS</b></td>
						<td style='border:1px solid #000; background-color: #9CCC68; padding: 2px;' align='center'><b>$grand_sks</b></td>
					</tr>
					</table>
					<p>&nbsp;</p>
					<table>
						<tr>
							<td width='400'></td>
							<td align='center'>Cirebon, $date_now<br>
							BAAK<br>
								<p></p>
								<u>$_SESSION[nama_lengkap]</u><br>
								<b>NIP. $nip[nip]</b> 
							</td>
						</tr>
					</table>
					";	
			
			
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('P','A4','fr', false, 'ISO-8859-15',array(10, 10, 10, 10)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>