<?php

$installer = $this;

$installer->startSetup();

$tableName = $installer->getTable('marcel_selector');

$sql=<<<SQLTEXT
CREATE TABLE `{$tableName}` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR( 64 ) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = InnoDB;
SQLTEXT;

$installer->run($sql);

$installer->endSetup();