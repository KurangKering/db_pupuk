<?php
include '../sesi.php';
	//Connection Database
$con = mysqli_connect("localhost","root","","db_pupuk");
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

switch ($_POST['type']) {

		//Tampilkan Data 
	case "get":

	$SQL = mysqli_query($con, "SELECT * FROM penjualan WHERE id_penjualan='".$_POST['id_penjualan']."'");
	$return = mysqli_fetch_array($SQL,MYSQLI_ASSOC);
	echo json_encode($return);
	break;

		//Tambah Data	
	case "new":


	$SQL = mysqli_query($con, 
		"INSERT INTO penjualan SET 
		nama_penjualan='".$_POST['nama_penjualan']."', 
		jk='".$_POST['jk']."', 
		tgl_lahir='".$_POST['tgl_lahir']."',
		alamat='".$_POST['alamat']."'
		");
	if($SQL){
		echo json_encode("OK");
			 //header('Location: http://' . $_SERVER['SERVER_NAME'] . '/db_pupuk/penjualan.php');
	}
	break;

		//Edit Data	
	case "edit":

	$SQL = mysqli_query($con, 
		"UPDATE penjualan SET 
		nama_penjualan='".$_POST['nama_penjualan']."', 
		jk='".$_POST['jk']."', 
		tgl_lahir='".$_POST['tgl_lahir']."',
		alamat='".$_POST['alamat']."'
		WHERE id_penjualan='".$_POST['id_penjualan']."'
		");
	if($SQL){
		echo json_encode("OK");
	}			
	break;

		//Hapus Data	
	case "delete":
	$delDetailPenjualan = mysqli_query($con, "DELETE FROM detail_penjualan WHERE id_penjualan='".$_POST['id_penjualan']."'");
	$SQL = mysqli_query($con, "DELETE FROM penjualan WHERE id_penjualan='".$_POST['id_penjualan']."'");
	if($SQL){
		echo json_encode("OK");
	}			
	break;

		//Hapus Data	
	case "get_details":
	// $SQL = mysqli_query($con, "SELECT dpp.*, pp.nama_pupuk, (SELECT SUM(dp.kuantitas * p.harga_per_kg) FROM detail_penjualan dp JOIN  pupuk p ON  dp.id_pupuk = p.id_pupuk WHERE dp.id_penjualan = dpp.id_penjualan) AS total FROM detail_penjualan dpp INNER JOIN pupuk pp ON dpp.id_pupuk = pp.id_pupuk WHERE dpp.id_penjualan = '".$_POST['id_penjualan']."'");
	$SQL = mysqli_query($con, "SELECT pen.tanggal, angg.nama_anggota, dpp.*, pp.nama_pupuk, (SELECT SUM(dp.kuantitas * dp.harga_per_kg) FROM detail_penjualan dp WHERE dp.id_penjualan = dpp.id_penjualan) AS total FROM detail_penjualan dpp INNER JOIN pupuk pp ON dpp.id_pupuk = pp.id_pupuk JOIN penjualan pen ON pen.id_penjualan = dpp.id_penjualan JOIN anggota angg ON pen.id_anggota = angg.id_anggota  WHERE dpp.id_penjualan = '".$_POST['id_penjualan']."'");
	$return = mysqli_fetch_all($SQL,MYSQLI_ASSOC);
	echo json_encode($return);		
	break;
} 

?>