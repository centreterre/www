<?php
if (isset ( $_POST ['submit'] )) {
	$email = $_POST ['email'];
	$first_name = $_POST ['first_name'];
	$last_name = $_POST ['last_name'];
	$message = "From " . $email . "\r\n"  ;
	$message = $message . "From " . $last_name . " " . $first_name . "\r\n"  ;
	$message = $message . $_POST ['message'] ;
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'From:' . $email . "\r\n" . 'Reply-To:' . $email . "\r\n" . 'Content-Type: text/plain; charset="utf-8"; DelSp="Yes"; format=flowed ' . "\r\n" . 'Content-Disposition: inline' . "\r\n" . 'Content-Transfer-Encoding: 7bit' . " \r\n" . 'X-Mailer:PHP/' . phpversion ();
	if (mail ( 'contact@centre-terre.fr', 'Message provenant du site www.centre-terre.fr', $message, $headers )) {
		echo '<div class="growl"></div><script src="assets/js/bootstrap-notify.min.js"></script><script type="text/javascript">$.notify({delay : 2000,	message : "Message envoyé"}, {type : "success"});</script>';
	} else {
		echo '<div class="growl"></div><script src="assets/js/bootstrap-notify.min.js"></script><script type="text/javascript">$.notify({delay : 2000,	message : "Message non envoyé"}, {type : "warning"});</script>';
	}
}
?>	