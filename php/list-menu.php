<?php

$list_per_page = "6" ;
 $query = "SELECT tb_category.id_category, tb_category.name, tb_subcategory.id_subcategory, tb_subcategory.name_sub, tb_subcategory.link, tb_subcategory.icon
FROM tb_category
INNER JOIN tb_subcategory ON tb_subcategory.id_category = tb_category.id_category ";
$sql = $config->paging($query, $list_per_page);
$stmt = $config->runQuery($sql);
$stmt->execute();
?>
<div class="x_panel">
    <div class="x_title">
      <h2><span class="fa fa-fw fa-list"></span> List Menu</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Settings 1</a>
            </li>
            <li><a href="#">Settings 2</a>
            </li>
          </ul>
        </li>
        <li><a class="close-link"><i class="fa fa-close"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <ul class="pagination pagination-split">
              <li><a href="#" data-toggle="modal" data-target="#addMenuList" >Add Menu</a></li>
            </ul>
          </div>

          <div class="clearfix"></div>
      <p>List Menu Admin SAS</p>

      <!-- start project list -->
      <table class="table table-striped projects">
        <thead>
          <tr>
            <th >#</th>
            <th >ID Category</th>
            <th >ID Sub Category</th>
            <th >Category</th>
            <th >Sub Category</th>
            <th >Link</th>
            <th >Icon</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            ?>
      <tr class="even pointer">

          <td>#</td>
          <td><?=$row['id_category']?></td>
          <td><?=$row['id_subcategory']?></td>
          <td><?=$row['name']?></td>
          <td><?=$row['name_sub']?></td>
          <td><?=$row['link']?></td>
          <td><span class="fa fa-fw <?=$row['icon']?>"></span></td>

      </tr>
      <?php } ?>
        </tbody>
      </table>
      <?php
        
        $stmt = $config->paginglink($query, $list_per_page);

        
        ?>
      <!-- end project list -->

    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="addMenuList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span> Add New Menu</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="php/add-menu.php">
                    <div class="form-group">
                        <select name="txt_category" class="form-control">
                            <option value="0" selected style="text-transform: capitalize; font-weight: 600;">-- Category
                                --
                            </option>
                            <?php
                            $admin = new Admin();

                            $stmt = $admin->runQuery("SELECT * FROM tb_category");
                            $stmt->execute();
                            // $upass = "admin";
                            // $new_password = password_hash($upass, PASSWORD_DEFAULT);

                            // echo $new_password;
                            while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                                # code...
                                ?>
                                <option style="text-transform: capitalize; font-weight: 600;"
                                        value="<?= $row['id_category'] ?>"><?= $row['name'] ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Sub Category</label>
                        <input name="txt_subCategory" type="text" class="form-control" id="exampleInputEmail1"
                               minlength="3" placeholder=". . . . . . . " required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Link URL</label>
                        <input name="txt_link" type="text" class="form-control" minlength="3" id="exampleInputPassword1"
                               placeholder=". . . . . . . ." required>
                    </div>
                    <div class="form-group">
                        <select name="txt_icon" class="form-control" style="font-family: 'FontAwesome', Arial;">
                            <option value="0" selected style="text-transform: capitalize; font-weight: 600;">-- Icon
                                --
                            </option>
                            <option value="fa fa-home">&#xf015;</option>
                            <option value="fa fa-list-alt">&#xf022;</option>
                            <option value="fa fa-th">&#xf00a;</option>
                            <option value="fa fa-sitemap">&#xf0e8;</option>
                            <option value="fa fa-bullseye">&#xf140;</option>
                            <option value="fa fa-user">&#xf007;</option>
                            <option value="fa fa-users">&#xf0c0;</option>
                            <option value="fa fa-user-md">&#xf0f0;</option>
                            <option value="fa fa-calendar">&#xf073;</option>
                            <option value="fa fa-calendar-o">&#xf133;</option>
                            <option value="fa fa-pencil-square-o">&#xf044;</option>
                            <option value="fa fa-gear">&#xf013;</option>
                            <option value="fa fa-barcode">&#xf02a;</option>
                            <option value="fa fa-image">&#xf03e;</option>
                            <option value="fa fa-newspaper-o">&#xf1ea;</option>
                            <option value="fa fa-frown-o">&#xf119;</option>
                            <option value="fa fa-pie-chart">&#xf200;</option>

                        </select>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>