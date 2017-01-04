 <?php 
 include 'sesi.php';
 include 'CRUD.php';
 $crud = new CRUD();
 $anggota = $crud->getRows("anggota");
 $distributor = $crud->getRows("distributor");
 $pupuk = $crud->getRows("pupuk");
 $header_title = 'Dashboard';
 include 'layout/header.php';
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
 					<a href="anggota.php" class="small-box-footer">Menu Anggota<i class="fa fa-arrow-circle-right"></i></a>
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
 					<a href="distributor.php" class="small-box-footer">Menu Distributor<i class="fa fa-arrow-circle-right"></i></a>
 				</div>
 			</div>
 			<!-- ./col -->
 			<div class="col-md-4 col-xs-4">
 				<!-- small box -->
 				<div class="small-box bg-yellow">
 					<div class="inner">
 						<h3><?php echo $pupuk ? count($pupuk) : "0"; ?></h3>

 						<p>Pupuk</p>
 					</div>
 					<div class="icon">
 						<i class="pe-7s-gleam"></i>
 					</div>
 					<a href="pupuk.php" class="small-box-footer">Menu Pupuk<i class="fa fa-arrow-circle-right"></i></a>
 				</div>
 			</div>

 		</div>
 	</div>
 </div>
 <div class="card">
 	<div class="content">
 		<div id="chart-container">
 			<canvas id="mycanvas"></canvas>
 		</div>
 	</div>
 </div>
 <?php
 ob_start();
 ?><!-- 
 <script type="text/javascript" language="javascript" >
 	var dTable;
 	$(document).ready(function() {
 		$.ajax({
 			url: "http://localhos/serverside/crud_dashboard.php",
 			method: "POST",
 			dataType: 'json',
 			data: {type:"get_data_penjualan"},
 			success: function(data) {
 				console.log(data);
 			}
 		});
 	} );
 </script> -->
 <?php
 $js_tambahan = ob_get_contents();
 ob_end_clean();
 include 'layout/footer.php';
 ?>