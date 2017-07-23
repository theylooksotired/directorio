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
		$fields = $this->createFormFields().'
				<div class="formField">
					<div class="captcha">
						'.$captchaError.'
						<div class="g-recaptcha" data-sitekey="'.CAPTCHA_SITE_KEY.'" id="google-captcha"></div>
					</div>
				</div>';
		return Form::createForm($fields, array('class'=>'formPublic formPlaceReport'));
	}

}
?>