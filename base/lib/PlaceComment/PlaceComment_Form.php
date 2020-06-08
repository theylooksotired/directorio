<?php
/**
* @class PlaceCommentForm
*
* This class manages the forms for the PlaceComment objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class PlaceComment_Form extends Form {

	/**
	* Render the public form.
	*/
	public function createPublic() {
		$captchaError = (isset($this->errors['captcha'])) ? '<div class="error">'.$this->errors['captcha'].'</div>' : '';
		$rating = (isset($this->values['rating'])) ? intval($this->values['rating']) : 0;
		$fields = '<div class="formPages">
						<div class="ratingAllWrapper">
							'.$this->field('rating').'
							'.PlaceComment_Ui::renderRating($rating).'
						</div>
						'.$this->field('comment').'
						<div class="formField formField-captcha">
							<div class="captcha">
								'.$captchaError.'
								<div class="g-recaptcha" data-sitekey="'.CAPTCHA_SITE_KEY.'" id="google-captcha"></div>
							</div>
						</div>
					</div>';
		return '<div class="formPagesWrapper formPagesWrapperSimple">
					'.Form::createForm($fields, array('class'=>'formSimple formPlaceComment')).'
				</div>';
	}

}
?>