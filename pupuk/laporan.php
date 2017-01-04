 <?php 
 include 'sesi.php';
 $header_title = 'Dashboard';
 include 'layout/header.php';
 ?>
 <div class="row">
 	<div class="col-md-12">
 		<div class="card">
 			<div class="content">
 				<form action="laporan_submit" method="get" accept-charset="utf-8">
 					<div class="row">
 						<div class="col-md-4 col-md-offset-4">

 							<div class="form-group">
 								<label>Jenis Laporan</label>
 								<select name="jenis_laporan" class="form-control">
 									<option value="penjualan">Penjualan</option>
 									<option value="penyediaan">Penyediaan</option>
 								</select>
 								
 							</div>
 							<div class="form-group">
 								<label>Bulan Laporan</label>
 								<select name="bulan_laporan" class="form-control">
 									<option value="1">Januari</option>
 									<option value="2">Februari</option>
 									<option value="3">Maret</option>
 									<option value="4">April</option>
 									<option value="5">Mei</option>
 									<option value="6">Juni</option>
 									<option value="7">Juli</option>
 									<option value="8">Agustus</option>
 									<option value="9">September</option>
 									<option value="10">Oktober</option>
 									<option value="11">November</option>
 									<option value="12">Desember</option>

 								</select>
 							</div>
 							<div class="form-group">
 								<label>Tahun Laporan</label>
 								<select name="bulan_laporan" class="form-control">
 									<option value="2017">2017</option>
 								</select>
 							</div>

 							<input type="submit" class="btn btn-fill btn-primary" name="submit_button" id="submit_button" value="Cetak">
 						</div>
 						
 					</form>
 				</div>
 			</div>
 		</div>

 	</div>
 	<?php
 	include 'layout/footer.php';
 	?>