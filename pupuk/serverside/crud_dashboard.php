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

	$SQL = mysqli_query($con, "DELETE FROM anggota WHERE id_anggota='".$_POST['id_anggota']."'");
	if($SQL){
		echo json_encode("OK");
	}			
	break;

	case "get_data_penjualan":

	$SQL = mysqli_query($con, "SELECT tanggal, COUNT(*) as total FROM penjualan WHERE MONTH(tanggal) = MONTH(NOW()) GROUP BY tanggal");
	$return = mysqli_fetch_all($SQL,MYSQLI_ASSOC);
	echo json_encode($return);			
	break;

	case "get_data_penyediaan":

	$SQL = mysqli_query($con, "SELECT tanggal, COUNT(*) as total FROM penyediaan WHERE MONTH(tanggal) = MONTH(NOW()) GROUP BY tanggal");
	$return = mysqli_fetch_all($SQL,MYSQLI_ASSOC);
	echo json_encode($return);			
	break;
} 

?>