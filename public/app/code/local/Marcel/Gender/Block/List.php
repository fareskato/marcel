<?php

class Marcel_Gender_Block_List extends Mage_Catalog_Block_Product_Abstract {

    protected $_itemCollection = null;

    public function getGender() {
        $attributeCode = "gender";
        $this->attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
        if ($this->attribute->usesSource()) {
            $options = $this->attribute->getSource()->getAllOptions(false);
//            var_dump($options);
            foreach ($options as $option) {               
                return $option['value'];
            }
        }
    }

    public function getItems() {
        $gender = $this->getGender();
        if (is_null($this->_itemCollection)) {
            $this->_itemCollection = Mage::getModel('marcel_gender/products')->getItemsCollection($this->gender);
        }
        return $this->_itemCollection;
    }

    public function getSalesItems() {

        if (is_null($this->_itemCollection)) {
            $this->_itemCollection = Mage::getModel('marcel_gender/products')->getSalesItemsCollection();
        }
        return $this->_itemCollection;
    }

}
