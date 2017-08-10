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
class AdjustWare_Icon_Model_Color extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('adjicon/color');
    }

    public function saveColor($attributeOptionInfo)
    {
        $optionId = $attributeOptionInfo['option_id'];
        if(!($color = Mage::app()->getRequest()->getPost('color'.$optionId))) {
			$this->deleteColor($optionId);
		}

		$this->setOptionId($optionId);
        $this->setColor($color);
        $this->save();
    }

	public function deleteColor($optionId) {
		$this->setOptionId($optionId);
		$this->delete();
	}
}