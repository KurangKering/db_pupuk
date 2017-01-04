<?php
include '../sesi.php';	
include '../database.php';
	/**
		* Script:    DataTables server-side script for PHP 5.2+ and MySQL 4.1+
		* Notes:     Based on a script by Allan Jardine that used the old PHP mysql_* functions.
		*            Rewritten to use the newer object oriented mysqli extension.
		* Copyright: 2010 - Allan Jardine (original script)
		*            2012 - Kari Söderholm, aka Haprog (updates)
		* License:   GPL v2 or BSD (3-point)
	*/
		mb_internal_encoding('UTF-8');

	/**
		* Array of database columns which should be read and sent back to DataTables. Use a space where
		* you want to insert a non-database field (for example a counter or static image)
	*/
	$aColumns = array( 'id_pupuk', 'nama_pupuk', 'stock_pupuk', 'harga_per_kg'); //Kolom Pada Tabel
	
	// Indexed column (used for fast and accurate table cardinality)
	$sIndexColumn = 'id_pupuk';
	
	// DB table to use
	$sTable = 'pupuk'; // Nama Tabel
	
	// Database connection information
	$gaSql['user']     = 'root';
	$gaSql['password'] = '';   
	$gaSql['db']       = 'db_pupuk';  //Database
	$gaSql['server']   = 'localhost';   
	$gaSql['port']     = 3306; // 3306 is the default MySQL port
	
	// Input method (use $_GET, $_POST or $_REQUEST)
	$input =& $_POST;

	$gaSql['charset']  = 'utf8';
	
	/**
		* MySQL connection
	*/
		$db = DB::connect();


	/**
		* Paging
	*/
		$sLimit = "";
		if ( isset( $input['iDisplayStart'] ) && $input['iDisplayLength'] != '-1' ) {
			$sLimit = " LIMIT ".intval( $input['iDisplayStart'] ).", ".intval( $input['iDisplayLength'] );
		}


	/**
		* Ordering
	*/
		$aOrderingRules = array();
		if ( isset( $input['iSortCol_0'] ) ) {
			$iSortingCols = intval( $input['iSortingCols'] );
			for ( $i=0 ; $i<$iSortingCols ; $i++ ) {
				if ( $input[ 'bSortable_'.intval($input['iSortCol_'.$i]) ] == 'true' ) {
					$aOrderingRules[] =
					"`".$aColumns[ intval( $input['iSortCol_'.$i] ) ]."` "
					.($input['sSortDir_'.$i]==='asc' ? 'asc' : 'desc');
				}
			}
		}

		if (!empty($aOrderingRules)) {
			$sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
		} else {
			$sOrder = "";
		}


	/**
		* Filtering
		* NOTE this does not match the built-in DataTables filtering which does it
		* word by word on any field. It's possible to do here, but concerned about efficiency
		* on very large tables, and MySQL's regex functionality is very limited
	*/
		$iColumnCount = count($aColumns);

		if ( isset($input['sSearch']) && $input['sSearch'] != "" ) {
			$aFilteringRules = array();
			for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
				if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' ) {
					$aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%". $db->quote($input['sSearch']) ."%'";
				}
			}
			if (!empty($aFilteringRules)) {
				$aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
			}
		}

	// Individual column filtering
	// for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
	// 	if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' && $input['sSearch_'.$i] != '' ) {
	// 		$aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string($input['sSearch_'.$i])."%'";
	// 	}
	// }

		if (!empty($aFilteringRules)) {
			$sWhere = " WHERE ".implode(" AND ", $aFilteringRules);
		} else {
			$sWhere = "";
		}


	/**
		* SQL queries
		* Get data to display
	*/
		$aQueryColumns = array();
		foreach ($aColumns as $col) {
			if ($col != ' ') {
				$aQueryColumns[] = $col;
			}
		}

		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", $aQueryColumns)."`
		FROM `".$sTable."`".$sWhere.$sOrder.$sLimit;

		$rResult = $db->query( $sQuery );

	// Data set length after filtering
		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = $db->query( $sQuery );
		list($iFilteredTotal) = $rResultFilterTotal->fetch(PDO::FETCH_NUM);

	// Total data set length
		$sQuery = "SELECT COUNT(`".$sIndexColumn."`) FROM `".$sTable."`";
		$rResultTotal = $db->query( $sQuery );
		list($iTotal) = $rResultTotal->fetch(PDO::FETCH_NUM);


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
		while ( $aRow = $rResult->fetch() ) {
			$row = array();
			$btn = '<td><center>
			<a onClick="showFormPupuk(\''.$aRow['id_pupuk'].'\')" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning btn-fill"> <i class="fa fa-edit" aria-hidden="true"></i></a>
			<a onClick="deletePupuk(\''.$aRow['id_pupuk'].'\')"   data-toggle="tooltip" title="Hapus" class="btn btn-sm btn-danger btn-fill"> <i class="fa fa-trash" aria-hidden="true"></i></a>
		</center></td>';

		// $btn = '<a href="#" onClick="showModals(\''.$aRow['id_pupuk'].'\')">Edit</a> | <a href="#" onClick="deleteUser(\''.$aRow['id_pupuk'].'\')">delete</a> | Print';
		for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
			$row[] = $aRow[ $aColumns[$i] ];

		}
		$row = array($aRow['id_pupuk'], $aRow['nama_pupuk'], $aRow['stock_pupuk'] . ' Kg', 'Rp. ' . number_format($aRow['harga_per_kg'], 0, ".", "."), $btn );
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
	
	?>