<div class="container">
	<p style="margin-bottom: 20px;">
		<?=Utils::i19n ( array ('fr' => 'Pour obtenir l\'une de ces photos en haute définition, merci de bien vouloir nous contacter à','es' => 'Para obtener alguna de las fotos en alta resolución, póngase en contacto con nosotros en' ) )?>
		<a href="mailto:contact@centre-terre.fr">contact@centre-terre.fr</a>
	</p>
	<img
		class="img-responsive"
		src="images/gallery/up2010/gallery-up2010-001.jpg"
		width="1170"
		height="779"
		style="display: block;">
	<br>
	<br>
<?php for ($i = 2; $i <= 12; $i++) {?>
<img
		class="lazy img-responsive"
		data-original="images/gallery/up2010/gallery-up2010-<?=str_pad($i, 3, "0", STR_PAD_LEFT)?>.jpg"
		width="1170"
		height="779"
		style="display: block;">
	<br>
	<br>
<?php }?>
</div>