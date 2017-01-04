 <?php 
 include 'sesi.php';
 include 'CRUD.php';
 $crud = new CRUD();
 $anggota = $crud->getRows("anggota");
 $distributor = $crud->getRows("distributor");
 $pupuk = $crud->getRows("pupuk");
 $header_title = 'Dashboard';
 include 'layout/header.php';

 $bulan = array(
 	'01' => 'Januari',
 	'02' => 'Februari',
 	'03' => 'Maret',
 	'04' => 'April',
 	'05' => 'Mei',
 	'06' => 'Juni',
 	'07' => 'Juli',
 	'08' => 'Agustus',
 	'09' => 'September',
 	'10' => 'Oktober',
 	'11' => 'November',
 	'12' => 'Desember',
 	);

 	?>
 	<div class="card custom-card">
 		<div class="content">
 			<div class="row">
 				<div class="col-md-4 col-xs-4">
 					<!-- small box -->
 					<div class="small-box bg-aqua">
 						<div class="inner">
 							<h3><?php echo $anggota ? count($anggota) : "0"; ?></h3>

 							<p>Anggota</p>
 						</div>
 						<div class="icon">
 							<i class="pe-7s-id"></i>
 						</div>
 						<a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
 					</div>
 				</div>
 				<!-- ./col -->
 				<div class="col-md-4 col-xs-4">
 					<!-- small box -->
 					<div class="small-box bg-green">
 						<div class="inner">
 							<h3><?php echo $distributor ? count($distributor) : "0"; ?></h3>

 							<p>Distributor</p>
 						</div>
 						<div class="icon">
 							<i class="pe-7s-users"></i>
 						</div>
 						<a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
 					</div>
 				</div>
 				<!-- ./col -->
 				<div class="col-md-4 col-xs-4">
 					<!-- small box -->
 					<div class="small-box bg-yellow">
 						<div class="inner">
 							<h3><?php echo $pupuk ? count($pupuk) : "0"; ?></h3>

 							<p>Jenis Pupuk</p>
 						</div>
 						<div class="icon">
 							<i class="pe-7s-gleam"></i>
 						</div>
 						<a href="#" class="small-box-footer">Menu Pupuk<i class="fa fa-arrow-circle-right"></i></a>
 					</div>
 				</div>

 			</div>
 		</div>
 	</div>
 	<div class="row">
 		<div class="col-md-6">
 			<div class="card">
 				<div class="header">
 					<h4 class="title">Grafik Penjualan Bulan <?php echo $bulan[date('m')] . ' ' . date('Y') ?></h4>
 				</div>
 				<div class="content">
 					<div id="chart-container">
 						<canvas id="mycanvas-penjualan"></canvas>
 					</div>
 				</div>
 			</div>

 		</div>

 		<div class="col-md-6">
 			<div class="card">
 				<div class="header">
 					<h4 class="title">Grafik Penyediaan Bulan <?php echo $bulan[date('m')] . ' ' . date('Y') ?></h4>
 				</div>
 				<div class="content">
 					<div id="chart-container">
 						<canvas id="mycanvas-penyediaan"></canvas>
 					</div>
 				</div>
 			</div>

 		</div>
 	</div>

 	<?php
 	ob_start();
 	?>
 	<script type="text/javascript" language="javascript" >
 		$(document).ready(function(){
 			$.ajax({
 				url: "serverside/crud_dashboard.php",
 				method: "POST",
 				dataType: 'json',
 				data: {type:"get_data_penjualan"},
 				success: function(data) {
 					console.log(data);
 					var tanggal = [];
 					var total = [];

 					for(var i in data) {
 						tanggal.push(data[i].tanggal);
 						total.push(data[i].total);
 					}

 					var chartdata = {
 						labels: tanggal,
 						datasets : [
 						{
 							label: 'Total Penjualan',
 							backgroundColor: 'rgba(100, 200, 200, 0.75)',
 							borderColor: 'rgba(200, 200, 200, 0.75)',
 							hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
 							hoverBorderColor: 'rgba(200, 200, 200, 1)',
 							data: total
 						}
 						]
 					};

 					var ctx = $("#mycanvas-penjualan");

 					var barGraph = new Chart(ctx, {
 						type: 'bar',
 						data: chartdata
 					});
 				},
 				error: function(data) {
 					console.log(data);
 				}
 			});

 			$.ajax({
 				url: "serverside/crud_dashboard.php",
 				method: "POST",
 				dataType: 'json',
 				data: {type:"get_data_penyediaan"},
 				success: function(data) {
 					console.log(data);
 					var tanggal = [];
 					var total = [];

 					for(var i in data) {
 						tanggal.push(data[i].tanggal);
 						total.push(data[i].total);
 					}

 					var chartdata = {
 						labels: tanggal,
 						datasets : [
 						{
 							label: 'Total Penyediaan',
 							backgroundColor: 'rgba(229, 20, 0, 0.75)',
 							borderColor: 'rgba(200, 200, 200, 0.75)',
 							hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
 							hoverBorderColor: 'rgba(200, 200, 200, 1)',
 							data: total
 						}
 						]
 					};

 					var ctx = $("#mycanvas-penyediaan");

 					var barGraph = new Chart(ctx, {
 						type: 'bar',
 						data: chartdata
 					});
 				},
 				error: function(data) {
 					console.log(data);
 				}
 			});
 		});

 	</script>
 	<?php
 	$js_tambahan = ob_get_contents();
 	ob_end_clean();
 	include 'layout/footer.php';
 	?>