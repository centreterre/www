<?php
$uid = $_GET ['uid'];
$file = '../documents/STREAMING/' . $_SESSION [$uid];
unset ( $_SESSION [$uid] );
readfile ( $file );
?>