<?php session_start();?><!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'common/head.php';?>
</head>
<body>
	<?php include 'common/analytics.php';?>
	<?php include 'common/navbar.php';?>
	<?php include 'common/banner.php';?>
	<?php include 'escolar/subnavbar.php';?>
	<div class="content container">
		<div class="row">
			<div class="col-md-8">
				<?php include 'escolar/recursos/fichas/datos-brutos.php';?>
			</div>
			<div class="col-md-4">
                <?php include 'escolar/sidebar.php';?>
				<?php include 'sidebar/sidebar-expe.php';?>
			</div>
		</div>
	</div>
	<?php include 'common/footer.php';?>
	<?php include 'common/js-core.php';?>
	<?php include 'common/lightbox.php';?>
</body>
</html>
