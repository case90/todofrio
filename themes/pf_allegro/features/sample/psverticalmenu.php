<?php 
$query_tables = array();
$query_sql = array();
$query_tables['psverticalmenu']['psverticalmenu'] = 'CREATE TABLE IF NOT EXISTS  `'._DB_PREFIX_.'psverticalmenu` (
  `id_psverticalmenu` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `is_group` tinyint(1) NOT NULL,
  `width` varchar(255) DEFAULT NULL,
  `submenu_width` varchar(255) DEFAULT NULL,
  `colum_width` varchar(255) DEFAULT NULL,
  `submenu_colum_width` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `colums` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `is_content` tinyint(1) NOT NULL,
  `show_title` tinyint(1) NOT NULL,
  `type_submenu` varchar(10) NOT NULL,
  `level_depth` smallint(6) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `submenu_content` text NOT NULL,
  `show_sub` tinyint(1) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `target` varchar(25) DEFAULT NULL,
  `privacy` smallint(6) DEFAULT NULL,
  `position_type` varchar(25) DEFAULT NULL,
  `menu_class` varchar(25) DEFAULT NULL,
  `content` text,
  `icon_class` varchar(255) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `left` int(11) NOT NULL,
  `right` int(11) NOT NULL,
  `submenu_catids` text,
  `is_cattree` tinyint(1) DEFAULT \'1\',
  `date_add` datetime DEFAULT NULL,
  `date_upd` datetime DEFAULT NULL,
  PRIMARY KEY (`id_psverticalmenu`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8';


$query_tables['psverticalmenu']['psverticalmenu_lang'] = 'CREATE TABLE IF NOT EXISTS  `'._DB_PREFIX_.'psverticalmenu_lang` (
  `id_psverticalmenu` int(11) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `description` text,
  `content_text` text,
  `submenu_content_text` text,
  PRIMARY KEY (`id_psverticalmenu`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';


$query_tables['psverticalmenu']['psverticalmenu_shop'] = 'CREATE TABLE IF NOT EXISTS  `'._DB_PREFIX_.'psverticalmenu_shop` (
  `id_psverticalmenu` int(11) NOT NULL DEFAULT \'0\',
  `id_shop` int(11) NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id_psverticalmenu`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';


$query_tables['psverticalmenu']['psverticalmenu_widgets'] = 'CREATE TABLE IF NOT EXISTS  `'._DB_PREFIX_.'psverticalmenu_widgets` (
  `id_widget` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `type` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `id_shop` int(11) NOT NULL,
  `key_widget` int(11) NOT NULL,
  PRIMARY KEY (`id_widget`,`id_shop`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8';


/*DATA FOR TABLE psverticalmenu*/
 $query_sql['psverticalmenu'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu( `id_psverticalmenu`,`image`,`id_parent`,`is_group`,`width`,`submenu_width`,`colum_width`,`submenu_colum_width`,`item`,`colums`,`type`,`is_content`,`show_title`,`type_submenu`,`level_depth`,`active`,`position`,`submenu_content`,`show_sub`,`url`,`target`,`privacy`,`position_type`,`menu_class`,`content`,`icon_class`,`level`,`left`,`right`,`submenu_catids`,`is_cattree`,`date_add`,`date_upd` ) 
							VALUES(\'1\', \'\', \'0\', \'0\', \'\', \'\', \'\', \'\', \'2\', \'1\', \'category\', \'0\', \'1\', \'menu\', \'1\', \'1\', \'0\', \'\', \'0\', \'\', \'_self\', \'0\', \'\', \'\', \'\', \'\', \'0\', \'0\', \'0\', \'\', \'1\', \'2014-05-18 22:38:09\', \'2014-05-18 22:38:09\')'; 
 $query_sql['psverticalmenu'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu( `id_psverticalmenu`,`image`,`id_parent`,`is_group`,`width`,`submenu_width`,`colum_width`,`submenu_colum_width`,`item`,`colums`,`type`,`is_content`,`show_title`,`type_submenu`,`level_depth`,`active`,`position`,`submenu_content`,`show_sub`,`url`,`target`,`privacy`,`position_type`,`menu_class`,`content`,`icon_class`,`level`,`left`,`right`,`submenu_catids`,`is_cattree`,`date_add`,`date_upd` ) 
							VALUES(\'2\', \'\', \'1\', \'0\', \'\', \'\', \'\', \'\', \'\', \'1\', \'url\', \'0\', \'1\', \'menu\', \'2\', \'1\', \'0\', \'\', \'0\', \'\', \'_self\', \'0\', \'\', \'\', \'\', \'\', \'0\', \'0\', \'0\', \'\', \'1\', \'2015-08-27 00:25:03\', \'2015-08-27 00:25:03\')'; 
 $query_sql['psverticalmenu'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu( `id_psverticalmenu`,`image`,`id_parent`,`is_group`,`width`,`submenu_width`,`colum_width`,`submenu_colum_width`,`item`,`colums`,`type`,`is_content`,`show_title`,`type_submenu`,`level_depth`,`active`,`position`,`submenu_content`,`show_sub`,`url`,`target`,`privacy`,`position_type`,`menu_class`,`content`,`icon_class`,`level`,`left`,`right`,`submenu_catids`,`is_cattree`,`date_add`,`date_upd` ) 
							VALUES(\'3\', \'\', \'1\', \'0\', \'\', \'\', \'\', \'\', \'\', \'1\', \'url\', \'0\', \'1\', \'menu\', \'2\', \'1\', \'1\', \'\', \'0\', \'#\', \'_self\', \'0\', \'\', \'\', \'\', \'\', \'0\', \'0\', \'0\', \'\', \'1\', \'2015-08-27 00:27:47\', \'2015-08-27 00:27:47\')'; 
 $query_sql['psverticalmenu'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu( `id_psverticalmenu`,`image`,`id_parent`,`is_group`,`width`,`submenu_width`,`colum_width`,`submenu_colum_width`,`item`,`colums`,`type`,`is_content`,`show_title`,`type_submenu`,`level_depth`,`active`,`position`,`submenu_content`,`show_sub`,`url`,`target`,`privacy`,`position_type`,`menu_class`,`content`,`icon_class`,`level`,`left`,`right`,`submenu_catids`,`is_cattree`,`date_add`,`date_upd` ) 
							VALUES(\'4\', \'\', \'1\', \'0\', \'\', \'\', \'\', \'\', \'\', \'1\', \'url\', \'0\', \'1\', \'menu\', \'2\', \'1\', \'2\', \'\', \'0\', \'\', \'_self\', \'0\', \'\', \'\', \'\', \'\', \'0\', \'0\', \'0\', \'\', \'1\', \'2015-08-27 00:28:24\', \'2015-08-27 00:28:24\')'; 
 $query_sql['psverticalmenu'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu( `id_psverticalmenu`,`image`,`id_parent`,`is_group`,`width`,`submenu_width`,`colum_width`,`submenu_colum_width`,`item`,`colums`,`type`,`is_content`,`show_title`,`type_submenu`,`level_depth`,`active`,`position`,`submenu_content`,`show_sub`,`url`,`target`,`privacy`,`position_type`,`menu_class`,`content`,`icon_class`,`level`,`left`,`right`,`submenu_catids`,`is_cattree`,`date_add`,`date_upd` ) 
							VALUES(\'5\', \'\', \'1\', \'0\', \'\', \'\', \'\', \'\', \'\', \'1\', \'url\', \'0\', \'1\', \'menu\', \'2\', \'1\', \'3\', \'\', \'0\', \'\', \'_self\', \'0\', \'\', \'\', \'\', \'\', \'0\', \'0\', \'0\', \'\', \'1\', \'2015-08-27 00:28:57\', \'2015-08-27 00:28:57\')'; 
 $query_sql['psverticalmenu'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu( `id_psverticalmenu`,`image`,`id_parent`,`is_group`,`width`,`submenu_width`,`colum_width`,`submenu_colum_width`,`item`,`colums`,`type`,`is_content`,`show_title`,`type_submenu`,`level_depth`,`active`,`position`,`submenu_content`,`show_sub`,`url`,`target`,`privacy`,`position_type`,`menu_class`,`content`,`icon_class`,`level`,`left`,`right`,`submenu_catids`,`is_cattree`,`date_add`,`date_upd` ) 
							VALUES(\'6\', \'\', \'1\', \'0\', \'\', \'\', \'\', \'\', \'\', \'1\', \'url\', \'0\', \'1\', \'menu\', \'2\', \'1\', \'4\', \'\', \'0\', \'\', \'_self\', \'0\', \'\', \'\', \'\', \'\', \'0\', \'0\', \'0\', \'\', \'1\', \'2015-08-27 00:29:23\', \'2015-08-27 00:29:23\')'; 
 $query_sql['psverticalmenu'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu( `id_psverticalmenu`,`image`,`id_parent`,`is_group`,`width`,`submenu_width`,`colum_width`,`submenu_colum_width`,`item`,`colums`,`type`,`is_content`,`show_title`,`type_submenu`,`level_depth`,`active`,`position`,`submenu_content`,`show_sub`,`url`,`target`,`privacy`,`position_type`,`menu_class`,`content`,`icon_class`,`level`,`left`,`right`,`submenu_catids`,`is_cattree`,`date_add`,`date_upd` ) 
							VALUES(\'7\', \'\', \'1\', \'0\', \'\', \'\', \'\', \'\', \'\', \'1\', \'url\', \'0\', \'1\', \'menu\', \'2\', \'1\', \'5\', \'\', \'0\', \'#\', \'_self\', \'0\', \'\', \'\', \'\', \'\', \'0\', \'0\', \'0\', \'\', \'1\', \'2015-08-27 00:29:52\', \'2015-08-27 00:30:06\')'; 
 $query_sql['psverticalmenu'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu( `id_psverticalmenu`,`image`,`id_parent`,`is_group`,`width`,`submenu_width`,`colum_width`,`submenu_colum_width`,`item`,`colums`,`type`,`is_content`,`show_title`,`type_submenu`,`level_depth`,`active`,`position`,`submenu_content`,`show_sub`,`url`,`target`,`privacy`,`position_type`,`menu_class`,`content`,`icon_class`,`level`,`left`,`right`,`submenu_catids`,`is_cattree`,`date_add`,`date_upd` ) 
							VALUES(\'8\', \'\', \'1\', \'0\', \'\', \'\', \'\', \'\', \'\', \'1\', \'url\', \'0\', \'1\', \'menu\', \'2\', \'1\', \'6\', \'\', \'0\', \'#\', \'_self\', \'0\', \'\', \'\', \'\', \'\', \'0\', \'0\', \'0\', \'\', \'1\', \'2015-08-27 00:30:34\', \'2015-08-27 00:30:34\')'; 
 $query_sql['psverticalmenu'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu( `id_psverticalmenu`,`image`,`id_parent`,`is_group`,`width`,`submenu_width`,`colum_width`,`submenu_colum_width`,`item`,`colums`,`type`,`is_content`,`show_title`,`type_submenu`,`level_depth`,`active`,`position`,`submenu_content`,`show_sub`,`url`,`target`,`privacy`,`position_type`,`menu_class`,`content`,`icon_class`,`level`,`left`,`right`,`submenu_catids`,`is_cattree`,`date_add`,`date_upd` ) 
							VALUES(\'9\', \'\', \'1\', \'0\', \'\', \'\', \'\', \'\', \'\', \'1\', \'url\', \'0\', \'1\', \'menu\', \'2\', \'1\', \'7\', \'\', \'0\', \'#\', \'_self\', \'0\', \'\', \'\', \'\', \'\', \'0\', \'0\', \'0\', \'\', \'1\', \'2015-08-27 00:31:02\', \'2015-08-27 00:31:02\')'; 
/*DATA FOR TABLE psverticalmenu_lang*/
 $query_sql['psverticalmenu_lang'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_lang( `id_psverticalmenu`,`id_lang`,`title`,`text`,`description`,`content_text`,`submenu_content_text` ) 
							VALUES(\'1\', \'_LANGUAGEID_\', \'Home\', \'\', \'\', \'\', \'\')'; 
 $query_sql['psverticalmenu_lang'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_lang( `id_psverticalmenu`,`id_lang`,`title`,`text`,`description`,`content_text`,`submenu_content_text` ) 
							VALUES(\'2\', \'_LANGUAGEID_\', \'clothing, shoes & jewelry\', \'\', \'\', \'\', \'\')'; 
 $query_sql['psverticalmenu_lang'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_lang( `id_psverticalmenu`,`id_lang`,`title`,`text`,`description`,`content_text`,`submenu_content_text` ) 
							VALUES(\'3\', \'_LANGUAGEID_\', \'baby & kids\', \'\', \'\', \'\', \'\')'; 
 $query_sql['psverticalmenu_lang'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_lang( `id_psverticalmenu`,`id_lang`,`title`,`text`,`description`,`content_text`,`submenu_content_text` ) 
							VALUES(\'4\', \'_LANGUAGEID_\', \'home, furniture & patio\', \'\', \'\', \'\', \'\')'; 
 $query_sql['psverticalmenu_lang'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_lang( `id_psverticalmenu`,`id_lang`,`title`,`text`,`description`,`content_text`,`submenu_content_text` ) 
							VALUES(\'5\', \'_LANGUAGEID_\', \'electronics\', \'\', \'\', \'\', \'\')'; 
 $query_sql['psverticalmenu_lang'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_lang( `id_psverticalmenu`,`id_lang`,`title`,`text`,`description`,`content_text`,`submenu_content_text` ) 
							VALUES(\'6\', \'_LANGUAGEID_\', \'toys & video games\', \'\', \'\', \'\', \'\')'; 
 $query_sql['psverticalmenu_lang'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_lang( `id_psverticalmenu`,`id_lang`,`title`,`text`,`description`,`content_text`,`submenu_content_text` ) 
							VALUES(\'7\', \'_LANGUAGEID_\', \'movies, music & books\', \'\', \'\', \'\', \'\')'; 
 $query_sql['psverticalmenu_lang'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_lang( `id_psverticalmenu`,`id_lang`,`title`,`text`,`description`,`content_text`,`submenu_content_text` ) 
							VALUES(\'8\', \'_LANGUAGEID_\', \'sports, fitness & outdoors\', \'\', \'\', \'\', \'\')'; 
 $query_sql['psverticalmenu_lang'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_lang( `id_psverticalmenu`,`id_lang`,`title`,`text`,`description`,`content_text`,`submenu_content_text` ) 
							VALUES(\'9\', \'_LANGUAGEID_\', \'beauty, health & pharmacy\', \'\', \'\', \'\', \'\')'; 
/*DATA FOR TABLE psverticalmenu_shop*/
 $query_sql['psverticalmenu_shop'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_shop( `id_psverticalmenu`,`id_shop` ) 
							VALUES(\'1\', \'_SHOPID_\')'; 
 $query_sql['psverticalmenu_shop'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_shop( `id_psverticalmenu`,`id_shop` ) 
							VALUES(\'2\', \'_SHOPID_\')'; 
 $query_sql['psverticalmenu_shop'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_shop( `id_psverticalmenu`,`id_shop` ) 
							VALUES(\'3\', \'_SHOPID_\')'; 
 $query_sql['psverticalmenu_shop'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_shop( `id_psverticalmenu`,`id_shop` ) 
							VALUES(\'4\', \'_SHOPID_\')'; 
 $query_sql['psverticalmenu_shop'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_shop( `id_psverticalmenu`,`id_shop` ) 
							VALUES(\'5\', \'_SHOPID_\')'; 
 $query_sql['psverticalmenu_shop'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_shop( `id_psverticalmenu`,`id_shop` ) 
							VALUES(\'6\', \'_SHOPID_\')'; 
 $query_sql['psverticalmenu_shop'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_shop( `id_psverticalmenu`,`id_shop` ) 
							VALUES(\'7\', \'_SHOPID_\')'; 
 $query_sql['psverticalmenu_shop'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_shop( `id_psverticalmenu`,`id_shop` ) 
							VALUES(\'8\', \'_SHOPID_\')'; 
 $query_sql['psverticalmenu_shop'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_shop( `id_psverticalmenu`,`id_shop` ) 
							VALUES(\'9\', \'_SHOPID_\')'; 
/*DATA FOR TABLE psverticalmenu_widgets*/
 $query_sql['psverticalmenu_widgets'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_widgets( `id_widget`,`name`,`type`,`params`,`id_shop`,`key_widget` ) 
							VALUES(\'1\', \'New products\', \'productlist\', \'FIklTPxfoB7SPjkyh2lh5N/NPhC+CFM38NRRbprK7zJkKhbfc6oyOjKTVrBauPLjuPVweWk6tVa2IgTH1jhlpJo0EIUNNVUr2XQJCs0VLGgr8n3CCBaYQGvpq9Ty6PJ7pD8WkRb9xIYlgRSPa11HvDIK8cG2x/78u875KfURZRGzEhF+G87jXJMgOSNpqcAde8p6iYniFfqAkulGVKjpPuycePIC03ws1vGC2Yf7pWsMS/RrwayPNw7MlhElfrt10u9htGQazDcGrwiw4K63y/KuWZbyz98AmooQneKd7H2CZA2hnBPw+nqoDb4hm6j03BO10z1NViQUf4qqO4hlVVVNhhsa9kWeU9CWxku+zWkMXE90NQqn2toTLJPMC14pD+zee+lbXDJzDLD0fZfleo/v2RfwnoFmn0t2t+9tXb9jouxQdO7ASfh4QhQOg7fDd/AKiZSRSQnc7tJt+zgG88IbYqoQDuCuSN6Bbdq3sk1VUxZMcirFYMu/ByqNnl3Um04eeUHTfbm0qzcfFgT0J67btKpf2Fhli+7ckS6wIWz72Hs52Ffgr4t89P2YJw+agT24lLn9RfgfOGhM58LSocPuv+WJ8/G36OhIxwVoqccT5vVRbX17DVaaUYYXYDUcWhpj95RQlPsvbU5qbLzsJ7am/RXp/XplGo6sTRz6t5wAinzqKGBtAKVkXWMlKYHOHx7771030mmm0m+fzv0fbVXkLi6znhz43dA9lin4nEOgQyxVajDayI08PBwdtIJaSwvWJp56EhWUfeHAUaOqnvsTz349cjIMFw3pXsbqPSGoQ23nE5nmoqr37FXRD6pUNKJRvZcJCRPSem8xZKJtcvqbHZMmZnD9YBXW1XuBPRY=000646\', \'_SHOPID_\', \'1440661560\')'; 
 $query_sql['psverticalmenu_widgets'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_widgets( `id_widget`,`name`,`type`,`params`,`id_shop`,`key_widget` ) 
							VALUES(\'2\', \'link1\', \'links\', \'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\', \'_SHOPID_\', \'1440661720\')'; 
 $query_sql['psverticalmenu_widgets'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_widgets( `id_widget`,`name`,`type`,`params`,`id_shop`,`key_widget` ) 
							VALUES(\'3\', \'link2\', \'links\', \'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003270\', \'_SHOPID_\', \'1440661912\')'; 
 $query_sql['psverticalmenu_widgets'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_widgets( `id_widget`,`name`,`type`,`params`,`id_shop`,`key_widget` ) 
							VALUES(\'4\', \'link4\', \'links\', \'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003217\', \'_SHOPID_\', \'1440662020\')'; 
 $query_sql['psverticalmenu_widgets'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_widgets( `id_widget`,`name`,`type`,`params`,`id_shop`,`key_widget` ) 
							VALUES(\'5\', \'link3\', \'links\', \'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003054\', \'_SHOPID_\', \'1440662243\')'; 
 $query_sql['psverticalmenu_widgets'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_widgets( `id_widget`,`name`,`type`,`params`,`id_shop`,`key_widget` ) 
							VALUES(\'6\', \'manufacture\', \'manufacture\', \'7UuhYaYQSkS4j2b9cv5fL9/NPhC+CFM38NRRbprK7zJkKhbfc6oyOjKTVrBauPLjuPVweWk6tVa2IgTH1jhlpJo0EIUNNVUr2XQJCs0VLGjgaDKTMwCKkJo4EczxhkRnVx/oQ/laiUQGn2St+tBf7rFXBMtoq91fJxHnRvXl2JtsZhNQICmY7DBxGLkikuq2YqjyoFUmLSvio3wB5p9+k6DOgqvE5mri4ZFYVpJRkfTjVkiTDGGReS4HehpjnOXHpJ5Kdfi6LDIPTux1TiqC76KtXykQRfh4JFpAWIJobjCcPL7noTuWFJI3ycFroB6lLaoEMCiYKPhc+1eQLqU2ZDYIt6N8EDR1dYhEDVm7RFhZrOuaO6Cw1NMxt45SpOTgE4zVaRbFymUR3KNUIQbW1dPpFd3N/ABRus8K1OAcepPszO2G6zMF36m+/5CPsPKQ4Jr/mAf/t+FNomoDpD+XiP0fSo1T/ppXZj2quFEkzeB+X+egExk/i40hfcO3xk3eji7VmUNYlG4ugRTomZGPG+OdDScfcpniJMFeMdFDnKma5JTtdysv/dWPr5oe0tjSkWqZNlQl/lSfi4//IYYsXw+n1vyHOGSTcierbeeDs77ZmyEWHzVxChn0/IFMw8nkoM6Cq8TmauLhkVhWklGR9HmgP5TiCVTAJb5k3io96lIefjjLCNudfRO/up77KFCx/cZDTqAaNO8/HkWz5Xg/vg==000538\', \'_SHOPID_\', \'1440662444\')'; 
 $query_sql['psverticalmenu_widgets'][] = 'INSERT INTO '._DB_PREFIX_.'psverticalmenu_widgets( `id_widget`,`name`,`type`,`params`,`id_shop`,`key_widget` ) 
							VALUES(\'7\', \'subcategories\', \'subcategories\', \'FIklTPxfoB7SPjkyh2lh5N/NPhC+CFM38NRRbprK7zJkKhbfc6oyOjKTVrBauPLjnNwsyNbruUjc4RyyMyLM+dVubIYTc3QcgDnRXbd3Sv7KnubvT+fpZPILcOtiKWSLOxCoM3I1ySNAlpykitR9QXk9JGtuFdMy3cxCLpbLfSn61f3aGCQv0DN/QOqJsPf73h+GnYFohvPtKn2HOTWozfChV8939W2vIDUsWQnLODvjZ8PYNPxuhNOQ8C6tQzcryp7m70/n6WTyC3DrYilki5ZbTDXG0u6GeWqJYB7CCKWU3kpKIbeWh40RK3TgR0luyzb+yJRRrMDc2h41KbZ9aSgiO2b1CYvuvZrbggK5gRFkqT76g6n5Yyezm7vuHtJxbGYTUCApmOwwcRi5IpLqtpDomNZ4Q6aijaPGmGRC4hU9LB9p1c94Bu2Hcr8PwL8HYJQ40H5LE0w67QbPcTnXK3OxCkvfWOHTKB9a/OKh92HS72G0ZBrMNwavCLDgrrfLW3mt0utv4EmJwYyQmTFjhsc7dKnFscoWUrU83VNxy1gBnNZTZeyd51CEFwHWg+YlbGYTUCApmOwwcRi5IpLqtjW5JV+FbqYowFtb19gYDg09LB9p1c94Bu2Hcr8PwL8HYJQ40H5LE0w67QbPcTnXK3KfRZIpkx2yKNNtoKQS3iGauc+jDoJb3RKptkJIYL1rW3mt0utv4EmJwYyQmTFjhsc7dKnFscoWUrU83VNxy1gHgHhI/vVNAqC1GRLdljawbGYTUCApmOwwcRi5IpLqtjFfDuElUfKEQZfRdGGXPsQ9LB9p1c94Bu2Hcr8PwL8HYJQ40H5LE0w67QbPcTnXK7hR4CayudDq+LjTvMOfkfY=000651\', \'_SHOPID_\', \'1440662489\')'; 

 ?>