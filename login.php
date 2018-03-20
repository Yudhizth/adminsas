<?php
// ini contoh commite 1
session_start();
include_once 'config/api.php';

$cekLogin = new Login();

if($cekLogin->is_loggedin()!="")
{
  $cekLogin->redirect('index.php');
}

  if(isset($_POST['btn-login']))
  {
    $username = strip_tags($_POST['txt_username']);
    $password = strip_tags($_POST['txt_password']);

    if ($cekLogin->runLogin($username, $password)) {
      # code...
      $cekLogin->redirect('index.php');
    } else{
      $error = $_SESSION['error'];
    }
  }
  $pass = password_verify('hello', 'makan');
  echo $pass;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SAS | Admin</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">

    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form name="login" method="post" action="">
              <h1>Login Form</h1>
              <?php
      if(isset($error))
      {
        ?>
                <div class="alert alert-danger" style="font-size: 15px">
                   <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                </div>
                <?php
      }
    ?>
              <div>
                <input name="txt_username" type="text" class="form-control" placeholder="Username" autofocus="autofocus" required />
              </div>
              <div>
                <input name="txt_password" type="password" class="form-control" placeholder="Password" required />
              </div>
              <div>
                <button type="submit" name="btn-login" class="btn btn-login">Submit
                  
                </button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">
                  Please contact your admin if you don't have any username!
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-building"></i> Sinergiadhikarya</h1>
                  <p>©2016 All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        
      </div>
    </div>
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
  </body>
</html>
