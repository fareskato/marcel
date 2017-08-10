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
class AdjustWare_Icon_Model_Mysql4_Icon_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('adjicon/icon');
    }
    
    public function addOptionsFilter($ids, $storeId=null)
    {
        $this->getSelect()
            ->joinInner(array('v' => $this->getTable('eav/attribute_option_value')), 'main_table.option_id=v.option_id', array('value'=>'value','store_id'=>'store_id'))
            ->where('main_table.option_id in (?)', array_unique($ids))
            ->where('v.store_id in(0, ?)', Mage::app()->getStore($storeId)->getId());
         return $this;
    }
}