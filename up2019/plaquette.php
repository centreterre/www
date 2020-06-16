<div style="text-align: center;">
	<a
		class="flag"
		href="documents/EXPEDITIONS/UP2019/PLAQUETTE/CT-UP2019-PLAQUETTE-6P-MEDIUM-FR-V3.pdf"
		target="_blank">
		<img
			alt=""
			src="images/common/fr.png" />
	</a>
    <span>&nbsp;</span>
    <a
        href="documents/EXPEDITIONS/UP2019/PLAQUETTE/CT-UP2019-PLAQUETTE-6P-MEDIUM-FR-V3.pdf"
        target="_blank">pdf version française</a>
    <span>&nbsp;&nbsp;</span>
	<a
		class="flag"
		href="documents/EXPEDITIONS/UP2019/PLAQUETTE/CT-UP2019-PLAQUETTE-6P-MEDIUM-ES-V3.pdf"
		target="_blank">
		<img
			alt=""
			src="images/common/es.png" />
	</a>
    <span>&nbsp;</span>
    <a
        href="documents/EXPEDITIONS/UP2019/PLAQUETTE/CT-UP2019-PLAQUETTE-6P-MEDIUM-ES-V3.pdf"
        target="_blank">pdf versión en español</a>
    <span>&nbsp;&nbsp;</span>
	<a
		class="flag"
		href="documents/EXPEDITIONS/UP2019/PLAQUETTE/CT-UP2019-PLAQUETTE-6P-MEDIUM-EN-V2.pdf"
		target="_blank">
		<img
			alt=""
			src="images/common/en.png" />
	</a>
    <span>&nbsp;</span>
    <a
        href="documents/EXPEDITIONS/UP2019/PLAQUETTE/CT-UP2019-PLAQUETTE-6P-MEDIUM-EN-V2.pdf"
        target="_blank">pdf english version</a>
</div>
<br/>
<div class="container">
    <img
        class="img-responsive"
        src="images/up2019/booklet/up2019-booklet-<?=Utils::get_lang()?>-01.svg"
        width="1170"
        height="1661"
        style="display: block;">
    <br>
    <br>
<?php for ($i = 2; $i <= 6; $i++) {?>
<img
        class="lazy img-responsive"
        data-original="images/up2019/booklet/up2019-booklet-<?=Utils::get_lang()?>-<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>.svg"
        width="1170"
        height="1661"
        style="display: block;">
    <br>
    <br>
<?php }?>
</div>
