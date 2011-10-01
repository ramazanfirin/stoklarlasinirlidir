/*Table structure for table `customer_support` */

DROP TABLE IF EXISTS `customer_support`;

CREATE TABLE `customer_support` (
  `customer_support_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `subject` tinytext,
  `enquiry` text,
  `answer` text,
  `date_added` datetime DEFAULT NULL,
  `date_answer` datetime DEFAULT NULL,
  `customer_support_1st_category_id` int(11) DEFAULT NULL,
  `customer_support_2nd_category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`customer_support_id`)
) ;

/*Table structure for table `customer_support_category` */

DROP TABLE IF EXISTS `customer_support_category`;

CREATE TABLE `customer_support_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`category_id`)
);

/*Table structure for table `customer_support_category_description` */

DROP TABLE IF EXISTS `customer_support_category_description`;

CREATE TABLE `customer_support_category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`category_id`,`language_id`),
  KEY `name` (`name`)
);

/*Table structure for table `customer_support_category_to_store` */

DROP TABLE IF EXISTS `customer_support_category_to_store`;

CREATE TABLE `customer_support_category_to_store` (
  `category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`store_id`)
);

