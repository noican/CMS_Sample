<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
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
		<br />
		<a class= "normal" href="new_subject.php"><button type="button">Add a subject</a>
	</div>
	<div id="page">	
		<?php 
			echo message();
			if ($current_subject) {
				echo "<h2 style=\"text-align:center;\">MANAGE SUBJECT</h2>";
				$str_subject_name = htmlentities(strtoupper($current_subject["subject_name"]));
				$str_subject_position = $current_subject["position"];
				$str_subject_visible = $current_subject["visible"];
				echo "Subject Name : ".$str_subject_name;
				echo "<br/>";
				echo "Subject position : ".$str_subject_position;
				echo "<br/>";
				echo "Subject visible : ";
				echo $str_subject_visible == 1 ? 'Yes' : 'No';
				echo "<br/>";
				echo "<br/>";
				echo "<table align = \"left\">";
				echo "<tr><td>";
				echo "<a class= \"normal\" href=\"new_page.php?subject=".$current_subject["id"]."\"><button type=\"button\">Add a Page</a>"; 
				echo "</td><td>";
				echo "<a class= \"normal\" href=\"edit_subject.php?subject=".$current_subject["id"]."\"><button type=\"button\">Edit subject</a>"; 
				echo "</td><td>";
				echo "<a class= \"normal\" href=\"delete_subject.php?subject=".$current_subject["id"]."\" onclick =\"return confirm('Are you sure?');\"><button type=\"button\">Delete subject</a>";
				echo "</td></tr>";
				echo "</table>";
				
			} elseif ($current_page) {
				echo "<h2 style=\"text-align:center;\">MANAGE PAGE</h2>";
				$str_page_name = htmlentities(ucwords($current_page["page_name"]));
				$str_page_position = $current_page["position"];
				$str_page_visible = $current_page["visible"];
				$str_page_content = htmlentities($current_page["content"]);
				echo "Page Name : ".$str_page_name;
				echo "<br/>";
				echo "Page position : ".$str_page_position;
				echo "<br/>";
				echo "Page visible : ";
				echo $str_page_visible == 1 ? 'Yes' : 'No';
				echo "<br/>";
				echo "Content: ";
				echo "<br/>";
				echo "<br/>";
				echo "<textarea readonly rows=\"15\" cols=\"125\" style=\"color:#000000;\" id=\"page_content\">";
				echo $str_page_content;
				echo "</textarea>";
				echo "<br/>";
				echo "<table align = \"left\">";
				echo "<tr><td>";
				echo "<a class= \"normal\" href=\"edit_page.php?page=".$current_page["id"]."\"><button type=\"button\">Edit Page</a>"; 
				echo "</td><td>";
				echo "<a class= \"normal\" href=\"delete_page.php?page=".$current_page["id"]."\" onclick =\"return confirm('Are you sure?');\"><button type=\"button\">Delete Page</a>";
				echo "</td></tr>";
				echo "</table>";
			} else {
					echo "Please select a subject or page.";
			}
		?>	
	</div>
</div>
<?php include("../../includes/layouts/page_footer.php");?>