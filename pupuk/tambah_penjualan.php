<?php 
include_once 'sesi.php';
require_once 'CRUD.php';
require_once 'database.php';
$db = new CRUD();
$pdo = DB::connect();
$anggota = $db->getRows("anggota");
$pupuk  = $db->getRows("pupuk");
$db->delete("tmp_penjualan", "");
/******************************************************************/
$header_title = 'Tambah Penjualan';
include 'layout/header.php';
?>
<!--=================================================================================-->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">

			</div>
			<div class="content">
				<form method="post" action="serverside/crud_tambah_penjualan.php">
					<input type="text" hidden name="id_anggota" id="id_anggota">

					<div class="row">
						<div class="col-md-4">

							<div class="form-group">
								<label>Tanggal Transaksi</label>
								<input type="text" class="form-control" readonly style="background:white;" id="tanggal"  name="tanggal">
							</div>
							<div class="form-group">
								<label>Nama Anggota</label>
								<input type="text" class="form-control readonly" id="nama_anggota" data-toggle="modal" data-target="#myModal"  required name="nama_anggota">
							</div>
						</div>
						<div class="col-md-4 col-md-offset-3">
							
							<div class="form-group">
								<label>Nama Pupuk</label>
								<select class="form-control" id="id_pupuk" name="id_pupuk" required>
									<option disabled selected value> Pilih Pupuk</option>
									<?php foreach ($pupuk as $value) { ?>
									<option id="<?php echo $value['id_pupuk']?>" value="<?php echo $value['stock_pupuk']?>"><?php echo $value['nama_pupuk']?></option> 
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
										<th>No</th>
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

							<div class="form-group pull-right">
								<input type="submit" class="btn btn-fill btn-primary" name="submit_penjualan" value="Simpan">
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
							if ($anggota) {

								foreach ($anggota as $value) { ?>
								<tr class="pilih" data-id-anggota="<?php echo $value['id_anggota']; ?>" data-nama-anggota="<?php echo $value['nama_anggota']; ?>">
									<td><?php echo $value['id_anggota']; ?></td>
									<td><?php echo $value['nama_anggota']; ?></td>
								</tr>	
								<?php }	}?>	
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
    "sAjaxSource": "serverside/server_tambah_penjualan.php", // Load Data
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
function delete_penjualan( id_pupuk )
{
	$.ajax({
		dataType: 'json',
		url : 'serverside/crud_tambah_penjualan.php',
		type : 'post',
		data: {id_pupuk:id_pupuk,type:"get_tmp_penjualan"},
		success : function(msg) {
			$.ajax({
				dataType: 'json',
				url : 'serverside/crud_tambah_penjualan.php',
				type : 'post',
				data: {id_pupuk:id_pupuk,type:"delete_penjualan"},
				success : function(res) {
					
					var kuantitas = parseInt(res[0].kuantitas);
					var stockk = parseInt($("#id_pupuk option[id="+res[0].id_pupuk+"]").val());
					console.log(stockk);
					$("#id_pupuk option[id="+res[0].id_pupuk+"]").attr("value", kuantitas  + stockk);
					document.getElementById("stock").value = $("#id_pupuk option[id="+res[0].id_pupuk+"]").val();	

        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
        $('.error_info_tambah').html('Berhasil menghapus dari keranjang');
    }
});

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
	var id_pupuk = $(this).children(":selected").attr("id");
	var stock_pupuk = this.value;
	document.getElementById("stock").value = stock_pupuk;	
	update_total();
});

$(document).on('click', '#btn_tambah', function (e) { 
	var id_pupuk = $('#id_pupuk').children(":selected").attr("id");
	$('.error_info_tambah').html('');
	var kuantitas = $('#kuantitas').val();
	if (!$('#stock').val()) {
		$(".error_info_tambah").html("Silahkan pilih pupuk  ");

	}
	else 	if (!$('#kuantitas').val()) {
		$(".error_info_tambah").html("Silahkan Masukkan kuantitas ");

	}
	else if (parseInt($('#kuantitas').val()) > parseInt($('#stock').val())) {
		$(".error_info_tambah").html("Kuantitas terlalu besar");
	}
	else if ($('#kuantitas').val() > 0){
		$.ajax({
			type: "POST",
			url: "serverside/crud_tambah_penjualan.php",
			dataType: 'json',
			data: {id_pupuk:id_pupuk, kuantitas:kuantitas, type:"insert_tmp_penjualan"},
			success: function(res) {
				if (res) {
					var x = parseInt($('#kuantitas').val());
					var y = parseInt($('#stock').val());
					        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
					        $(".error_info_tambah").html(" Berhasil Menambah");
					        document.getElementById("stock").value = y - x;
					        $("#id_pupuk option[value="+y+"]").attr("value", y - x);
					    }
					}
				});

	}

});

        //Tampilkan Modal 
        function showModals( id_penjualan )
        {
        	waitingDialog.show();
        	clearModals();

        // Untuk Eksekusi Data Yang Ingin di Edit atau Di Hapus 
        if( id_penjualan )
        {
        	$.ajax({
        		type: "POST",
        		url: "serverside/crud_anggota.php",
        		dataType: 'json',
        		data: {id_penjualan:id_penjualan,type:"get"},
        		success: function(res) {
        			waitingDialog.hide();
        			setModalData( res );
        		}
        	});
        }
    }

</script>
<?php
$js_tambahan = ob_get_contents();
ob_end_clean();
include 'layout/footer.php';
?>