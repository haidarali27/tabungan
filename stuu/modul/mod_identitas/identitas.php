<?php
if ($_GET['act'] == 'add' || $_GET['act'] == 'edit'){
?>
	<script type="text/javascript" src="../js/ajaxupload.3.5.js" ></script>
	<link rel="stylesheet" type="text/css" href="../css/Ajaxfile-upload.css" />
	<script type="text/javascript" >
		$(function(){
			var btnUpload=$('#me');
			var mestatus=$('#mestatus');
			var files=$('#files');
			new AjaxUpload(btnUpload, {
				action: 'modul/mod_identitas/upload_identitas.php',
				name: 'uploadfile',
				onSubmit: function(file, ext){
					 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
	                    // extension is not allowed 
						mestatus.text('Only JPG, PNG or GIF files are allowed');
						return false;
					}
					mestatus.html('<img src="ajax-loader.gif" height="16" width="16">');
				},
				onComplete: function(file, response){
					//On completion clear the status
					mestatus.text('');
					//On completion clear the status
					files.html('');
					//Add uploaded file to list
					if(response==="success"){
						$('<li></li>').appendTo('#files').html('<img src="foto/identitas/gb_'+file+'" alt="" width="120" /><br />').addClass('success');
						$('<li></li>').appendTo('#identitas').html('<input type="hidden" name="filename" value="gb_'+file+'">').addClass('nameupload');
						
					} else{
						$('<li></li>').appendTo('#files').text(file).addClass('error');
					}
				}
			});
			
		});
	</script>
<?php
}
?>

<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
<script type="text/javascript" src="../js/jquery.autocomplete.js"></script>

