<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/validations_functions.php");
	include("../../includes/layouts/page_header.php");
	logged_in();
	
	if (isset($_GET["userid"])) {
		$current_user = find_user_by_id($_GET["userid"]);
	} else {
		$current_user = null;
	}
	

	if (!$current_user["id"]) {
		redirect_to("manage_users.php");
	} 
	
?>

<?php

	if (isset($_POST['submit'])) {
		
		$username = mysqli_prep($_POST["username"]);
		$password = password_encrypt($_POST["password"]);
		
		$required_fields = array("username","password");
		validate_presences($required_fields);
		
		$field_with_max_lengths = array("username" => 60);
		validate_max_lengths($field_with_max_lengths);	
		
		if (empty($errors)) {
			
			$id = $current_user["id"];
			
			$update_query = "UPDATE users SET ";
			$update_query .= "username = '{$username}', ";
			$update_query .= "hashed_password = '{$password}' ";
			$update_query .= "WHERE id = {$id} " ;
			$update_query .= "LIMIT 1";
			
			$result = mysqli_query($connection,$update_query);
			
			if($result && mysqli_affected_rows($connection) == 1) {
				$_SESSION["message"] = "User edit success.";
				redirect_to("manage_users.php"); 
			} else {
				$_SESSION["message"] = "User edit failed.";
				redirect_to("manage_users.php"); 
			}
		
		}//if (empty($errors))
		
		
	}

?>

<div id="main">
	<div id="navigation">
		<br />
		<a href="admin.php">&laquo Admin Menu</a>
		<br />
	</div>
	<div id="page">	
		<?php
			echo message();
			if (!empty($errors)) {
				echo form_errors($errors);
			}
			
		?>
		<br />
		<form action="" method="post">
			<table border=1>
				<tr><td colspan=2 align = center>Add New User :</td></tr>
				<tr><td align = left>Username :</td><td><input type=text width=80 name="username" value="<?php echo $current_user["username"]; ?>"/></td></tr>
				<tr><td align = left>Password :</td><td><input type=password width=80 name="password"  value="<?php echo $current_user["hashed_password"]; ?>"/></td></tr>
				<tr><td colspan=2 align = center><input type = "submit" name = "submit" value = "Edit" />
				<a class="normal" href="manage_users.php"><button type="button">Cancel</a></td></tr>
			</table>
		</form>
			
	</div>
</div>
<?php include("../../includes/layouts/page_footer.php");?>