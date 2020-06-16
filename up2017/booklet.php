<div class="container">
	<img
		class="img-responsive"
		src="images/up2017/booklet/up2017-booklet-<?=Utils::get_lang()?>-01.jpg"
		width="1170"
		height="1661"
		style="display: block;">
	<br>
	<br>
<?php for ($i = 2; $i <= 6; $i++) {?>
<img
		class="lazy img-responsive"
		data-original="images/up2017/booklet/up2017-booklet-<?=Utils::get_lang()?>-<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>.jpg"
		width="1170"
		height="1661"
		style="display: block;">
	<br>
	<br>
<?php }?>
</div>
