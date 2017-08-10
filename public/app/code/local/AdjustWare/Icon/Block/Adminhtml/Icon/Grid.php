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
class AdjustWare_Icon_Block_Adminhtml_Icon_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('iconsGrid');
        $this->setDefaultSort('pos');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('adjicon/attribute')
            ->getResourceCollection()
            ->addTitles();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $hlp = Mage::helper('adjicon');
        $this->addColumn('id', array(
            'header'    => $hlp->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'id',
        ));

        $this->addColumn('pos', array(
            'header'    => $hlp->__('Position'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'pos',
        ));

        $this->addColumn('frontend_label', array(
            'header'    => $hlp->__('Attribute'),
            'align'     =>'left',
            'index'     => 'frontend_label',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}