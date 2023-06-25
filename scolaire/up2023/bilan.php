<?php if (Utils::is_lang('fr')) { ?>
    <?php include 'bilan_fr.php'; ?>
<?php } ?>
<?php if (Utils::is_lang('es')) { ?>
    <?php include 'bilan_fr.php'; ?>
<?php } ?>

<a href="projet-scolaire-up2023-realisations-laureates.php">
    <i class="fa fa-link" aria-hidden="true">&nbsp;</i>
    <?= Utils::i19n(array('fr' => 'Réalisations lauréates', 'es' => 'Trabajos de las clases ganadoras')) ?>
</a>