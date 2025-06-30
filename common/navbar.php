<nav
        role="navigation"
        class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button
                    type="button"
                    class="navbar-toggle"
                    data-toggle="collapse"
                    data-target="#navbar-collapse-1">
                <span class="sr-only">Toggle</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-brand navbar-logo">
                <a href="index.php">
                    <img
                            alt=""
                            src="images/common/logo-icon.png"/>
                </a>
                <a href="index.php">
                    <img
                            alt=""
                            id="navbar-logo-text"
                            src="images/common/logo-text_<?= Utils::get_lang() ?>.png"/>
                </a>
            </div>
            <div class="navbar-brand navbar-flags">
                <?php if (Utils::show_lang('fr')) { ?>
                    <a href="<?= Utils::get_flag_href('fr') ?>">
                        <img
                                alt=""
                                src="images/common/france.png"/>
                    </a>
                <?php } ?>
                <?php if (Utils::show_lang('en')) { ?>
                    <a href="<?= Utils::get_flag_href('en') ?>">
                        <img
                                alt=""
                                src="images/common/uk.png"/>
                    </a>
                <?php } ?>
                <?php if (Utils::show_lang('es')) { ?>
                    <a href="<?= Utils::get_flag_href('es') ?>">
                        <img
                                alt=""
                                src="images/common/chile.png"/>
                    </a>
                <?php } ?>
            </div>
        </div>
        <div
                class="collapse navbar-collapse"
                id="navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="<?= Utils::get_menu_class('/centre-terre') ?>">
                    <a href="centre-terre-asso.php"><?= Utils::i19n(array(
                            'fr' => 'Centre Terre',
                            'en' => 'Centre Terre',
                            'es' => 'Centre Terre')) ?></a>
                </li>
                <li class="<?= Utils::get_menu_class('/mayang2026-projet-scientifique', 'index') ?>">
                    <a href="mayang2026-projet-scientifique.php"><?= Utils::i19n(array(
                            'fr' => 'MAYANG 2026',
                            'en' => 'MAYANG 2026',
                            'es' => 'MAYANG 2026')) ?></a>
                </li>
                <li class="<?= Utils::get_menu_class('/gallery') ?>">
                    <a href="gallery-up2010.php"><?= Utils::i19n(array(
                            'fr' => 'Photos',
                            'en' => 'Photos',
                            'es' => 'Galería de fotos')) ?></a>
                </li>
                <li class="<?= Utils::get_menu_class('/shop') ?>">
                    <a href="shop.php"><?= Utils::i19n(array(
                            'fr' => 'Boutique',
                            'en' => 'Shop',
                            'es' => 'Tienda on-line')) ?></a>
                </li>
                <li class="<?= Utils::get_menu_class('/contact') ?>">
                    <a href="contact.php"><?= Utils::i19n(array(
                            'fr' => 'Contact',
                            'en' => 'Contact',
                            'es' => 'Contacto')) ?></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
