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


		case "get_tmp_penyediaan":
		$id_pupuk  = $_POST['id_pupuk']; 
		$pdo = $db->getRows("tmp_penyediaan", array('where'=> array('id_pupuk' => $id_pupuk)));
		echo json_encode($pdo);
		break;

		case "insert_tmp_penyediaan": 
		$id_pupuk = $_POST['id_pupuk'];
		$kuantitas = $_POST['kuantitas'];
		$harga_per_kg = $_POST['harga_per_kg'];
		$sql = "SELECT * FROM tmp_penyediaan WHERE id_pupuk = $id_pupuk";
		$result = $pdo->query($sql);
		if ($result->rowCount() > 0) {
			$sql = "UPDATE tmp_penyediaan SET kuantitas = kuantitas + $kuantitas, harga_per_kg = harga_per_kg + $harga_per_kg WHERE id_pupuk = $id_pupuk";
			$pdo = $pdo->prepare($sql);
			$pdo->execute();
			echo json_encode("Update");	
		}
		else {
			$pdo = $db->insert_tmp_penyediaan($id_pupuk, $kuantitas, $harga_per_kg);
			echo json_encode("Insert");

		}
		break;

		case "update_total_penyediaan":
		$sql = "SELECT id_pupuk, kuantitas, harga_per_kg , SUM(kuantitas* harga_per_kg) AS total FROM tmp_penyediaan" ;
		$pdo = $pdo->prepare($sql);
		$pdo->execute();
		$result = $pdo->fetchAll();
		echo json_encode($result);
		break;


		case "delete_penyediaan":

		$id_pupuk = $_POST['id_pupuk'];
		$cicak = $db->getRows("tmp_penyediaan", array('where'=> array('id_pupuk' => $id_pupuk)));
		$sql = "DELETE FROM tmp_penyediaan WHERE id_pupuk = $id_pupuk";
		$pdo = $pdo->prepare($sql);
		$pdo->execute();

		echo json_encode($cicak);
		break;



		case "update_penyediaan":
		$id_pupuk = $_POST['id_pupuk'];
		$kuantitas = $_POST['kuantitas'];
		$harga_per_kg = $_POST['harga_per_kg'];
		$sql = "SELECT * FROM tmp_penyediaan WHERE id_pupuk = $id_pupuk";
		$result = $pdo->query($sql);
		if ($result->rowCount() > 0) {
			$sql = "UPDATE  tmp_penyediaan SET kuantitas = kuantitas + $kuantitas, harga_per_kg = harga_per_kg + $harga_per_kg WHERE id_pupuk = $id_pupuk";
			$pdo = $pdo->prepare($sql);
			$pdo->execute();
			echo json_encode("OK");
			break;	
		}

		case "submit_penyediaan":
		$id_distributor = $_POST['id_distributor'];
		$tanggal = $_POST['tanggal'];
		$sql = "INSERT INTO penyediaan (id_distributor, tanggal)  VALUES (:id_distributor, :tanggal)";
		$pdo = $pdo->prepare($sql);
		$pdo->execute(array (
			"id_distributor" => $id_distributor,
			"tanggal" => $tanggal
			));
		break;
	}
}

else if (isset($_POST['submit_penyediaan'])) {
	$pdo_1 = $pdo;
	$pdo_2 = $pdo;
	$id_distributor = $_POST['id_distributor'];
	$tanggal = $_POST['tanggal'];
	$sql = "INSERT INTO penyediaan (id_distributor, tanggal)  VALUES (:id_distributor, :tanggal)";
	$result = $pdo_1->prepare($sql);
	$result->execute(array (
		"id_distributor" => $id_distributor,
		"tanggal" => $tanggal));

	$id_penyediaan = $pdo_1->lastInsertId();
	$result = $db->getRows("tmp_penyediaan");
	$insert_detail_penyediaan = array();
	foreach ($result as  $data) {
		$insert_detail_penyediaan = 
		array(
			"id_penyediaan" => $id_penyediaan,
			"id_pupuk" => $data['id_pupuk'],
			"kuantitas" => $data['kuantitas'],
			"harga_per_kg" => $data['harga_per_kg'],
			"sub_total" => $data['kuantitas'] * $data['harga_per_kg']);
		$insert = $db->insert("detail_penyediaan", $insert_detail_penyediaan);
		$kuantitas = $data['kuantitas'];
		$id_pupuk = $data['id_pupuk'];
		$sql = "UPDATE  pupuk SET stock_pupuk = stock_pupuk + $kuantitas WHERE id_pupuk = $id_pupuk";
		$result = $pdo_2->prepare($sql);
		$result->execute();
	}

	header("location:../penyediaan.php"); }

	?>