<?php
class PlaceEdit_Form extends Form{

	public function createPublic($options=[]) {
		$this->values['choicePromotion'] = (isset($this->values['choicePromotion'])) ? $this->values['choicePromotion'] : 'promoted';
		$this->values['choicePayment'] = (isset($this->values['choicePayment'])) ? $this->values['choicePayment'] : 'paypal';
		$captchaError = (isset($this->errors['captcha'])) ? '<div class="error">'.$this->errors['captcha'].'</div>' : '';
		$fields = '<div class="formPages" data-url="'.url('tag-autocomplete').'">
						
						<div class="formPage formPage-intro">
							<div class="formPageIns">
								<div class="formPageIntroWrapper">
									<div class="formPageIntroImage">
										'.((isset($options['update']) && $options['update']==true) ? '
										<img src="'.BASE_URL.'visual/img/owner.svg"/>
										' : '
										<img src="'.BASE_URL.'visual/img/happy.svg"/>
										').'
									</div>
									<div class="formPageIntroInfo">
										'.((isset($options['update']) && $options['update']==true) ? '
										<div class="formPageInfoTitle">Actualice la información de su empresa o negocio</div>
										<p>Revise todos los campos o complete la información de contacto.</p>
										' : '
										<div class="formPageInfoTitle">Inscriba a su empresa o negocio</div>
										').'
										<p>Nuestro directorio le dará visibilidad para atraer clientes y mejorar sus ventas.</p>
										<p>Una vez que ingrese todos los datos los revisaremos manualmente y los publicaremos en un <strong>plazo máximo de 48 horas</strong>.</p>
										<p>Le informaremos sobre todo el proceso via email.</p>
									</div>
								</div>
							</div>
						</div>

						<div class="formPage formPage-name">
							<div class="formPageIns">
								<div class="formPageInfo">
									<div class="formPageInfoTitle">Comencemos por el nombre de su empresa o negocio</div>
								</div>
								'.$this->field('idPlaceEdit').'
								'.$this->field('title', ['label'=>'', 'class'=>'formIcon formIcon-business']).'
							</div>
						</div>

						<div class="formPage formPage-contact">
							<div class="formPageIns">
								<div class="formPageInfo">
									<div class="formPageInfoTitle">Ahora, necesitamos su información de contacto</div>
								</div>
								<div class="formFields2">
									'.$this->field('email', ['class'=>'formIcon formIcon-email']).'
									'.$this->field('telephone', ['class'=>'formIcon formIcon-telephone']).'
								</div>
								<div class="formFields2">
									'.$this->field('mobile', ['class'=>'formIcon formIcon-mobile']).'
									'.$this->field('whatsapp', ['class'=>'formIcon formIcon-whatsapp']).'
								</div>
							</div>
						</div>

						<div class="formPage formPage-social">
							<div class="formPageIns">
								<div class="formPageInfo">
									<div class="formPageInfoTitle">Indíquenos sus enlaces en la web</div>
								</div>
								<div class="formFields2">
									'.$this->field('web', ['class'=>'formIcon formIcon-globe']).'
								</div>
								<div class="formFields2">
									'.$this->field('facebook', ['class'=>'formIcon formIcon-facebook']).'
									'.$this->field('twitter', ['class'=>'formIcon formIcon-twitter']).'
								</div>
								<div class="formFields2">
									'.$this->field('instagram', ['class'=>'formIcon formIcon-instagram']).'
									'.$this->field('youtube', ['class'=>'formIcon formIcon-youtube']).'
								</div>
							</div>
						</div>

						<div class="formPage formPage-address">
							<div class="formPageIns">
								<div class="formPageInfo">
									<div class="formPageInfoTitle">Ahora, necesitamos su dirección</div>
								</div>
								'.$this->field('address', ['required'=>true]).'
								<div class="triggerCityWrapper">
									<div class="triggerCitySelect">
										'.$this->field('city').'
										<div class="triggerCity">
											'.__('cityDoesNotAppear').'
										</div>
									</div>
									<div class="triggerCityInfo">
										'.FormField_Text::create(['name'=>'cityOther', 'label'=>'city']).'
									</div>
								</div>
								<div class="formMandatory">* Datos obligatorios</div>
							</div>
						</div>

						<div class="formPage formPage-short-description">
							<div class="formPageIns">
								<div class="formPageInfo">
									<div class="formPageInfoTitle">Díganos en unas líneas a qué se dedica</div>
								</div>
								'.$this->field('shortDescription', ['required'=>true]).'
								'.$this->field('idTag').'
								<div class="formMandatory">* Dato obligatorio</div>
							</div>
						</div>

						<div class="formPage formPage-description">
							<div class="formPageIns">
								<div class="formPageInfo">
									<div class="formPageInfoTitle">Ahora escriba una descripción completa de su actividad</div>
								</div>
								'.$this->field('description', ['label'=>'']).'
							</div>
						</div>

						<div class="formPage formPage-logo">
							<div class="formPageIns">
								<div class="formPageInfo">
									<div class="formPageInfoTitle">Si desea, puede ingresar el logo de su empresa</div>
								</div>
								<div class="uploadLogo">
									<div class="uploadLogoMessage"></div>
									<div class="uploadLogoIns">'.$this->field('image').'</div>
									<div class="uploadLogoImage"></div>
								</div>
							</div>
						</div>

						<div class="formPage formPage-logo">
							<div class="formPageIns">
								<div class="formPageInfo">
									<div class="formPageInfoTitle">Ahora, escriba el nombre y correo electrónico de una persona de contacto</div>
								</div>
								<div class="formFields2">
									'.$this->field('nameEditor', ['class'=>'formIcon formIcon-person']).'
									'.$this->field('emailEditor', ['class'=>'formIcon formIcon-email']).'
								</div>
								<div class="formMandatory">* Datos obligatorios</div>
							</div>
						</div>

						<div class="formPage formPage-promotion">
							<div class="formPageIns">
								<div class="formPageInfo">
									<div class="formPageInfoTitle">Promocione a su empresa por un costo mínimo</div>
								</div>
								<div class="formChoices">
									<div class="formChoicesItem formPromotionItem formPromotionItem-promoted" data-value="promoted">
										<div class="formChoicesItemIns">
											<i class="icon '.(($this->values['choicePromotion']=='promoted') ? 'icon-checked' : '').'"></i>
											<div class="formChoicesInfo">
												<strong>Deseo promocionar a mi empresa por un pago único de 10$USD (dólares americanos)</strong>
												<span>Aparecerá en los primeros lugares de las búsquedas y tendrá una página libre de publicidad. El pago es único y no tiene limite de duración.</span>
											</div>
										</div>
									</div>
									<div class="formChoicesItem formPromotionItem formPromotionItem-not-promoted" data-value="not-promoted">
										<div class="formChoicesItemIns">
											<i class="icon '.(($this->values['choicePromotion']=='not-promoted') ? 'icon-checked' : '').'"></i>
											<div class="formChoicesInfo">
												<strong>Deseo inscribir a mi empresa en el directorio de forma gratuita</strong>
											</div>
										</div>
									</div>
									'.FormField_Hidden::create(array('name'=>'choicePromotion', 'value'=>$this->values['choicePromotion'])).'
								</div>
							</div>
						</div>

						<div class="formPage formPage-payment">
							<div class="formPageIns">
								<div class="formPageInfo">
									<div class="formPageInfoTitle">Indíquenos la forma para realizar el pago</div>
								</div>
								<div class="formChoices">
									<div class="formChoicesItem formPaymentItem formPaymentItem-card" data-value="paypal">
										<div class="formChoicesItemIns">
											<i class="icon '.(($this->values['choicePayment']=='paypal') ? 'icon-checked' : '').'"></i>
											<div class="formChoicesInfo">
												<strong>PayPal</strong>
												<span>El pago se realizará mediante el servicio de pagos en línea PayPal</span>
											</div>
										</div>
									</div>
									<div class="formChoicesItem formPaymentItem" data-value="transfer">
										<div class="formChoicesItemIns">
											<i class="icon '.(($this->values['choicePayment']=='transfer') ? 'icon-checked' : '').'"></i>
											<div class="formChoicesInfo">
												<strong>Transferencia bancaria o giro postal</strong>
												<span>Deberá realizar una transferencia bancaria o giro postal. Le enviaremos los datos de nuestro banco a su correo electrónico</span>
											</div>
										</div>
									</div>
									'.FormField_Hidden::create(array('name'=>'choicePayment', 'value'=>$this->values['choicePayment'])).'
								</div>
							</div>
						</div>

						<div class="formPage formPage-payment">
							<div class="formPageIns">
								<div class="formPageInfo">
									<div class="formPageInfoTitle">Finalmente debemos confirmar que usted no es un robot.</div>
								</div>
								<div class="formField formField-captcha">
									<div class="captcha">
										'.$captchaError.'
										<div class="g-recaptcha" data-sitekey="'.CAPTCHA_SITE_KEY.'" id="google-captcha"></div>
									</div>
								</div>
								<div class="formPageDisclaimer">
									<p>Antes de proceder le recomendamos leer nuestros <a href="'.url('terminos-condiciones').'" target="_blank">Términos y Condiciones de Uso</a>.</p>
									<p>Para cualquier información adicional puede contactarse con <a href="http://www.plasticwebs.com/contacto" target="_blank">Plasticwebs</a>.</p>
								</div>
							</div>
						</div>

					</div>
					<div class="formButtons">
						<div class="formButtonsIns">
							<div class="formButton formButtonPrev">
								<div class="formButtonIns">
									<i class="icon icon-arrow-left"></i>
									<span>Atrás</span>
								</div>
							</div>
							<div class="formButton formButtonNext">
								<div class="formButtonIns">
									<span>Siguiente</span>
									<i class="icon icon-arrow-right"></i>
								</div>
							</div>
						</div>
					</div>';
		return '<div class="formPagesWrapper">
					'.Form::createForm($fields, array('submit'=>__('send'), 'class'=>'formSimple formPlaceEdit" autocomplete="off', 'id'=>'formPlaceEdit')).'
				</div>';
	}

