<div style="text-align: center;">
    <a
            class="flag"
            href="mayang2026/plaquette/CT-PNG-2026-V3-fr.pdf"
            target="_blank">
        <img
                alt=""
                src="images/common/fr.png"/>
    </a>
    <span>&nbsp;</span>
    <a
            href="mayang2026/plaquette/CT-PNG-2026-V3-fr.pdf"
            target="_blank"><?= Utils::i19n(array(
            'fr' => 'PDF Version Française',
            'en' => 'PDF French Version')) ?></a>
    <a
            class="flag"
            href="mayang2026/plaquette/CT-PNG-2026-V3-en.pdf"
            target="_blank">
        <img
                alt=""
                src="images/common/en.png"/>
    </a>
    <span>&nbsp;</span>
    <a
            href="mayang2026/plaquette/CT-PNG-2026-V3-en.pdf"
            target="_blank"><?= Utils::i19n(array(
            'fr' => 'PDF Version Anglaise',
            'en' => 'PDF English Version')) ?></a>
</div>
<br/>
<div class="container">
    <img
            class="img-responsive"
            src="mayang2026/images/CT-PNG-2026-V3-<?= Utils::get_lang() ?>-01.jpg"
            width="1236"
            height="1780"
            style="display: block;">
    <br>
    <br>
    <?php for ($i = 2; $i <= 7; $i++) { ?>
        <img
                class="lazy img-responsive"
                data-original="mayang2026/images/CT-PNG-2026-V3-<?= Utils::get_lang() ?>-<?= str_pad($i, 2, "0", STR_PAD_LEFT) ?>.jpg"
                width="1236"
                height="874"
                style="display: block;">
        <br>
        <br>
    <?php } ?>
</div>
