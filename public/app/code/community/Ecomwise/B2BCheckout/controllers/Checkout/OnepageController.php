<?php
require_once(Mage::getModuleDir('controllers','Mage_Checkout').DS.'OnepageController.php');
class Ecomwise_B2BCheckout_Checkout_OnepageController extends Mage_Checkout_OnepageController /* extends Mage_Checkout_Controller_Action */
{  
   
	/**
	 * save checkout billing address
	 */
	public function saveBillingAction()
	{
		if ($this->_expireAjax()) {
			return;
		}
		if ($this->getRequest()->isPost()) {
			
			$groups = Mage::getStoreConfig('b2bcheckout/parameters/groups');
			//$customerGroup = Mage::helper('customer')->getCustomer()->getGroupId();
			$customerGroup = Mage::helper('ecomwiseskipsm')->getGroupId();
			
			//if(((Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled') && in_array($customerGroup,explode(',',$groups))) || !Mage::getSingleton('customer/session')->isLoggedIn() || !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')) && Mage::getStoreConfig('b2bcheckout/parameters/enabled')) {
			if(Mage::getStoreConfig('b2bcheckout/parameters/enabled') && Mage::getStoreConfig('b2bcheckout/parameters/skip_payment')
					&& (( Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')  && in_array($customerGroup,explode(',',$groups)))
							|| !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')
					) && Mage::helper('customer')->isLoggedIn()
			){	
				$data = $this->getRequest()->getPost('billing', array());
				$customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
				
				if (isset($data['email'])) {
					$data['email'] = trim($data['email']);
				}
				$result = $this->getOnepage()->saveBilling($data, $customerAddressId);
				
				if (!isset($result['error'])) {				
					
					if($data['use_for_shipping']){
						/* Custome code */
						$codes = Mage::helper('ecomwiseskipsm');
						$method = $codes->getRateCode(Mage::getStoreConfig('b2bcheckout/parameters/shipping_methods'));
						//$method = 'flatrate_flatrate';
						$result = $this->getOnepage()->saveShippingMethod($method);
						Mage::getSingleton('checkout/type_onepage')->getQuote()->getShippingAddress()-> setShippingMethod($method)->save();						
					}
					
					$payment = array( 'method' => 'checkmo' );
					$result[] = $this->getOnepage()->savePayment($payment);
					
					if(!Mage::getStoreConfig('b2bcheckout/parameters/skip_shipping')){
						$next_step = 'shipping_method';
						$name = 'shipping-method';
						$html = $this->_getShippingMethodsHtml();
					} elseif(!Mage::getStoreConfig('b2bcheckout/parameters/skip_payment')){
						$next_step = 'payment';
						$name = 'payment-method';
						$html = $this->_getPaymentMethodsHtml();						
					} else {
						$this->loadLayout('checkout_onepage_review');
						$next_step = 'review';
						$name = 'review';
						$html = $this->_getReviewHtml();
					}					
					/* Endo of Custome code */
						
					if ($this->getOnepage()->getQuote()->isVirtual()) {
						//$this->loadLayout('checkout_onepage_review'); // Custome code
						$result['goto_section'] = $next_step; // Custome code
						$result['update_section'] = array(
								'name' => $name, // Custome code
								'html' => $html // Custome code
						);
					} elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
						//$this->loadLayout('checkout_onepage_review'); // Custome code
						$result['goto_section'] = $next_step; // Custome code
						$result['update_section'] = array(
								'name' => $name, // Custome code
								'html' => $html // Custome code
						);
				
						$result['allow_sections'] = array('shipping');
						$result['duplicateBillingInfo'] = 'true';
					} else {
						$result['goto_section'] = 'shipping';
					}
				}
				
				$this->getOnepage()->getQuote()->collectTotals()->save(); // Custome code
				$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
			}elseif (Mage::getStoreConfig('b2bcheckout/parameters/enabled') && !(Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')  && in_array($customerGroup,explode(',',$groups)))){
				$data = $this->getRequest()->getPost('billing', array());
				$customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
				
				if (isset($data['email'])) {
					$data['email'] = trim($data['email']);
				}
				$result = $this->getOnepage()->saveBilling($data, $customerAddressId);
				
				if (!isset($result['error'])) {
					if (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
						$result['goto_section'] = 'shipping_method';
						$result['update_section'] = array(
								'name' => 'shipping-method',
								'html' => $this->_getShippingMethodsHtml()
						);
				
						$result['allow_sections'] = array('shipping');
						$result['duplicateBillingInfo'] = 'true';
					} else {
						$result['goto_section'] = 'shipping';
					}
				}
				
				$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
			
			} else{
				$data = $this->getRequest()->getPost('billing', array());
				$customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
				
				if (isset($data['email'])) {
					$data['email'] = trim($data['email']);
				}
				$result = $this->getOnepage()->saveBilling($data, $customerAddressId);
				
				if (!isset($result['error'])) {
					if (Mage::getStoreConfig('b2bcheckout/parameters/enabled') 
							&& !Mage::getStoreConfig('b2bcheckout/parameters/skip_payment') 
							&& Mage::getStoreConfig('b2bcheckout/parameters/skip_shipping') 
							&& $data['use_for_shipping'] == 1						
							) {
						$result['goto_section'] = 'payment';
						$result['update_section'] = array(
								'name' => 'payment-method',
								'html' => $this->_getPaymentMethodsHtml()
						);
						$result['allow_sections'] = array('shipping');
					} elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
						$result['goto_section'] = 'shipping_method';
						$result['update_section'] = array(
								'name' => 'shipping-method',
								'html' => $this->_getShippingMethodsHtml()
						);
				
						$result['allow_sections'] = array('shipping');
						$result['duplicateBillingInfo'] = 'true';
					} else {
						$result['goto_section'] = 'shipping';
					}
				}
				
				$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));				
			}
		}
	}
   
	/**
	 * Shipping address save action
	 */
	public function saveShippingAction()
	{
		if ($this->_expireAjax()) {
			return;
		}
		if ($this->getRequest()->isPost()) {
			
			$groups = Mage::getStoreConfig('b2bcheckout/parameters/groups');
			//$customerGroup = Mage::helper('customer')->getCustomer()->getGroupId();
			$customerGroup = Mage::helper('ecomwiseskipsm')->getGroupId();
				
			//if((Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled') && in_array($customerGroup,explode(',',$groups))) || !Mage::getSingleton('customer/session')->isLoggedIn() || !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')){				
			if(Mage::getStoreConfig('b2bcheckout/parameters/enabled') && Mage::getStoreConfig('b2bcheckout/parameters/skip_payment')
					&& (( Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')  && in_array($customerGroup,explode(',',$groups)))
							|| !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')
					) && Mage::helper('customer')->isLoggedIn()
			){	
				$data = $this->getRequest()->getPost('shipping', array());
				$customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);
				$result = $this->getOnepage()->saveShipping($data, $customerAddressId);				
				if (!isset($result['error'])) {						
					if(!Mage::getStoreConfig('b2bcheckout/parameters/skip_shipping')){
						$result['goto_section'] = 'shipping_method';
						$result['update_section'] = array(
								'name' => 'shipping-method',
								'html' => $this->_getShippingMethodsHtml()								
						);							
					}elseif (!Mage::getStoreConfig('b2bcheckout/parameters/skip_payment')){					
						$result['goto_section'] = 'payment';
						$result['update_section'] = array(
								'name' => 'payment-method',
								'html' => $this->_getPaymentMethodsHtml()
						);				
					}else {
						$this->loadLayout('checkout_onepage_review'); // Custome code
						$result['goto_section'] = 'review';
						$result['update_section'] = array(
								//'name' => 'shipping-method',
								//'html' => $this->_getShippingMethodsHtml()
								'name' => 'review', // Custome code
								'html' => $this->_getReviewHtml() // Custome code
						);
					}					
					
					/* //$result['goto_section'] = 'shipping_method';
					$result['goto_section'] = $next_step; // Custome code
					$result['update_section'] = array(
							//'name' => 'shipping-method',
							//'html' => $this->_getShippingMethodsHtml()
							'name' => $next_name, // Custome code
							'html' => $this->_getReviewHtml() // Custome code
					); */					
				}					
				$this->getOnepage()->getQuote()->collectTotals()->save();	// Custome code
				$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));				
							
			}elseif (Mage::getStoreConfig('b2bcheckout/parameters/enabled') && !(Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')  && in_array($customerGroup,explode(',',$groups)))){
				$data = $this->getRequest()->getPost('shipping', array());
				$customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);
				$result = $this->getOnepage()->saveShipping($data, $customerAddressId);
				
				if (!isset($result['error'])) {
					if (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
						$result['goto_section'] = 'shipping_method';
						$result['update_section'] = array(
								'name' => 'shipping-method',
								'html' => $this->_getShippingMethodsHtml()
						);
						$result['allow_sections'] = array('shipping');
						$result['duplicateBillingInfo'] = 'true';
					}
					else {
						$result['goto_section'] = 'shipping_method';
						$result['update_section'] = array(
								'name' => 'shipping-method',
								'html' => $this->_getShippingMethodsHtml()
						);
						$result['duplicateBillingInfo'] = 'true';
						$result['allow_sections'] = array('shipping');
				
					}
					$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
				}			
			}else{			
				$data = $this->getRequest()->getPost('shipping', array());
				$customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);
				$result = $this->getOnepage()->saveShipping($data, $customerAddressId);
				
				if (!isset($result['error'])) {
					if (Mage::getStoreConfig('b2bcheckout/parameters/enabled') && !Mage::getStoreConfig('b2bcheckout/parameters/skip_payment') && Mage::getStoreConfig('b2bcheckout/parameters/skip_shipping')) {
						$result['goto_section'] = 'payment';
						$result['update_section'] = array(
								'name' => 'payment-method',
								'html' => $this->_getPaymentMethodsHtml()
						);
						$result['allow_sections'] = array('shipping');
					} elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
						$result['goto_section'] = 'shipping_method';
						$result['update_section'] = array(
								'name' => 'shipping-method',
								'html' => $this->_getShippingMethodsHtml()
						);
						$result['allow_sections'] = array('shipping');
						$result['duplicateBillingInfo'] = 'true';
				}
				else {
						$result['goto_section'] = 'shipping_method';
						$result['update_section'] = array(
								'name' => 'shipping-method',
								'html' => $this->_getShippingMethodsHtml()
						);
						$result['duplicateBillingInfo'] = 'true';
						$result['allow_sections'] = array('shipping');
						
					}
				$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
			}		
		}
		
		}	
	}
	/**
	 * Shipping method save action
	 */
	public function saveShippingMethodAction()
	{
		if ($this->_expireAjax()) {
			return;
		}
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost('shipping_method', '');
			$result = $this->getOnepage()->saveShippingMethod($data);
			// $result will contain error data if shipping method is empty
			if (!$result) {
				Mage::dispatchEvent(
						'checkout_controller_onepage_save_shipping_method',
						array(
								'request' => $this->getRequest(),
								'quote'   => $this->getOnepage()->getQuote()));
				$this->getOnepage()->getQuote()->collectTotals();
				$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));	
				
				$groups = Mage::getStoreConfig('b2bcheckout/parameters/groups');
				//$customerGroup = Mage::helper('customer')->getCustomer()->getGroupId();
				$customerGroup = Mage::helper('ecomwiseskipsm')->getGroupId();
				
				if(Mage::getStoreConfig('b2bcheckout/parameters/enabled') && Mage::getStoreConfig('b2bcheckout/parameters/skip_payment') 
					&& (( Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')  && in_array($customerGroup,explode(',',$groups)))
						 || !Mage::getStoreConfig('b2bcheckout/parameters/groups_enabled')
						)	&& Mage::helper('customer')->isLoggedIn()					
					){
					$this->loadLayout('checkout_onepage_review');
					$result['goto_section'] = 'review';
					$result['update_section'] = array(
							'name' => 'review',
							'html' => $this->_getReviewHtml()
					);				
				} else {					
					$result['goto_section'] = 'payment';
					$result['update_section'] = array(
							'name' => 'payment-method',
							'html' => $this->_getPaymentMethodsHtml()
					);					
				}				
			}
			$this->getOnepage()->getQuote()->collectTotals()->save();
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		}
	}
   
}