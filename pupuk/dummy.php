<?php 
include 'sesi.php';
include 'CRUD.php';
require_once 'database.php';
$pdo = DB::connect();
$db = new CRUD();


/******************************************************************/
$header_title = 'Dummy';
include 'layout/header.php';

$con = mysqli_connect("localhost","root","","db_pupuk");
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// $sql = "SELECT SQL_CALC_FOUND_ROWS p.*,a.nama_anggota, 
// (SELECT SUM(dp.kuantitas * p.harga_per_kg) FROM detail_penjualan dp JOIN  pupuk p ON  dp.id_pupuk = p.id_pupuk WHERE dp.id_penjualan = p.id_penjualan ) AS total FROM penjualan AS p 
// inner join anggota AS a  on
// a.id_anggota = p.id_anggota WHERE p.id_penjualan = 7";

// $SQL = mysqli_query($con, "SELECT pen.tanggal, angg.nama_anggota, dpp.*, pp.nama_pupuk, (SELECT SUM(dp.kuantitas * p.harga_per_kg) FROM detail_penjualan dp JOIN  pupuk p ON  dp.id_pupuk = p.id_pupuk WHERE dp.id_penjualan = dpp.id_penjualan) AS total FROM detail_penjualan dpp INNER JOIN pupuk pp ON dpp.id_pupuk = pp.id_pupuk JOIN penjualan pen ON pen.id_penjualan = dpp.id_penjualan JOIN anggota angg ON pen.id_anggota = angg.id_anggota  WHERE dpp.id_penjualan = '".$_POST['id_penjualan']."'");
// 	$return = mysqli_fetch_all($SQL,MYSQLI_ASSOC);
// 	echo json_encode($return);	
// 	
// 	
// $sql = "SELECT pen.tanggal, angg.nama_anggota, dpp.*, pp.nama_pupuk, (SELECT SUM(dp.kuantitas * p.harga_per_kg) FROM detail_penjualan dp JOIN  pupuk p ON  dp.id_pupuk = p.id_pupuk WHERE dp.id_penjualan = dpp.id_penjualan) AS total FROM detail_penjualan dpp INNER JOIN pupuk pp ON dpp.id_pupuk = pp.id_pupuk JOIN penjualan pen ON pen.id_penjualan = dpp.id_penjualan JOIN anggota angg ON pen.id_anggota = angg.id_anggota  WHERE dpp.id_penjualan = 6";
// $sql = "SELECT dp_.*, (SELECT SUM(dp.kuantitas * p.harga_per_kg) FROM detail_penjualan dp JOIN  pupuk p ON  dp.id_pupuk = p.id_pupuk WHERE dp.id_penjualan = p.id_penjualan  GROUP BY dp.id_penjualan) AS total FROM detail_penjualan p WHERE id_penjualan = 6";
// 
// 
// $sql = "SELECT pen.tanggal, dist.nama_distributor, dpp.*, pp.nama_pupuk, (SELECT SUM(dp.kuantitas * dp.harga_per_kg) FROM detail_penyediaan dp JOIN  pupuk p ON  dp.id_pupuk = p.id_pupuk WHERE dp.id_penyediaan = pen.id_penyediaan) AS total FROM detail_penyediaan dpp INNER JOIN pupuk pp ON dpp.id_pupuk = pp.id_pupuk JOIN penyediaan pen ON pen.id_penyediaan = dpp.id_penyediaan JOIN distributor dist ON pen.id_distributor = dist.id_distributor  WHERE dpp.id_penyediaan = 8";


// $sql = "SELECT SUM(dp.kuantitas * p.harga_per_kg) AS TOTAL FROM detail_penjualan dp JOIN  pupuk p ON  dp.id_pupuk = p.id_pupuk 	  GROUP BY dp.id_penjualan";
// $sql = "SELECT p.id_pupuk, nama_pupuk FROM detail_penjualan p INNER JOIN pupuk ON p.id_pupuk = pupuk.id_pupuk WHERE p.id_penjualan = 3";
// $cicak = $db->getRows('anggota', array('where' => array("id_anggota" => '4') ));

// echo $cicak[0]['id_anggota'];
// print_r($cicak);

// $result = $pdo->prepare($sql);
// $result->execute();
// $q = $result->fetchAll();
//echo json_encode($q);
//
//
//

$SQL = mysqli_query($con, 
	"INSERT INTO anggota SET 
	nama_anggota= 'cicak', 
	jk='laki-laki', 
	tgl_lahir='0000',
	alamat='sdfjklsakflas'
	");
$last_id = mysqli_insert_id($con);
header("Location: ../kartu_anggota.php?id_anggota= '".$last_id."'' ");

print_r($last_id);
include 'layout/footer.php';
?>