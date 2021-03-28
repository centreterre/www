<?php
include 'classes/BlogManager2.php';
$bm = new BlogManager ('up2022/news');
$pageIndex = 0;
if (isset ( $_GET ['page'] )) {
	$page = $_GET ['page'];
	$pageIndex = $bm->getPageIndex($page);
}
if (isset ( $_POST ['nextPage'] )) {
	$pageIndex = $_POST ['pageIndex'] + 1;
}
if (isset ( $_POST ['prevPage'] )) {
	$pageIndex = $_POST ['pageIndex'] - 1;
}
if (isset ( $_GET ['pageIndex'] )) {
	$pageIndex = $_GET ['pageIndex'];
}
$bm->renderPage ( $pageIndex );
$bm->renderPagination ( $pageIndex );
?>

