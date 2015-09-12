<?php 
	require_once("../../includes/sessions.php");
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	include("../../includes/layouts/public_page_header.php");
	find_default_page();
?>

<div id="main">
	<div id="navigation">
		<br />
		<a href="/cms/index.php">&laquo Home</a>
		<br />
		<?php echo public_navigation($current_subject,$current_page); ?>
	</div>
	<div id="page">	
		<?php 
			if ($current_page && $current_page["visible"] == 1) {
				$str_page_name = htmlentities(ucwords($current_page["page_name"]));
				$str_page_content = htmlentities($current_page["content"]);
				echo "<h2 style=\"text-align:center;\">".$str_page_name."</h2>";
				echo "<table align=\"center\" width=90%> <tr> <td> <span style=\"text-align:center; color:#4CCCFF;\">".nl2br($str_page_content)."</span> </td> </tr> </table>";
			} else {
					echo "<h2 style=\"text-align:center;\">Welcome!!!</h2>";
					echo "<br />";
					echo "<img style=\"display: block; margin-left: auto; margin-right: auto;\" src='/cms/images/welcome.jpg' height= 80%/>";
			}
		?>	
	</div>
</div>

<?php include("../../includes/layouts/page_footer.php");?>