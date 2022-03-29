<h1><?=Utils::i19n ( array ('fr' => 'Devenez partenaire d\'Ultima Patagonia 2023','es' => 'Colabore con Última Patagonia 2023' ) )?></h1>
<div class="row">
	<div class="col-md-12">
		<?php if (Utils::is_lang('fr')) {?>
		<p>Nous avons le privilège rare, pour ne pas dire unique, de pouvoir fouler les dernières terres vierges de la Terre, comme au temps révolu des
			grandes expéditions géographiques, mais avec l'apport de la technologie du XXIe siècle. Les glaciers de marbre de Madre de Dios et les cavités de
			Patagonie, tel est le cadre exceptionnel où nous mettrons en pratique les valeurs qui nous animent.</p>
		<p>Notre ambition est de repousser les frontières de la connaissance en explorant toujours plus loin, et d'en témoigner auprès de ceux qui n'ont pas
			la possibilité d'approcher ces territoires de l'extrême, les scientifiques, le grand public, tout par¬ti¬culièrement les jeunes auxquels il est
			primordial d'insuffler l'esprit d'entreprise.</p>
		<p>Si ces valeurs sont les vôtres, si explorer, comprendre et partager sont des mots qui résonnent en vous, rejoignez-nous dans cette grande
			aventure humaine.</p>
		<?php }?>
		<?php if (Utils::is_lang('es')) {?>
		<p>Tenemos el enorme y raro privilegio de caminar por tierras vírgenes de este planeta, como en los tiempos de las grandes expediciones geográficas,
			pero con toda la tecnología del siglo XXI. Los glaciares de mármol de Madre de Dios y las cavidades de la Patagonia son un marco excepcional donde
			pondremos en práctica los valores que nos mueven.</p>
		<p>Nuestro objetivo es ampliar las barreras del conocimiento mediante nuevas exploraciones así como dar a conocer estos lugares a aquellos que no
			tienen acceso a estos territorios extremos : a los científicos, al público en general y, sobre todo, a los jóvenes, a quienes es sumamente
			importante inculcar el espíritu de la iniciativa.</p>
		<p>Si piensa que estos valores también son los suyos y si se reconoce en las palabras "explorar, entender, compartir", únase a nosotros y forme
			parte de esta gran aventura humana.</p>
		<?php }?>
	</div>
</div>
<h1><?=Utils::i19n ( array ('fr' => 'Ils nous soutiennent déjà','es' => 'Ya nos apoyan' ) )?></h1>
<br>
<?php
include 'classes/SponsorsManager.php';
$bm = new SponsorsManager ('up2023');
$bm->renderPages ( );
?>
