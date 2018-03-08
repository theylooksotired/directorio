<?php
class Khipu {

	static public function checkoutRequestUrl($options=array()) {
		require BASE_FILE.'helpers/khipu/autoload.php';
		$options = Khipu::formatOptions($options);
		$config = new Khipu\Configuration();
		$config->setSecret(KHIPU_SECRET);
		$config->setReceiverId(KHIPU_RECEIVER);
		$config->setDebug(KHIPU_DEBUG);
		$client = new Khipu\ApiClient($config);
		$expiration = new DateTime();
		$expiration->modify('+1 month');
		$khipu = new Khipu\Client\PaymentsApi($client);
		try {
		    $optionsKhipu = array(
		    	"transaction_id" => $options['item_number'],
		        "return_url" => $options['return_url'],
		        "cancel_url" => $options['cancel_url'],
		        "notify_url" => $options['notify_url'],
		        "notify_api_version" => "1.3",
		        "expires_date" => $expiration,
		    	"body" => $options['item_name']
		    );
		    $response = $khipu->paymentsPost($options['item_name'], $options['currency_code'], $options['item_amount'], $optionsKhipu);
		    $paymentId = $khipu->paymentsIdGet($response->getPaymentId());
		    return $paymentId['payment_url'];
		} catch(Exception $e) {
		    echo $e->getMessage();
		}
	}

	static public function formatOptions($options=array()) {
		$options['item_name'] = (isset($options['item_name'])) ? $options['item_name'] : Parms::param('titlePage');
		$options['item_number'] = (isset($options['item_number'])) ? $options['item_number'] : '1';
		$options['item_amount'] = (isset($options['item_amount'])) ? $options['item_amount'] : '1.00';
		$options['currency_code'] = (isset($options['currency_code'])) ? $options['currency_code'] : 'USD';
		$options['cancel_return'] = (isset($options['cancel_return'])) ? $options['cancel_return'] : url('');
		$options['return'] = (isset($options['return'])) ? $options['return'] : url('');
		return $options;
	}

	static public function notificated() {
		require BASE_FILE.'helpers/khipu/autoload.php';
        $api_version = (isset($_REQUEST['api_version'])) ? $_REQUEST['api_version'] : '';
        $notification_token = (isset($_REQUEST['notification_token'])) ? $_REQUEST['notification_token'] : '';
        try {
            if ($api_version == '1.3') {
                $configuration = new Khipu\Configuration();
                $configuration->setSecret(KHIPU_SECRET);
				$configuration->setReceiverId(KHIPU_RECEIVER);
				$configuration->setDebug(KHIPU_DEBUG);
                $client = new Khipu\ApiClient($configuration);
                $payments = new Khipu\Client\PaymentsApi($client);
                $response = $payments->paymentsGet($notification_token);
                if ($response->getReceiverId() == KHIPU_RECEIVER) {
                    if ($response->getStatus() == 'done') {
                    	return true;
                    }
                }
            }
        } catch (\Khipu\ApiException $exception) {
        	return false;
        }
        return false;
	}

}
?>