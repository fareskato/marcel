<?php
class Ecomwise_B2BCheckout_Block_Checkout_Cart_Shipping extends Mage_Checkout_Block_Cart_Shipping {	
	
	/**
	 * Render block HTML
	 *
	 * @return string
	 */
	protected function _toHtml()
	{
		if(Mage::helper('ecomwiseskipsm')->showShipping()){
			return '';
		}else {
			return parent::_toHtml();
		}	
	}	
}
	