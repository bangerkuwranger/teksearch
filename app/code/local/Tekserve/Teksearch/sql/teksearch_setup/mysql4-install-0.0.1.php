<?php
echo 'Running This Upgrade: '.get_class($this)."\n <br /> \n";
$installer = $this;
$installer->startSetup();
$installer->run("
    CREATE TABLE `{$installer->getTable('teksearch/contentresult')}` (
      `sku` int(16) NOT NULL,
      `title` text,
      `description` text,
      `link` text,
      `url` text,
      PRIMARY KEY  (`sku`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    INSERT INTO `{$installer->getTable('teksearch/contentresult')}` VALUES (1,'No Results Found','There are no results for your search','','');
    
    CREATE TABLE `{$installer->getTable('teksearch/resultlist')}` (
      `resultlist_id` int(16) NOT NULL auto_increment,
      `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
      `current_handle` varchar(128),
      `prev_handle` varchar(128),
      `display_mode` tinytext,
      `result_count` mediumint(9),
      `per_page` smallint(6),
      `current_page` smallint(6),
      `sort_type` varchar(32),
      `sort_dir` tinytext,
      PRIMARY KEY  (`resultlist_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8; 
");
$installer->endSetup();