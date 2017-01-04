<?php 
include 'sesi.php';
/******************************************************************/
$header_title = 'Penjualan';
include 'layout/header.php';
?>
<!--=================================================================================-->

</div>
<div class="row" id="div_table_penjualan">
  <div class="col-md-12">
    <div class="card">
     <div class="header">
       <a href="tambah_penjualan.php"><button type="button" class="btn btn-success">
         <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
       </button>
     </a>
   </div>
   <div class="content">
    <table id="table_penjualan"  class="display compact" cellpadding="0" cellspacing="0" border="0" style="width: 100%">

      <thead>
        <tr>
          <th>ID</th>
          <th>Tanggal Penjualan</th>
          <th>Id Anggota</th>
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
<script type="text/javascript" language="javascript" >
 var dTable;
 $(document).ready(function() {
   dTable = $('#table_penjualan').DataTable( {
    "bProcessing": true,
    "bServerSide": true,
    "bJQueryUI": false,
    "responsive": true,
    "bAutoWidth" : false,
    "paging": true,
    "pagingType": "simple",
    "sAjaxSource": "serverside/server_penjualan.php", // Load Data
    "sServerMethod": "POST",
    // "columnDefs": [
    // { "orderable": true, "targets": 0, "searchable": false, "width" : "5%" },
    // { "orderable": true, "targets": 1, "searchable": true, "width" : "20%" },
    // { "orderable": true, "targets": 2, "searchable": true, "width" : "15%" },
    // { "orderable": true, "targets": 3, "searchable": true, "width" : "15%" },
    // { "orderable": true, "targets": 4, "searchable": true, "width" : "27%" },
    // { "orderable": false, "targets": 5, "searchable": false, "width" : "18%" },
    // ],
    "order": [
    [0, 'desc']
    ]
  } );
 } );
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
function deletePenjualan( id_penjualan )
{
  var conf = confirm("Yakin Ingin Menghapus Data Transaksi Penjualan ?");
  if (conf == true) {
    $.ajax({
     dataType: 'json',
     url : 'serverside/crud_penjualan.php',
     type : 'post',
     data: {id_penjualan:id_penjualan,type:"delete"},
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