	public function createPublicUpdate() {
		$this->values['choicePromotion'] = (isset($this->values['choicePromotion'])) ? $this->values['choicePromotion'] : 'promoted';
		$this->values['choicePayment'] = (isset($this->values['choicePayment'])) ? $this->values['choicePayment'] : 'paypal';
		$captchaError = (isset($this->errors['captcha'])) ? '<div class="error">'.$this->errors['captcha'].'</div>' : '';
		$fields = '<div class="formPages" data-url="'.url('tag-autocomplete').'">
						'.$this->field('idPlaceEdit').'
						'.$this->field('title').'
						<div class="formFields2">
							'.$this->field('email', ['class'=>'formIcon formIcon-email']).'
							'.$this->field('telephone', ['class'=>'formIcon formIcon-telephone']).'
						</div>
						<div class="formFields2">
							'.$this->field('mobile', ['class'=>'formIcon formIcon-mobile']).'
							'.$this->field('whatsapp', ['class'=>'formIcon formIcon-whatsapp']).'
						</div>
						<div class="formFields2">
							'.$this->field('web', ['class'=>'formIcon formIcon-globe']).'
						</div>
						<div class="formFields2">
							'.$this->field('facebook', ['class'=>'formIcon formIcon-facebook']).'
							'.$this->field('twitter', ['class'=>'formIcon formIcon-twitter']).'
						</div>
						<div class="formFields2">
							'.$this->field('instagram', ['class'=>'formIcon formIcon-instagram']).'
							'.$this->field('youtube', ['class'=>'formIcon formIcon-youtube']).'
						</div>
						'.$this->field('address', ['required'=>true]).'
						<div class="triggerCityWrapper">
							<div class="triggerCitySelect">
								'.$this->field('city').'
								<div class="triggerCity">
									'.__('cityDoesNotAppear').'
								</div>
							</div>
							<div class="triggerCityInfo">
								'.FormField_Text::create(['name'=>'cityOther', 'label'=>'city']).'
							</div>
						</div>
						'.$this->field('shortDescription', ['required'=>true]).'
						'.$this->field('idTag').'
						'.$this->field('description').'
						<div class="uploadLogo">
							<div class="uploadLogoMessage"></div>
							<div class="uploadLogoIns">'.$this->field('image').'</div>
							<div class="uploadLogoImage"></div>
						</div>
						<div class="formFields2">
							'.$this->field('nameEditor', ['class'=>'formIcon formIcon-email']).'
							'.$this->field('emailEditor', ['class'=>'formIcon formIcon-email']).'
						</div>
						'.FormField_Hidden::create(array('name'=>'choicePromotion', 'value'=>$this->values['choicePromotion'])).'
						'.FormField_Hidden::create(array('name'=>'choicePayment', 'value'=>$this->values['choicePayment'])).'
						<div class="formField formField-captcha">
							<div class="captcha">
								'.$captchaError.'
								<div class="g-recaptcha" data-sitekey="'.CAPTCHA_SITE_KEY.'" id="google-captcha"></div>
							</div>
						</div>
						<div class="formPageDisclaimer">
							<p>Antes de proceder le recomendamos leer nuestros <a href="'.url('terminos-condiciones').'" target="_blank">Términos y Condiciones de Uso</a>.</p>
							<p>Para cualquier información adicional puede contactarse con <a href="http://www.plasticwebs.com/contacto" target="_blank">Plasticwebs</a>.</p>
						</div>

					</div>';
		return '<div class="formPagesWrapper formPagesWrapperSimple">
					'.Form::createForm($fields, array('submit'=>__('send'), 'class'=>'formSimple formPlaceEdit" autocomplete="off')).'
				</div>';
	}

