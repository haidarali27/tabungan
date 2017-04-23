<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Karyawan baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Karyawan berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data karyawan berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
<script type="text/javascript" src="../js/jquery.autocomplete.js"></script>

<script type='text/javascript'>
	$(document).ready(function() {
		$("#tag").autocomplete("modul/mod_cetak_profil/autocomplete.php", {
			selectFirst: true
		});

		$('#frm_form').validate({
			rules:{
				nik: true,
				
			},
			messages:{
				nim:{
					required: "Masukkan NIK terlebih dahulu."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Cetak Karyawan</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form action="" method="GET" id="frm_form">
			<input type="hidden" name="mod" value="kartu_profil">
			<input type="hidden" name="act" value="detail">
			<table class='form'>
				<tr valign="top">
					<td width="200"><label>NIK Karyawan</label></td>
					<td><input type="text" name="nik" id="tag" size="40" maxlength="150" class="required"></td>
				</tr>
				
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary">Buka Data</button></td>
				</tr>
			</table>
		</div>
	</div>
<?php

	break;
	
	case "detail":
	$nik = explode(" : ", $_GET['nik']);
	$sql_mhs = $db->database_prepare("SELECT 	nik,
												nama,
												gelar_akademik,
												tempat_lhr,
												tgl_lahir,
												kode_jk,
												alamat_ktp,
												telepon,
												hp
									FROM master_data
									WHERE nik = ? ")->execute($nik[1]);
	$nums = $db->database_num_rows($sql_mhs);
	$data_mhs = $db->database_fetch_array($sql_mhs);
	$sql_krs = $db->database_prepare("SELECT * FROM as_riwayat_pendidikan_karyawan A INNER JOIN as_kode_perguruan_tinggi B ON B.kode_perguruan_tinggi = A.kode_perguruan_tinggi 
									  INNER JOIN as_kode_program_studi C ON C.kode_program_studi=A.kode_program_studi 
									  WHERE karyawan_id=? ORDER BY riwayat_id ASC")->execute($nik[2]);
	$nums2 = $db->database_num_rows($sql_krs);
	$sql_karyawan = $db->database_prepare("SELECT as_riwayat_jabatan_karyawan.status_transaksi, as_master_jabatan.nama_jabatan, as_master_unit_kerja.nama_unit_kerja, 
												as_riwayat_jabatan_karyawan.periode_awal, as_riwayat_jabatan_karyawan.periode_akhir 
												FROM as_riwayat_jabatan_karyawan INNER JOIN master_data ON master_data.id_karyawan = as_riwayat_jabatan_karyawan.karyawan_id
												INNER JOIN as_master_jabatan ON as_master_jabatan.id_jabatan = as_riwayat_jabatan_karyawan.jabatan_id
												INNER JOIN as_master_unit_kerja ON as_master_unit_kerja.id_unit_kerja = as_riwayat_jabatan_karyawan.unit_kerja_id
												WHERE as_riwayat_jabatan_karyawan.karyawan_id = ? ORDER BY as_riwayat_jabatan_karyawan.karyawan_id DESC")->execute($nik[2]);
	
	if ($nums == 0 || $nums2 == 0){
		echo "<p>&nbsp;</p><div class='well'>NIK/Nama Karyawan tidak ditemukan <br><a href='javascript:history.go(-1)'>Back</a></div>";
	}
	else{
		
		echo "<a href='index.php?mod=kartu_profil'><img src='../images/back.png'></a>
			<div class='message info'>
				<h5>
				Data Karyawan</h5>
			</div>
		
			<div class='box round first fullpage'>
				<div class='block '>
				<table class='form'>
					<tr valign=top>
						<td width='100'>NIK</td>
						<td><b>$data_mhs[nik] <input type='hidden' name='id_kar' value='$data_mhs[id_karyawan]'></b></td>
					</tr>
					<tr valign=top>
						<td>Nama</td>
						<td><b>$data_mhs[nama] $data_mhs[gelar_akademik]</b></td>
					</tr>
					<tr valign=top>
						<td>TTL</td>
						<td><b>$data_mhs[tempat_lhr], $data_mhs[tgl_lahir]</b></td>
					</tr>
					<tr valign=top>
						<td>JK</td>
						<td><b>$data_mhs[kode_jk] </b></td>
					</tr>
					<tr valign=top>
						<td>Alamat</td>
						<td><b>$data_mhs[alamat_ktp]</b></td>
					</tr>
					<tr valign=top>
						<td>No. telp/HP</td>
						<td><b>$data_mhs[telepon]/$data_mhs[hp]</b></td>
					</tr>
				</table>
			</div></div>";
		
		echo "<div class='message info'>
				<h5>
				Riwayat Pendidikan</h5>
			</div>
		";
		echo "<table class='data display datatable' id='example'>
				<thead>
					<tr>
						<th width='30'>No</th>
						<th width='200'>Nama Perguruan Tinggi</th>
						<th width='150'>Program Studi</th>
						<th width='120'>Gelar Akademik</th>
						<th width='120'>Tanggal Ijazah</th>
						<th width='80'>SKS Lulus</th>
						<th width='100'>IPK Akhir</th>

					</tr>
				</thead><tbody>";
		$i = 1; 
		while ($data_riwayat = $db->database_fetch_array($sql_krs)){
			/*if ($data_riwayat['program'] == 'A'){
				$program = "Reguler";
			}
			else{
				$program = "Non-Reguler";
			}
			*/
			
			if ($data_riwayat['kode_jenjang_studi'] == 'A'){
				$kd_jenjang_studi = "S3";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'B'){
				$kd_jenjang_studi = "S2";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'C'){
				$kd_jenjang_studi = "S1";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'D'){
				$kd_jenjang_studi = "D4";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'E'){
				$kd_jenjang_studi = "D3";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'F'){
				$kd_jenjang_studi = "D2";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'G'){
				$kd_jenjang_studi = "D1";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'H'){
				$kd_jenjang_studi = "Sp-1";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'I'){
				$kd_jenjang_studi = "Sp-2";
			}
			else{
				$kd_jenjang_studi = "Profesi";
			}
			
			$tgl = tgl_indo($data_riwayat['tanggal_ijazah']);
			echo "<tr valign=top>
					<td>$i</td>
					<td>$data_riwayat[nama_perguruan_tinggi]</td>
					<td>$kd_jenjang_studi $data_riwayat[nama_program_studi]</td>
					<td>$data_riwayat[gelar_akademik]</td>
					<td>$tgl</td>
					<td>$data_riwayat[sks_lulus]</td>
					<td>$data_riwayat[ipk_akhir]</td>
					
				</tr>";
			$i++;
		}
		echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p><br>
				<div class='message info'>
				<h5>
				Riwayat Jabatan</h5>
			</div>
		";
		echo "<table class='data display datatable' id='example1'>
				<thead>
				<tr>
							<th>No</th>
							<th>Jabatan</th>
							<th>Wilayah</th>
							<th>Status</th>
							<th>Periode Awal</th>
							<th>Periode Akhir</th>
				</tr>
				</thead><tbody>";
		$i = 1; 
		while ($data_karyawan = $db->database_fetch_array($sql_karyawan)){
			if ($data_karyawan['status_transaksi'] == 'A'){
					$status = "Aktif";
				}
				elseif ($data_karyawan['status_transaksi'] == 'C'){
					$status = "Cuti";
				}
				elseif ($data_karyawan['status_transaksi'] == 'K'){
					$status = "Keluar/Pensiun";
				}
				elseif ($data_karyawan['status_transaksi'] == 'S'){
					$status = "Studi Lanjut";
				}
				elseif ($data_karyawan['status_transaksi'] == 'T'){
					$status = "Tugas di Instansi Lain";
				}
				elseif ($data_karyawan['status_transaksi'] == 'N'){
					$status = "Non-Aktif";
				}
				else{
					$status = "Almarhum";
				}
				
				$periode_awal = tgl_indo($data_karyawan['periode_awal']);
				$periode_akhir = tgl_indo($data_karyawan['periode_akhir']);
				echo "	<tr>
							<td>$i</td>
							<td>$data_karyawan[nama_jabatan]</td>
							<td>$data_karyawan[nama_unit_kerja]</td>
							<td>$status</td>
							<td>$periode_awal</td>
							<td>$periode_akhir</td>							
						</tr>";
				$i++;
			}

		echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>";
		/*echo "
				<table id="example2" class="display"'>
					
					<tr valign=top>
						<td>No. telp/HP</td>
						<td><b>$data_mhs[telepon]/$data_mhs[hp]</b></td>
					</tr>
				</table>
			";*/	
		echo "<div>
			<a title='Cetak' href='modul/mod_cetak_profil/cetak_profil.php?act=export&act=pdf&id_kar=$data_mhs[id_karyawan]&nik=$data_mhs[nik]' target='_blank'><button type='button' class='btn btn-green'>Export to PDF</button></a>
		</div>";
	}
	break;
}
?>