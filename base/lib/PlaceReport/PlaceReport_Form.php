<?php
/**
* @class PlaceReportForm
*
* This class manages the forms for the PlaceReport objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class PlaceReport_Form extends Form {

	/**
	* Render the public form.
	*/
	public function createPublic() {
		$captchaError = (isset($this->errors['captcha'])) ? '<div class="error">'.$this->errors['captcha'].'</div>' : '';
		$fields = '<div class="formPages">
						'.$this->createFormFields().'
						<div class="formField formField-captcha">
							<div class="captcha">
								'.$captchaError.'
								<div class="g-recaptcha" data-sitekey="'.CAPTCHA_SITE_KEY.'" id="google-captcha"></div>
							</div>
						</div>
					</div>';
		return '<div class="formPagesWrapper formPagesWrapperSimple">
					'.Form::createForm($fields, array('class'=>'formSimple formPlaceReport')).'
				</div>';
	}

}
?>