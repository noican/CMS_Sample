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
	</div>
	<div id="page">	
		<br />
		<?php 
			echo message();
			echo users_navigation();
		?>	
	</div>
</div>
<?php include("../../includes/layouts/page_footer.php");?>