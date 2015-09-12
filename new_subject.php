<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/validations_functions.php");
	include("../../includes/layouts/page_header.php");
	logged_in();
	find_selected_page();
	
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
		<h2>Create Subject</h2>
		<form action="create_subject.php" method="post">
			<table border=1>
				<tr>
					<td>Menu Name : </td>
					<td><input type = "text" size = 60 name = "menu_name" value = "" /></td>
				</tr>
				<tr>
					<td>Position : </td>
					<td><select name = "position">
						<?php
							$subject_set = find_all_subjects();
							$subject_count = mysqli_num_rows($subject_set);
							for ($count=1; $count <= $subject_count + 1; $count++) {
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
					<td colspan = "2" style="text-align:center;">
						<input type = "submit" name = "submit" value = "Create" />
						<input type = "reset" value = "Clear" />
						<a class="normal" href="manage_content.php"><button type="button">Cancel</a>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php include("../includes/layouts/page_footer.php");?>