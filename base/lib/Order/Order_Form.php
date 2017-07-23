<?php
/**
* @class OrderForm
*
* This class manages the forms for the Order objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Order_Form extends Form{

	public function createPublic() {
		$fields = $this->field('name').'
				'.$this->field('email');
		return Form::createForm($fields, array('submit'=>'Pague con PayPal', 'class'=>'formPublic formOrder'));
	}

}
?>