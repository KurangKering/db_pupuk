<?php 
include 'sesi.php';
require_once 'CRUD.php';
require_once 'database.php';
$db = new CRUD();
$pdo = DB::connect();
$anggota = $db->getRows("anggota");
$pupuk  = $db->getRows("pupuk");

/******************************************************************/
$header_title = 'Dashboard';
include 'layout/header.php';
?>
<!--=================================================================================-->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">

			</div>
			<div class="content">
				<form>
					<input type="text" hidden name="id_anggota" id="id_anggota">

					<div class="row">
						<div class="col-md-4">

							<div class="form-group">
								<label>Tanggal Transaksi</label>
								<input type="text" class="form-control" readonly style="background:white;" id="tanggal"  name="tanggal">
							</div>
							<div class="form-group">
								<label>Nama Anggota</label>
								<input type="text" class="form-control" id="nama_anggota" data-toggle="modal" data-target="#myModal"  required name="nama_anggota">
							</div>
						</div>
						<div class="col-md-4 col-md-offset-3">
							
							<div class="form-group">
								<label>Nama Pupuk</label>
								<select class="form-control" id="id_pupuk" name="id_pupuk" required>
									<option disabled selected value> Pilih Pupuk</option>
									<?php foreach ($pupuk as $value) { ?>
									<option value="<?php echo $value['id_pupuk']?>"><?php echo $value['nama_pupuk']?></option> 
									<?php } ?>
								</select>	
							</div>

							<div class="form-group">
								<label>Stock</label>
								<input type="text" disabled class="form-control" id="stock" readonly="">
							</div>

							<div class="form-group">
								<label>Kuantitas</label>
								<input type="text" class="form-control" required="" id="kuantitas" name="kuantitas">
							</div>


							<div class="form-group">
								<button type="button" class="btn btn-warning" id="btn_tambah">Tambah</button> <span class="error_info_tambah"></span>
							</div>

						</div>


					</div>

					<div class="row">
						<div class="col-md-12">
							<table class="table" id="table_tmp">
								<thead>
									<tr>
										<th>Nama Pupuk</th>
										<th>Stock Pupuk</th>
										<th>Kuantitas Pupuk</th>
										<th>Harga Per Kg</th>
										<th>Sub Total </th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					<input type="submit" name="">

				</div>

			</form>
		</div>

	</div>
</div>





<!--=================================================================================-->
<?php
ob_start();
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:800px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Daftar Anggota</h4>
			</div>
			<div class="modal-body">
				<table id="lookup" class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>Id Anggota</th>
							<th>Nama Anggota</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($anggota as $value) { ?>
						<tr class="pilih" data-id-anggota="<?php echo $value['id_anggota']; ?>" data-nama-anggota="<?php echo $value['nama_anggota']; ?>">
							<td><?php echo $value['id_anggota']; ?></td>
							<td><?php echo $value['nama_anggota']; ?></td>
						</tr>	
						<?php }?>	
					</tbody>
				</table>  
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var dTable;
	$(document).ready(function() {
		dTable = $('#table_tmp').DataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bJQueryUI": false,
			"bAutoWidth" : false,
			"paging": false,
    "sAjaxSource": "serverside/server_penjualan.php", // Load Data
    "sServerMethod": "POST"
} );

	} );

// function tambah dan edit

$(document).on('submit', '#form_anggota', function(e) {
	e.preventDefault();
	var formData = $("#form_anggota").serialize();
	$.ajax({
		type: "POST",
		url: "serverside/crud_anggota.php",
		dataType: 'json',
		data: formData,
		success: function(data) {
			if (data == 'OK') {
				location.reload(true);
			}
		}
	});

});

//Hapus Data
function delete_penjualan( id_pupuk )
{
	$.ajax({
		dataType: 'json',
		url : 'serverside/crud_penjualan.php',
		type : 'post',
		data: {id_pupuk:id_pupuk,type:"delete_penjualan"},
		success : function(msg) {
			if(msg == 'OK') {
        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
    }
}


});
}
$(document).on('click', '.pilih', function (e) {
	document.getElementById("id_anggota").value = $(this).attr('data-id-anggota');
	document.getElementById("nama_anggota").value = $(this).attr('data-nama-anggota');

	$('#myModal').modal('hide');
});

$(function () {
	$("#lookup").dataTable();

});

$( function() {
	$( "#tanggal" ).datepicker({
		dateFormat: 'yy-mm-dd'
	}).datepicker("setDate", new Date()).datepicker("destroy");
} );

$(document).on('change', '#id_pupuk', function (e) { 
	var id_pupuk = this.value;
	$.ajax({
		type: "POST",
		url: "serverside/crud_penjualan.php",
		dataType: 'json',
		data: {id_pupuk:id_pupuk, type:"get_stock"},
		success: function(res) {
			$("#stock").val(res[0].stock_pupuk);
			pupuk_id = res[0].id_pupuk;
		}
	});
});

var pupuk_id;
$(document).on('click', '#btn_tambah', function (e) { 

	$('.error_info_tambah').html('');
	var kuantitas = $('#kuantitas').val();
	if (parseInt($('#kuantitas').val()) > parseInt($('#stock').val())) {
		$(".error_info_tambah").html("Kuantitas terlalu besar");
	}
	else {
		$.ajax({
			type: "POST",
			url: "serverside/crud_penjualan.php",
			dataType: 'json',
			data: {id_pupuk:pupuk_id, kuantitas:kuantitas, type:"insert_tmp_penjualan"},
			success: function(res) {
				if (res) {
					        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis

					    }
					}
				});

	}

});
</script>
<?php
$js_tambahan = ob_get_contents();
ob_end_clean();
include 'layout/footer.php';
?>