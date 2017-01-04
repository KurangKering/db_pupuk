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
			
			$SQL = mysqli_query($con, "SELECT * FROM distributor WHERE id_distributor='".$_POST['id_distributor']."'");
			$return = mysqli_fetch_array($SQL,MYSQLI_ASSOC);
			echo json_encode($return);
			break;
		
		//Tambah Data	
		case "new":
			
			
			$SQL = mysqli_query($con, 
									"INSERT INTO distributor SET 
										nama_distributor='".$_POST['nama_distributor']."', 
										jk='".$_POST['jk']."', 
										tgl_lahir='".$_POST['tgl_lahir']."',
										alamat='".$_POST['alamat']."'
								");
			if($SQL){
				 echo json_encode("OK");
				
			}
			break;
			
		//Edit Data	
		case "edit":
			
			$SQL = mysqli_query($con, 
									"UPDATE distributor SET 
										nama_distributor='".$_POST['nama_distributor']."', 
										jk='".$_POST['jk']."', 
										tgl_lahir='".$_POST['tgl_lahir']."',
										alamat='".$_POST['alamat']."'
									WHERE id_distributor='".$_POST['id_distributor']."'
								");
			if($SQL){
				echo json_encode("OK");
			}			
			break;
			
		//Hapus Data	
		case "delete":
			
			$SQL = mysqli_query($con, "DELETE FROM distributor WHERE id_distributor='".$_POST['id_distributor']."'");
			if($SQL){
				echo json_encode("OK");
			}			
			break;
	} 
	
?>