<?php 
include 'sesi.php';
/******************************************************************/
$header_title = 'Distributor';
include 'layout/header.php';
?>
<!--=================================================================================-->
<div class="row hidden-div" id="div_form_distributor">
  <div class="col-md-8 col-md-offset-2">
    <div class="card">
      <div class="header"> <h3 class="title text-center" id="judul_form_distributor">Form Tambah Distributor</h3></div>
      <div class="content">
        <form method="post" id="form_distributor">
          <input type="text" id="type"  name="type" value="new" hidden>
          <input type="text" id="id_distributor" name="id_distributor" value="" hidden>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Distributor</label>
                <input type="text" id="nama_distributor" name="nama_distributor" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Jenis Kelamin</label>
                <select class="form-control" id="jk" name="jk" required>
                  <option>Laki-Laki</option>
                  <option>Perempuan</option>

                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="text" class="form-control form-date" required id="tgl_lahir" name="tgl_lahir">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" id="alamat" required></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <a href="distributor.php"><button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-fill pull-left"></button></a>
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
<div class="row" id="div_table_distributor">
  <div class="col-md-12">
    <div class="card">
     <div class="header">
       <button type="button" onclick="showFormDistributor()" class="btn btn-success btn-fill">
         <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
       </button>
     </div>
     <div class="content">
      <table id="table_distributor"  class="display compact" cellpadding="0" cellspacing="0" border="0" style="width: 100%">

        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Distributor</th>
            <th>Jenis Kelamin</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
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
   dTable = $('#table_distributor').DataTable( {
    "bProcessing": true,
    "bServerSide": true,
    "bJQueryUI": false,
    "responsive": true,
    "bAutoWidth" : false,
    "paging": true,
    "pagingType": "simple",
    "sAjaxSource": "serverside/server_distributor.php", // Load Data
    "sServerMethod": "POST",
    "columnDefs": [
    { "orderable": true, "targets": 0, "searchable": false, "width" : "5%" },
    { "orderable": true, "targets": 1, "searchable": true, "width" : "20%" },
    { "orderable": true, "targets": 2, "searchable": true, "width" : "15%" },
    { "orderable": true, "targets": 3, "searchable": true, "width" : "15%" },
    { "orderable": true, "targets": 4, "searchable": true, "width" : "27%" },
    { "orderable": false, "targets": 5, "searchable": false, "width" : "18%" },
    ],
    "order": [
    [0, 'desc']
    ]
  } );
  


} );

// function tambah dan edit

$(document).on('submit', '#form_distributor', function(e) {
  e.preventDefault();
  var formData = $("#form_distributor").serialize();
  $.ajax({
    type: "POST",
    url: "serverside/crud_distributor.php",
    dataType: 'json',
    data: formData,
    success: function(data) {
      if (data == 'OK') {
        location.reload(true);
      }
    }
  });

});

function showFormDistributor(id_distributor) {
 $("#type").val("");
 if (id_distributor) {
  $.ajax({
    type: "POST",
    url: "serverside/crud_distributor.php",
    dataType: 'json',
    data: {id_distributor:id_distributor,type:"get"},
    success: function(res) {
     $("#judul_form_distributor").html('Edit Distributor : '+res.nama_distributor);
     $("#id_distributor").val(res.id_distributor);
     $("#type").val("edit");
     $("#jk").val(res.jk);
     $("#tgl_lahir").val(res.tgl_lahir);
     $("#nama_distributor").val(res.nama_distributor);
     $("#alamat").val(res.alamat);

     $('#div_table_distributor').addClass('hidden-div');
     $('#div_form_distributor').removeClass('hidden-div');
   }
 });
}
else {
  $("#judul_form_distributor").html("Form Entry Distributor");
  $("#type").val("new"); 
  $('#div_table_distributor').addClass('hidden-div');
  $('#div_form_distributor').removeClass('hidden-div');

}
}
//Hapus Data
function deleteDistributor( id_distributor )
{
  var conf = confirm("Yakin Ingin Menghapus Distributor ?");
  if (conf == true) {
    $.ajax({
     dataType: 'json',
     url : 'serverside/crud_distributor.php',
     type : 'post',
     data: {id_distributor:id_distributor,type:"delete"},
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