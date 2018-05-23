<?php

require_once('db.php');

class Login
{

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	//execute your login
	public function runLogin($username,$password)
		{
			try
			{
				$stmt = $this->conn->prepare("SELECT * FROM tb_admin WHERE username=:uname");
				$stmt->execute(array(':uname'=>$username));
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
				if($stmt->rowCount() == 1)
				{
					if(password_verify($password, $userRow['password']))
					{
						if($userRow['status'] == '1'){
                            $_SESSION['user_session'] = $userRow['username'];
							
							$log = $this->conn->prepare("INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id)
							VALUES (:a, :b, :c, :d, :e)");
							$log->execute(array(
								':a'	=> $userRow['id'],
								':b'	=> '2',
								':c'	=> 'tb_admin',
								':d'	=> 'login',
								':e'	=> $userRow['id']
							));
                            return true;
                        }else{

						    $_SESSION['error'] = "Sorry, Your Acount are ready Disable!";
						    return false;

                        }
					}
					else
					{
                        $_SESSION['error'] = "Trying to find somewhere";
						return false;
					}
				}
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
	//session data
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	//link for session is true
	public function redirect($url)
	{
		header("Location: $url");
	}
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	//link logout
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}
}

class Admin
{

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	// execute every query with pdo statement
	// $query = "YOUR QUERY";
	// $variable = $stmt->execute() or $Varname = $stmt->bindParam()
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function Products($field, $table)
    {
        $stmt = $this->conn->prepare('SELECT '. $field .' FROM '. $table);
        $stmt->execute();
        return $stmt;
    }
	public function lastInsertID()
	{
		return $this->conn->lastInsertId();
	}
	public function adminID()
	{
		$id = $_SESSION['user_session'];
		$stmt = $this->conn->prepare("SELECT id, username, nama_admin, id_role, picture, status FROM tb_admin WHERE username=:user_id");
		$stmt->execute(array(':user_id' => $id));

		$rowAdmin=$stmt->fetch(PDO::FETCH_LAZY);

		return $rowAdmin;

	}
	public function CountQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt;
	}
	public function paging($query,$records_per_page)

	 {

	  $starting_position=0;
	  if(isset($_GET["page_no"]))
	  {
	   $starting_position=($_GET["page_no"]-1)*$records_per_page;
	  }
	  $query2=$query." limit $starting_position,$records_per_page";
	  return $query2;
	 }

	 public function paginglink($query, $records_per_page)

	 {

	  //$self = $_SERVER['PHP_SELF'];
	 	//$self = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	 	$self = "$_SERVER[REQUEST_URI]";
        $self = explode('&', $self);
        $self = $self['0'];

	  $stmt = $this->conn->prepare($query);
	  $stmt->execute();

	  $total_no_of_records = $stmt->rowCount();

	  if($total_no_of_records > 0)
	  {
	   ?><ul class="pagination"><?php
	   $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
	   $current_page=1;
	   if(isset($_GET["page_no"]))
	   {
	    $current_page=$_GET["page_no"];
	   }
	   if($current_page!=1)
	   {
	    $previous =$current_page-1;
	    echo "<li><a href='".$self."&page_no=1'>First</a></li>";
	    echo "<li><a href='".$self."&page_no=".$previous."'>Previous</a></li>";
	   }
	   for($i=1;$i<=$total_no_of_pages;$i++)
	   {
	    if($i==$current_page)
	    {
	     echo "<li class='paginate_button active'><a href='".$self."&page_no=".$i."';'>".$i."</a></li>";
	    }
	    else
	    {
	     echo "<li><a href='".$self."&page_no=".$i."'>".$i."</a></li>";
	    }
	   }
	   if($current_page!=$total_no_of_pages)
	   {
	    $next=$current_page+1;
	    echo "<li><a href='".$self."&page_no=".$next."'>Next</a></li>";
	    echo "<li><a href='".$self."&page_no=".$total_no_of_pages."'>Last</a></li>";
	   }
	   ?></ul><?php
	  }
	 }

	 public function paginglinkURL($query, $url, $records_per_page)

	 {

	  //$self = $_SERVER['PHP_SELF'];
	 	//$self = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	 	$self = "$_SERVER[REQUEST_URI]";
        $self = explode('&', $self);
        $self = $self['0'];

	  $stmt = $this->conn->prepare($query);
	  $stmt->execute();

	  $total_no_of_records = $stmt->rowCount();

	  if($total_no_of_records > 0)
	  {
	   ?><ul class="pagination"><?php
	   $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
	   $current_page=1;
	   if(isset($_GET["page_no"]))
	   {
	    $current_page=$_GET["page_no"];
	   }
	   if($current_page!=1)
	   {
	    $previous =$current_page-1;
	    echo "<li><a href='".$self."&".$url."page_no=1'>First</a></li>";
	    echo "<li><a href='".$self."&".$url."page_no=".$previous."'>Previous</a></li>";
	   }
	   for($i=1;$i<=$total_no_of_pages;$i++)
	   {
	    if($i==$current_page)
	    {
	     echo "<li class='paginate_button active'><a href='".$self."&".$url."page_no=".$i."';'>".$i."</a></li>";
	    }
	    else
	    {
	     echo "<li><a href='".$self."&".$url."page_no=".$i."'>".$i."</a></li>";
	    }
	   }
	   if($current_page!=$total_no_of_pages)
	   {
	    $next=$current_page+1;
	    echo "<li><a href='".$self."&".$url."page_no=".$next."'>Next</a></li>";
	    echo "<li><a href='".$self."&".$url."page_no=".$total_no_of_pages."'>Last</a></li>";
	   }
	   ?></ul><?php
	  }
	 }

    public function paginglinkURLJquery($query, $url, $records_per_page)

    {

        //$self = $_SERVER['PHP_SELF'];
        //$self = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $self = "$_SERVER[REQUEST_URI]";
        $self = explode('&', $self);
        $self = $self['0'];

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $total_no_of_records = $stmt->rowCount();

        if($total_no_of_records > 0)
        {
            ?><ul class="pagination"><?php
            $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
            $current_page=1;
            if(isset($_GET["page_no"]))
            {
                $current_page=$_GET["page_no"];
            }
            if($current_page!=1)
            {
                $previous =$current_page-1;
                echo "<li><a href='".$url."page_no=1'>First</a></li>";
                echo "<li><a href='".$url."page_no=".$previous."'>Previous</a></li>";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
                if($i==$current_page)
                {
                    echo "<li class='paginate_button active'><a href='".$url."page_no=".$i."';'>".$i."</a></li>";
                }
                else
                {
                    echo "<li><a href='".$url."page_no=".$i."'>".$i."</a></li>";
                }
            }
            if($current_page!=$total_no_of_pages)
            {
                $next=$current_page+1;
                echo "<li><a href='".$url."page_no=".$next."'>Next</a></li>";
                echo "<li><a href='".$url."page_no=".$total_no_of_pages."'>Last</a></li>";
            }
            ?></ul><?php
        }
    }

	 //for generate autonumber
	//$id for field name
	//$kode for initianl
	//tbName for name of table you got select
	public function Generate($id, $kode, $tbName)
	{

		$sql = "SELECT MAX(RIGHT(". $id . ", 4)) AS max_id FROM " . $tbName . " ORDER BY ". $id . "";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_LAZY);
		$id = $row['max_id'];
		$sort_num = (int) substr($id, 1, 6);
  		$sort_num++;
  		$new_code = sprintf("$kode%04s", $sort_num);

  		return $new_code;
	}
	public function getDate($format)
    {
        date_default_timezone_set("Asia/Jakarta");

        $tanggal = date($format);

        return $tanggal;
    }

