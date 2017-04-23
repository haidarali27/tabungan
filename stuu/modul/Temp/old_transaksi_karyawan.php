<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Transaksi karyawan berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Transaksi karyawan berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Transaksi karyawan berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$( "#datepicker1" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: 'c-65:c-0'
		});
		
		$( "#datepicker2" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: '2013:c-0'
		});
		
		$('#frm_karyawan').validate({
			rules:{
				nid: true,
				transaksi: true
			},
			messages:{
				nid:{
					required: "Pilih NIP/Nama karyawan."
				},
				transaksi:{
					required: "Pilih transaksi karyawan."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Transaksi karyawan</h5>
	<div>
		<a title="Tambah transaksi karyawan" href="?mod=trx_karyawan&act=add"><button type="button" class="btn btn-green">+ Tambah Transaksi karyawan</button></a>
	</div><br>
	<table class="data display datatable" id="example">
		<thead>
			<tr>
				<th width="30">No</th>
				<th width="100">NIK</th>
				<th width="180">Nama karyawan</th>
				<th width="110">Gelar Akademik</th>
				<th width="140">Status Trx karyawan</th>
				<th width="130">Periode Awal</th>
				<th width="130">Periode Akhir</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			$sql_karyawan = $db->database_prepare("SELECT * FROM as_transaksi_karyawan INNER JOIN msdos ON msdos.IDDOSMSDOS = as_transaksi_karyawan.karyawan_id
												WHERE STDOSMSDOS != 'A' GROUP BY as_transaksi_karyawan.karyawan_id DESC")->execute();
			while ($data_karyawan = $db->database_fetch_array($sql_karyawan)){
				if ($data_karyawan['status_transaksi'] == 'A'){
					$status = "Aktif Mengajar";
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
				else{
					$status = "Almarhum";
				}
				
				$periode_awal = tgl_indo($data_karyawan['periode_awal']);
				$periode_akhir = tgl_indo($data_karyawan['periode_akhir']);
				echo "	<tr>
							<td>$i</td>
							<td>$data_karyawan[NODOSMSDOS]</td>
							<td>$data_karyawan[NMDOSMSDOS]</td>
							<td>$data_karyawan[GELARMSDOS]</td>
							<td>$status</td>
							<td>$periode_awal</td>
							<td>$periode_akhir</td>
							<td><a title='Ubah' href='?mod=trx_karyawan&act=edit&id=$data_karyawan[trx_id]'><img src='../images/edit.jpg' width='20'></a> ";
							?>
							<a title="Batalkan" href="modul/mod_karyawan/aksi_transaksi_karyawan.php?mod=trx_karyawan&act=delete&id=<?php echo $data_karyawan[trx_id];?>" onclick="return confirm('Anda Yakin ingin membatalkan transaksi karyawan #<?php echo $data_karyawan[trx_id];?>?');"><img src='../images/delete.jpg' width='20'></a>
							<?php
							echo "</td>
						</tr>";
				$i++;
			}
			?>
		</tbody>
	</table>
<?php

	break;
	
	case "add":
?>
	<p><a href="?mod=trx_karyawan"><img src="../images/back.png"></a></p>
	<h5>Tambah Transaksi</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_karyawan" action="modul/mod_karyawan/aksi_transaksi_karyawan.php?mod=trx_karyawan&act=input" method="POST">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>NID / Nama karyawan</label></td>
					<td><select name="nid" class="required">
							<option value="">- none -</option>
							<?php
							$sql_karyawan = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS ='A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_karyawan = $db->database_fetch_array($sql_karyawan)){
								echo "<option value=$data_karyawan[IDDOSMSDOS]>$data_karyawan[NODOSMSDOS] - $data_karyawan[NMDOSMSDOS] $data_karyawan[GELARMSDOS]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Transaksi</label></td>
					<td><select name="transaksi" class="required">
							<option value="">- none -</option>
							<option value="A">Aktif Mengajar</option>
							<option value="C">Cuti</option>
							<option value="K">Keluar/Pensiun</option>
							<option value="S">Studi Lanjut</option>
							<option value="T">Tugas di Instansi Lain</option>
							<option value="M">Almarhum</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Periode Awal</label></td>
					<td><input type="text" name="periode_awal" id="datepicker1"></td>
				</tr>
				<tr valign="top">
					<td><label>Periode Akhir</label></td>
					<td><input type="text" name="periode_akhir" id="datepicker2"></td>
				</tr>
				<tr valign="top">
					<td><label>Keterangan</label></td>
					<td><textarea name="keterangan" class="ckeditor"></textarea></td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary">Lanjutkan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<?php
	break;
	
	case "edit":
	$data_trx = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_transaksi_karyawan INNER JOIN msdos ON msdos.IDDOSMSDOS=as_transaksi_karyawan.karyawan_id WHERE trx_id = ?")->execute($_GET["id"]));
?>	
	<p><a href="?mod=trx_karyawan"><img src="../images/back.png"></a></p>
	<h5>Ubah Transaksi</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_karyawan" action="modul/mod_karyawan/aksi_transaksi_karyawan.php?mod=trx_karyawan&act=update" method="POST">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>NID / Nama karyawan</label></td>
					<td><b><?php echo $data_trx['NODOSMSDOS']; ?> - <?php echo $data_trx['NMDOSMSDOS']; ?> <?php echo $data_trx['GELARMSDOS']; ?></b><br><br>
							<input type="hidden" name="id" value="<?php echo $data_trx['trx_id']; ?>">
							<input type="hidden" name="karyawan_id" value="<?php echo $data_trx['karyawan_id']; ?>">
					</td>
				</tr>
				<tr valign="top">
					<td><label>Transaksi</label></td>
					<td><select name="transaksi" class="required">
							<option value="A" <?php if ($data_trx['status_transaksi'] == 'A'){ echo "SELECTED"; } ?>>Aktif Mengajar</option>
							<option value="C" <?php if ($data_trx['status_transaksi'] == 'C'){ echo "SELECTED"; } ?>>Cuti</option>
							<option value="K" <?php if ($data_trx['status_transaksi'] == 'K'){ echo "SELECTED"; } ?>>Keluar/Pensiun</option>
							<option value="S" <?php if ($data_trx['status_transaksi'] == 'S'){ echo "SELECTED"; } ?>>Studi Lanjut</option>
							<option value="T" <?php if ($data_trx['status_transaksi'] == 'T'){ echo "SELECTED"; } ?>>Tugas di Instansi Lain</option>
							<option value="M" <?php if ($data_trx['status_transaksi'] == 'M'){ echo "SELECTED"; } ?>>Almarhum</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Periode Awal</label></td>
					<td><input type="text" name="periode_awal" id="datepicker1" value="<?php echo $data_trx['periode_awal']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Periode Akhir</label></td>
					<td><input type="text" name="periode_akhir" id="datepicker2" value="<?php echo $data_trx['periode_akhir']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Keterangan</label></td>
					<td><textarea name="keterangan" class="ckeditor"><?php echo $data_trx['keterangan']; ?></textarea></td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary">Lanjutkan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<?php
	break;
}
?>