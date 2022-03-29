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
						src="images/common/logo-icon.png" />
					<img
						alt=""
						id="navbar-logo-text"
						src="images/common/logo-text_<?=Utils::get_lang()?>.png" />
				</a>
			</div>
			<div class="navbar-brand navbar-flags">
				<a href="<?=Utils::get_flag_href('fr')?>">
					<img
						alt=""
						src="images/common/france.png" />
				</a>
				<a href="<?=Utils::get_flag_href('es')?>">
					<img
						alt=""
						src="images/common/chile.png" />
				</a>
			</div>
		</div>
		<div
			class="collapse navbar-collapse"
			id="navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li class="<?=Utils::get_menu_class('/centre-terre')?>">
					<a href="centre-terre-asso.php"><?=Utils::i19n ( array ('fr' => 'Centre Terre','es' => 'Centre Terre' ) )?></a>
				</li>
				<li class="<?=Utils::get_menu_class('/up2023-blog')?>">
					<a href="up2023-blog.php"><?=Utils::i19n ( array ('fr' => 'UP2022','es' => 'UP2022' ) )?></a>
				</li>
				<li class="<?=Utils::get_menu_class('/gallery')?>">
					<a href="gallery-up2010.php"><?=Utils::i19n ( array ('fr' => 'Galerie photos','es' => 'Galería de fotos' ) )?></a>
				</li>
				<li class="<?=Utils::get_menu_class('/up2023-partenaires')?>">
					<a href="up2023-partenaires.php"><?=Utils::i19n ( array ('fr' => 'Partenaires','es' => 'Colaboradores' ) )?></a>
				</li>
                <?php if (Utils::is_lang('fr')) {?>
                    <li class="<?=Utils::get_menu_class('/projet-scolaire')?>">
                        <a href="projet-scolaire-up2023-presentation.php">Espace scolaire</a>
                    </li>
                <?php }?>
                <?php if (Utils::is_lang('es')) {?>
                    <li class="<?=Utils::get_menu_class('/espacio-escolar-chile')?>">
                        <a href="espacio-escolar-chile-presentation.php">Espacio escolar</a>
                    </li>
                <?php }?>
				<li class="<?=Utils::get_menu_class('/shop')?>">
					<a href="shop.php"><?=Utils::i19n ( array ('fr' => 'Boutique','es' => 'Tienda on-line' ) )?></a>
				</li>
				<li class="<?=Utils::get_menu_class('/contact')?>">
					<a href="contact.php"><?=Utils::i19n ( array ('fr' => 'Contact','es' => 'Contacto' ) )?></a>
				</li>
			</ul>
		</div>
	</div>
</nav>
