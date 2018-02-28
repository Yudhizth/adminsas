<!-- conth -->
<?php
  include_once 'config/session.php';
  include_once 'config/api.php';
  $user_admin = new Login();
  $config = new Admin();
  
  if(isset($_SESSION['user_session'])){
      $admin_id = $_SESSION['user_session'];
  


  $stmt = $user_admin->runQuery("SELECT * FROM tb_admin WHERE username=:user_id");
  $stmt->execute(array(":user_id"=>$admin_id));

  $rowAdmin=$stmt->fetch(PDO::FETCH_ASSOC);
  $kd_admin = $rowAdmin['username'];

  // sidebarquery
    $category = "SELECT * FROM  tb_category INNER JOIN tb_staff ON tb_staff.id_category = tb_category.id_category WHERE tb_staff.id_roles = :idstaff";
    $cat = $config->runQuery($category);
    $cat->execute(array(
      ':idstaff'  => $rowAdmin['id_role']
      ));

  // endsidebar
    // readurl
    $url = "$_SERVER[REQUEST_URI]";
    $url = explode('/', $url);
    $urltype = explode('=', $url[2]);

    if (isset($urltype[1])){
        $root = explode('&', $urltype[1]);
        if($root == true){
            $footer = $root[0];
        }else{
            $footer = $urltype[1];
        }
    }else{
        $footer = "";
    }



    // endread
  include_once 'php/header.php';
  include_once 'php/side-navbar.php';
  include_once 'php/top-navbar.php';

?>
        <!-- page content -->
        <div class="right_col" role="main">
          <?php
          echo $footer;
            include_once 'php/page.php';
          ?>

        </div>
        <!-- /page content -->

       
    <?php
      include_once 'php/footer.php';
  }
    ?>
