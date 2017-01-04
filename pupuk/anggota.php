<?php 
include 'sesi.php';
/******************************************************************/
$header_title = 'Anggota';
include 'layout/header.php';
?>
<!--=================================================================================-->
<div class="row hidden-div" id="div_form_anggota">
  <div class="col-md-8 col-md-offset-2">
    <div class="card">
      <div class="header"> <h3 class="title text-center" id="judul_form_anggota">Form Tambah Anggota</h3></div>
      <div class="content">
        <form method="post" id="form_anggota">
          <input type="text" id="type"  name="type" value="new" hidden>
          <input type="text" id="id_anggota" name="id_anggota" value="" hidden>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Anggota</label>
                <input type="text" id="nama_anggota" name="nama_anggota"  class="form-control form_datetime" required>
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
                <input type="text" class="form-control form-date" required id="tgl_lahir"  name="tgl_lahir">
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
              <a href="anggota.php"><button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-fill pull-left"></button></a>
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
<div class="row" id="div_table_anggota">
  <div class="col-md-12">
    <div class="card">
     <div class="header">
       <button type="button" onclick="showFormAnggota()" class="btn btn-success btn-fill">
         <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
       </button>
     </div>
     <div class="content">
      <table id="table_anggota"  class="display compact" cellpadding="0" cellspacing="0" border="0" style="width: 100%">

        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Anggota</th>
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
   dTable = $('#table_anggota').DataTable( {
    "bProcessing": true,
    "bServerSide": true,
    "bJQueryUI": false,
    "responsive": true,
    "bAutoWidth" : false,
    "paging": true,
    "pagingType": "simple",
    "sAjaxSource": "serverside/server_anggota.php", // Load Data
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

$(function () {
  $('#tgl_lahir').datetimepicker();
});

function showFormAnggota(id_anggota) {
 $("#type").val("");
 if (id_anggota) {
  $.ajax({
    type: "POST",
    url: "serverside/crud_anggota.php",
    dataType: 'json',
    data: {id_anggota:id_anggota,type:"get"},
    success: function(res) {
     $("#judul_form_anggota").html('Edit Anggota : '+res.nama_anggota);
     $("#id_anggota").val(res.id_anggota);
     $("#type").val("edit");
     $("#jk").val(res.jk);
     $("#tgl_lahir").val(res.tgl_lahir);
     $("#nama_anggota").val(res.nama_anggota);
     $("#alamat").val(res.alamat);

     $('#div_table_anggota').addClass('hidden-div');
     $('#div_form_anggota').removeClass('hidden-div');
   }
 });
}
else {
  $("#judul_form_anggota").html("Form Entry Anggota ");
  $("#type").val("new"); 
  $('#div_table_anggota').addClass('hidden-div');
  $('#div_form_anggota').removeClass('hidden-div');

}
}
//Hapus Data
function deleteAnggota( id_anggota )
{
  var conf = confirm("Yakin Ingin Menghapus Anggota ?");
  if (conf == true) {
    $.ajax({
     dataType: 'json',
     url : 'serverside/crud_anggota.php',
     type : 'post',
     data: {id_anggota:id_anggota,type:"delete"},
     success : function(msg) {
      if(msg == 'OK') {
        dTable.ajax.reload();
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