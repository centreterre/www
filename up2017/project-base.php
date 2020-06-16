<div class="container">
	<img
		class="img-responsive"
		src="images/up2017/project-base/up2017-project-base-01.jpg"
		width="1170"
		height="200"
		style="display: block;">
	<img
		class="img-responsive"
		src="images/up2017/project-base/up2017-project-base-02.jpg"
		width="1170"
		height="827"
		style="display: block;">
	<?php for ($i = 3; $i <= 12; $i++) {?>
	<hr>
	<img
		class="lazy img-responsive"
		data-original="images/up2017/project-base/up2017-project-base-<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>.jpg"
		width="1170"
		height="827"
		style="display: block;">
	<?php }?>
	<br>
</div>
