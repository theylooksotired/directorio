<?php
class Place_Form extends Form{

	public function createFormFields($options=array()) {
		return '<div class="formWrapper">
					'.$this->field('idPlace').'
					'.$this->field('title').'
					'.$this->field('address').'
					<div class="formLine formLine2">
						'.$this->field('telephone').'
						'.$this->field('web').'
						'.$this->field('email').'
						'.$this->field('city').'
					</div>
					'.$this->field('shortDescription').'
					'.$this->field('description').'
					'.$this->field('idTag').'
					<div class="formLine formLine2">
						'.$this->field('nameEditor').'
						'.$this->field('emailEditor').'
					</div>
					<div class="formLine formLine2">
						'.$this->field('image').'
						'.$this->field('colorBackground').'
					</div>
					'.$this->field('promoted').'
				</div>';
	}

	public function createPublic() {
		return Form::createForm($this->createFormFields(), array('class'=>'formPublic'));
	}

}
?>