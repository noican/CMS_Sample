<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/validations_functions.php");
	logged_in();
?>


<?php
if (isset($_POST['submit'])) {
	
	$menu_name = mysqli_prep($_POST["menu_name"]);
	$position = (int) $_POST["position"];
	$visible = (int) $_POST["visible"];
	
	$required_fields = array("menu_name","position","visible");
	validate_presences($required_fields);
	
	$field_with_max_lengths = array("menu_name" => 60);
	validate_max_lengths($field_with_max_lengths);
	
	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_subject.php");
	}
	
	$exist_subject_name = find_subject_by_name($menu_name);
	
	if (mysqli_num_rows($exist_subject_name) > 0 ) {
		$_SESSION["message"] = "Can't create a similar subject name.";
		redirect_to("manage_content.php");
	} 
	
	$ins_query = "INSERT INTO subjects (";
	$ins_query .= "subject_name, position, visible";
	$ins_query .= ") VALUES (";
	$ins_query .= "'{$menu_name}',{$position},{$visible}";
	$ins_query .= ");";
	
	$result = mysqli_query($connection,$ins_query);
	
	if($result) {
		$_SESSION["message"] = "Subject creation success.";
		redirect_to("manage_content.php?subject=".$connection->insert_id); 
	} else {
		$_SESSION["message"] = "Subject creation failed.";
		redirect_to("new_subject.php"); 
	}
	
} else {
	redirect_to("new_subject.php");
}
?>


<?php /* close connection */ if (isset($connection)) {mysqli_close($connection);} ?>