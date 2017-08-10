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
$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('adjicon/attribute')}` 
ADD `show_images` TINYINT( 1 ) NOT NULL AFTER `pos` ,
ADD `columns_num` TINYINT( 1 ) NOT NULL AFTER `show_images` ,
ADD `hide_qty`    TINYINT( 1 ) NOT NULL AFTER `columns_num` ,
ADD `sort_by`     TINYINT( 1 ) NOT NULL AFTER `hide_qty` ;

");

$installer->endSetup();