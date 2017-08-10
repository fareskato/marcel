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
class Mdl_UnderConstruction_Block_Adminhtml_System_Config_Form_Field_Editor extends Mage_Adminhtml_Block_System_Config_Form_Field 
implements Varien_Data_Form_Element_Renderer_Interface{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
        $element->setWysiwyg(true);
        $element->setConfig(Mage::getSingleton('cms/wysiwyg_config')->getConfig());
        return parent::_getElementHtml($element);
    }
}