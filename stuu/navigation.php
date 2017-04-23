<?php
if ($_SESSION["level"] == 0){
?>
	<div class="grid_2">
		<div class="box sidemenu">
			<div class="block" id="section-menu">
				<ul class="section menu">
					<li><a class="menuitem">Manajemen Sistem</a>
						<ul class="submenu">
							<li><a href="?mod=datapt">Data Sistem</a></li>
							<!--<li><a href="?mod=user">Pengguna</a></li>-->
							<li><a href="?mod=backup_db">Backup Database</a></li>
						</ul>
					</li>
					
					<li><a class="menuitem">Data Jamaah</a>
						<ul class="submenu">
							<li><a href="?mod=identitas">Identitas Diri</a></li>
							<!--<li><a href="?mod=jaminan_karyawan">Keterampilan/Keahlian</a></li>-->
							<li><a href="?mod=#">Riwayat Pendidikan</a></li>
							<li><a href="?mod=#">Riwayat Pelatihan</a></li>
							<!--<li><a href="?mod=riwayat_jabatan">Identitas Kejamaahan</a></li>-->
							<li><a href="?mod=#">Data usaha</a></li>
							
						</ul>
					</li>
					
					<li><a class="menuitem">Tabungan</a>
						<ul class="submenu">
							<li><a href="?mod=#">Data Produk Tabungan</a></li>
							<li><a href="?mod=#">Data Master Tabungan</a></li>
							<li><a href="?mod=#">Transaksi Tabungan</a></li>
							<li><a href="?mod=#">Mutasi Tabungan</a></li>
							
						</ul>
					</li>
					
					<li><a class="menuitem">Cetak Data</a>
						<ul class="submenu">
							<li><a href="?mod=#">Data Master</a></li>
							<li><a href="?mod=#">Laporan Tabungan</a></li>
							
						</ul>
					</li>
					
				</ul>
			</div>
		</div>
	</div>
<?php
}

elseif ($_SESSION["level"] == 1 ){
?>
	<div class="grid_2">
		<div class="box sidemenu">
			<div class="block" id="section-menu">
				<ul class="section menu">
					<li><a class="menuitem">Tabungan</a>
						<ul class="submenu">
							<li><a href="?mod=#">Data Produk Tabungan</a></li>
							<li><a href="?mod=#">Data Master Tabungan</a></li>
							<li><a href="?mod=#">Transaksi Tabungan</a></li>
							<li><a href="?mod=#">Mutasi Tabungan</a></li>
							
						</ul>
					</li>
					
					<li><a class="menuitem">Cetak Data</a>
						<ul class="submenu">
							<li><a href="?mod=#">Data Master</a></li>
							<li><a href="?mod=#">Laporan Tabungan</a></li>
							
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php
}

elseif ($_SESSION["level"] == 2){
?>
	<div class="grid_2">
		<div class="box sidemenu">
			<div class="block" id="section-menu">
				<ul class="section menu">
										
					<li><a class="menuitem">Cetak Data</a>
						<ul class="submenu">
							<li><a href="?mod=#">Data Master</a></li>
							<li><a href="?mod=#">Laporan Tabungan</a></li>
							
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php
}
?>