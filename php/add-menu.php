<?php
session_start();
include_once '../config/api.php';
$config = new Admin();

$category = $_POST['txt_category'];
$subCategory = $_POST['txt_subCategory'];
$link = $_POST['txt_link'];
$icon = $_POST['txt_icon'];
$admin_id = $config->adminID();
$admin_id = $admin_id['id'];

$query = "INSERT INTO tb_subcategory (id_category, name_sub, link, icon) VALUES (:idsub, :name, :link, :icon)";

    $stmt = $config->runQuery($query);
    $stmt->execute(array(
      ':idsub' => $category,
      ':name'   => $subCategory,
      ':link'   => $link,
      ':icon'   => $icon
    ));

    if ($stmt) {
        $id_reff = $config->lastInsertID();
        $log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
        $log = $config->runQuery($log);
        $log->execute(array(
            ':a'    => $id_reff,
            ':b'    => '2',
            ':c'    => 'tb_loker',
            ':d'    => 'update data loker',
            ':e'    =>  $admin_id
        ));
      # code...
      echo "<script>
        alert('Menu berhasil ditambahkan!');
        window.location.href='../?p=list-menu';
        </script>";
    }else{
      echo "<script>
        alert('Menu gagal di input!');
        window.location.href='../?p=list-menu';
        </script>";
    }


 ?>
