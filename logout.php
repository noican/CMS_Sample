<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/functions.php");
	
	/*Simple logout 
	$_SESSION["user_id"] = null;
	$_SESSION["username"] = null;*/
	
	
	session_start();
	$_SESSION = array();
	
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(),'',time()-50000,'/');
	}
	
	session_destroy();
	redirect_to("login.php");
	

	
	
?>