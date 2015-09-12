<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/validations_functions.php");
	include("../../includes/layouts/page_header.php");
	logged_in();
?>

<?php

	if (isset($_POST['submit'])) {
		
		$username = mysqli_prep($_POST["username"]);
		$password = password_encrypt($_POST["password"]);
				
		$required_fields = array("username","password");
		validate_presences($required_fields);
		
		$field_with_max_lengths = array("username" => 60);
		validate_max_lengths($field_with_max_lengths);	
		
		if (find_user_by_username($username)) {
			$_SESSION["message"] = "Username already taken!!!";
			redirect_to("manage_users.php");
		}
		
		if (empty($errors)) {
			
			$ins_query = "INSERT INTO users (";
			$ins_query .= "username, hashed_password";
			$ins_query .= ") VALUES (";
			$ins_query .= "'{$username}','{$password}'";
			$ins_query .= ");";
		
		
		
			$result = mysqli_query($connection,$ins_query);
			
			if($result && mysqli_affected_rows($connection) == 1) {
				$_SESSION["message"] = "User creation success.";
				redirect_to("manage_users.php"); 
			} else {
				$_SESSION["message"] = "User creation failed.";
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
				<tr><td align = left>Username :</td><td><input type=text width=80 name="username"/></td></tr>
				<tr><td align = left>Password :</td><td><input type=password width=80 name="password" /></td></tr>
				<tr><td colspan=2 align = center><input type = "submit" name = "submit" value = "Create" />
				<a class="normal" href="manage_users.php"><button type="button">Cancel</a></td></tr>
			</table>
		</form>
			
	</div>
</div>
<?php include("../includes/layouts/page_footer.php");?>