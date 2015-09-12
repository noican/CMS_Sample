<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/validations_functions.php");
	logged_in();
	find_selected_page();
	
	if (!$current_subject) {
		redirect_to("manage_content.php");
	}
	
	include("../../includes/layouts/page_header.php");
	
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
	
	if (empty($errors)) {
			
		$id = $current_subject["id"];
		$update_query = "UPDATE subjects SET ";
		$update_query .= "subject_name = '{$menu_name}', ";
		$update_query .= "position = '{$position}', ";
		$update_query .= "visible = '{$visible}' ";
		$update_query .= "WHERE id = {$id} " ;
		$update_query .= "LIMIT 1";
		
		$result = mysqli_query($connection,$update_query);
		
		if($result && mysqli_affected_rows($connection) == 1) {
			$_SESSION["message"] = "Subject edit success.";
			redirect_to("manage_content.php?subject={$id}"); 
		} else {
			$_SESSION["message"] = "Subject creation failed.";
			redirect_to("manage_content.php?subject={$id}"); 
		}
		
	}//if (empty($errors))

} //if (isset($_POST['submit'])) 

?>

<div id="main">
	<div id="navigation">
		<br />
		<a href="admin.php">&laquo Admin Menu</a>
		<br />
		<?php echo navigation($current_subject,$current_page); ?>
	</div>
	<div id="page">
		<?php
			if (!empty($errors)) {
				echo form_errors($errors);
			}
		?>
	
		<h2>Edit Subject : <?php echo $current_subject["subject_name"];?> </h2>
		<form action="edit_subject.php?subject=<?php echo $current_subject["id"];?>" method="post">
			<table border=1>
				<tr>
					<td>Menu Name : </td>
					<td><input type = "text" size = 60 name = "menu_name" value = "<?php echo $current_subject["subject_name"]; ?>" /></td>
				</tr>
				<tr>
					<td>Position : </td>
					<td><select name = "position">
						<?php
							$subject_set = find_all_subjects();
							$subject_count = mysqli_num_rows($subject_set);
							for ($count=1; $count <= $subject_count; $count++) {
								echo "<option value = \"{$count}\"";
								if ($current_subject["position"] == $count) {
									echo " selected";
								}
								echo ">{$count}</option>";
							}
						?>
							
						</select>
					</td>
				</tr>
				<tr>
					<td>Visible : </td>
					<td><input type = "radio" name = "visible" value="1" <?php if ($current_subject["visible"] == 1) { echo " checked=\"checked\" "; } ?> /> Yes
						<input type = "radio" name = "visible" value="0" <?php if ($current_subject["visible"] == 0) { echo " checked=\"checked\" "; } ?> /> No
					</td>
				</tr>
				<tr>
					<td colspan = "2" style="text-align:center;">
						<input type = "submit" name = "submit" value = "Update" />
						<input type = "reset" value = "Clear" />
						<a class="normal" href="manage_content.php"><button type="button">Cancel</a>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php include("../../includes/layouts/page_footer.php");?>