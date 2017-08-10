<?php
class Ecomwise_B2BCheckout_Block_Checkout_Onepage extends Mage_Checkout_Block_Onepage {
	
	
	/**
	 * Get 'one step checkout' step data
	 *
	 * @return array
	 */
	public function getSteps()
	{
		$steps = array();		
		
		$groups = Mage::getStoreConfig('b2bcheckout/parameters/groups');
		//$customerGroup = Mage::helper('customer')->getCustomer()->getGroupId();
		$customerGroup = Mage::helper('ecomwiseskipsm')->getGroupId();
		
			
		/* if(	((Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled') && in_array($customerGroup,explode(',',$groups))) 
				|| !Mage::getSingleton('customer/session')->isLoggedIn() 
				|| !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled'))
				&& Mage::getStoreConfig('b2bcheckout/parameters/enabled')){	 */

		if(Mage::getStoreConfig('b2bcheckout/parameters/enabled') 
				&& (( Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')  && in_array($customerGroup,explode(',',$groups)))
						|| !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')
				) && $this->isCustomerLoggedIn()
		){
			
			
			$stepCodes = array('login', 'billing', 'shipping');			
			if(!Mage::getStoreConfig('b2bcheckout/parameters/skip_shipping')){
				$stepCodes[] = 'shipping_method';
			}			
			if(!Mage::getStoreConfig('b2bcheckout/parameters/skip_payment')){
				$stepCodes[] = 'payment';
			}			
			$stepCodes[] = 'review';			
			//$stepCodes = array('login', 'billing', 'shipping', 'shipping_method',  'payment', 'review');			
		}else{
			$stepCodes = $this->_getStepCodes();
		}
	
		if ($this->isCustomerLoggedIn()) {
			$stepCodes = array_diff($stepCodes, array('login'));
		}
	
		foreach ($stepCodes as $step) {
			$steps[$step] = $this->getCheckout()->getStepData($step);
		}
	
		return $steps;
	}
	
	
}