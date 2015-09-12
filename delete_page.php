<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	logged_in();
	$current_page = find_page_by_id($_GET["page"]);
	
	if (!$current_page) {
		redirect_to("manage_content.php");
	} else {
		
		$id = $current_page["id"];
		
	
		$delete_query  = "DELETE FROM pages ";
		$delete_query .= "WHERE id = {$id} ";
		$delete_query .= "LIMIT 1";
		
		$result = mysqli_query($connection,$delete_query);
		
		if($result && mysqli_affected_rows($connection) == 1) {
			$_SESSION["message"] = "Subject deletion success.";
			redirect_to("manage_content.php"); 
		} else {
			$_SESSION["message"] = "Subject deletion failed.";
			redirect_to("manage_content.php?page={$id}"); 
		}
		
			
		
	} //if (!$current_subject) {
	
?>