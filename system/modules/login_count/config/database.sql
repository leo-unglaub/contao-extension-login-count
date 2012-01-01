-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_member`
-- 

CREATE TABLE `tl_member` (
  `lu_login_count` int(10) unsigned NOT NULL default '0',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------


-- 
-- Table `tl_content`
-- 

CREATE TABLE `tl_content` (
  `lc_from` int(10) unsigned NOT NULL default '0',
  `lc_to` int(10) unsigned NOT NULL default '0',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;