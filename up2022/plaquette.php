<div style="text-align: center;">
    <a
            class="flag"
            href="https://resource.centre-terre.fr/up2022/plaquette/up2022-plaquette-fr.pdf"
            target="_blank">
        <img
                alt=""
                src="images/common/fr.png"/>
    </a>
    <span>&nbsp;</span>
    <a
            href="https://resource.centre-terre.fr/up2022/plaquette/up2022-plaquette-fr.pdf"
            target="_blank">pdf version française</a>
    <span>&nbsp;&nbsp;</span>
    <a
            class="flag"
            href="https://resource.centre-terre.fr/up2022/plaquette/up2022-plaquette-es.pdf"
            target="_blank">
        <img
                alt=""
                src="images/common/es.png"/>
    </a>
    <span>&nbsp;</span>
    <a
            href="https://resource.centre-terre.fr/up2022/plaquette/up2022-plaquette-es.pdf"
            target="_blank">pdf versión en español</a>
    <span>&nbsp;</span>
    <a
            class="flag"
            href="https://resource.centre-terre.fr/up2022/plaquette/up2022-plaquette-en.pdf"
            target="_blank">
        <img
                alt=""
                src="images/common/en.png"/>
    </a>
    <span>&nbsp;</span>
    <a
            href="https://resource.centre-terre.fr/up2022/plaquette/up2022-plaquette-en.pdf"
            target="_blank">pdf english version</a>
</div>
<br/>
<div class="container">
    <img
            class="img-responsive"
            src="https://resource.centre-terre.fr/up2022/plaquette/up2022-plaquette-<?= Utils::get_lang() ?>-01.png"
            width="1170"
            height="1661"
            style="display: block;">
    <br>
    <br>
    <?php for ($i = 2; $i <= 6; $i++) { ?>
        <img
                class="lazy img-responsive"
                data-original="https://resource.centre-terre.fr/up2022/plaquette/up2022-plaquette-<?= Utils::get_lang() ?>-<?= str_pad($i, 2, "0", STR_PAD_LEFT) ?>.png"
                width="1170"
                height="1661"
                style="display: block;">
        <br>
        <br>
    <?php } ?>
</div>
