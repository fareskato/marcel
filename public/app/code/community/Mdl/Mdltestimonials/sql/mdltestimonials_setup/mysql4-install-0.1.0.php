<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('mdltestimonials')};
CREATE TABLE {$this->getTable('mdltestimonials')} (
  `mdltestimonials_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `author` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `content` varchar(255) NOT NULL default '',
  `store_id` varchar(255) NULL,
  `status` smallint(6) NOT NULL default '0',
  
  PRIMARY KEY (`mdltestimonials_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO {$this->getTable('mdltestimonials')} (`mdltestimonials_id`, `title`, `author`, `filename`, `content`, `store_id`, `status`) VALUES
(1, 'Testimonial 01', 'John Dev', 'img01_5.jpg', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ', '0', 1),
(2, 'Testimonial 02', 'Jennifer Smith', 'img02_1.jpg', ' Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait', '0', 1),
(3, 'Testimonial 03', 'Will Clark', 'img03_1.jpg', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat', '2', 1);


");

$installer->endSetup(); 
