CREATE TABLE `o2o_category`(
`id` int(11) unsigned NOT NULL auto_increment,
`name` varchar(50) NOT NULL default '',
`parent_id` int(11)  UNSIGNED NOT NULL  DEFAULT 0,
 `listorder` INT(8) UNSIGNED NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 0,
  `create_time` INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` INT(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY parent_id(`parent_id`)
)ENGINE =InnoDB AUTO_INCREMENT=1 DEFAULT CHAR SET =utf8;