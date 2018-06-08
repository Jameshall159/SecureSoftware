<?php
 
//Start our session.
session_start();
 
//Expire the session if user is inactive for 30
//minutes or more.
$expireAfter = 5;
 
//Check to see if our "last action" session
//variable has been set.
if(isset($_SESSION['last_action'])){
    
    //Figure out how many seconds have passed
    //since the user was last active.
    $secondsInactive = time() - $_SESSION['last_action'];
    
    //Convert our minutes into seconds.
    $expireAfterSeconds = $expireAfter * 60;
    
    //Check to see if they have been inactive for too long.
    if($secondsInactive >= $expireAfterSeconds){
	$old_sessid = session_id();
		session_regenerate_id();
		$new_sessid = session_id();
		session_id($old_sessid);;
			session_unset();
			session_destroy();
		
    }
}
 
//Assign the current timestamp as the user's
//latest activity
$_SESSION['last_action'] = time();

	
	require_once 'class.user.php';
	$session = new USER();
	
	// if user session is not active(not loggedin) this page will help 'home.php and profile.php' to redirect to login page
	// put this file within secured pages that users (users can't access without login)
	
	if(!$session->is_loggedin())
	{
		// session no set redirects to login page
		$session->redirect('index.php');
	}
	