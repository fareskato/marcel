<?php
/**
 * Koolthememaster
 *
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs
 * Please refer to http://www.magentocommerce.com for more information.
 * @package   Comming soon page
 * @version   1.0.0
 * @copyright Copyright (coffee) 2013 Koolthememaster (http://koolthememaster.net/)
 */
?>
<?php
class Mdl_UnderConstruction_Model_Adminhtml_System_Config_Source_Bgposition
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