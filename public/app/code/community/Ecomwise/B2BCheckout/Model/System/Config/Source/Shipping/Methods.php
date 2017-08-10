<?php 
class Ecomwise_B2BCheckout_Model_System_Config_Source_Shipping_Methods {			
	
	public function toOptionArray()	{
		
		$methods = Mage::getSingleton('shipping/config')->getActiveCarriers();
		$codes = Mage::helper('ecomwiseskipsm');	
		$options = array();	
		foreach($methods as $_code => $_method)	{
			if(!$_title = Mage::getStoreConfig("carriers/$_code/title")){
				$_title = $_code;
			}			
			if($codes->getRateCode($_code ) !== false){
				$options[] = array('value' => $_code, 'label' => $_title . " ($_code)");
			}			
		}	
		array_unshift($options, array('value'=>'', 'label'=> Mage::helper('adminhtml')->__('--Please Select--')));	
		return $options;
	}	
}
