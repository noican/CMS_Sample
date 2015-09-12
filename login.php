<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/validations_functions.php");
	include("../../includes/layouts/page_header.php");
	
?>

<?php
	$username = "";

	if (isset($_POST['submit'])) {
		
		$username = mysqli_prep($_POST["username"]);
		$input_password = $_POST["password"];
				
		$required_fields = array("username","password");
		validate_presences($required_fields);
		
		if (empty($errors)) {
			
			$found_admin = attempt_login($username, $input_password);
			
			if($found_admin) {
				$_SESSION['userid'] = $found_admin['id'];
				$_SESSION['username'] = $found_admin['username'];
				
				redirect_to("/cms/admin.php"); 
			} else {
				$_SESSION["message"] = "Login Failed.";
				redirect_to("/cms/login.php"); 
			}
		
		}//if (empty($errors))
		
		
	}

?>

<div id="main">
	<div id="navigation">
		&nbsp
		
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
				<tr><td colspan=2 align = center>Login</td></tr>
				<tr><td align = left>Username :</td><td><input type=text width=80 name="username" value = "<?php echo htmlentities($username); ?>"/></td></tr>
				<tr><td align = left>Password :</td><td><input type=password width=80 name="password" /></td></tr>
				<tr><td colspan=2 align = center><input type = "submit" name = "submit" value = "Login" />
			</table>
		</form>
			
	</div>
</div>
<?php include("../../includes/layouts/page_footer.php");?>