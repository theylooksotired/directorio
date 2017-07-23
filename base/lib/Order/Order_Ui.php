<?php
/**
* @class OrderUi
*
* This class manages the UI for the Order objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Order_Ui extends Ui{

	public function renderPublic($options=array()) {
		$service = Service::read($this->object->get('idService'));
		$serviceCategory = ServiceCategory::read($service->get('idServiceCategory'));
		if ($this->object->get('payed')!='1') {
			$payedLabel = '<div class="orderNotPayedLabel">
								<a href="'.url('servicios/deposito/').'">'.__('orderNotPayed').'</a>
							</div>';
			$payedClass = 'orderNotPayed';
		} else {
			$payedLabel = '';
			$payedClass = '';
		}
		return '<div class="order '.$payedClass.'">
					<div class="orderLeft">
						<h2><strong>'.$serviceCategory->getBasicInfo().'</strong> '.$this->object->get('service').'</h2>
						<p>'.$this->object->get('message').'</p>
						<div class="orderDate">
							'.__('createdOn').'
							'.Date::sqlText($this->object->get('created'), true).'
						</div>
						'.$payedLabel.'
					</div>
					<div class="orderRight">
						<div class="serviceCostMoney">
							'.Text::money($this->object->get('price')).'
							<span>$USD <em>('.__('americanDollars').')</em></span>
						</div>
					</div>
				</div>';
	}

}
?>