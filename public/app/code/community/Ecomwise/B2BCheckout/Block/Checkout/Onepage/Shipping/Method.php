<?php 
class Ecomwise_B2BCheckout_Block_Checkout_Onepage_Shipping_Method extends Mage_Checkout_Block_Onepage_Shipping_Method {	
	
	/**
	 * Retrieve is allow and show block
	 *
	 * @return bool
	 */
	public function isShow()
	{ 		
		if(Mage::helper('ecomwiseskipsm')->showShipping()){
			return false;
		}else {
			return parent::isShow();
		}		
	}	
	
}