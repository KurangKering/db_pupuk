<?php 

require_once '../CRUD.php';
require_once '../database.php';
$db = new CRUD();
$pdo = DB::connect();
if (isset($_POST['type'])) {


	switch ($_POST['type']) {

		case "get_stock_pupuk":
		$id_pupuk  = $_POST['id_pupuk']; 
		$pdo = $db->getRows("pupuk", array('where'=> array('id_pupuk' => $id_pupuk)));
		echo json_encode($pdo);
		break;


		case "get_tmp_penjualan":
		$id_pupuk  = $_POST['id_pupuk']; 
		$pdo = $db->getRows("tmp_penjualan", array('where'=> array('id_pupuk' => $id_pupuk)));
		echo json_encode($pdo);
		break;

		case "insert_tmp_penjualan": 
		$id_pupuk = $_POST['id_pupuk'];
		$kuantitas = $_POST['kuantitas'];
		$sql = "SELECT * FROM tmp_penjualan WHERE id_pupuk = $id_pupuk";
		$result = $pdo->query($sql);
		if ($result->rowCount() > 0) {
			$sql = "UPDATE tmp_penjualan SET kuantitas = kuantitas + $kuantitas WHERE id_pupuk = $id_pupuk";
			$pdo = $pdo->prepare($sql);
			$pdo->execute();
			echo json_encode("Update");	
		}
		else {
			$pdo = $db->insert_tmp_penjualan($id_pupuk, $kuantitas);
			echo json_encode("Insert");

		}
		break;

		case "update_total_penjualan":
		$sql = "SELECT id_pupuk, kuantitas, harga_per_kg , SUM(kuantitas* harga_per_kg) AS total FROM tmp_penjualan" ;
		$pdo = $pdo->prepare($sql);
		$pdo->execute();
		$result = $pdo->fetchAll();
		echo json_encode($result);
		break;


		case "delete_penjualan":

		$id_pupuk = $_POST['id_pupuk'];
		$cicak = $db->getRows("tmp_penjualan", array('where'=> array('id_pupuk' => $id_pupuk)));
		$sql = "DELETE FROM tmp_penjualan WHERE id_pupuk = $id_pupuk";
		$pdo = $pdo->prepare($sql);
		$pdo->execute();

		echo json_encode($cicak);
		break;



		case "update_penjualan":
		$id_pupuk = $_POST['id_pupuk'];
		$kuantitas = $_POST['kuantitas'];
		$sql = "SELECT * FROM tmp_penjualan WHERE id_pupuk = $id_pupuk";
		$result = $pdo->query($sql);
		if ($result->rowCount() > 0) {
			$sql = "UPDATE  tmp_penjualan SET kuantitas = kuantitas + $kuantitas WHERE id_pupuk = $id_pupuk";
			$pdo = $pdo->prepare($sql);
			$pdo->execute();
			echo json_encode("OK");
			break;	
		}

		case "submit_penjualan":
		$id_anggota = $_POST['id_anggota'];
		$tanggal = $_POST['tanggal'];
		$sql = "INSERT INTO penjualan (id_anggota, tanggal)  VALUES (:id_anggota, :tanggal)";
		$pdo = $pdo->prepare($sql);
		$pdo->execute(array (
			"id_anggota" => $id_anggota,
			"tanggal" => $tanggal
			));
	}
}

else if (isset($_POST['submit_penjualan'])) {
	$pdo_1 = $pdo;
	$pdo_2 = $pdo;
	$id_anggota = $_POST['id_anggota'];
	$tanggal = $_POST['tanggal'];
	$sql = "INSERT INTO penjualan (id_anggota, tanggal)  VALUES (:id_anggota, :tanggal)";
	$result = $pdo_1->prepare($sql);
	$result->execute(array (
		"id_anggota" => $id_anggota,
		"tanggal" => $tanggal));

	$id_penjualan = $pdo_1->lastInsertId();
	$result = $db->getRows("tmp_penjualan");
	$insert_detail_penjualan = array();
	foreach ($result as  $data) {
		$insert_detail_penjualan = 
		array(
			"id_penjualan" => $id_penjualan,
			"id_pupuk" => $data['id_pupuk'],
			"kuantitas" => $data['kuantitas'],
			"harga_per_kg" => $data['harga_per_kg'],
			"sub_total" => $data['kuantitas'] * $data['harga_per_kg']);
		$insert = $db->insert("detail_penjualan", $insert_detail_penjualan);
		$kuantitas = $data['kuantitas'];
		$id_pupuk = $data['id_pupuk'];
		$sql = "UPDATE  pupuk SET stock_pupuk = stock_pupuk - $kuantitas WHERE id_pupuk = $id_pupuk";
		$result = $pdo_2->prepare($sql);
		$result->execute();
	}

	header("location:../penjualan.php"); }

	?>