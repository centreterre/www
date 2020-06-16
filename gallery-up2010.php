<?php session_start();?><!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'common/head.php';?>
</head>
<body>
	<?php include 'common/analytics.php';?>
	<?php include 'common/navbar.php';?>
	<?php include 'common/banner.php';?>
	<div class="subnavbar">
		<nav
			role="navigation"
			class="container navbar navbar-default">
			<ul class="nav navbar-nav">
				<?php include 'gallery/subnavbar.php';?>
			</ul>
		</nav>
	</div>
	<div class="content container">
		<div class="row">
			<?php include 'gallery/gallery-up2010.php';?>
		</div>
	</div>
	<?php include 'common/footer.php';?>
	<?php include 'common/js-core.php';?>
	<?php include 'common/js-lazy.php';?>
</body>
</html>
