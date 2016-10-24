CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(10) NOT NULL auto_increment,
  `first_name` varchar(50) default NULL,
  `last_name` varchar(50) default NULL,
  `email` varchar(50) default NULL,
  `phone_no` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `job` (
  `id` int(10) NOT NULL auto_increment,
  `job_title` varchar(50) default NULL,
  `salary` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;