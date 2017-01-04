<?php require_once 'sesi.php';  ?>
<?php require_once 'nav_menu.php' ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Sistem Informasi Penjualan Pupuk</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/AdminLTE.min.css" rel="stylesheet" />
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/plugins/dataTables/media/css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="assets/plugins/dataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/plugins/jqueryui/jquery-ui.min.css">
    
    <link rel="stylesheet" href="assets/css/my-style.css">


    <?php if (isset($css_tambahan)) echo $css_tambahan; ?>
</head>
<body>

    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text">
                CV PERSADA
            </a>
        </div>
        <?php include 'layout/nav.php' ?>
    </div>
</div>

<div class="main-panel">
    <nav class="navbar navbar-default navbar-fixed">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?php if (isset($header_title)) echo $header_title; else echo ""; ?></a>
            </div>
            <div class="collapse navbar-collapse">

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="proses_logout.php">
                            <?php echo $_SESSION['username']; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content">
        <div class="container-fluid" id="tampil_data">

