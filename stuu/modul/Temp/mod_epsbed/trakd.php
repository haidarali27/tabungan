<?php
error_reporting(0);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
include "../../../fungsi/fungsi_date.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../index.php?code=2");
}

else{
	require ("../../../fungsi/html2pdf/html2pdf.class.php");
	$filename="msdos.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	
	$content .= "
				<table>
					<tr valign='top'>
						<td align='right'><img src='../../../logo.jpg' height='50'></td>
						<td width='10'></td>
						<td>
							<b>Universitas ASFA Solution</b><br>
							Jl. Pegadaian No. 38 Arjawinangun, Cirebon - Indonesia 45162<br>
							Telp. (0231) 358630, 0856 2121 141<br>
							Website: http://www.asfasolution.com; Email: info@asfasolution.com
						</td>
					</tr>
					<tr>
						<td colspan='3' width='1000'><hr></td>
					</tr>
				</table>
				<table>
					<tr>
						<td align='center' width='1000'><h4>Master Transaksi Dosen</h4></td>
					</tr>
				</table>
				<br>
				<table cellpadding=0 cellspacing=0 border=1>
					<tr>
						<th width=20 style='padding: 5px;'>No</th>
						<th width='80' align='center' style='padding: 5px;'>NIP</th>
						<th align='center' style='padding: 5px;' width='200'>Nama Dosen</th>
						<th align='center' style='padding: 5px;' width='80'>Gelar</th>
						<th align='center' style='padding: 5px;' width='80'>Jabatan</th>
						<th align='center' style='padding: 5px;' width='80'>Transaksi</th>
						<th align='center' style='padding: 5px;' width='120'>Periode</th>
					</tr>";
					$no = 1;
					$sql = $db->database_prepare("SELECT * FROM as_transaksi_dosen A INNER JOIN msdos B ON B.IDDOSMSDOS=A.dosen_id ORDER BY A.periode_awal DESC")->execute();
					while ($data = $db->database_fetch_array($sql)){
						$start = tgl_indo($data['periode_awal']);
						$end = tgl_indo($data['periode_akhir']);
						
						if ($data['KDSTAMSDOS'] == 'A'){
							$status = "Dosen Tetap";
						}
						elseif ($data['KDSTAMSDOS'] == 'B'){
							$status = "Dosen PNS DPK";
						}
						elseif ($data['KDSTAMSDOS'] == 'C'){
							$status = "Dosen PNS PTN";
						}
						elseif ($data['KDSTAMSDOS'] == 'D'){
							$status = "Honorer Non PNS PTN";
						}
						else{
							$status = "Kontrak/Tetap Kontrak";
						}
						
						if ($data['KDJANMSDOS'] == 'A'){
							$jabatan = "Tenaga Pengajar";
						}
						elseif ($data['KDJANMSDOS'] == 'B'){
							$jabatan = "Asisten Ahli";
						}
						elseif ($data['KDJANMSDOS'] == 'C'){
							$jabatan = "Lektor";
						}
						elseif ($data['KDJANMSDOS'] == 'D'){
							$jabatan = "Lektor Kepala";
						}
						else{
							$jabatan = "Guru Besar";
						}
						
						if ($data['status_transaksi'] == 'A'){
							$status_aka = "Aktif Mengajar";
						}
						elseif ($data['status_transaksi'] == 'C'){
							$status_aka = "Cuti";
						}
						elseif ($data['status_transaksi'] == 'K'){
							$status_aka = "Keluar/Pensiun";
						}
						elseif ($data['status_transaksi'] == 'S'){
							$status_aka = "Studi Lanjut";
						}
						elseif ($data['status_transaksi'] == 'T'){
							$status_aka = "Tugas di Instansi Lain";
						}
						else{
							$status_aka = "Almarhum";
						}
									
						$content .= "
							<tr>
								<td style='padding: 5px;'>$no</td>
								<td style='padding: 5px;'>$data[NODOSMSDOS]</td>
								<td style='padding: 5px;'>$data[NMDOSMSDOS]</td>
								<td style='padding: 5px;' align='center'>$data[GELARMSDOS]</td>
								<td style='padding: 5px;'>$jabatan</td>
								<td style='padding: 5px;'>$status_aka</td>
								<td align='center' style='padding: 5px;'>$start sd $end</td>
							</tr>
						";
						$no++;
					}
					
		$content .= "</table>
				<table>
					<tr>
						<td width='400'></td>
						<td align='center'><p>&nbsp;</p>Universitas ASFA Solution, <br>Ketua / <i>President</i><p>&nbsp;</p><br><br>Agus Saputra, S.Kom.<br>NIP. <b>2013080002</b></td>
					</tr>
				</table>
				";
	}
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('L','A4','en', false, 'ISO-8859-15',array(15, 15, 15, 15)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
?>