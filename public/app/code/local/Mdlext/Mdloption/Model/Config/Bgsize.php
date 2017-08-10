<?php

class Mdlext_Mdloption_Model_Config_Bgsize 
{
    public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label'=>Mage::helper('adminhtml')->__('None')),
            array('value' => '2', 'label'=>Mage::helper('adminhtml')->__('100%')),
			array('value' => '3', 'label'=>Mage::helper('adminhtml')->__('Cover')),
        );
    }
}
?>