<?php 
$query_tables = array();
$query_sql = array();
$query_tables['ptsbttestimonials']['ptsbttestimonials'] = 'CREATE TABLE IF NOT EXISTS  `'._DB_PREFIX_.'ptsbttestimonials` (
  `id_ptsbttestimonials` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `avatar` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` varchar(500) NOT NULL,
  `media_id` varchar(20) DEFAULT NULL,
  `media_type` varchar(20) DEFAULT NULL,
  `media_code` varchar(100) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id_ptsbttestimonials`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8';


$query_tables['ptsbttestimonials']['ptsbttestimonials_lang'] = 'CREATE TABLE IF NOT EXISTS  `'._DB_PREFIX_.'ptsbttestimonials_lang` (
  `id_ptsbttestimonials` int(10) unsigned NOT NULL,
  `id_lang` int(10) NOT NULL,
  `content` text NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id_ptsbttestimonials`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';


$query_tables['ptsbttestimonials']['ptsbttestimonials_shop'] = 'CREATE TABLE IF NOT EXISTS  `'._DB_PREFIX_.'ptsbttestimonials_shop` (
  `id_ptsbttestimonials` int(10) unsigned NOT NULL,
  `id_shop` int(10) NOT NULL,
  PRIMARY KEY (`id_ptsbttestimonials`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';


/*DATA FOR TABLE ptsbttestimonials*/
 $query_sql['ptsbttestimonials'][] = 'INSERT INTO '._DB_PREFIX_.'ptsbttestimonials( `id_ptsbttestimonials`,`avatar`,`name`,`email`,`company`,`address`,`media_id`,`media_type`,`media_code`,`date_add`,`position`,`active` ) 
							VALUES(\'1\', \'sample-1.png\', \'Tom Henry.\', \'demo@gmail.com\', \'Prestashop\', \'Street name, California, USA\', \'9bdrk8FNWnc\', \'Youtube\', \'http://www.youtube.com/watch?v=9bdrk8FNWnc\', \'2015-04-20 04:45:39\', \'1\', \'1\')'; 
 $query_sql['ptsbttestimonials'][] = 'INSERT INTO '._DB_PREFIX_.'ptsbttestimonials( `id_ptsbttestimonials`,`avatar`,`name`,`email`,`company`,`address`,`media_id`,`media_type`,`media_code`,`date_add`,`position`,`active` ) 
							VALUES(\'2\', \'sample-2.png\', \'John doe 2\', \'demo@gmail.com\', \'Prestashop\', \'Street name, California, USA\', \'9bdrk8FNWnc\', \'Youtube\', \'http://www.youtube.com/watch?v=9bdrk8FNWnc\', \'2015-04-20 04:45:39\', \'2\', \'1\')'; 
/*DATA FOR TABLE ptsbttestimonials_lang*/
 $query_sql['ptsbttestimonials_lang'][] = 'INSERT INTO '._DB_PREFIX_.'ptsbttestimonials_lang( `id_ptsbttestimonials`,`id_lang`,`content`,`note` ) 
							VALUES(\'1\', \'_LANGUAGEID_\', \'<p>Lorem Khaled Ipsum is a major key to success. Find peace, life is like a water fall, you’ve gotta flow. They don’t want us to win. We the best. Watch your back, but more importantly when you get out the shower, dry your back, it’s a cold world out there.</p>\', \'<p><span>Designers</span></p>\')'; 
 $query_sql['ptsbttestimonials_lang'][] = 'INSERT INTO '._DB_PREFIX_.'ptsbttestimonials_lang( `id_ptsbttestimonials`,`id_lang`,`content`,`note` ) 
							VALUES(\'2\', \'_LANGUAGEID_\', \'<p>The ladies always say Khaled you smell good, I use no cologne. Cocoa butter is the key. Every chance I get, I water the plants, Lion! Don’t ever play yourself. Eliptical talk. We the best. </p>\', \'<p>Developer</p>\')'; 
/*DATA FOR TABLE ptsbttestimonials_shop*/
 $query_sql['ptsbttestimonials_shop'][] = 'INSERT INTO '._DB_PREFIX_.'ptsbttestimonials_shop( `id_ptsbttestimonials`,`id_shop` ) 
							VALUES(\'1\', \'_SHOPID_\')'; 
 $query_sql['ptsbttestimonials_shop'][] = 'INSERT INTO '._DB_PREFIX_.'ptsbttestimonials_shop( `id_ptsbttestimonials`,`id_shop` ) 
							VALUES(\'2\', \'_SHOPID_\')'; 

 ?>