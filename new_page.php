<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/validations_functions.php");
	include("../../includes/layouts/page_header.php");
	logged_in();
	find_selected_page();
	
	if (!$current_subject) {
		redirect_to("manage_content.php");
	} else {
		$subject_id = $current_subject["id"];
	}
	
?>

<?php
if (isset($_POST['submit'])) {
	
	$subject_id = (int) $_POST["subject_id"];
	$page_name = mysqli_prep($_POST["page_name"]);
	$position = (int) $_POST["position"];
	$visible = (int) $_POST["visible"];
	$content =  mysqli_prep($_POST["content"]);
	
	$required_fields = array("page_name","position","visible","content");
	validate_presences($required_fields);
	
	$field_with_max_lengths = array("page_name" => 60);
	validate_max_lengths($field_with_max_lengths);
	
	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		$_SESSION["content"] = $content;
		redirect_to("new_page.php?subject=".$subject_id);
	} 
	
	$ins_query = "INSERT INTO pages (";
	$ins_query .= "subject_id, page_name, position, visible, content";
	$ins_query .= ") VALUES (";
	$ins_query .= "{$subject_id},'{$page_name}',{$position},{$visible},'{$content}'";
	$ins_query .= ");";
	
	$result = mysqli_query($connection,$ins_query);
	
	if($result) {
		$_SESSION["message"] = "Page creation success.";
		redirect_to("manage_content.php?page=".$connection->insert_id); 
	} else {
		$_SESSION["message"] = "Page creation failed.".$ins_query;
		redirect_to("new_page.php?subject=".$subject_id); 
	}

} else {



	
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
			echo message();
			$errors = errors();
			echo form_errors($errors);
		?>
		<h2>Create Page</h2>
		<form action="new_page.php?subject=<?php echo $subject_id; ?>" method="post">
			<table width=100% border=1>
				<tr>
					<td>Subject Name : </td><td><?php echo $current_subject["subject_name"]; ?>
					<input type="hidden" size = 60 name="subject_id" value = "<?php echo $subject_id; ?>"></input></td>
					
				</tr>
				<tr>
					<td>Page Name : </td>
					<td><input type = "text" size = 60 name = "page_name" value = "" /></td>
				</tr>
				<tr>
					<td>Position : </td>
					<td><select name = "position">
						<?php
							$page_set = find_page_per_subject($subject_id);
							$page_count = mysqli_num_rows($page_set);
							for ($count=1; $count <= $page_count + 1; $count++) {
								echo "<option value = \"{$count}\" selected>{$count}</option>";
							}
						?>
							
						</select>
					</td>
				</tr>
				<tr>
					<td>Visible : </td>
					<td><input type = "radio" name = "visible" value = "1"  checked="checked"/> Yes
						<input type = "radio" name = "visible" value = "0"/> No
					</td>
				</tr>
				<tr>
					<td style="vertical-align:top">Content :</td>
					<td><textarea rows="15" cols="125" name="content"><?php 
						$content = content();
						$content = str_replace('\r\n','&#13;&#10;',$content);
						echo $content; 
					?></textarea></td>
				</tr>
				<tr>
					<td colspan = "2" style="text-align: right;">
						<input type = "submit" name = "submit" value = "Create" />
						<input type = "reset" value = "Clear" />
						<a class="normal" href="manage_content.php?subject=<?php echo $subject_id; ?>"><button type="button">Cancel</a>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php 
} 

include("../includes/layouts/page_footer.php");?>