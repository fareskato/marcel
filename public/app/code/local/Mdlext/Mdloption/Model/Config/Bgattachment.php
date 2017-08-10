<?php
class Mdlext_Mdloption_Model_Config_Bgattachment
{
    public function toOptionArray()
       {
        return array(
           array('value' => '1', 'label'=>Mage::helper('adminhtml')->__('Scroll')),
           array('value' => '2', 'label'=>Mage::helper('adminhtml')->__('Fixed')),
       );
    }
}
?>