    public function getTime($format)
    {
        date_default_timezone_set("Asia/Jakarta");

        $waktu = date($format);

        return $waktu;
    }

	// public function getID($new_kode, $subject, $admin, $kepada, $isi)
	// {
	// 	$sql = "INSERT INTO tb_push (kd_push, subject, dari, kepada) VALUES (:kd, :subject, :dari, :kepada)";
	// 	$stmt = $this->conn->prepare($sql);
	// 	$stmt->execute(array(
	//       ':kd'   => $new_kode,
	//       ':subject' => $subject,
	//       ':dari' => $admin,
	//       ':kepada' => $kepada));

	// 	if (!$stmt) {
	// 		# code...
	// 		$pesan = "Data tidak masuk ke DB";
	// 		return $pesan;
	// 	} else{
	// 		$id = $this->conn->lastInsertId();

	// 		$pesan = "Data masuk";
	// 		return $pesan;
	// 	}

	// }
    function generateRandomString($length = 10)
    {

        return substr(str_shuffle(str_repeat($x='!@#$%^&*()0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    function newPassword($pass){
        $password = password_hash($pass, PASSWORD_DEFAULT);

        return $password;
    }

}
class Perusahaan
{
	private $conn;

	public function __construct()
	{
		$data= new Database();
		$db= $data->dbConnection();
		$this->conn = $db;
	}
	// execute every query with pdo statement,
	// $query = "YOUR QUERY";
	// $variable = $stmt->execute() or $Varname = $stmt->bindParam()
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	//for generate autonumber
	//$id for field name
	//$kode for initianl
	//tbName for name of table you got select
	public function Generate($id, $kode, $tbName)
	{

		$sql = "SELECT MAX(RIGHT(". $id . ", 4)) AS max_id FROM " . $tbName . " ORDER BY ". $id . "";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_LAZY);
		$id = $row['max_id'];
		$sort_num = (int) substr($id, 1, 6);
  		$sort_num++;
  		$new_code = sprintf("$kode%04s", $sort_num);

  		return $new_code;
	}
}
class Karyawan
{

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	// execute every query with pdo statement,
	// $query = "YOUR QUERY";
	// $variable = $stmt->execute() or $Varname = $stmt->bindParam()
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	public function addTest($kodeTest, $ktp, $kdAdmin, $tanggalTest)
	{
		$stmt = $this->conn->prepare("
			INSERT INTO tb_info_test (kode_test, no_ktp, date_test, kode_admin) VALUES (:kode, :no_ktp, :tanggal, :admin)");
		$stmt->bindParam(':kode', $kodeTest);
		$stmt->bindParam(':no_ktp', $ktp);
		$stmt->bindParam(':tanggal', $tanggalTest);
		$stmt->bindParam(':admin', $kdAdmin);

		$stmt->execute();

		return $stmt;

	}
	//for generate autonumber
	//$id for field name
	//$kode for initianl
	//tbName for name of table you got select
	public function Generate($id, $kode, $tbName)
	{

		$sql = "SELECT MAX(RIGHT(". $id . ", 4)) AS max_id FROM " . $tbName . " ORDER BY ". $id . "";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_LAZY);
		$id = $row['max_id'];
		$sort_num = (int) substr($id, 1, 6);
  		$sort_num++;
  		$new_code = sprintf("$kode%04s", $sort_num);

  		return $new_code;
	}

}


?>
