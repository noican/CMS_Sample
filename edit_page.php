<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/validations_functions.php");
	include("../../includes/layouts/page_header.php");
	logged_in();
	find_selected_page();
	
	if (!$current_page["id"]) {
		redirect_to("manage_content.php");
	} 
?>


<?php
if (isset($_POST['submit'])) {
	
	$subject_id_to_edit = (int) $_POST["subject_id"];
	$page_name = mysqli_prep($_POST["page_name"]);
	$position = (int) $_POST["position"];
	$visible = (int) $_POST["visible"];
	$content = mysqli_prep($_POST["content"]);
	
	$required_fields = array("page_name","position","visible","content");
	validate_presences($required_fields);
	
	$field_with_max_lengths = array("page_name" => 60);
	validate_max_lengths($field_with_max_lengths);	
	
	
	if (empty($errors)) {
			
		$id = $current_page["id"];
		$update_query = "UPDATE pages SET ";
		$update_query .= "subject_id = {$subject_id_to_edit}, ";
		$update_query .= "page_name = '{$page_name}', ";
		$update_query .= "position = {$position}, ";
		$update_query .= "content = '{$content}', ";
		$update_query .= "visible = {$visible} ";
		$update_query .= "WHERE id = {$id} " ;
		$update_query .= "LIMIT 1";
		
		$result = mysqli_query($connection,$update_query);
		
		if($result && mysqli_affected_rows($connection) == 1) {
			$_SESSION["message"] = "Subject edit success.";
			redirect_to("manage_content.php?page={$id}"); 
		} else {
			$_SESSION["message"] = "Subject creation failed.";
			redirect_to("manage_content.php?page={$id}"); 
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
	
		<h2>Edit Page : <?php echo $current_page["page_name"];?> </h2>
		<form action="edit_page.php?page=<?php echo $current_page["id"];?>" method="post">
			<input type="hidden" name ="subject_id" value = "<?php echo $current_page["subject_id"]; ?>"></input>
			<table border=1>
				<tr>
					<td>Page Name : </td>
					<td><input type = "text" name = "page_name" size = 60 value = "<?php echo ucfirst($current_page["page_name"]); ?>" /></td>
				</tr>
				<tr>
					<td>Position : </td>
					<td><select name = "position">
						<?php
							$page_set = find_page_per_subject($current_page["subject_id"]);
							$page_count = mysqli_num_rows($page_set);
							for ($count=1; $count <= $page_count; $count++) {
								echo "<option value = \"{$count}\"";
								if ($current_page["position"] == $count) {
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
					<td><input type = "radio" name = "visible" value="1" <?php if ($current_page["visible"] == 1) { echo " checked=\"checked\" "; } ?> /> Yes
						<input type = "radio" name = "visible" value="0" <?php if ($current_page["visible"] == 0) { echo " checked=\"checked\" "; } ?> /> No
					</td>
				</tr>
				<tr>
					<td style="vertical-align:top">Content :</td>
					<td><textarea rows="15" cols="125" name="content"><?php 
						echo $current_page["content"];
					?></textarea></td>
				</tr>
				<tr>
					<td colspan = "2" style="text-align:center;">
						<input type = "submit" name = "submit" value = "Update" />
						<a class="normal" href="manage_content.php?page=<?php echo $current_page["id"];?>"><button type="button">Cancel</a>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php include("../../includes/layouts/page_footer.php");?>