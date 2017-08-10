<?php
class Mdlext_Mdloption_Model_Config_Bgposition
{
    public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label'=>Mage::helper('adminhtml')->__('Center Center')),
            array('value' => '2', 'label'=>Mage::helper('adminhtml')->__('Left Top')),
			array('value' => '3', 'label'=>Mage::helper('adminhtml')->__('Right Top')),
			array('value' => '4', 'label'=>Mage::helper('adminhtml')->__('Left Bottom')),
			array('value' => '5', 'label'=>Mage::helper('adminhtml')->__('right Bottom')),
        );
    }
}
?>