	public function createPublicAdmin() {
		$this->values['choicePromotion'] = (isset($this->values['choicePromotion'])) ? $this->values['choicePromotion'] : 'promoted';
		$this->values['choicePayment'] = (isset($this->values['choicePayment'])) ? $this->values['choicePayment'] : 'paypal';
		$fields = '<div class="formPages" data-url="'.url('tag-autocomplete').'">
						'.$this->field('idPlaceEdit').'
						'.$this->field('idPlace').'
						'.$this->field('title').'
						<div class="formFields2">
							'.$this->field('email', ['class'=>'formIcon formIcon-email']).'
							'.$this->field('telephone', ['class'=>'formIcon formIcon-telephone']).'
						</div>
						<div class="formFields2">
							'.$this->field('mobile', ['class'=>'formIcon formIcon-mobile']).'
							'.$this->field('whatsapp', ['class'=>'formIcon formIcon-whatsapp']).'
						</div>
						<div class="formFields2">
							'.$this->field('web', ['class'=>'formIcon formIcon-globe']).'
						</div>
						<div class="formFields2">
							'.$this->field('facebook', ['class'=>'formIcon formIcon-facebook']).'
							'.$this->field('twitter', ['class'=>'formIcon formIcon-twitter']).'
						</div>
						<div class="formFields2">
							'.$this->field('instagram', ['class'=>'formIcon formIcon-instagram']).'
							'.$this->field('youtube', ['class'=>'formIcon formIcon-youtube']).'
						</div>
						'.$this->field('address', ['required'=>true]).'
						<div class="triggerCityWrapper">
							<div class="triggerCitySelect">
								'.$this->field('city').'
								<div class="triggerCity">
									'.__('cityDoesNotAppear').'
								</div>
							</div>
							<div class="triggerCityInfo">
								'.FormField_Text::create(['name'=>'cityOther', 'label'=>'city']).'
							</div>
						</div>
						'.$this->field('shortDescription', ['required'=>true]).'
						'.$this->field('idTag').'
						'.$this->field('description').'
						<div class="uploadLogo">
							<div class="uploadLogoMessage"></div>
							<div class="uploadLogoIns">'.$this->field('image').'</div>
							<div class="uploadLogoImage"></div>
						</div>
						<div class="formFields2">
							'.$this->field('nameEditor', ['class'=>'formIcon formIcon-email']).'
							'.$this->field('emailEditor', ['class'=>'formIcon formIcon-email']).'
						</div>
						'.FormField_Hidden::create(array('name'=>'choicePromotion', 'value'=>$this->values['choicePromotion'])).'
						'.FormField_Hidden::create(array('name'=>'choicePayment', 'value'=>$this->values['choicePayment'])).'
					</div>';
		$form = Form::createForm($fields, array('submit'=>'Actualizar', 'class'=>'formPublic formPlaceEdit'));
		return '<div class="formPagesWrapper formPagesWrapperSimple">
					'.Form::createForm($fields, array('submit'=>__('send'), 'class'=>'formSimple formPlaceEdit" autocomplete="off')).'
					<div class="btnPublish">
						<a href="'.url('lugar-editar-publicar/'.PlaceEdit::encodeIdSimple($this->object->id())).'">Publicar la empresa</a>
						* Esta accion es irreversible.
					</div>
				</div>';
	}

}
?>