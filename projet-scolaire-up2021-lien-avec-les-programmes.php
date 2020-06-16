<?php session_start();?><!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'common/head.php';?>
</head>
<body>
	<?php include 'common/analytics.php';?>
	<?php include 'common/navbar.php';?>
	<?php include 'common/banner.php';?>
	<?php include 'scolaire/subnavbar.php';?>
	<div class="content container">
		<div class="row">
			<div class="col-md-8">
				<?php include 'scolaire/up2021/lien-avec-les-programmes.php';?>
			</div>
			<div class="col-md-4">
				<?php include 'scolaire/sidebar.php';?>
				<?php include 'sidebar/sidebar-expe.php';?>
			</div>
		</div>
	</div>	
	<?php include 'common/footer.php';?>
	<?php include 'common/js-core.php';?>
</body>
</html>
