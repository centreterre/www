<h1><?= Utils::i19n(array(
        'fr' => 'Devenez partenaire de Mayang 2026',
        'en' => 'Become a partner of Mayang 2026')) ?></h1>
<div class="row">
    <div class="col-md-12">
        <?php if (Utils::is_lang('fr')) { ?>
            <p>Nous avons le privilège rare, pour ne pas dire unique, de pouvoir fouler les dernières terres vierges de
                la Terre, comme au temps révolu des
                grandes expéditions géographiques, mais avec l'apport de la technologie du XXIe siècle. Les glaciers de
                marbre de Madre de Dios et les cavités de
                Patagonie, tel est le cadre exceptionnel où nous mettrons en pratique les valeurs qui nous animent.</p>
            <p>Notre ambition est de repousser les frontières de la connaissance en explorant toujours plus loin, et
                d'en témoigner auprès de ceux qui n'ont pas
                la possibilité d'approcher ces territoires de l'extrême, les scientifiques, le grand public, tout
                particulièrement les jeunes auxquels il est
                primordial d'insuffler l'esprit d'entreprise.</p>
            <p>Si ces valeurs sont les vôtres, si explorer, comprendre et partager sont des mots qui résonnent en vous,
                rejoignez-nous dans cette grande
                aventure humaine.</p>
        <?php } ?>
        <?php if (Utils::is_lang('en')) { ?>
            <p>We have the rare -and one might even say unique- privilege of setting foot on the last virgin lands on
                Earth, much as in the bygone era of the great geographic expeditions, but now bolstered by 21st-century
                technology. The marble glaciers of Madre de Dios and the caverns of Patagonia: this is the extraordinary
                setting in which we will put into practice the values that drive us.</p>
            <p>Our ambition is to push the boundaries of knowledge by exploring ever farther, and to share our findings
                with those who cannot venture into these extreme regions-scientists, the general public, and especially
                young people, in whom it is vital to instill an entrepreneurial spirit.</p>
            <p>If these values are yours, if exploring, understanding, and sharing resonate within you, join us in this
                great human adventure.</p>
        <?php } ?>
    </div>
</div>
<h1><?= Utils::i19n(array(
        'fr' => 'Ils nous soutiennent déjà',
        'en' => 'They already support us')) ?></h1>
<br>
<?php
include 'classes/SponsorsManager.php';
$bm = new SponsorsManager ('mayang2026');
$bm->renderPages();
?>
