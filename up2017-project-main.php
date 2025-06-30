<?php session_start(); ?>
<?php include 'common/html.php';?>
<?php include 'common/head.php';?>
<body>
	<?php include 'common/analytics.php';?>
	<?php include 'common/navbar.php';?>
	<?php include 'up2017/banner.php';?>
	<?php include 'up2017/subnavbar.php';?>
	<div class="content container">
		<div class="row">
			<div class="col-md-8">
				<?php include 'up2017/project-main_'.Utils::get_lang().'.php';?>
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
