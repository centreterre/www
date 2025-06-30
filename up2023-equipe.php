<?php session_start(); ?>
<?php include 'common/html.php';?>
<?php include 'common/head.php';?>
<body>
	<?php include 'common/analytics.php';?>
	<?php include 'common/navbar.php';?>
	<?php include 'up2023/banner.php';?>
	<?php include 'up2023/subnavbar.php';?>
	<div class="content container">
		<div class="row">
			<div class="col-md-8">
				<?php include 'up2023/equipe.php';?>
			</div>
			<div class="col-md-4">
				<?php include 'common/sidebar-latest.php';?>
				<?php include 'common/sidebar-expe.php';?>
			</div>
		</div>
	</div>
	<?php include 'common/footer.php';?>
	<?php include 'common/js-core.php';?>
</body>
</html>
