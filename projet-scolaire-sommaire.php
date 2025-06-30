<?php session_start(); ?>
<?php include 'common/html.php';?>
<?php include 'common/head.php';?>
<body>
	<?php include 'common/analytics.php';?>
	<?php include 'common/navbar.php';?>
	<?php include 'common/banner.php';?>
	<?php include 'scolaire/subnavbar.php';?>
	<div class="content container">
		<div class="row">
			<div class="col-md-8">
                <h2>Suivez l'expédition UP2019 avec vos élèves</h2>
				<?php include 'scolaire/up2019/presentation.php';?>
			</div>
			<div class="col-md-4">
				<?php include 'sidebar/sidebar-latest.php';?>
				<?php include 'sidebar/sidebar-expe.php';?>
			</div>
		</div>
	</div>	
	<?php include 'common/footer.php';?>
	<?php include 'common/js-core.php';?>
</body>
</html>
