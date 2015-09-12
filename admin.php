<?php 
	require_once("../../includes/functions.php");
	require_once("../../includes/sessions.php");
	include("../../includes/layouts/page_header.php");
	logged_in();
	
?>

<div id="main">
	<div id="navigation">
		&nbsp;
	</div>
	<div id="page">
		<h2>Admin Menu</h2>
		
		<ul>
			<li><a href="/cms/manage_content.php">Manage Content</a></li>
			<li><a href="/cms/manage_users.php">Manage User Accounts</a></li>
			<li><a href="/cms/logout.php">Logout</a></li>
		</ul>
	</div>
</div>

<?php include("../../includes/layouts/page_footer.php");?>