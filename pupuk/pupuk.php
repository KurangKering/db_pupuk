<?php 
include 'sesi.php';
/******************************************************************/
$header_title = 'Pupuk';
include 'layout/header.php';
?>
<!--=================================================================================-->
<div class="row hidden-div" id="div_form_pupuk">
  <div class="col-md-8 col-md-offset-2">
    <div class="card">
      <div class="header"> <h3 class="title text-center" id="judul_form_pupuk">Form Tambah Pupuk</h3></div>
      <div class="content">
        <form method="post" id="form_pupuk">
          <input type="text" id="type"  name="type" value="new" hidden>
          <input type="text" id="id_pupuk" name="id_pupuk" value="" hidden>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Pupuk</label>
                <input type="text" id="nama_pupuk" name="nama_pupuk" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Stock</label>
                <input type="text" id="stock_pupuk" name="stock_pupuk" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Harga Per Kg</label>
                <input type="text" class="form-control" required id="harga_per_kg" name="harga_per_kg">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <a href="pupuk.php"><button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-fill pull-left"></button></a>
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-info glyphicon glyphicon-ok btn-fill pull-right"></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--=================================================================-->

</div>
<div class="row" id="div_table_pupuk">
  <div class="col-md-12">
    <div class="card">
     <div class="header">
       <button type="button" onclick="showFormPupuk()" class="btn btn-success btn-fill">
         <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
       </button>
     </div>
     <div class="content">
      <table id="table_pupuk"  class="display compact" cellpadding="0" cellspacing="0" border="0" style="width: 100%">

        <thead>
          <tr>
          <th>ID Pupuk</th>
            <th>Nama Pupuk</th>
            <th>Stock</th>
            <th>Harga Per Kg</th>
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
$js_tambahan = <<<EOF
<script type="text/javascript" language="javascript" >

  var dTable;
  $(document).ready(function() {
   dTable = $('#table_pupuk').DataTable( {
    "bProcessing": true,
    "bServerSide": true,
    "bJQueryUI": false,
    "responsive": true,
    "bAutoWidth" : false,
    "paging": true,
    "pagingType": "simple",
    "sAjaxSource": "serverside/server_pupuk.php", // Load Data
    "sServerMethod": "POST",
    "columnDefs": [
    { "orderable": true, "targets": 0, "searchable": false, "width" : "15%" },
    { "orderable": true, "targets": 1, "searchable": true, "width" : "25"},
    { "orderable": true, "targets": 2, "searchable": true, "width" : "20%" },
    { "orderable": true, "targets": 3, "searchable": true, "width" : "20%" },
    { "orderable": false, "targets": 4, "searchable": false, "width" : "20%" },
    ],
    "order": [
    [0, 'desc']
    ]
  } );
  


} );

// function tambah dan edit

$(document).on('submit', '#form_pupuk', function(e) {
  e.preventDefault();
  var formData = $("#form_pupuk").serialize();
  $.ajax({
    type: "POST",
    url: "serverside/crud_pupuk.php",
    dataType: 'json',
    data: formData,
    success: function(data) {
      if (data == 'OK') {
        location.reload(true);
      }
    }
  });

});

function showFormPupuk(id_pupuk) {
 $("#type").val("");
 if (id_pupuk) {
  $.ajax({
    type: "POST",
    url: "serverside/crud_pupuk.php",
    dataType: 'json',
    data: {id_pupuk:id_pupuk,type:"get"},
    success: function(res) {
     $("#judul_form_pupuk").html('Edit Pupuk : '+res.nama_pupuk);
     $("#id_pupuk").val(res.id_pupuk);
     $("#type").val("edit");
     $("#stock_pupuk").val(res.stock_pupuk);
     $("#harga_per_kg").val(res.harga_per_kg);
     $("#nama_pupuk").val(res.nama_pupuk);

     $('#div_table_pupuk').addClass('hidden-div');
     $('#div_form_pupuk').removeClass('hidden-div');
   }
 });
}
else {
  $("#judul_form_pupuk").html("Form Entry Pupuk");
  $("#type").val("new"); 
  $('#div_table_pupuk').addClass('hidden-div');
  $('#div_form_pupuk').removeClass('hidden-div');

}
}
//Hapus Data
function deletePupuk( id_pupuk )
{
  var conf = confirm("Yakin Ingin Menghapus Pupuk ?");
  if (conf == true) {
    $.ajax({
     dataType: 'json',
     url : 'serverside/crud_pupuk.php',
     type : 'post',
     data: {id_pupuk:id_pupuk,type:"delete"},
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
EOF;
include 'layout/footer.php';
?>