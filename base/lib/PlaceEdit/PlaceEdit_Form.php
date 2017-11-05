<?php
class PlaceEdit_Form extends Form{

	public function createPublic($place='') {
		$form = (is_object($place)) ? Place_Form::newObject($place) : $this;
		$paymentsAccepted = explode(':', PAYMENTS_ACCEPTED);
		$this->values['choicePromotion'] = (isset($this->values['choicePromotion'])) ? $this->values['choicePromotion'] : 'promoted';
		$this->values['choicePayment'] = (isset($this->values['choicePayment'])) ? $this->values['choicePayment'] : $paymentsAccepted[0];
		$captchaError = (isset($this->errors['captcha'])) ? '<div class="error">'.$this->errors['captcha'].'</div>' : '';
		$fields = '<div class="formFieldsWrapper">
						<div class="formFields">
							<h2>Datos sobre usted</h2>
							<div class="formFieldsIns">
								<div class="formFields2">
									'.$this->field('nameEditor').'
									'.$this->field('emailEditor').'
								</div>
							</div>
						</div>
						<div class="formFields">
							<h2>Datos sobre su empresa</h2>
							<div class="formFieldsIns">
								'.$form->field('title').'
								<div class="formFields2">
									'.$form->field('address').'
									'.$form->field('city').'
								</div>
								<div class="formFields3">
									'.$form->field('telephone').'
									'.$form->field('web').'
									'.$form->field('email').'
								</div>
								'.$form->field('shortDescription').'
								'.$form->field('description').'
								'.$form->field('idTag').'
								'.$this->field('idPlaceEdit').'
							</div>
						</div>
						<a name="continuar"></a>
						<div class="formFieldsPromotion">
							'.FormField_Radio::create(array('name'=>'choicePromotion', 
											'class'=>'choicePromotion',
											'selected'=>$this->values['choicePromotion'],
											'value'=>array(
												'not-promoted'=>'Deseo inscribir a mi empresa de forma gratuita.', 

												'promoted'=>'<strong>Deseo promocionar a mi empresa por 10$USD (dólares americanos) anuales.</strong>
												Aparecerá en los primeros lugares de las búsquedas y podré adjuntar el logo de la misma.'
												))).'
							<div class="formFieldsPromotionLink">
								<a href="'.url('promocion').'" target="_blank">
									<span>Ver todas las ventajas</span>
									<i class="icon icon-arrow-right"></i>
								</a>
							</div>
						</div>
						<div class="formFields formFieldsPromoted">
							<h2>Estilo de la empresa</h2>
							<div class="formFieldsIns">
								<div class="formFields2">
									'.$form->field('image').'
									'.$form->field('colorBackground').'
								</div>
							</div>
						</div>
						<div class="formFields formFieldsPromoted">
							<h2>Forma de pago</h2>
							<div class="formFieldsIns">
								'.FormField_Radio::create(array('name'=>'choicePayment', 
								'class'=>'choicePayment',
								'selected'=>$this->values['choicePayment'],
								'value'=>array(
									'khipu'=>'<strong>Tarjeta de crédito o débito</strong>
									<span>El pago se realizará mediante el servicio de pagos en línea <a href="https://www.khipu.com" target="_blank">Khipu</a></span>', 

									'paypal'=>'<strong>PayPal</strong>
									<span>El pago se realizará mediante el servicio de pagos en línea <a href="https://www.paypal.com" target="_blank">PayPal</a></span>', 

									'transference'=>'<strong>Transferencia bancaria o giro postal</strong>
									<span>'.HtmlSection::showFileSimple('transfer').'</span>'
									))).'
							</div>
						</div>
						<div class="formField">
							<div class="captcha">
								'.$captchaError.'
								<div class="g-recaptcha" data-sitekey="'.CAPTCHA_SITE_KEY.'" id="google-captcha"></div>
							</div>
						</div>
					</div>';
		return Form::createForm($fields, array('submit'=>'Guardar', 'class'=>'formPublic formPlaceEdit')).'
				'.HtmlSection::showFile('inscribirBottom');
	}

	public function createPublicPromote($place='') {
		$form = (is_object($place)) ? Place_Form::newObject($place) : $this;
		$captchaError = (isset($this->errors['captcha'])) ? '<div class="error">'.$this->errors['captcha'].'</div>' : '';
		$fields = '<div class="formFieldsWrapper">
						<div class="formFields">
							<h2>Datos sobre usted</h2>
							<div class="formFieldsIns">
								<div class="formFields2">
									'.$this->field('nameEditor').'
									'.$this->field('emailEditor').'
								</div>
							</div>
						</div>
						<div class="formFields">
							<h2>Estilo de la empresa</h2>
							<div class="formFieldsIns">
								<div class="formFields2">
									'.$form->field('image').'
									'.$form->field('colorBackground').'
								</div>
							</div>
						</div>
						<div class="formFields">
							<h2>Actualice los datos de su empresa</h2>
							<div class="formFieldsIns">
								'.$form->field('title').'
								<div class="formFields2">
									'.$form->field('address').'
									'.$form->field('city').'
								</div>
								<div class="formFields3">
									'.$form->field('telephone').'
									'.$form->field('web').'
									'.$form->field('email').'
								</div>
								'.$form->field('shortDescription').'
								'.$form->field('description').'
								'.$form->field('idTag').'
								'.$this->field('idPlaceEdit').'
							</div>
						</div>
						<div class="formFieldsPromotedMessage message messageInfo">
							<p><i class="icon icon-paypal"></i></p>
							<p>El pago de los 10$USD (dólares americanos) se realiza mediante <a href="http://www.paypal.com" target="_blank">PayPal</a>. Antes de proceder le recomendamos leer nuestros <a href="'.url('terminos-condiciones').'" target="_blank">Términos y Condiciones de Uso</a>.</p>
							<p>Para cualquier información adicional puede contactarse con <a href="http://www.plasticwebs.com/contacto" target="_blank">Plasticwebs</a>.</p>
						</div>
						<div class="formField">
							<div class="captcha">
								'.$captchaError.'
								<div class="g-recaptcha" data-sitekey="'.CAPTCHA_SITE_KEY.'" id="google-captcha"></div>
							</div>
						</div>
					</div>';
		return Form::createForm($fields, array('submit'=>'Guardar', 'class'=>'formPublic formPlaceEdit'));
	}

	public function createPublicPromoted($place='') {
		$form = (is_object($place)) ? Place_Form::newObject($place) : $this;
		$captchaError = (isset($this->errors['captcha'])) ? '<div class="error">'.$this->errors['captcha'].'</div>' : '';
		$fields = '<div class="formFieldsWrapper">
						<div class="formFields">
							<h2>Datos sobre usted</h2>
							<div class="formFieldsIns">
								<div class="formFields2">
									'.$form->field('nameEditor').'
									'.$form->field('emailEditor').'
								</div>
							</div>
						</div>
						<div class="formFields">
							<h2>Datos sobre su empresa</h2>
							<div class="formFieldsIns">
								'.$form->field('title').'
								<div class="formFields2">
									'.$form->field('address').'
									'.$form->field('city').'
								</div>
								<div class="formFields3">
									'.$form->field('telephone').'
									'.$form->field('web').'
									'.$form->field('email').'
								</div>
								'.$form->field('shortDescription').'
								'.$form->field('description').'
								'.$form->field('idTag').'
								'.$this->field('idPlaceEdit').'
							</div>
						</div>
						<div class="formFields">
							<h2>Estilo de la empresa</h2>
							<div class="formFieldsIns">
								<div class="formFields2">
									'.$form->field('image').'
									'.$form->field('colorBackground').'
								</div>
							</div>
						</div>
						<div class="formField">
							<div class="captcha">
								'.$captchaError.'
								<div class="g-recaptcha" data-sitekey="'.CAPTCHA_SITE_KEY.'" id="google-captcha"></div>
							</div>
						</div>
					</div>';
		return Form::createForm($fields, array('submit'=>'Guardar', 'class'=>'formPublic formPlaceEdit'));
	}

	public function createFormFieldsPublicAdmin() {
		return '<div class="formFieldsWrapper">
					<div class="formFields">
						<h2>Datos sobre la persona</h2>
						<div class="formFieldsIns">
							<div class="formFields2">
								'.$this->field('nameEditor').'
								'.$this->field('emailEditor').'
							</div>
						</div>
					</div>
					<div class="formFields">
						<h2>Datos sobre la empresa</h2>
						<div class="formFieldsIns">
							'.$this->field('title').'
							<div class="formFields2">
								'.$this->field('address').'
								'.$this->field('city').'
							</div>
							<div class="formFields3">
								'.$this->field('telephone').'
								'.$this->field('web').'
								'.$this->field('email').'
							</div>
							'.$this->field('shortDescription').'
							'.$this->field('description').'
							'.$this->field('idTag').'
							'.$this->field('idPlace').'
							'.$this->field('idPlaceEdit').'
						</div>
					</div>
					<div class="formFields">
						<h2>Promoción</h2>
						<div class="formFieldsIns">
							<div class="formFields2">
								'.$this->field('image').'
								'.$this->field('colorBackground').'
							</div>
						</div>
					</div>
				</div>';
	}

	public function createFormFieldsPublicAdminPlace($place) {
		$place->loadTags();
		return '<div class="formFieldsWrapper">
					<div class="formFields">
						<h2>Datos sobre la persona</h2>
						<div class="formFieldsIns">
							<div class="formFields2">
								'.$this->field('nameEditor').'
								'.$this->field('emailEditor').'
							</div>
							<div class="formFields2">
								<div class="formField formFieldOld">'.$place->get('nameEditor').'</div>
								<div class="formField formFieldOld">'.$place->get('emailEditor').'</div>
							</div>
						</div>
					</div>
					<div class="formFields">
						<h2>Datos sobre la empresa</h2>
						<div class="formFieldsIns">
							'.$this->field('title').'
							<div class="formField formFieldOld">'.$place->get('title').'</div>
							<div class="formFields2">
								'.$this->field('address').'
								'.$this->field('city').'
							</div>
							<div class="formFields2">
								<div class="formField formFieldOld">'.$place->get('address').'</div>
								<div class="formField formFieldOld">'.$place->get('city').'</div>
							</div>
							<div class="formFields3">
								'.$this->field('telephone').'
								'.$this->field('web').'
								'.$this->field('email').'
							</div>
							<div class="formFields3">
								<div class="formField formFieldOld">'.$place->get('telephone').'</div>
								<div class="formField formFieldOld">'.$place->get('web').'</div>
								<div class="formField formFieldOld">'.$place->get('email').'</div>
							</div>
							'.$this->field('shortDescription').'
							<div class="formField formFieldOld">'.$place->get('shortDescription').'</div>
							'.$this->field('description').'
							<div class="formField formFieldOld">'.$place->get('description').'</div>
							'.$this->field('idTag').'
							<div class="formField formFieldOld">'.$place->tags->showList(array('function'=>'Simple')).'</div>
							'.$this->field('idPlace').'
							'.$this->field('idPlaceEdit').'
						</div>
					</div>
					<div class="formFields">
						<h2>Promoción</h2>
						<div class="formFieldsIns">
							<div class="formFields2">
								'.$this->field('image').'
								'.$this->field('colorBackground').'
							</div>
							<div class="formFields2">
								<div class="formField formFieldOld">'.$place->getImage('image', 'small').'</div>
								<div class="formField formFieldOld">
									'.$place->get('colorBackground').'
									<div style="width: 50px; height: 30px; background: '.$place->get('colorBackground').';"></div>
								</div>
							</div>
						</div>
					</div>
				</div>';
	}

	public function createPublicAdmin() {
		$place = Place::read($this->values['idPlace']);
		$form = Form::createForm($this->createFormFieldsPublicAdmin(), array('submit'=>'Actualizar', 'class'=>'formPublic formPlaceEdit'));
		if ($place->id()!='') {
			$form = Form::createForm($this->createFormFieldsPublicAdminPlace($place), array('submit'=>'Actualizar', 'class'=>'formPublic formPlaceEdit'));
			/*
			$form = '<div class="adminWrapper">
						<div class="adminItem adminItem2">
							<h2>Informacion original</h2>
							'.$place->showUi('Info').'
						</div>
						<div class="adminItem adminItem2">
							<h2>Informacion modificada</h2>
							'.$form.'
						</div>
					</div>';
			*/
		}
		return $form.'
				<div class="btnPublish">
					<a href="'.url('lugar-editar-publicar/'.PlaceEdit::encodeIdSimple($this->object->id())).'">Publicar la empresa</a>
					* Esta accion es irreversible.
				</div>';
	}
	
}
?>