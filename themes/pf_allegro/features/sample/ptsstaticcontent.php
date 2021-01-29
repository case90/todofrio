<?php 
$query_tables = array();
$query_sql = array();
$query_tables['ptsstaticcontent']['ptsstaticcontent'] = 'CREATE TABLE IF NOT EXISTS  `'._DB_PREFIX_.'ptsstaticcontent` (
  `id_item` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `item_order` int(10) unsigned NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `title_use` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
  `hook` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `target` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
  `image` varchar(100) DEFAULT NULL,
  `image_w` varchar(10) DEFAULT NULL,
  `image_h` varchar(10) DEFAULT NULL,
  `html` text,
  `active` tinyint(1) unsigned NOT NULL DEFAULT \'1\',
  `col_lg` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
  `col_sm` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
  `class` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8';


/*DATA FOR TABLE ptsstaticcontent*/
 $query_sql['ptsstaticcontent'][] = 'INSERT INTO '._DB_PREFIX_.'ptsstaticcontent( `id_item`,`id_shop`,`id_lang`,`item_order`,`title`,`title_use`,`hook`,`url`,`target`,`image`,`image_w`,`image_h`,`html`,`active`,`col_lg`,`col_sm`,`class` ) 
							VALUES(\'4\', \'_SHOPID_\', \'_LANGUAGEID_\', \'1\', \'Call support free: \', \'1\', \'home\', \'#\', \'1\', \'icon-header1.png\', \'0\', \'0\', \'<p>1800 - 123 456 78</p>\', \'1\', \'0\', \'0\', \'\')'; 
 $query_sql['ptsstaticcontent'][] = 'INSERT INTO '._DB_PREFIX_.'ptsstaticcontent( `id_item`,`id_shop`,`id_lang`,`item_order`,`title`,`title_use`,`hook`,`url`,`target`,`image`,`image_w`,`image_h`,`html`,`active`,`col_lg`,`col_sm`,`class` ) 
							VALUES(\'5\', \'_SHOPID_\', \'_LANGUAGEID_\', \'2\', \'Email us:\', \'1\', \'home\', \'#\', \'0\', \'icon-header2.png\', \'0\', \'0\', \'<p>info@company.com</p>\', \'1\', \'0\', \'0\', \'\')'; 
 $query_sql['ptsstaticcontent'][] = 'INSERT INTO '._DB_PREFIX_.'ptsstaticcontent( `id_item`,`id_shop`,`id_lang`,`item_order`,`title`,`title_use`,`hook`,`url`,`target`,`image`,`image_w`,`image_h`,`html`,`active`,`col_lg`,`col_sm`,`class` ) 
							VALUES(\'6\', \'_SHOPID_\', \'_LANGUAGEID_\', \'3\', \'Business hours:\', \'1\', \'home\', \'#\', \'0\', \'icon-header3.png\', \'0\', \'0\', \'<p>Mon-Sat: 8.00-18.00</p>\', \'1\', \'0\', \'0\', \'\')'; 

 ?>