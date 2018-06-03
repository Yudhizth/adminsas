
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SAS | </title>
    <link rel="stylesheet" href="build/css/jquery-ui.css">
    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- Datatables -->
    <link href="vendors/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">

      <link href="vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
      <link href="vendors/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">
      <link href="vendors/timepicker/jquery.timepicker.min.css" rel="stylesheet">

      <?php if($footer == 'data-entry' OR $footer == 'map' OR $footer == 'calon-karyawan'){ ?>
        <link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <?php } ?>

    <!-- Custom Theme Style -->
    <link href="build/css/custom.css" rel="stylesheet">
  </head>
	<body class="nav-md">
	    <div class="container body">
	      <div class="main_container">
	        <div class="col-md-3 left_col">
	          <div class="left_col scroll-view">
	            <div class="navbar nav_title" style="border: 0;">
	              <a href="index.php" class="site_title"><i class="fa fa-building"></i> <span>Sinergiadhikarya</span></a>
	            </div>

	            <div class="clearfix"></div>

	            <!-- menu profile quick info -->
	            <div class="profile clearfix">
	              <div class="profile_pic">
	                <img src="images/<?php echo $rowAdmin['picture']; ?>" alt="..." class="img-circle profile_img">
	              </div>
	              <div class="profile_info">
	                <span>Welcome,</span>
	                <h2><?php echo $rowAdmin['nama_admin']; ?></h2>
	              </div>
	            </div>
	            <!-- /menu profile quick info -->

