CREATE TABLE IF NOT EXISTS `task` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `description` varchar(1000) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;