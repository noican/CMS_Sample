<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	logged_in();
	$current_subject = find_subject_by_id($_GET["subject"]);
	
	if (!$current_subject) {
		redirect_to("manage_content.php");
	} else {
		
		$id = $current_subject["id"];
		
		$pages_set = find_page_per_subject($current_subject["id"]);
		if (mysqli_num_rows($pages_set) > 0 ) {
			$_SESSION["message"] = "Can't delete a subject with existing page/s.";
			redirect_to("manage_content.php?subject={$current_subject["id"]}");
		} else {
		
		
			$delete_query  = "DELETE FROM subjects ";
			$delete_query .= "WHERE id = {$id} ";
			$delete_query .= "LIMIT 1";
			
			$result = mysqli_query($connection,$delete_query);
			
			if($result && mysqli_affected_rows($connection) == 1) {
				$_SESSION["message"] = "Subject deletion success.";
				redirect_to("manage_content.php"); 
			} else {
				$_SESSION["message"] = "Subject deletion failed.";
				redirect_to("manage_content.php?subject={$id}"); 
			}
			
		}//if (mysqli_num_rows($pages_set) > 0 ) {
		
		
	} //if (!$current_subject) {
	
?>