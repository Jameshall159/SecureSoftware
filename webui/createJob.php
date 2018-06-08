<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	if(isset($_POST['btn-upload']))
{
	

   $jobName = trim($_POST['txtjobName']);
		$user_id = $_SESSION['user_session'];
		$DestinationID = $_POST['destination_id'];
	


    if($auth_user->createJob($jobName,$user_id,$DestinationID))
    {
      $auth_user->redirect('home.php');

    }
    else{
     echo "sorry , Query could not execute...";

   }
   }
   




?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css"  />


<title>Welcome - <?php print($userRow['user_name']); ?></title>


</head>

<body style="background-color:#f2dddc;">



<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="font-family:Calibri";>File System - Create Job</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo $userRow['user_name']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="home.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Home</a></li>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <div class="clearfix"></div>
    	
    
<div class="container-fluid" style="margin-top:80px;">
	
    <div class="container">




        <body id="login">
          <div class="form-group">
          <?php if(isset($msg)) echo $msg;  ?>
            <form class="form-signin" method="post" enctype="multipart/form-data">
            
              <input type="jobName" class="form-control"  pattern="^((?!<)(?!>).)*$" style="border-radius:10px; width:100%; padding:10px; margin-bottom:10px;" placeholder="Job Desc" name="txtjobName" required /></textarea>

			  				  Select a Destination to send this file to:
				  <select name="destination_id" required>
				   <?php

         $database = new Database();
         $db = $database->dbConnection();
         $conn = $db;


         $stmt =  $db->prepare("SELECT * FROM destinations" );
         $stmt->execute(array());
         while($row=$stmt->fetch(PDO::FETCH_BOTH))
         {
             echo "<option value='".$row['DestinationID']."'>'".$row['DestinationName']."'</option>";
         }
         ?>
	</select> <br> <br>

              <button class="btn btn-info" style="border-radius:10px" type="submit" name="btn-upload"><i class="fa fa-upload"></i> Create</button>
			  
			  
			  
            </form>
</div>

    
    </div>

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>