<?php
class Ecomwise_B2BCheckout_Model_Checkout_Type_Onepage extends Mage_Checkout_Model_Type_Onepage {
	
	/**
	 * Specify quote shipping method
	 *
	 * @param   string $shippingMethod
	 * @return  array
	 */
	public function saveShippingMethod($shippingMethod)
	{
		if (empty($shippingMethod)) {
			
			$groups = Mage::getStoreConfig('b2bcheckout/parameters/groups');
			$customerGroup = Mage::helper('customer')->getCustomer()->getGroupId();
				
			if(((Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled') && in_array($customerGroup,explode(',',$groups))) || !Mage::getSingleton('customer/session')->isLoggedIn() || !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')) && Mage::getStoreConfig('b2bcheckout/parameters/enabled')){
				$codes = Mage::helper('ecomwiseskipsm');				
				$shippingMethod = $codes->getRateCode(Mage::getStoreConfig('b2bcheckout/parameters/shipping_methods'));
				//$shippingMethod = 'flatrate_flatrate'; // Custome code
			}else{
				return array('error' => -1, 'message' => Mage::helper('checkout')->__('Invalid shipping method.'));
			}					
		}
		$rate = $this->getQuote()->getShippingAddress()->getShippingRateByCode($shippingMethod);
		if (!$rate) {
			return array('error' => -1, 'message' => Mage::helper('checkout')->__('Invalid shipping method.'));
		}
		$this->getQuote()->getShippingAddress()
		->setShippingMethod($shippingMethod);
	
		$this->getCheckout()
		->setStepData('shipping_method', 'complete', true)
		->setStepData('payment', 'allow', true)
		;
	
		return array();
	}
	
	/**
	 * Specify quote payment method
	 *
	 * @param   array $data
	 * @return  array
	 */
	public function savePayment($data)
	{		
		if (empty($data)) {			
			
			$groups = Mage::getStoreConfig('b2bcheckout/parameters/groups');
			$customerGroup = Mage::helper('customer')->getCustomer()->getGroupId();
			
			if(((Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled') && in_array($customerGroup,explode(',',$groups))) || !Mage::getSingleton('customer/session')->isLoggedIn() || !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')) && Mage::getStoreConfig('b2bcheckout/parameters/enabled') && Mage::helper('customer')->isLoggedIn()			){
				$data = array( 'method' => 'checkmo' );	// Custome code
			}else{
				return array('error' => -1, 'message' => Mage::helper('checkout')->__('Invalid data.'));
			}
		}
		$quote = $this->getQuote();
		if ($quote->isVirtual()) {
			$quote->getBillingAddress()->setPaymentMethod(isset($data['method']) ? $data['method'] : null);
		} else {
			$quote->getShippingAddress()->setPaymentMethod(isset($data['method']) ? $data['method'] : null);
			
			if(((Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled') && in_array($customerGroup,explode(',',$groups))) || !Mage::getSingleton('customer/session')->isLoggedIn() || !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')) && Mage::getStoreConfig('b2bcheckout/parameters/enabled') && Mage::helper('customer')->isLoggedIn()			){
				$codes = Mage::helper('ecomwiseskipsm');
				$shippingMethod = $codes->getRateCode(Mage::getStoreConfig('b2bcheckout/parameters/shipping_methods'));
				$this->getQuote()->getShippingAddress()->setShippingMethod($shippingMethod);
			}			
		}
	
		// shipping totals may be affected by payment method
		if (!$quote->isVirtual() && $quote->getShippingAddress()) {
			$quote->getShippingAddress()->setCollectShippingRates(true);
		}
	
		$payment = $quote->getPayment();
		$payment->importData($data);
	
		$quote->save();
	
		$this->getCheckout()
		->setStepData('payment', 'complete', true)
		->setStepData('review', 'allow', true);
	
		return array();
	}
	
}