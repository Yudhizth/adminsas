<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 08/02/2018
 * Time: 17.01
     */
include_once '../../config/api.php';
$config = new Admin();

$id = $_GET['roles'];
$username = $_GET['username'];

$a = "SELECT * FROM tb_category";
$a = $config->runQuery($a);
$a->execute();

?>
<style type="text/css">
    .panel-primary{
        border-color: rgba(52,152,219,.88)!important;
    }

    .panel-primary>.panel-heading{
        background-color: rgba(52,152,219,.88) !important;
        color: #fff !important;
        border-color: rgba(52,152,219,.88) !important;
    }

    .panel-warning{
        border-color: rgba(243,156,18,.88) !important;
    }

    .panel-warning>.panel-heading{
        background-color: rgba(243,156,18,.88) !important;
        color: #fff !important;
        border-color: rgba(243,156,18,.88) !important;
    }
    .panel-danger{
        border-color: rgba(231,76,60,.88) !important;
    }

    .panel-danger>.panel-heading{
        background-color: rgba(231,76,60,.88) !important;
        color: #fff !important;
        border-color: rgba(231,76,60,.88) !important;
    }
    ul.to_do p{
        color: #fff;
        text-transform: capitalize;
        font-size: 14px;
        padding: 0.1% 4% !important;
    }
</style>

<div id="contentISI">
    <div class="x_title">
        <h2>Previllage USER <small>Limited Edition</small></h2>
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
    <div class="x_content" id="previllage">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <?php while ($category = $a->fetch(PDO::FETCH_LAZY)){

                    if($category['id_category'] == '1'){
                        $panel = "primary";
                        $label = "background: #4ca4df; !imporant";
                    }elseif($category['id_category'] == '2'){
                        $panel = "warning";
                        $label = "background: #f4a82e; !imporant";
                    }else{
                        $panel = "danger";
                        $label = "background: #ea6153; !imporant";
                    }
                    $b = "SELECT tb_category.id_category, tb_category.name, tb_subcategory.id_subcategory, tb_subcategory.name_sub, tb_subcategory.link, tb_subcategory.icon, tb_previllage.id_admin FROM tb_subcategory
INNER JOIN tb_category ON tb_category.id_category = tb_subcategory.id_category
INNER JOIN tb_previllage ON tb_previllage.id_subcategory = tb_subcategory.id_subcategory
WHERE tb_category.id_category = :id AND tb_previllage.id_admin = :admin";
                    $stmt = $config->runQuery($b);

                    $stmt->execute(array(
                        ':id'   => $category['id_category'],
                        ':admin'=>$username
                    ));
                    ?>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="panel panel-<?=$panel?>">
                        <div class="panel-heading">
                            <h3 style="text-transform: capitalize;"><?=$category['name']?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="x_content">

                                <div class="">
                                    <ul class="to_do">
                                        <?php while ($sub = $stmt->fetch(PDO::FETCH_LAZY)){ ?>
                                        <li style="<?=$label?> color: #fff!important;">
                                            <p>
                                                <?=$sub['name_sub']?>
                                            </p>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
