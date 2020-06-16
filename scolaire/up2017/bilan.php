
<div style="text-align: center;">
    <i
        class="fa fa-file-pdf-o"
        aria-hidden="true"></i>
    <a
        href="https://resource.centre-terre.fr/scolaire/up2017/bilan-projet-educatif-up2017.pdf"
        target="_blank">Télécharger au format PDF</a>
</div>
<div class="container">
    <img
        class="img-responsive"
        src="https://resource.centre-terre.fr/scolaire/up2017/bilan-01.jpg"
        width="1170"
        height="1661"
        style="display: block;">
    <br>
    <br>
<?php for ($i = 2; $i <= 5; $i++) {?>
<img
        class="lazy img-responsive"
        data-original="https://resource.centre-terre.fr/scolaire/up2017/bilan-<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>.jpg"
        width="1170"
        height="1661"
        style="display: block;">
    <br>
    <br>
<?php }?>
</div>
