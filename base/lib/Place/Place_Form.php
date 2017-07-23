<?php
class Place_Form extends Form{

	public function createPublic() {
		return Form::createForm($this->createFormFields(), array('class'=>'formPublic'));
	}
	
}
?>