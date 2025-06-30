<?php session_start(); ?>
<?php include 'common/html.php';?>
<?php include 'common/head.php';?>
<body>
	<?php include 'common/analytics.php';?>
	<?php include 'common/navbar.php';?>
	<?php include 'common/banner.php';?>
	<?php include 'up2019/subnavbar.php';?>
	<div class="content container">
		<div class="row">
			<?php include 'up2023/appel-dons-'.Utils::get_lang().'.php';?>
		</div>
	</div>
	<?php include 'common/footer.php';?>
	<?php include 'common/js-core.php';?>
	<?php include 'common/js-lazy.php';?>
</body>
</html>
