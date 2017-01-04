<?php 
include 'sesi.php';
/******************************************************************/
$header_title = 'Penyediaan';
include 'layout/header.php';
?>
<!--=================================================================================-->

</div>
<div class="row" id="div_table_penyediaan">
  <div class="col-md-12">
    <div class="card">
     <div class="header">
       <a href="tambah_penyediaan.php"><button type="button" class="btn btn-success btn-fill">
         <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
       </button>
     </a>
   </div>
   <div class="content">
    <table id="table_penyediaan"  class="display compact" cellpadding="0" cellspacing="0" border="0" style="width: 100%">

      <thead>
        <tr>
          <th>ID Penyediaan</th>
          <th>Tanggal Penyediaan</th>
          <th>Nama Distributor</th>
          <th>Total Bayar</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>

    </table>
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
        <h4 class="modal-title" id="myModalLabel">Detail Penyediaan</h4>
      </div>
      <div class="modal-body">
        <div class="col-xs-12">
          <label>Tanggal Transaksi &emsp; :</label> <span id="det_tanggal"></span>
          <div class="clearfix"></div>
          <label>Nama Distributor &emsp;&nbsp;&nbsp; :</label> <span id="det_nama_distributor"></span>
          <div class="clearfix"></div>
          <label>Total Bayar &emsp;&emsp;&emsp;&nbsp;&emsp;&nbsp; :</label> <span id="det_total"></span>


        </div>
        <table id="detail_penyediaan" class="table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pupuk</th>
              <th>Kuantitas</th>
              <th>Harga Per Kg</th>
              <th>Sub Total</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>  
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" language="javascript" >
 var dTable;
 $(document).ready(function() {
   dTable = $('#table_penyediaan').DataTable( {
    "bProcessing": true,
    "bServerSide": true,
    "bJQueryUI": false,
    "responsive": true,
    "bAutoWidth" : false,
    "paging": true,
    "pagingType": "simple",
    "sAjaxSource": "serverside/server_penyediaan.php", // Load Data
    "sServerMethod": "POST",
    "columnDefs": [
    { "orderable": true, "targets": 0, "searchable": false },
    { "orderable": true, "targets": 1, "searchable": true },
    { "orderable": true, "targets": 2, "searchable": true },
    { "orderable": false, "targets": 3, "searchable": false},
    { "orderable": false, "targets": 4, "searchable": false},
    ],
    "order": [
    [0, 'desc']
    ]
  } );
 } );

 function clearData() {
   $("#det_tanggal").text("");
   $("#det_nama_distributor").text("");
   $("#det_total").text("");
   $('#detail_penyediaan > tbody > tr').remove();
 }
 function showDetail(id_penyediaan) {
  clearData();
  $.ajax({
    type: "POST",
    url: "serverside/crud_penyediaan.php",
    dataType: 'json',
    data: {id_penyediaan:id_penyediaan, type:"get_details"},
    success: function(data) {
      var dataz = data, ii = 1;
      $("#det_tanggal").text(dataz[0].tanggal);
      $("#det_nama_distributor").text(dataz[0].nama_distributor);
      $("#det_total").text(dataz[0].total);

      $.each(data, function(idx, elem) {
        $('#detail_penyediaan > tbody:last-child').append("<tr><td>"+ii+"</td><td>"+elem.nama_pupuk+"</td><td>"+elem.kuantitas+"</td><td>"+elem.harga_per_kg+"</td><td>"+elem.sub_total+"</td></tr>");
        ii++;
      })
    }
  });
  $('#myModal').modal('show');

}
// function tambah dan edit

// $(document).on('submit', '#form_anggota', function(e) {
//   e.preventDefault();
//   var formData = $("#form_anggota").serialize();
//   $.ajax({
//     type: "POST",
//     url: "serverside/crud_anggota.php",
//     dataType: 'json',
//     data: formData,
//     success: function(data) {
//       if (data == 'OK') {
//         location.reload(true);
//       }
//     }
//   });

// });

// function showFormAnggota(id_anggota) {
//  $("#type").val("");
//  if (id_anggota) {
//   $.ajax({
//     type: "POST",
//     url: "serverside/crud_anggota.php",
//     dataType: 'json',
//     data: {id_anggota:id_anggota,type:"get"},
//     success: function(res) {
//      $("#judul_form_anggota").html('Edit Anggota : '+res.nama_anggota);
//      $("#id_anggota").val(res.id_anggota);
//      $("#type").val("edit");
//      $("#jk").val(res.jk);
//      $("#tgl_lahir").val(res.tgl_lahir);
//      $("#nama_anggota").val(res.nama_anggota);
//      $("#alamat").val(res.alamat);

//      $('#div_table_anggota').addClass('hidden-div');
//      $('#div_form_anggota').removeClass('hidden-div');
//    }
//  });
// }
// else {
//   $("#judul_form_anggota").html("Form Entry Anggota ");
//   $("#type").val("new"); 
//   $('#div_table_anggota').addClass('hidden-div');
//   $('#div_form_anggota').removeClass('hidden-div');

// }
// }
//Hapus Data
function deletePenyediaan( id_penyediaan )
{
  var conf = confirm("Yakin Ingin Menghapus Data Transaksi Penyediaan ?");
  if (conf == true) {
    $.ajax({
     dataType: 'json',
     url : 'serverside/crud_penyediaan.php',
     type : 'post',
     data: {id_penyediaan:id_penyediaan,type:"delete"},
     success : function(msg) {
      if(msg == 'OK') {
        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
      }
      else {
        alert("Gagal");
      }
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