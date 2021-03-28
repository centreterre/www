<?php session_start();?><!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'common/head.php';?>
</head>
<body>
	<?php include 'common/analytics.php';?>
	<?php include 'common/navbar.php';?>
	<?php include 'common/banner.php';?>
	<?php include 'up2022/subnavbar.php';?>
	<div class="content container">
		<div class="row">
			<div class="col-md-8">
				<?php include 'up2022/projet-scientifique_'.Utils::get_lang().'.php';?>
			</div>
			<div class="col-md-4">
				<?php include 'sidebar/sidebar-latest.php';?>
				<?php include 'sidebar/sidebar-expe.php';?>
			</div>
		</div>
	</div>
	<?php include 'common/footer.php';?>
	<?php include 'common/js-core.php';?>
	<?php include 'common/js-lazy.php';?>
</body>
</html>
