<div class="row">
	<div class="col-md-8">
		<div class="list-container">
			<h2><?=Utils::i19n ( array ('fr' => 'Nous envoyer un message','es' => 'Contacto' ) )?></h2>
			<form
				action="contact.php"
				method="post"
				enctype="application/x-www-form-urlencoded"
				name="sentMessage"
				id="contactForm">
				<div class="control-group form-group">
					<div class="controls">
						 <input
							type="email"
							class="form-control"
							placeholder="<?=Utils::i19n ( array ('fr' => 'Votre adresse mail','es' => 'Su correo electrónico' ) )?>"
							id="email"
							name="email"
							required="true">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input
							type="text"
							id="last_name"
							name="last_name"
							class="form-control"
							placeholder="<?=Utils::i19n ( array ('fr' => 'Votre nom','es' => 'Apellido' ) )?>"
							autocomplete="off"
							maxlength="50"
							style="margin-top: 10px;"
							required="true" />
					</div>
					<div class="col-md-6">
						<input
							type="text"
							id="first_name"
							name="first_name"
							class="form-control"
							placeholder="<?=Utils::i19n ( array ('fr' => 'Votre prénom','es' => 'Nombre' ) )?>"
							autocomplete="off"
							maxlength="50"
							style="margin-top: 10px;"
							required="true" />
					</div>
				</div>
				<br/>
				<div class="control-group form-group">
					<div class="controls">
						<textarea
							rows="5"
							cols="100"
							class="form-control"
							id="message"
							name="message"
							placeholder="<?=Utils::i19n ( array ('fr' => 'Votre message','es' => 'Su mensaje' ) )?>"
							required="true"
							maxlength="999"
							style="resize: none"></textarea>
					</div>
				</div>
				<div id="success"></div>
				<button
					name="submit"
					type="submit"
					class="btn btn-primary"><?=Utils::i19n ( array ('fr' => 'Envoyer','es' => 'Enviar' ) )?></button>
			</form>
		</div>
	</div>
	<div class="col-md-4">
		<div class="well">
			<h2><?=Utils::i19n ( array ('fr' => 'Informations','es' => 'Informaciones' ) )?></h2>
			<br>
			<p>
				Centre Terre
				<br>
				25 rue Louis de Broglie
				<br>
				31100 Toulouse
				<br>
			</p>
			<p>
				<i class="fa fa-phone"></i>&nbsp;&nbsp;+33 (1) 5 34 60 95 63
				<br>
				<i class="fa fa-envelope-o"></i>&nbsp;&nbsp;
				<a href="mailto:contact@centre-terre.fr">contact@centre-terre.fr</a>
			</p>
			<ul class="list-unstyled list-inline list-social-icons">
				<li>
					<a href="https://www.facebook.com/CentreTerre/">
						<i class="fa fa-facebook-square fa-2x"></i>
					</a>
				</li>
				<li>
					<a href="https://twitter.com/centreterre">
						<i class="fa fa-twitter-square fa-2x"></i>
					</a>
				</li>
			</ul>
		</div>
		<div class="well">
			<h2><?=Utils::i19n ( array ('fr' => 'Géolocalisation','es' => 'Geolocalización' ) )?></h2>
			<iframe
				id="geolocalisation"
				width="100%"
				height="300px"
				src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=43.58008,1.38150&amp;t=m&amp;z=5&amp;output=embed"></iframe>
		</div>
	</div>
</div>