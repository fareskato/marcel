<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Marcel_Gender_Model_Products extends Mage_Catalog_Model_Product
{
    public function getItemsCollection($valueId)
    {
        $collection = $this->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('gender', array('eq' => $valueId));
        Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($collection);
        return $collection;
    }

    public function getSalesItemsCollection()
    {
        $todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
        $tomorrow = mktime(0, 0, 0, date('m'), date('d')+1, date('y'));
        $dateTomorrow = date('m/d/y', $tomorrow);

        $collection = $this->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('visibility', array(
                Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
                Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
            ))
            ->addAttributeToFilter('special_from_date', array('date' => true, 'to' => $todayDate))
            ->addAttributeToFilter('special_to_date', array('or'=> array(0 => array('date' => true, 'from' => $dateTomorrow), 1 => array('is' => new Zend_Db_Expr('null')))), 'left')
        ;/**/
        Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($collection);

        return $collection;
    }
}

