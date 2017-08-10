<?php
class Ecomwise_B2BCheckout_Helper_Data extends Mage_Core_Helper_Abstract {

	public function getGroupId(){		
		$customer_helper = Mage::helper('customer');		
		if($customer_helper->isLoggedIn()){
			return $customer_helper->getCustomer()->getGroupId();
		}else{
			return -1;
		}		
	}
	
	public function showShipping(){		
		$groups = Mage::getStoreConfig('b2bcheckout/parameters/groups');
		$customerGroup = $this->getGroupId();
		return (Mage::getStoreConfig('b2bcheckout/parameters/enabled') && Mage::getStoreConfig('b2bcheckout/parameters/skip_shipping')
				&& (( Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')  && in_array($customerGroup,explode(',',$groups)))
						|| !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled'))  && Mage::helper('customer')->isLoggedIn());		
		
	}
	
	public function showPayment(){		
		$groups = Mage::getStoreConfig('b2bcheckout/parameters/groups');
		$customerGroup = $this->getGroupId();		
		return (Mage::getStoreConfig('b2bcheckout/parameters/enabled') && Mage::getStoreConfig('b2bcheckout/parameters/skip_payment')
				&& (( Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')  && in_array($customerGroup,explode(',',$groups)))
						|| !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')  && Mage::helper('customer')->isLoggedIn()
				)
		);		
	}
	
	public function getRateCode($shipping_method_code){
		
		switch ($shipping_method_code) {
			case 'flatrate':
				$code = 'flatrate_flatrate';
				break;
			case 'freeshipping':
				$code = 'freeshipping_freeshipping';
				break;
			case 'tablerate':
				$code = 'tablerate_bestway';
				break;	
			//case 'matrixrate':
			//	$code = 'matrixrate_matrixrate_1';
			//	break;				
			default:
					$code = false;
		}		
		return $code;		
	}

}