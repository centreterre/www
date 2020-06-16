<?php session_start();?><!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'common/head.php';?>
</head>
<body>
	<?php include 'common/analytics.php';?>
	<?php include 'common/navbar.php';?>
	<?php include 'common/banner.php';?>
	<div class="content container">
		<?php include 'contact/contact.php';?>
	</div>
	<?php include 'common/footer.php';?>
	<?php include 'common/js-core.php';?>
	<?php include 'contact/sendmail.php';?>
</body>
</html>
