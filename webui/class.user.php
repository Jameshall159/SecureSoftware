<?php

require_once('dbconfig.php');

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function register($uname,$umail,$upass)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			
			$stmt = $this->conn->prepare("INSERT INTO users(user_name,user_email,user_pass) 
		                                               VALUES(:uname, :umail, :upass)");
												  
			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":umail", $umail);
			$stmt->bindparam(":upass", $new_password);										  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}

	
	public function doLogin($uname,$umail,$upass)
	{
		$ip = $_SERVER["REMOTE_ADDR"];
				$stmt = $this->conn->prepare("INSERT INTO ip(address)
				VALUES(:ip)");
				$stmt->bindparam(":ip", $ip);
				$stmt->execute();
				$stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM ip WHERE address LIKE '$ip' AND timestamp > (now() - interval 1 minute)");
			 	$stmt->execute();
				$attemptCount=$stmt->fetch(PDO::FETCH_ASSOC);
				$userRow = $attemptCount['count'];

				echo $userRow;

				if($userRow == 4){
				  header('location: '.'fail.php');
				} else{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_id, user_name, user_email, user_pass FROM users WHERE user_name=:uname OR user_email=:umail ");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($upass, $userRow['user_pass']))
				{
					$_SESSION['user_session'] = $userRow['user_id'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	
		
	public function can_loggedin()
	{
		$ip = $_SERVER["REMOTE_ADDR"];
		$stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM ip WHERE address LIKE '$ip' AND timestamp > (now() - interval 1 minute)");
		$stmt->execute();
		$attemptCount=$stmt->fetch(PDO::FETCH_ASSOC);
		$userRow = $attemptCount['count'];

		if($userRow == 4)
		{
			return true;
		}
	}
	
	public function upload_doc($docTitle,$docDesc,$file,$file_type,$new_size,$jobID){
   try
   {
	   
     $stmt = $this->conn->prepare("INSERT INTO tbl_upload(docTitle,docDesc,docFile,docType,docSize,jobID)
                                                  VALUES(:document_title, :document_desctiption, :doc_file, :doc_Type, :doc_Size, :job_id)");

     $stmt->bindparam(":document_title",$docTitle);
     $stmt->bindparam(":document_desctiption",$docDesc);
     $stmt->bindparam("doc_file",$file);
     $stmt->bindparam("doc_Type",$file_type);
     $stmt->bindparam("doc_Size",$new_size);
	 $stmt->bindparam("job_id",$jobID);
     $stmt->execute();
     return $stmt;
	 

   }
   catch(PDOException $ex)
   {
    echo $ex->getMessage();
   }

 }
 
 	public function createJob($jobName,$user_id,$DestinationID){
   try
   {
	   
     $stmt = $this->conn->prepare("INSERT INTO tbl_job(jobName,user_id,DestinationID)
                                                  VALUES(:job_name, :user_job, :destination)");

     $stmt->bindparam(":job_name",$jobName);
     $stmt->bindparam(":user_job",$user_id);
     $stmt->bindparam(":destination",$DestinationID);	 
     $stmt->execute();
     return $stmt;
	 

   }
   catch(PDOException $ex)
   {
    echo $ex->getMessage();
   }

 }
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function doLogout()
	{
		$old_sessid = session_id();
		session_regenerate_id();
		$new_sessid = session_id();
		session_id($old_sessid);
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}
}
?>