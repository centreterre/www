<?php
include 'classes/Utils.php';
Utils::init_lang ();
?>
<?php session_start();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Centre Terre - Découvrir Explorer Partager</title>
<link
	href="assets/css/bootstrap.min.css"
	rel="stylesheet">
<link
	href="assets/css/centre-terre-print-v1.css"
	rel="stylesheet">
<link
	href="assets/font-awesome/css/font-awesome.min.css"
	rel="stylesheet"
	type="text/css">
</head>
<body>
	<div class="content container">
		<h1>Ultima Patagonia 2021</h1>
		<div class="row">
			<div class="col-md-8">
				<?php include 'up2021/print.php';?>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
</body>
</html>
