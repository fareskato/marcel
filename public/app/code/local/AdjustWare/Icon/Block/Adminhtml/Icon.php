<?php
/**
 * Visualize Your Attributes - Color Swatch
 *
 * @category:    AdjustWare
 * @package:     AdjustWare_Icon
 * @version      3.1.15
 * @license:     hlC9gt9cdSBrS26S2Ln1ysO97rKL4VLtOdRx2Aycga
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
class AdjustWare_Icon_Block_Adminhtml_Icon extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_icon';
        $this->_headerText = Mage::helper('adjicon')->__('Visualize Your Attributes');
        $this->_addButtonLabel = Mage::helper('adjicon')->__('Fill Out');
        $this->_blockGroup = 'adjicon';
    }

}