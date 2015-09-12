<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	logged_in();
	$current_user = find_user_by_id($_GET["userid"]);
	
	if (!$current_user) {
		redirect_to("manage_users.php");
	} else {
		
		$id = $current_user["id"];
		
	
		$delete_query  = "DELETE FROM users ";
		$delete_query .= "WHERE id = {$id} ";
		$delete_query .= "LIMIT 1";
		
		$result = mysqli_query($connection,$delete_query);
		
		if($result && mysqli_affected_rows($connection) == 1) {
			$_SESSION["message"] = "User deletion success.";
		} else {
			$_SESSION["message"] = "User deletion failed.";
		}
		
		redirect_to("manage_users.php"); 
		
	} //if (!$current_subject) {
	
?>