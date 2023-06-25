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
			<?php include 'scolaire/up2023/bilan.php';?>
		</div>
	</div>
	<?php include 'common/footer.php';?>
	<?php include 'common/js-core.php';?>
    <?php include 'common/js-lazy.php';?>    
</body>
</html>