<script type='text/javascript'>
	$(document).ready(function() {

		$("#tagcabang").autocomplete("modul/mod_identitas/autocabang.php", {
			selectFirst: true
		});
		
		$("#tagranting").autocomplete("modul/mod_identitas/autoranting.php", {
			selectFirst: true
		});

		$("#tagkoja").autocomplete("modul/mod_identitas/autokoja.php", {
			selectFirst: true
		});
		
		$("#propinsi").change(function(){
			var propinsi = $("#propinsi").val();
			$.ajax({
				url: "modul/mod_identitas/ambilkabkota.php",
				data: "propinsi="+propinsi,
				cache: false,
				success: function(msg){
					$("#kabupaten").html(msg);
				}
			});
		});

		$("#kabupaten").change(function(){
			var kabupaten = $("#kabupaten").val();
			$.ajax({
				url: "modul/mod_identitas/ambilkecamatan.php",
				data: "kabupaten="+kabupaten,
				cache: false,
				success: function(msg){
					$("#kecamatan").html(msg);
				}
			});
		});

		$("#kecamatan").change(function(){
			var kecamatan = $("#kecamatan").val();
			$.ajax({
				url: "modul/mod_identitas/ambildesa.php",
				data: "kecamatan="+kecamatan,
				cache: false,
				success: function(msg){
					$("#desa").html(msg);
				}
			});
		});

		$( "#datepicker1" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: 'c-90:2014'
		});
		
		$( "#datepicker2" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: '2013:c-0'
		});
		
		$( "#datepicker3" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: 'c-90:2014'
		});
		
		$('#frm_identitas').validate({
			rules:{
				nokarymskary: true,
				kdwilmskary: true,
				nmkarymskary: true,
				gelarmskary: true,
				kdjkmskary: true,
				tplhrmskary: true,
				tgl_lahir: true,
				stkarymskary: true,
				tgl_masuk: true
			},
			messages:{
				nokarymskary:{
					required: "No ID Wajib Diisi."
				},
				kdwilmskary:{
					required: "Wilayah Kerja Wajib Diisi."
				},
				nmkarymskary:{
					required: "Nama Wajib Diisi."
				},
				gelarmskary:{
					required: "Gelar Akademik Wajib Diisi."
				},
				kdjkmskary:{
					required: "Jenis Kelamin Wajib Diisi."
				},
				tplhrmskary:{
					required: "Tempat Lahir Wajib Diisi."
				},
				stkarymskary:{
					required: "Status Wajib Diisi."
				},
				tgl_masuk:{
					required: "Mulai Masuk Wajib Diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h4>Data Diri</h4><br>
	<div>
		<a href="?mod=identitas&act=add"><button type="button" class="btn btn-green">+ Tambah Data</button></a>
	</div><br>
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width="30">No</th>
			<th width="100">NIK</th>
			<!--<th>NIP PNS</th>
			<th>NIP</th>-->
			<th width="100">No KTP</th>
			<th width="180">Nama</th>
			<th width="100">Gelar Akademik</th>
			<th width="30">JK</th>
			<th width="120">Email</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_identitas = $db->database_prepare("SELECT A.id_identitas, A.nik, A.no_ktp, A.nama, A.gelar_akademik, A.kode_jk, A.email
									FROM master_data A ORDER BY A.nama ASC")->execute();
	while ($data_identitas = $db->database_fetch_array($sql_identitas)){
		//<td>$data_identitas[NIPNSMSKARY]</td>
			//<td>$data_identitas[NIP]</td>
		echo "
		<tr>
			<td>$no</td>
			<td>$data_identitas[nik]</td>
			<td>$data_identitas[no_ktp]</td>
			<td>$data_identitas[nama]</td>
			<td>$data_identitas[gelar_akademik]</td>
			<td>$data_identitas[kode_jk]</td>
			<td>$data_identitas[email]</td>
			<td><a title='Cetak KTP' href='?mod=identitas&act=card&id=$data_identitas[id_identitas]'><img src='../images/id_card.png' width='20'></a>
			    <a title='Ubah' href='?mod=identitas&act=edit&id=$data_identitas[id_identitas]'><img src='../images/edit.jpg' width='20'></a>";

			?>
				<a title='Hapus' href="modul/mod_identitas/aksi_identitas.php?mod=identitas&act=delete&id=<?php echo $data_identitas[id_identitas];?>" onclick="return confirm('Anda Yakin ingin menghapus identitas <?php echo $data_identitas[nama]." ".$data_identitas[gelar_akademik];?>?');"><img src='../images/delete.jpg' width='20'></a>
			<?php
			echo "</td>
		</tr>";
		$no++;
	} 
	?>
	</tbody>
</table>
<?php

	break;
	
	case "add":
	$tahun = date("Y");
	$month = date('m');
	$sql_urut = $db->database_prepare("SELECT id_identitas FROM master_data ORDER BY id_identitas DESC LIMIT 1")->execute();
	$num_urut = $db->database_num_rows($sql_urut);
	
	$data_urut = $db->database_fetch_array($sql_urut);
	$awal = substr($data_urut['id_identitas'],0-4);
	$next = $awal + 1;
	$jnim = strlen($next);
	
	if (!$data_urut['id_identitas']){
		$no = "0001";
	}
	elseif($jnim == 1){
		$no = "000";
	} 
	elseif($jnim == 2){
		$no = "00";
	}
	elseif($jnim == 3){
		$no = "0";
	}
	elseif($jnim == 4){
		$no = "";
	}
	if ($num_urut == 0){
		$npm = $tahun.$month.$no;
	}
	else{
		$npm = $tahun.$month.$no.$next;
	}
?>
	<p><a href="?mod=identitas"><img src="../images/back.png"></a></p>
	<h5>Tambah Data</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_identitas" action="modul/mod_identitas/aksi_identitas.php?mod=identitas&act=input" method="POST" enctype="multipart/form-data">
			<table class="form">
				<tr valign="top">
					<td width="200"><label> Nomor ID </label></td>
					<td><input type="text" name="nik" size="40" maxlength="10" value="<?php echo $npm; ?>" DISABLED>
						<input type="hidden" name="nik" size="40" maxlength="10" value="<?php echo $npm; ?>">
					</td>
				</tr>
				<tr valign="top">
					<td><label>NoID Lama<font color="red">*</font> <i>NIK Lama</i></label></td>
					<td><input type="text" class="required" name="nik_lama" size="40" maxlength="50"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Masuk <!--<font color="red">*</font>--></label></td>
					<td><input type="text" name="tgl_masuk" size="40" maxlength="10" id="datepicker2"></td>
				</tr>
				<tr valign="top">
					<td><label>Tempat Daftar <font color="red">*</font></label></td>
					<td><select name="tempat_daftar" class="required">
							<option value="">- none -</option>
							<option value="0">Pusat</option>
							<option value="1">Jawa Timur</option>
							<option value="2">Jawa Tengah</option>
							<option value="3">Jawa Barat</option>
						</select>
					</td>
				</tr>	
				<tr valign="top">
					<td><label>Nomor KTP</label></td>
					<td><input type="text" name="no_ktp" size="40" maxlength="25"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama  <font color="red">*</font> <i>Nama </i></label></td>
					<td><input type="text" class="required" name="nama" size="40" maxlength="50"></td>
				</tr>
				<tr valign="top">
					<td><label>Gelar Akademik Tertinggi <font color="red">*</font></label></td>
					<td><input type="text" class="required" name="gelar_akademik" size="40" maxlength="10"></td>
				</tr>
				<tr valign="top">
					<td><label>Pendidikan Tertinggi</label></td>
					<td><select name="pendidikan_tertinggi">
							<option value="">- none -</option>
							<option value="A">S3</option>
							<option value="B">S2</option>
							<option value="C">S1</option>
							<option value="D">Sp-1</option>
							<option value="E">Sp-2</option>
							<option value="F">D4</option>
							<option value="G">D3</option>
							<option value="H">D2</option>
							<option value="I">D1</option>
							<option value="J">Profesi</option>
							<option value="K">SMA/SMK/MA</option>
							<option value="L">SMP/MTS</option>
							<option value="M">SD/MI</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Tempat Lahir <!--<font color="red">*</font>--></label></td>
					<td><input type="text" name="tempat_lhr" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Lahir <!--<font color="red">*</font>--></label></td>
					<td><input type="text" name="tgl_lahir" size="40" maxlength="10" id="datepicker1"></td>
				</tr>
				<tr valign="top">
					<td><label>Jenis Kelamin <font color="red">*</font></label></td>
					<td><select name="kode_jk" class="required">
							<option value="">- none -</option>
							<option value="L">Laki-Laki</option>
							<option value="P">Perempuan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>STATUS</label></td>
					<td><select name="status">
							<option value="">- none -</option>
							<option value="A">Belum Menikah</option>
							<option value="B">Menikah</option>
							<option value="C">Janda</option>
							<option value="D">Duda</option>
						</select>
					</td>
				</tr>
				
				<tr valign="top">
					<td><label>Status Kejamaahan </label></td>
					<td><select name="status_ikatan_kerja">
							<option value="">- none -</option>
							<option value="A">Jamaah</option>
							<option value="B">Simpatisan</option>
							<option value="C">Mitra</option>
						</select>
					</td>
				</tr>
				
				<tr valign="top">
					<td><label>Cabang </label></td>
					<td><input name="cabang" type="text" id="tagcabang" size="40" class="required"/></td>
				</tr>
				<tr valign="top">
					<td><label>Ranting </label></td>
					<td><input name="ranting" type="text" id="tagranting" size="40" class="required"/></td>
				</tr>
				<tr valign="top">
					<td><label>Koja </label></td>
					<td><input name="koja" type="text" id="tagkoja" size="40" class="required"/></td>
				</tr>
				<tr valign="top">
					<td><label>Luas Lahan</label></td>
					<td><input type="text" name="lahan" maxlength="20"> <label>M2 (Meter Persegi)</label> </td>
				</tr>
				<tr valign="top">
					<td><label>Foto</label></td>
					<td><div id="me" class="styleall" style="cursor:pointer;">
							<label>
								<button class="btn btn-primary">Browse</button>
							</label>
						</div>
						<span id="mestatus" ></span>
						<div id="identitas">
							<li class="nameupload"></li>
						</div>
						<div id="files">
			              <li class="success">
			              </li>
			            </div>
					</td>
				</tr>
				
				<tr valign="top">
					<td><label>Alamat Sesuai KTP</label></td>
					<td><textarea name="alamat_ktp" cols="40" rows="3"></textarea></td>
				</tr>
				<tr valign="top">
					<td><label>Propinsi</label></td>
					<td><select name='propinsi' id='propinsi' class="required">
									<option value=''>- none -</option>
									<?php
										$sql_propinsi = $db->database_prepare("SELECT * FROM master_ref_provinsi order by nama ")->execute();
										while ($data_propinsi = $db->database_fetch_array($sql_propinsi)){
											echo "<option value=$data_propinsi[id]>$data_propinsi[id] - $data_propinsi[nama]</option>";
										}
								echo "</select>"; ?>
							</td>
				</tr>
				<tr valign="top">
					<td><label>Kabupaten</label></td>
					<td><select name='kabupaten' id='kabupaten'>
							<option value=''></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Kecamatan</label></td>
					<td><select name='kecamatan' id='kecamatan'>
							<option value=''></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Desa</label></td>
					<td><select name='desa' id='desa'>
							<option value=''></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Dusun/Dukuh</label></td>
					<td><input type="text" name="dukuh" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Jalan</label></td>
					<td><input type="text" name="jalan" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>No Rumah</label></td>
					<td><input type="text" name="no_rumah" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>RT</label></td>
					<td><input type="text" name="rt" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>RW</label></td>
					<td><input type="text" name="rw" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Kode Pos</label></td>
					<td><input type="text" name="kode_pos" size="40" maxlength="5"></td>
				</tr>
				<tr valign="top">
					<td><label>Kewarganegaraan</label></td>
					<td><select name="negara">
							<option value="">- none -</option>
							<option value="A">WNI</option>
							<option value="B">WNA</option>
						</select>
					</td>
				</tr>
				
				<tr valign="top">
					<td><label>Telepon</label></td>
					<td><input type="text" name="telepon" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Hp</label></td>
					<td><input type="text" name="hp" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Email</label></td>
					<td><input type="text" name="email" maxlength="40"></td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary">Simpan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<?php
	break;
	
	case "edit":
	$data_identitas = $db->database_fetch_array($db->database_prepare("SELECT * FROM master_data 
		INNER JOIN master_ref_cabang ON master_ref_cabang.id_unit_cabang = master_data.cabang
		INNER JOIN master_ref_ranting ON master_ref_ranting.id_unit_ranting = master_data.ranting
		INNER JOIN master_ref_koja ON master_ref_koja.id_unit_koja = master_data.koja
		WHERE id_identitas = ?")->execute($_GET["id"]));
?>	
	<p><a href="?mod=identitas"><img src="../images/back.png"></a></p>
	<h5>Ubah Data</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_identitas" action="modul/mod_identitas/aksi_identitas.php?mod=identitas&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_identitas['id_identitas']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Nomor ID</label></td>
					<td><input type="text" name="nik" size="40" class="required" maxlength="10" value="<?php echo $data_identitas['nik']; ?>" DISABLED></td>
				</tr>
				<tr valign="top">
					<td width="200"><label>Nomor ID Lama</label></td>
					<td><input type="text" name="nik_lama" size="40" class="required" maxlength="10" value="<?php echo $data_identitas['nik_lama']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Masuk <!--<font color="red">*</font>--></label></td>
					<td><input type="text" name="tgl_masuk" size="40" maxlength="10" id="datepicker2" value="<?php echo $data_identitas['tgl_masuk']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tempat Daftar <font color="red">*</font></label></td>
					<td><select name="tempat_daftar" class="required">
							<option value="0" <?php if($data_identitas['tempat_daftar'] == '0'){ echo "SELECTED"; } ?>>Pusat</option>
							<option value="1" <?php if($data_identitas['tempat_daftar'] == '1'){ echo "SELECTED"; } ?>>Jawa Timur</option>
							<option value="2" <?php if($data_identitas['tempat_daftar'] == '2'){ echo "SELECTED"; } ?>>Jawa Tengah</option>
							<option value="3" <?php if($data_identitas['tempat_daftar'] == '3'){ echo "SELECTED"; } ?>>Jawa Barat</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Nomor KTP</label></td>
					<td><input type="text" name="no_ktp" size="40" maxlength="25" value="<?php echo $data_identitas['no_ktp']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama<font color="red">*</font> <i>Nama</i></label></td>
					<td><input type="text" class="required" name="nama" size="40" maxlength="30" value="<?php echo $data_identitas['nama']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Gelar Akademik Tertinggi <font color="red">*</font></label></td>
					<td><input type="text" class="required" name="gelar_akademik" size="40" maxlength="10" value="<?php echo $data_identitas['gelar_akademik']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Pendidikan Tertinggi</label></td>
					<td><select name="pendidikan_tertinggi">
							<option value="">- none -</option>
							<option value="A" <?php if($data_identitas['pendidikan_tertinggi'] == 'A'){ echo "SELECTED"; } ?>>S3</option>
							<option value="B" <?php if($data_identitas['pendidikan_tertinggi'] == 'B'){ echo "SELECTED"; } ?>>S2</option>
							<option value="C" <?php if($data_identitas['pendidikan_tertinggi'] == 'C'){ echo "SELECTED"; } ?>>S1</option>
							<option value="D" <?php if($data_identitas['pendidikan_tertinggi'] == 'D'){ echo "SELECTED"; } ?>>Sp-1</option>
							<option value="E" <?php if($data_identitas['pendidikan_tertinggi'] == 'E'){ echo "SELECTED"; } ?>>Sp-2</option>
							<option value="F" <?php if($data_identitas['pendidikan_tertinggi'] == 'F'){ echo "SELECTED"; } ?>>D4</option>
							<option value="G" <?php if($data_identitas['pendidikan_tertinggi'] == 'G'){ echo "SELECTED"; } ?>>D3</option>
							<option value="H" <?php if($data_identitas['pendidikan_tertinggi'] == 'H'){ echo "SELECTED"; } ?>>D2</option>
							<option value="I" <?php if($data_identitas['pendidikan_tertinggi'] == 'I'){ echo "SELECTED"; } ?>>D1</option>
							<option value="J" <?php if($data_identitas['pendidikan_tertinggi'] == 'J'){ echo "SELECTED"; } ?>>Profesi</option>
							<option value="K" <?php if($data_identitas['pendidikan_tertinggi'] == 'K'){ echo "SELECTED"; } ?>>SMA/SMK/MA</option>
							<option value="L" <?php if($data_identitas['pendidikan_tertinggi'] == 'L'){ echo "SELECTED"; } ?>>SMP/MTS</option>
							<option value="M" <?php if($data_identitas['pendidikan_tertinggi'] == 'M'){ echo "SELECTED"; } ?>>SD/MI</option>
						</select>
					</td>
				</tr>

				<tr valign="top">
					<td><label>Tempat Lahir <!--<font color="red">*</font>--></label></td>
					<td><input type="text" name="tempat_lhr" size="40" maxlength="20" value="<?php echo $data_identitas['tempat_lhr']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Lahir <!--<font color="red">*</font>--></label></td>
					<td><input type="text" name="tgl_lahir" size="40" maxlength="10" id="datepicker1" value="<?php echo $data_identitas['tgl_lahir']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Jenis Kelamin <font color="red">*</font></label></td>
					<td><select name="kode_jk" class="required">
							<option value="L" <?php if($data_identitas['kode_jk'] == 'L'){ echo "SELECTED"; } ?>>Laki-Laki</option>
							<option value="P" <?php if($data_identitas['kode_jk'] == 'P'){ echo "SELECTED"; } ?>>Perempuan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status</label></td>
					<td><select name="status">
							<option value="">- none -</option>
							<option value="A" <?php if($data_identitas['status'] == 'A'){ echo "SELECTED"; } ?>>Belum Menikah</option>
							<option value="B" <?php if($data_identitas['status'] == 'B'){ echo "SELECTED"; } ?>>Menikah</option>
							<option value="C" <?php if($data_identitas['status'] == 'C'){ echo "SELECTED"; } ?>>Janda</option>
							<option value="D" <?php if($data_identitas['status'] == 'D'){ echo "SELECTED"; } ?>>Duda</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status Kejamaahan</label></td>
					<td><select name="status_ikatan_kerja">
							<option value="">- none -</option>
							<option value="A" <?php if($data_identitas['status_ikatan_kerja'] == 'A'){ echo "SELECTED"; } ?>>Jamaah</option>
							<option value="B" <?php if($data_identitas['status_ikatan_kerja'] == 'B'){ echo "SELECTED"; } ?>>Simpatisan</option>
							<option value="C" <?php if($data_identitas['status_ikatan_kerja'] == 'C'){ echo "SELECTED"; } ?>>Mitra</option>
						</select>
					</td>
				</tr>

				
				<tr valign="top">
					<td><label>Cabang </label></td>
					<td><input name="cabang" type="text" id="tagcabang" size="40" class="required" value="<?php echo $data_identitas['nama_unit_cabang']." : ".$data_identitas['id_unit_cabang']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Ranting </label></td>
					<td><input name="ranting" type="text" id="tagranting" size="40" class="required" value="<?php echo $data_identitas['nama_unit_ranting']." : ".$data_identitas['id_unit_ranting']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Koja </label></td>
					<td><input name="koja" type="text" id="tagkoja" size="40" class="required" value="<?php echo $data_identitas['nama_unit_koja']." : ".$data_identitas['id_unit_koja']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Luas Lahan</label></td>
					<td><input type="text" name="lahan" maxlength="20" value="<?php echo $data_identitas['lahan']; ?>"> <label>M2 (Meter Persegi)</label> </td>
				</tr>
				<tr valign="top">
					<td><label>Foto</label></td>
					<td><div id="me" class="styleall" style="cursor:pointer;">
							<label>
								<button class="btn btn-primary">Browse</button>
							</label>
						</div>
						<span id="mestatus" ></span>
						<div id="identitas">
							<li class="nameupload"></li>
						</div>
						<div id="files">
			              <li class="success">
			              	<?php if ($data_identitas['foto'] != ''){ 
			              		$filephptoada=$data_identitas['foto'];?>
			              		<img src="foto/identitas/<?php echo $data_identitas['foto']; ?>" width="120">
			              		<input type="hidden" name="filename1" value="<?php echo $data_identitas['foto']; ?>">;
			              	<?php } ?>
			              </li>
				            </div>
					</td>
				</tr>
				
				<tr valign="top">
					<td><label>Alamat</label></td>
					<td><textarea name="alamat_ktp" cols="40" rows="3"><?php echo $data_identitas['alamat_ktp']; ?></textarea></td>
				</tr>
				
				<tr valign="top">
					<td><label>Propinsi</label></td>
					<td><select name='propinsi' id='propinsi' class="required">
					<?php
								$sql_propinsi = $db->database_prepare("SELECT * FROM master_ref_provinsi order by nama ")->execute();
								while ($data_propinsi = $db->database_fetch_array($sql_propinsi)){
									if ($data_propinsi[id]==$data_identitas[propinsi]){
									echo "<option value=$data_propinsi[id] SELECTED>$data_propinsi[id] - $data_propinsi[nama]</option>";
									} else
									{echo "<option value=$data_propinsi[id]>$data_propinsi[id] - $data_propinsi[nama]</option>"; 
									}
								}
								echo "</select>"; 
								?>		
							
					</td>
					
				</tr>
				<tr valign="top">
					<td><label>Kabupaten</label></td>
					<td><select name='kabupaten' id='kabupaten'>
					<?php
								$sql_kabupaten = $db->database_prepare("SELECT * FROM master_ref_kabkota where id_prov = ? order by nama ")->execute($data_identitas['propinsi']);
								while ($data_kabupaten = $db->database_fetch_array($sql_kabupaten)){
									if ($data_kabupaten[id]==$data_identitas[kabupaten]){
									echo "<option value=$data_kabupaten[id]*$data_kabupaten[id_prov]*$data_kabupaten[nama] SELECTED>$data_kabupaten[id] - $data_kabupaten[nama]</option>";
									} else
									{echo "<option value=$data_kabupaten[id]*$data_kabupaten[id_prov]*$data_kabupaten[nama]>$data_kabupaten[id] - $data_kabupaten[nama]</option>"; 
									}
								}
								echo "</select>"; 
								?>		
					</td>

					
				</tr>
				<tr valign="top">
					<td><label>Kecamatan</label></td>
					<td><select name='kecamatan' id='kecamatan'>
					<?php
								$sql_kecamatan = $db->database_prepare("SELECT * FROM master_ref_kecamatan where id_kabkota = ? order by nama ")->execute($data_identitas['kabupaten']);
								while ($data_kecamatan = $db->database_fetch_array($sql_kecamatan)){
									if ($data_kecamatan[id]==$data_identitas[kecamatan]){
									echo "<option value=$data_kecamatan[id]*$data_kecamatan[id_kabkota]*$data_kecamatan[nama] SELECTED>$data_kecamatan[id] - $data_kecamatan[nama]</option>";
									} else
									{echo "<option value=$data_kecamatan[id]*$data_kecamatan[id_kabkota]*$data_kecamatan[nama]>$data_kecamatan[id] - $data_kecamatan[nama]</option>"; 
									}
								}
								echo "</select>"; 
								?>		
					</td>
					
				</tr>
				<tr valign="top">
					<td><label>Desa</label></td>
					<td><select name='desa' id='desa'>
					<?php
								$sql_desa = $db->database_prepare("SELECT * FROM master_ref_desa where id_kecamatan = ? order by nama ")->execute($data_identitas['kecamatan']);
								while ($data_desa = $db->database_fetch_array($sql_desa)){
									if ($data_desa[id]==$data_identitas[desa]){
									echo "<option value=$data_desa[id]*$data_desa[id_kecamatan]*$data_desa[nama] SELECTED>$data_desa[id] - $data_desa[nama]</option>";
									} else
									{echo "<option value=$data_desa[id]*$data_desa[id_kecamatan]*$data_desa[nama]>$data_desa[id] - $data_desa[nama]</option>"; 
									}
								}
								echo "</select>"; 
								?>		
					</td>
					
				</tr>
				<tr valign="top">
					<td><label>Jalan</label></td>
					<td><input type="text" name="jalan" size="40" maxlength="20" value="<?php echo $data_identitas['jalan']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>No Rumah</label></td>
					<td><input type="text" name="no_rumah" size="40" maxlength="20" value="<?php echo $data_identitas['no_rumah']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>RT</label></td>
					<td><input type="text" name="rt" size="40" maxlength="20" value="<?php echo $data_identitas['rt']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>RW</label></td>
					<td><input type="text" name="rw" size="40" maxlength="20" value="<?php echo $data_identitas['rw']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Dusun/Dukuh</label></td>
					<td><input type="text" name="dukuh" size="40" maxlength="20" value="<?php echo $data_identitas['dukuh']; ?>"></td>
				</tr>
				
				<tr valign="top">
					<td><label>Kode Pos</label></td>
					<td><input type="text" name="kode_pos" size="40" maxlength="5" value="<?php echo $data_identitas['kode_pos']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Kewarganegaraan</label></td>
					<td><select name="negara">
							<option value="">- none -</option>
							<option value="A" <?php if($data_identitas['negara'] == 'A'){ echo "SELECTED"; } ?>>WNI</option>
							<option value="B" <?php if($data_identitas['negara'] == 'B'){ echo "SELECTED"; } ?>>WNA</option>
						</select>
					</td>
				</tr>
				
				<tr valign="top">
					<td><label>Telepon</label></td>
					<td><input type="text" name="telepon" maxlength="20" value="<?php echo $data_identitas['telepon']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Hp</label></td>
					<td><input type="text" name="hp" maxlength="20" value="<?php echo $data_identitas['hp']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Email</label></td>
					<td><input type="text" name="email" maxlength="40" value="<?php echo $data_identitas['email']; ?>"></td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary">Simpan Perubahan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<?php
	break;

	case "card":
	echo "<a href=javascript:history.go(-1)><img src='../images/back.png'></a>";
	echo "<h4>Preview Kartu Identitas</h4>";
	$data_identitas = $db->database_fetch_array($db->database_prepare("SELECT A.nik, A.nama, A.foto, A.email FROM master_data A WHERE A.id_identitas = ?")->execute($_GET["id"]));
	//INNER JOIN mspst B ON A.kode_program_studi=B.IDPSTMSPST 
	if ($data_identitas['foto'] == '' || $data_identitas['foto'] == NULL){
		echo "Pembuatan Kartu Identitas gagal, foto belum tersedia untuk data ini.";
		exit();
	}	
	else{
		$background = imagecreatefromjpeg('../images/ktm.jpg');
		
		$color1	= imagecolorallocate( $background, 255, 255, 255 );
		
		$font	= '../fungsi/fonts/MyriadPro-Regular.ttf';
		
		imagettftext($background, 25, 0, 340, 530, $color1, $font, $data_identitas['nama']);
		imagettftext($background, 25, 0, 340, 570, $color1, $font, $data_identitas['nik']);
		imagettftext($background, 25, 0, 340, 610, $color1, $font, $data_identitas['email']);
		
		$foto = imagecreatefromjpeg('foto/identitas/thumb/small_'.$data_identitas['foto']);
		
		$sizejpeg = getimagesize('foto/identitas/thumb/small_'.$data_identitas['foto']);
		$jpegw = $sizejpeg[0];
		$jpegh = $sizejpeg[1];
		$placementX = 60;
		$placementY = 305;
		
		imagecopy($background, $foto, $placementX, $placementY, 0, 0, $jpegw, $jpegh);
		
		$save = imagejpeg($background, "foto/ktp/ktp_".$data_identitas['id_identitas'].".jpg");
		
		echo "<img src='foto/ktp/ktp_$data_identitas[id_identitas].jpg' width='800'> <br><br>
			<a href='modul/mod_identitas/ktp.php?file=ktp_$data_identitas[id_identitas].jpg'><button type='button' class='btn btn-green'>Download Kartu ID</button></a>
		";
		
		imagedestroy($foto);
		imagedestroy($background);
	}
	break;
}
?>