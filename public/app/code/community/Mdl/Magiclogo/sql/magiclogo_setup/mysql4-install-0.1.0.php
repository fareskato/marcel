<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('magiclogo')};
CREATE TABLE {$this->getTable('magiclogo')} (
  `magiclogo_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `store_id` varchar(255) NULL,
  `status` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`magiclogo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO {$this->getTable('magiclogo')} (`magiclogo_id`, `title`, `filename`, `url`, `store_id`, `status`) VALUES
(1, 'Zatchels', '/b/r/brand-img01.png', 'http://www.google.co.uk', '3', 1),
(2, 'Vans', '/b/r/brand-img02.png', 'http://www.google.co.uk', '0', 1),
(3, 'Oakley', '/b/r/brand-img03.png', 'http://www.google.co.uk', '0', 1),
(4, 'Hunter', '/b/r/brand-img04.png', 'http://www.google.co.uk', '0', 1),
(5, 'Zatchels', '/b/r/brand-img05.png', 'http://www.google.co.uk', '0', 1),
(6, 'Vans', '/b/r/brand-img02_1.png', 'http://www.google.co.uk', '0', 1),
(7, 'Oakley', '/b/r/brand-img03_1.png', 'http://www.google.co.uk', '0', 1);



");

$installer->endSetup(); 
