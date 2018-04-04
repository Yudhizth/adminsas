<?php
		$pages_dir = 'php';
		if(!empty($_GET['p'])){
			$pages = scandir($pages_dir, 0);
			unset($pages[0], $pages[1]);
 
			$p = $_GET['p'];
			if($p == $footer){
				$admin_id = $config->adminID();
				$admin_id = $admin_id['id'];

				$log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
				$log = $config->runQuery($log);
				$log->execute(array(
					':a'    => $footer,
					':b'    => '2',
					':c'    => 'unset',
					':d'    => 'akses halaman',
					':e'    =>  $admin_id
				));
			// echo $footer;
			}
			if(in_array($p.'.php', $pages)){
				include($pages_dir.'/'.$p.'.php');
			} else {
				include($pages_dir.'/404.php');
			}
		} else {
			include($pages_dir.'/default.php');
		}
		?>