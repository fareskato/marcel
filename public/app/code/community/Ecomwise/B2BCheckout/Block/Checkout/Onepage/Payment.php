<?php 
class Ecomwise_B2BCheckout_Block_Checkout_Onepage_Payment extends Mage_Checkout_Block_Onepage_Payment {	
	
	/**
	 * Retrieve is allow and show block
	 *
	 * @return bool
	 */
	public function isShow()
	{		
		if(Mage::helper('ecomwiseskipsm')->showPayment()){
			return false;
		}else {
			return parent::isShow();
		}
	}	
	
}