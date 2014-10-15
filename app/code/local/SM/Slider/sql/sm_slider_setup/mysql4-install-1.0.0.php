<?php
/**
 * Created by PhpStorm.
 * User: CITA
 * Date: 29/09/14
 * Time: 11:52
 */
$installer = $this;

$installer->startSetup();


$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('sm_slider/slider')};
CREATE TABLE {$this->getTable('sm_slider/slider')} (
  `slider_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `described` text,
  `mode` varchar(255),
  `width` int(10),
  `height` int(10),
  `status` int(1) NOT NULL default '0',
  `created_time` datetime NOT NULL default CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`slider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();
?>