<!DOCTYPE html>
<html>
<head>
	<title>CETAK LAPORAN PEMESANAN TRAVEL PO ABABIL</title>
</head>
<body>
 
	<center>
 
		<h2>ABABIL TRAVEL</h2>
		<h4>PT ZIDAN AUTO</h4>
 
	</center>
 
	<?php 
	require_once('connect.php');
	?>
 
	<table border="1" style="width: 100%">
		<tr>
			<th width="1%">No</th>
			<th>Nama</th>
			<th>Tanggal Berangkat</th>
			<th>Jumlah Tiket</th>
			<th>Nomor Kursi</th>
			<th>Tempat Penjemputan</th>
			<th>Tempat Tujuan</th>
			<th>Status</th>
			<th>Tarif</th>
		</tr>
		<?php 
		$no = 1;
		$sql= $con->query('SELECT `kd_pemesanan`,`tgl_berangkat`, `jml_tiket`,`tmp_jemput`,`no_kursi`, `pelanggan`.`pelanggan`, `tmp_tujuan`, 
		`tgl_berangkat`, `tarif`, `status` FROM pemesanan INNER JOIN pelanggan ON pemesanan.id_pelanggan = pelanggan.id_pelanggan');
		while($data = mysqli_fetch_array($sql)){
		?>
		<tr>
			<th><?php echo $no++; ?></th>
			<th><?php echo $data['pelanggan']; ?></th>
			<th><?php echo $data['tgl_berangkat']; ?></th>
			<th><?php echo $data['jml_tiket']; ?></th>
			<th><?php echo $data['no_kursi']; ?></th>
			<th><?php echo $data['tmp_jemput']; ?></th>
			<th><?php echo $data['tmp_tujuan']; ?></th>
			<th><?php echo $data['status']; ?></th>
			<th><?php echo $data['tarif']; ?></th>
		</tr>
		<?php 
		}
		?>
	</table>
 
	<script>
		window.print();
	</script>
 
</body>
</html>