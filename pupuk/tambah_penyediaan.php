<?php 
include_once 'sesi.php';
require_once 'CRUD.php';
require_once 'database.php';
$db = new CRUD();
$pdo = DB::connect();
$distributor = $db->getRows("distributor");
$pupuk  = $db->getRows("pupuk");
$db->delete("tmp_penyediaan", "");
/******************************************************************/
$header_title = 'Tambah Penyediaan';
include 'layout/header.php';
?>
<!--=================================================================================-->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">

			</div>
			<div class="content">
				<form method="post" action="serverside/crud_tambah_penyediaan.php">
					<input type="text" hidden name="id_distributor" id="id_distributor">

					<div class="row">
						<div class="col-md-4">

							<div class="form-group">
								<label>Tanggal Transaksi</label>
								<input type="text" class="form-control" readonly style="background:white;" id="tanggal"  name="tanggal">
							</div>
							<div class="form-group">
								<label>Nama distributor</label>
								<input type="text" class="form-control readonly" required id="nama_distributor" data-toggle="modal" data-target="#myModal"  name="nama_distributor">
							</div>
						</div>
						<div class="col-md-4 col-md-offset-3">
							
							<div class="form-group">
								<label>Nama Pupuk</label>
								<select class="form-control" id="id_pupuk" name="id_pupuk" required>
<!-- 									<option disabled selected value> Pilih Pupuk</option>
-->									<?php foreach ($pupuk as $value) { ?>
<option id="<?php echo $value['id_pupuk']?>" value="<?php echo $value['stock_pupuk']?>"><?php echo $value['nama_pupuk']?></option> 
<?php } ?>
</select>	
</div>

<div class="form-group">
	<label>Kuantitas</label>
	<input type="text" class="form-control" id="kuantitas" required="" name="kuantitas">
</div>

<div class="form-group">
	<label>Harga Per Kg</label>
	<input type="text" class="form-control" required="" id="harga_per_kg" name="harga_per_kg">
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
					<th>No</th>
					<th>Nama Pupuk</th>
					<th>Kuantitas Pupuk</th>
					<th>Harga Per Kg</th>
					<th>Sub Total </th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		<div class="form-group pull-right">
			<input type="submit" class="btn btn-fill btn-primary" name="submit_penyediaan" value="Simpan">
		</div>
	</div>

</div>

<div>

</form>

</div>
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
				<h4 class="modal-title" id="myModalLabel">Daftar distributor</h4>
			</div>
			<div class="modal-body">
				<table id="lookup" class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>Id distributor</th>
							<th>Nama distributor</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($distributor) {
							foreach ($distributor as $value) { ?>
							<tr class="pilih" data-id-distributor="<?php echo $value['id_distributor']; ?>" data-nama-distributor="<?php echo $value['nama_distributor']; ?>">
								<td><?php echo $value['id_distributor']; ?></td>
								<td><?php echo $value['nama_distributor']; ?></td>
							</tr>	
							<?php } }?>	
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
				"bSort": false,
				"bInfo": false,
				"bAutoWidth" : false,
				"paging": false,
				"bFilter": false,
    "sAjaxSource": "serverside/server_tambah_penyediaan.php", // Load Data
    "sServerMethod": "POST"
} );

		} );

// function tambah dan edit

$(".readonly").on('keydown paste', function(e){
	e.preventDefault();
});

function update_total () {
	$.ajax({
		type: "POST",
		url: "serverside/crud_tambah_penjualan.php",
		dataType: 'json',
		data: {type:"update_total_penjualan"},
		success: function(data) {
			var total = data[0].total;
			$('#lbl_total').text(total);
		}
	});

}
//Hapus Data
function delete_penyediaan( id_pupuk )
{
	$.ajax({
		dataType: 'json',
		url : 'serverside/crud_tambah_penyediaan.php',
		type : 'post',
		data: {id_pupuk:id_pupuk,type:"get_tmp_penyediaan"},
		success : function(msg) {
			$.ajax({
				dataType: 'json',
				url : 'serverside/crud_tambah_penyediaan.php',
				type : 'post',
				data: {id_pupuk:id_pupuk,type:"delete_penyediaan"},
				success : function(res) {
					// var kuantitas = parseInt(res[0].kuantitas);
					// var stockk = parseInt($("#id_pupuk option[id="+res[0].id_pupuk+"]").val());
					// console.log(stockk);
					// $("#id_pupuk option[id="+res[0].id_pupuk+"]").attr("value", kuantitas  + stockk);
					// document.getElementById("stock").value = $("#id_pupuk option[id="+res[0].id_pupuk+"]").val();	
        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
        $('.error_info_tambah').html('Berhasil menghapus dari keranjang');
    }
});

		}
	});
}

$(document).on('click', '.pilih', function (e) {
	document.getElementById("id_distributor").value = $(this).attr('data-id-distributor');
	document.getElementById("nama_distributor").value = $(this).attr('data-nama-distributor');
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
	document.getElementById("kuantitas").value = "";	
	document.getElementById("harga_per_kg").value = "";	

});

$(document).on('click', '#btn_tambah', function (e) { 
	var id_pupuk = $('#id_pupuk').children(":selected").attr("id");
	var kuantitas = $('#kuantitas').val() ;
	var harga_per_kg = $('#harga_per_kg').val();
	$('.error_info_tambah').html('');
	if (!kuantitas || !harga_per_kg) {
		$(".error_info_tambah").html("Kuantitas atau harga kosong");

	}
	// else if (parseInt($('#kuantitas').val()) > parseInt($('#stock').val())) {
	// 	$(".error_info_tambah").html("Kuantitas terlalu besar");
	// }
	else if (kuantitas > 0 && harga_per_kg > 0) {
		$.ajax({
			type: "POST",
			url: "serverside/crud_tambah_penyediaan.php",
			dataType: 'json',
			data: {id_pupuk:id_pupuk, kuantitas:kuantitas, harga_per_kg:harga_per_kg, type:"insert_tmp_penyediaan"},
			success: function(res) {
				if (res) {
					        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
					        $(".error_info_tambah").html(" Berhasil Menambah");
					        
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