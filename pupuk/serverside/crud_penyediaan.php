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

	$SQL = mysqli_query($con, "SELECT * FROM anggota WHERE id_anggota='".$_POST['id_anggota']."'");
	$return = mysqli_fetch_array($SQL,MYSQLI_ASSOC);
	echo json_encode($return);
	break;

		//Tambah Data	
	case "new":


	$SQL = mysqli_query($con, 
		"INSERT INTO anggota SET 
		nama_anggota='".$_POST['nama_anggota']."', 
		jk='".$_POST['jk']."', 
		tgl_lahir='".$_POST['tgl_lahir']."',
		alamat='".$_POST['alamat']."'
		");
	if($SQL){
		echo json_encode("OK");
			 //header('Location: http://' . $_SERVER['SERVER_NAME'] . '/db_pupuk/anggota.php');
	}
	break;

		//Edit Data	
	case "edit":

	$SQL = mysqli_query($con, 
		"UPDATE anggota SET 
		nama_anggota='".$_POST['nama_anggota']."', 
		jk='".$_POST['jk']."', 
		tgl_lahir='".$_POST['tgl_lahir']."',
		alamat='".$_POST['alamat']."'
		WHERE id_anggota='".$_POST['id_anggota']."'
		");
	if($SQL){
		echo json_encode("OK");
	}			
	break;

		//Hapus Data	
	case "delete":
	$delDetailPenyediaan = mysqli_query($con, "DELETE FROM detail_penyediaan WHERE id_penyediaan='".$_POST['id_penyediaan']."'");
	$SQL = mysqli_query($con, "DELETE FROM penyediaan WHERE id_penyediaan='".$_POST['id_penyediaan']."'");
	if($SQL){
		echo json_encode("OK");
	}			
	break;
	case "get_details":
	// $SQL = mysqli_query($con, "SELECT dpp.*, pp.nama_pupuk, (SELECT SUM(dp.kuantitas * p.harga_per_kg) FROM detail_penjualan dp JOIN  pupuk p ON  dp.id_pupuk = p.id_pupuk WHERE dp.id_penjualan = dpp.id_penjualan) AS total FROM detail_penjualan dpp INNER JOIN pupuk pp ON dpp.id_pupuk = pp.id_pupuk WHERE dpp.id_penjualan = '".$_POST['id_penjualan']."'");
	$SQL = mysqli_query($con, "SELECT pen.tanggal, dist.nama_distributor, dpp.*, pp.nama_pupuk, (SELECT SUM(dp.kuantitas * dp.harga_per_kg) FROM detail_penyediaan dp JOIN  pupuk p ON  dp.id_pupuk = p.id_pupuk WHERE dp.id_penyediaan = dpp.id_penyediaan) AS total FROM detail_penyediaan dpp INNER JOIN pupuk pp ON dpp.id_pupuk = pp.id_pupuk JOIN penyediaan pen ON pen.id_penyediaan = dpp.id_penyediaan JOIN distributor dist ON pen.id_distributor = dist.id_distributor  WHERE dpp.id_penyediaan = '".$_POST['id_penyediaan']."'");
	$return = mysqli_fetch_all($SQL,MYSQLI_ASSOC);
	echo json_encode($return);		
	break;
} 

?>