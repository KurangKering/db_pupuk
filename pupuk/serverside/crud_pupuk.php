
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
			
			$SQL = mysqli_query($con, "SELECT * FROM pupuk WHERE id_pupuk='".$_POST['id_pupuk']."'");
			$return = mysqli_fetch_array($SQL,MYSQLI_ASSOC);
			echo json_encode($return);
			break;
		
		//Tambah Data	
		case "new":
			
			
			$SQL = mysqli_query($con, 
									"INSERT INTO pupuk SET 
										nama_pupuk='".$_POST['nama_pupuk']."', 
										stock_pupuk='".$_POST['stock_pupuk']."', 
										harga_per_kg='".$_POST['harga_per_kg']."'
								");
			if($SQL){
				echo json_encode("OK");
			}
			break;
			
		//Edit Data	
		case "edit":
			
			$SQL = mysqli_query($con, 
									"UPDATE pupuk SET 
										nama_pupuk='".$_POST['nama_pupuk']."', 
										stock_pupuk='".$_POST['stock_pupuk']."', 
										harga_per_kg='".$_POST['harga_per_kg']."'
									WHERE id_pupuk='".$_POST['id_pupuk']."'
								");
			if($SQL){
				echo json_encode("OK");
			}			
			break;
			
		//Hapus Data	
		case "delete":
			
			$SQL = mysqli_query($con, "DELETE FROM pupuk WHERE id_pupuk='".$_POST['id_pupuk']."'");
			if($SQL){
				echo json_encode("OK");
			}			
			break;
	} 
	
?>