<?php 
include 'sesi.php';
/******************************************************************/
$css_tambahan = '<link href="kartu_anggota.css" rel="stylesheet"/>';
$header_title = 'Name Card';
include 'layout/header.php';
?>
<!--=================================================================================-->
<div class="card card-kartu" >
	<div class="header card-header" style="padding-top: 5px;" > 
		<div class="row">
			<div class="col-xs-3 div-logo">
				<img class="logo-perusahaan" src="assets/img/logo_perusahaan.png">
			</div>
			<div class="col-xs-9" >
				<h5 class="text-center">CV Persada</h5>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="row">
			
		</div>
	</div>
</div>

<!--=================================================================================-->
<?php
include 'layout/footer.php';
?>