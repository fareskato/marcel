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
class Mdl_UnderConstruction_Model_Adminhtml_System_Config_Source_Styles
{
    public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label'=>Mage::helper('adminhtml')->__('no-repeat')),
            array('value' => '2', 'label'=>Mage::helper('adminhtml')->__('repeat')),
			array('value' => '3', 'label'=>Mage::helper('adminhtml')->__('repeat-x')),
			array('value' => '4', 'label'=>Mage::helper('adminhtml')->__('repeat-y')),
        );
    }
}
?>