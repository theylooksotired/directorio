<?php
/**
* @class Order
*
* This class defines the users in the administration system.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Order extends Db_Object {

	public function encodeId() {
		return Order::encodeIdSimple($this->id());
	}

	static public function encodeIdSimple($id) {
		return md5('plasticwebs_order_'.$id);
	}

	static public function readCoded($code) {
		return Order::readFirst(array('where'=>'MD5(CONCAT("plasticwebs_order_",idOrder))="'.$code.'"'));
	}

	public function paypalButton($options=array()) {
		return PayPal::checkoutButton($this->formatOptionsPaypal($options));
	}

	public function paypalRequest($options=array()) {
		header('Location: '.PayPal::checkoutRequestUrl($this->formatOptionsPaypal($options)));
		exit();
	}

	public function khipuRequest($options=array()) {
		header('Location: '.Khipu::checkoutRequestUrl($this->formatOptionsKhipu($options)));
		exit();
	}

	public function formatOptionsPaypal($options=array()) {
		$returnUrl = (isset($options['returnUrl']) && $options['returnUrl']!='') ? $options['returnUrl'] : url('paypal/pagado/'.md5('plasticwebs_pagado'.$this->id()));
		$cancelUrl = (isset($options['cancelUrl']) && $options['cancelUrl']!='') ? $options['cancelUrl'] : url('paypal/anulado/'.md5('plasticwebs_anulado'.$this->id()));
		return array('item_name' => $this->get('name'),
					'item_number' => $this->id(),
					'item_amount' => doubleval($this->get('price')),
					'currency_code' => 'USD',
					'cancel_return' => $cancelUrl,
					'return' => $returnUrl);
	}

	public function formatOptionsKhipu($options=array()) {
		$returnUrl = (isset($options['returnUrl']) && $options['returnUrl']!='') ? $options['returnUrl'] : url('khipu/pagado/'.md5('plasticwebs_pagado'.$this->id()));
		$cancelUrl = (isset($options['cancelUrl']) && $options['cancelUrl']!='') ? $options['cancelUrl'] : url('khipu/anulado/'.md5('plasticwebs_anulado'.$this->id()));
		$notifyUrl = (isset($options['notifyUrl']) && $options['notifyUrl']!='') ? $options['notifyUrl'] : url('khipu/notificado/'.md5('plasticwebs_notificado'.$this->id()));
		return array('item_name' => $this->get('name'),
					'item_number' => $this->id(),
					'item_amount' => ((KHIPU_CURRENCY=='USD') ? doubleval($this->get('price')) : doubleval($this->get('price') * 7)),
					'currency_code' => KHIPU_CURRENCY,
					'cancel_url' => $cancelUrl,
					'notify_url' => $notifyUrl,
					'return_url' => $returnUrl);
	}
}
?>