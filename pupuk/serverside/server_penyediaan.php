<?php
function mysqliConnection()
{		
				// Database connection information
	$gaSql['user']     = 'root';
	$gaSql['password'] = '';   
				$gaSql['db']       = 'db_pupuk';  //Database
				$gaSql['server']   = 'localhost';   
				$gaSql['port']     = 3306; // 3306 is the default MySQL port
				$gaSql['charset']  = 'utf8';
				$db = new mysqli($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'], $gaSql['port']);
				if (mysqli_connect_error()) {
					die( 'Error connecting to MySQL server (' . mysqli_connect_errno() .') '. mysqli_connect_error() );
				}
				
				if (!$db->set_charset($gaSql['charset'])) {
					die( 'Error loading character set "'.$gaSql['charset'].'": '.$db->error );
				}
				return $db;
			}
			
			function Paging( $input )
			{
				$sLimit = "";
				if ( isset( $input['iDisplayStart'] ) && $input['iDisplayLength'] != '-1' ) {
					$sLimit = " LIMIT ".intval( $input['iDisplayStart'] ).", ".intval( $input['iDisplayLength'] );
				}
				
				return $sLimit;
			}
			
			
			function Ordering( $input, $aColumns )
			{
				$aOrderingRules = array();
				if ( isset( $input['iSortCol_0'] ) ) {
					$iSortingCols = intval( $input['iSortingCols'] );
					for ( $i=0 ; $i<$iSortingCols ; $i++ ) {
						if ( $input[ 'bSortable_'.intval($input['iSortCol_'.$i]) ] == 'true' ) {
							$aOrderingRules[] =
							$aColumns[ intval( $input['iSortCol_'.$i] ) ]." "
							.($input['sSortDir_'.$i]==='asc' ? 'asc' : 'desc');
						}
					}
				}
				
				if (!empty($aOrderingRules)) {
					$sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
				} else {
					$sOrder = "";
				}
				return $sOrder;
			}
			
			function Filtering( $aColumns, $iColumnCount, $input, $db )
			{
				if ( isset($input['sSearch']) && $input['sSearch'] != "" ) {
					$aFilteringRules = array();
					for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
						if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' ) {
							$aFilteringRules[] = $aColumns[$i]." LIKE '%".$db->real_escape_string( $input['sSearch'] )."%'";
						}
					}
					if (!empty($aFilteringRules)) {
						$aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
					}
				}
				
				// Individual column filtering
				for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
					if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' && $input['sSearch_'.$i] != '' ) {
						$aFilteringRules[] = $aColumns[$i]."  LIKE '%".$db->real_escape_string($input['sSearch_'.$i])."%'";
					}
				}
				
				if (!empty($aFilteringRules)) {
					$sWhere = "WHERE ".implode(" AND ", $aFilteringRules);
				} else {
					$sWhere = "WHERE 1=1 ";
				}
				return $sWhere;
			}
			

			mb_internal_encoding('UTF-8');
	$aColumns = array('p.id_penyediaan','p.tanggal','a.nama_distributor'); //Kolom Pada Tabel
	
	// Indexed column (used for fast and accurate table cardinality)
	$sIndexColumn = 'id_penyediaan';
	
	// DB table to use
	$sTable = 'penyediaan'; // Nama Tabel
	$sTable2 = 'distributor'; // Nama Tabel
	$sTable3 = 'detail_penyediaan';
	
	
	// Input method (use $_GET, $_POST or $_REQUEST)
	$input =& $_POST;

	
	$iColumnCount = count($aColumns);
	
	$db = mysqliConnection();
	$sLimit = Paging( $input );
	$sOrder = Ordering( $input, $aColumns );
	$sWhere = Filtering( $aColumns, $iColumnCount, $input, $db );
	
	$aQueryColumns = array();
	foreach ($aColumns as $col) {
		if ($col != ' ') {
			$aQueryColumns[] = $col;
		}
	}
	
	$sQuery = "
	SELECT SQL_CALC_FOUND_ROWS p.*,a.nama_distributor, 
	(SELECT SUM(dp.kuantitas * dp.harga_per_kg) FROM detail_penyediaan dp WHERE dp.id_penyediaan = p.id_penyediaan ) AS total FROM penyediaan AS p 
	inner join distributor AS a  on
	a.id_distributor = p.id_distributor
	".$sWhere.$sOrder.$sLimit;
	
	
	$rResult = $db->query( $sQuery ) or die($db->error);
	// Data set length after filtering
	$sQuery = "SELECT FOUND_ROWS()";
	$rResultFilterTotal = $db->query( $sQuery ) or die($db->error);
	list($iFilteredTotal) = $rResultFilterTotal->fetch_row();
	
	// Total data set length
	$sQuery = "SELECT COUNT(p.".$sIndexColumn.") FROM ".$sTable." AS p INNER JOIN ".$sTable2." AS a ON p.id_distributor = a.id_distributor";
	$rResultTotal = $db->query( $sQuery ) or die($db->error);
	list($iTotal) = $rResultTotal->fetch_row();
	
	/**
		* Output
	*/
		$output = array(
			"sEcho"                => intval($input['sEcho']),
			"iTotalRecords"        => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData"               => array(),
			);

	// Looping Data
		while ( $aRow = $rResult->fetch_assoc() ) {
			$row = array();
			$btn = '<td><center>
			<a onClick="showDetail(\''.$aRow['id_penyediaan'].'\')" data-toggle="tooltip" title="Details" class="btn  btn-sm btn-info btn-fill"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
			<a onClick="deletePenyediaan(\''.$aRow['id_penyediaan'].'\')"   data-toggle="tooltip" title="Hapus" class="btn btn-sm btn-fill btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i></a>
		</center></td>';
		$row = array($aRow['id_penyediaan'], $aRow['tanggal'], $aRow['nama_distributor'], 'Rp. ' . number_format($aRow['total'], 0, ".", "."), $btn);
		$output['aaData'][] = $row;
	}

	echo json_encode( $output );
	?>