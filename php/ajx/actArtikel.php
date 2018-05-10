<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 22/03/2018
 * Time: 19.32
 */
include_once '../../config/session.php';
include_once '../../config/api.php';

if(isset($_SESSION['user_session'])){
    $admin_id = $_SESSION['admin_id'];
}else{
    $admin_id = false;
}

$config = new Admin();

if($_GET['type'] == 'delArtikel'){
    $a  = $_POST['data'];

    $sql = "DELETE FROM tb_artikel WHERE id_artikel = :id";
    $stmt = $config->runQuery($sql);
    $stmt->execute(array(':id'  => $a));

    if($stmt){
        echo 'Berhasil Delete Artikel!';
    }else{
        echo 'Failed!';
    }
}

if(isset($_POST['saveArtikel'])){

   // $id = $_POST['txtID'];

    $a = $_POST['txtJudul'];
    $b = $_POST['txtKategori'];
    $c = $_POST['kategoriArtikel'];
    $d = $_POST['isiArtikel'];
    $e = $config->getDate('Y-m-d H:m:s');
    $img = $_FILES['txtImages'];
    $file_name = stripslashes($_FILES['txtImages']['tmp_name']);
    $images_name = $_FILES['txtImages']['tmp_name'];


//        echo "<script>
//                        alert('Berhasil ditambahkan!');
//                        window.location.href='../../index.php?p=article';
//                    </script>";
        //    $errors= array();

    $file_size = $_FILES['txtImages']['size'];
    $name = $_FILES['txtImages']['name'];
        $file_tmp = $_FILES['txtImages']['tmp_name'];
        $file_type = $_FILES['txtImages']['type'];
    //    $file_ext=strtolower(end(explode('.',$_FILES['txtImages']['name'])));
        $file_ext = explode('.',$name);


        $expensions= array("jpeg","jpg","png");

        if(in_array($file_ext[1],$expensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }

        if($file_size > 2097152) {
            $errors[]='File size must be excately 2 MB';
        }

        if(empty($errors)==true) {
            $target_url = 'http://db.sinergiadhikarya.co.id/artikel/artikel.php';
            $file_name_with_full_path = realpath($_FILES['txtImages']['tmp_name']);
            /* curl will accept an array here too.
             * Many examples I found showed a url-encoded string instead.
             * Take note that the 'key' in the array will be the key that shows up in the
             * $_FILES array of the accept script
             */
//            $post = array('extra_info' => $images_name,'file_contents'=>'@'.$file_name_with_full_path);
            $post = array('file_contents' => new CurlFile($file_name_with_full_path, 'image/jpeg' /* MIME-Type */,'' /*directory*/));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$target_url);
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            $result=curl_exec ($ch);
            curl_close ($ch);
//            echo $result;
            echo '<pre>';
            print_r($_FILES['txtImages']);
            echo '</pre>';
            $exp = explode('php', $file_name_with_full_path);
           $exp_file = 'php'.$exp[1];


//            move_uploaded_file($file_tmp,"http://db.sinergiadhikarya.co.id/artikel/".$file_name);
//            $img = substr(explode(";",$img)[1], 7);
//            file_put_contents($file_name, base64_decode($img));
            echo "Success";
            $sql = "INSERT INTO tb_artikel (nama_artikel, slug, isi_artikel, images_artikel, id_kategori, active_artikel, create_artikel, nama_user) VALUES (:a, :b, :c, :y, :d, :e, :g, :f)";
            $stmt = $config->runQuery($sql);
            $stmt->execute(array(
                ':a'    => $a,
                ':b'    => $c,
                ':c'    => $d,
                ':y'    => $exp_file,
                ':d'    => $b,
                ':e'    => 'active',
                ':g'    => $e,
                ':f'    => $admin_id
            ));
            if($stmt){
                echo "<script>
                        alert('Berhasil ditambahkan!');
                        window.location.href='../../index.php?p=article';
               </script>";
            }
        }else{
            print_r($errors);
        }

}