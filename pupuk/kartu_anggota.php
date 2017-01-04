<?php
include 'sesi.php';
include 'CRUD.php';
$crud = new CRUD();
$cicak = $crud->getRows('anggota', array('where' => array("id_anggota" => $_GET['id_anggota']) ));

?>

<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="assets/css/AdminLTE.min.css" rel="stylesheet" />
<link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
<style type="text/css" media="print">
	@page { size:3.37in 2.125in; margin:0cm }
	@media print
	{    
		.no-print, .no-print *
		{
			display: none !important;
		}
	}
</style>
<div class="row" id="row_cetak">
	<div class="col-md-4 col-md-offset-4">
		<div class="card">
			<div class="header">
				<h4 class="title" style="text-align: center">Kartu Anggota CV Persada</h4>
			</div>
			<div class="content">
				<table class="table" style="width: 100%; ">
					<tr>
						<th>No Anggota</th>
						<td>:</td>
						<td><?php echo $cicak[0]['id_anggota']?></td>
					</tr>
					<tr>
						<th>Nama Anggota</th>
						<td>:</td>
						<td><?php echo $cicak[0]['nama_anggota']?></td>
					</tr>
					<tr>
						<th>Tanggal Lahir</th>
						<td>:</td>
						<td><?php echo $cicak[0]['tgl_lahir']?></td>
					</tr>
					<tr>
						<th>Alamat</th>
						<td>:</td>
						<td><?php echo $cicak[0]['alamat']?></td>
					</tr>
					
				</table>
			</div>

		</div>
	</div>
	
</div>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<button type="button" onclick="window.print()" id="btn_cetak" class="no-print btn btn-fill btn-primary">Cetak</button>
	</div>
	
</div>