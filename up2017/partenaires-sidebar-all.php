<div
	class="well"
	style="padding-left: 45px;">
	<?php
	foreach ( scandir ( 'up2017/images/sponsors' ) as $file ) {
		if (strstr ( $file, '.png' )) {
			?>
					<img
		alt=""
		class="img-responsive"
		src="up2017/images/sponsors/<?=$file?>"> <br><?php
		}
	}
	?>
</div>
