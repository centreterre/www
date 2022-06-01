<div style="text-align: center;">
    <a
            class="flag"
            href="https://resource.centre-terre.fr/up2023/plaquette/up2023-plaquette-fr.pdf"
            target="_blank">
        <img
                alt=""
                src="images/common/fr.png"/>
    </a>
    <span>&nbsp;</span>
    <a
            href="https://resource.centre-terre.fr/up2023/plaquette/up2023-plaquette-fr.pdf"
            target="_blank">pdf version française</a>
</div>
<br/>
<div class="container">
    <img
            class="img-responsive"
            src="https://resource.centre-terre.fr/up2023/plaquette/up2023-plaquette-fr-01.jpg"
            width="1240"
            height="1790"
            style="display: block;">
    <br>
    <br>
    <?php for ($i = 2; $i <= 6; $i++) { ?>
        <img
                class="lazy img-responsive"
                data-original="https://resource.centre-terre.fr/up2023/plaquette/up2023-plaquette-fr-<?= str_pad($i, 2, "0", STR_PAD_LEFT) ?>.jpg"
                width="1240"
                height="1790"
                style="display: block;">
        <br>
        <br>
    <?php } ?>
</div>
