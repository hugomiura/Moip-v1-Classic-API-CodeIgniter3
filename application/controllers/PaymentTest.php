<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentTest extends CI_Controller {

	private $moip_key;
	private $moip_token;

	public function __construct() {

		parent::__construct();

		$this->config->load('moip');
		$this->load->library('payment_gateway');

		$this->moip_key = $this->config->item('moipKey');
		$this->moip_token = $this->config->item('moipToken');

		header('Content-type: Application/json'); // Just to make print_r readable

	}


	public function exampleBasicInstructions() {
	    $moip = new Moip();
	    $moip->setEnvironment('test');
	    $moip->setCredential(array(
	        'key' => $this->moip_key,
	        'token' => $this->moip_token
	    ));

	    $moip->setUniqueID(false);
	    $moip->setValue('100.00');
	    $moip->setReason('Payment of order #0001');

	    $moip->validate('Basic');

	    $moip->send();
	    print_r($moip->getAnswer());
	    //print_r($moip->getXML());
	}

	public function exampleIdentificationInstruction() {

	    $moip = new Moip();
	    $moip->setEnvironment('test');
	    $moip->setCredential(array('key' => $this->moip_key, 'token' => $this->moip_token));

	    $moip->setUniqueID(false);
	    $moip->setValue('100.00');
	    $moip->setReason('Payment of order #0001');

	    $moip->setPayer(array('name' => 'John Doe',
	        'email' => 'user@user-email.test.net',
	        'payerId' => 'user_id',
	        'billingAddress' => array('address' => 'My Street',
	            'number' => '1',
	            'complement' => 'apto 1',
	            'city' => 'My City',
	            'neighborhood' => 'My Neighborhood',
	            'state' => 'AA',
	            'country' => 'BRA',
	            'zipCode' => '00000-000',
	            'phone' => '(00)8888-8888')));
	    $moip->validate('Identification');

	    print_r($moip->send());
	}

	public function exampleQueryParcels() {

	    $moip = new Moip();
	    $moip->setEnvironment('test');
	    $moip->setCredential(array('key' => $this->moip_key, 'token' => $this->moip_token));

	    print_r($moip->queryParcel('shop@my-sale-site.test.net', '4', '1.99', '100.00'));
	}

	public function exampleAddParcel($example='1') {

	    $moip = new Moip();
	    $moip->setEnvironment('test');
	    $moip->setCredential(array('key' => $this->moip_key, 'token' => $this->moip_token));
	    $moip->setUniqueID(false);
	    $moip->setValue('100.00');
	    $moip->setReason('Payment of order #0001');

	    $moip->setPayer(array('name' => 'John Doe',
	        'email' => 'user@user-email.test.net',
	        'payerId' => 'user_id',
	        'billingAddress' => array('address' => 'My Street',
	            'number' => '1',
	            'complement' => 'apto 1',
	            'city' => 'My City',
	            'neighborhood' => 'My Neighborhood',
	            'state' => 'AA',
	            'country' => 'BRA',
	            'zipCode' => '00000-000',
	            'phone' => '(00)8888-8888')));
	    $moip->validate('Identification');

	    if ($example == '1')
	        $moip->addParcel('2', '12');
	    else if ($example == '2')
	        $moip->addParcel('2', '12', '1.99');
	    else if ($example == '3')
	        $moip->addParcel('2', '12', null, true);
	    else if ($example == '4') {
	        $moip->addParcel('2', '4');
	        $moip->addParcel('5', '7', '1.00');
	        $moip->addParcel('8', '12', null, true);
	    }

	    print_r($moip->send());
	}

	public function exampleAddComission($example='1') {
	    $moip = new Moip();
	    $moip->setEnvironment('test');
	    $moip->setCredential(array('key' => $this->moip_key, 'token' => $this->moip_token));
	    $moip->setUniqueID(false);
	    $moip->setValue('100.00');
	    $moip->setReason('Payment of order #0001');

	    $moip->setPayer(array('name' => 'John Doe',
	        'email' => 'user@user-email.test.net',
	        'payerId' => 'user_id',
	        'billingAddress' => array('address' => 'My Street',
	            'number' => '1',
	            'complement' => 'apto 1',
	            'city' => 'My City',
	            'neighborhood' => 'My Neighborhood',
	            'state' => 'AA',
	            'country' => 'BRA',
	            'zipCode' => '00000-000',
	            'phone' => '(00)8888-8888')));
	    $moip->validate('Identification');

	    if ($example == '1')
	        $moip->addComission('Sales Comission', 'salesman@my-sale-site.test.net', '12.00');
	    else if ($example == '2')
	        $moip->addComission('Sales Comission', 'salesman2@my-sale-site.test.net', '12.00', true);
	    else if ($example == '3')
	        $moip->addComission('Sales Comission', 'salesman3@my-sale-site.test.net', '12.00', true, 'salesman3@my-sale-site.test.net');
	    else if ($example == '4') {
	        $moip->addComission('Sales Comission', 'salesman@my-sale-site.test.net', '5.00');
	        $moip->addComission('Sales Comission', 'salesman2@my-sale-site.test.net', '2.00', true);
	        $moip->addComission('Sales Comission', 'salesman3@my-sale-site.test.net', '12.00', true, 'salesman3@my-sale-site.test.net');
	    }

	    print_r($moip->send());
	}

	public function exampleSetReceiver() {
	    $moip = new Moip();
	    $moip->setEnvironment('test');
	    $moip->setCredential(array('key' => $this->moip_key, 'token' => $this->moip_token));

	    $moip->setUniqueID(false);
	    $moip->setValue('100.00');
	    $moip->setReason('Payment of order #0001');

	    $moip->setPayer(array('name' => 'John Doe',
	        'email' => 'user@user-email.test.net',
	        'payerId' => 'user_id',
	        'billingAddress' => array('address' => 'My Street',
	            'number' => '1',
	            'complement' => 'apto 1',
	            'city' => 'My City',
	            'neighborhood' => 'My Neighborhood',
	            'state' => 'AA',
	            'country' => 'BRA',
	            'zipCode' => '00000-000',
	            'phone' => '(00)8888-8888')));
	    $moip->validate('Identification');

	    $moip->setReceiver('shop@my-sale-site.test.net');

	    print_r($moip->send());
	}

	public function exampleConfigPaymentWay($param) {
	    $moip = new Moip();
	    $moip->setEnvironment('test');
	    $moip->setCredential(array('key' => $this->moip_key, 'token' => $this->moip_token));

	    $moip->setUniqueID(false);
	    $moip->setValue('100.00');
	    $moip->setReason('Payment of order #0001');

	    $moip->setPayer(array('name' => 'John Doe',
	        'email' => 'user@user-email.test.net',
	        'payerId' => 'user_id',
	        'billingAddress' => array('address' => 'My Street',
	            'number' => '1',
	            'complement' => 'apto 1',
	            'city' => 'My City',
	            'neighborhood' => 'My Neighborhood',
	            'state' => 'AA',
	            'country' => 'BRA',
	            'zipCode' => '00000-000',
	            'phone' => '(00)8888-8888')));
	    $moip->validate('Identification');

	    $moip->addPaymentWay('creditCard');
	    $moip->addPaymentWay('billet');
	    $moip->setBilletConf("2011-04-06", true, array("First Line", "Second Line", "Third Line"), "http://www.my-sale-site.test.net/img/logo.png");

	    print_r($moip->send());
	}

	public function exampleFull() {

	    $moip = new Moip();
	    $moip->setEnvironment('test');
	    $moip->setCredential(array('key' => $this->moip_key, 'token' => $this->moip_token));
	    $moip->setUniqueID(false);
	    $moip->setValue('100.00');
	    $moip->setReason('Payment of order #0001');

	    $moip->setPayer(array('name' => 'John Doe',
	        'email' => 'user@user-email.test.net',
	        'payerId' => 'user_id',
	        'billingAddress' => array('address' => 'My Street',
	            'number' => '1',
	            'complement' => 'apto 1',
	            'city' => 'My City',
	            'neighborhood' => 'My Neighborhood',
	            'state' => 'AA',
	            'country' => 'BRA',
	            'zipCode' => '00000-000',
	            'phone' => '(00)8888-8888')));
	    $moip->validate('Identification');

	    $moip->setReceiver('shop@my-sale-site.test.net');

	    $moip->addParcel('2', '4');
	    $moip->addParcel('5', '7', '1.00');
	    $moip->addParcel('8', '12', null, true);

	    $moip->addComission('Sales Comission', 'salesman1@my-sale-site.test.net', '5.00');
	    $moip->addComission('Sales Comission', 'salesman2@my-sale-site.test.net', '2.00', true);
	    $moip->addComission('Sales Comission', 'salesman3@my-sale-site.test.net', '12.00', true, 'shop@my-sale-site.test.net');

	    $moip->addPaymentWay('creditCard');
	    //$moip->addPaymentWay('billet');
	    $moip->addPaymentWay('financing');
	    $moip->addPaymentWay('debit');
	    $moip->addPaymentWay('debitCard');
	    $moip->setBilletConf("2017-02-01", true, array("First Line", "Second Line", "Third Line"), "http://www.my-sale-site.test.net/img/logo.png");

	    print_r($moip->getXML());
	    echo '

	    ============================================================

	    ';
	    $moip->send();
	    print_r($moip->getAnswer());
	}



}
