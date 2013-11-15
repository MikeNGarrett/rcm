-- phpMyAdmin SQL Dump
-- version 4.0.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 15, 2013 at 01:55 AM
-- Server version: 5.0.95
-- PHP Version: 5.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `rcm`
--

-- --------------------------------------------------------

--
-- Table structure for table `rcm_bwps_lockouts`
--

CREATE TABLE IF NOT EXISTS `rcm_bwps_lockouts` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(1) NOT NULL,
  `active` int(1) NOT NULL,
  `starttime` int(10) NOT NULL,
  `exptime` int(10) NOT NULL,
  `host` varchar(20) default NULL,
  `user` bigint(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rcm_bwps_log`
--

CREATE TABLE IF NOT EXISTS `rcm_bwps_log` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(1) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `host` varchar(20) default NULL,
  `user` bigint(20) default NULL,
  `username` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `mem_used` varchar(255) default NULL,
  `referrer` varchar(255) default NULL,
  `data` mediumtext,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



--
-- Dumping data for table `rcm_options`
--

INSERT INTO `rcm_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(NULL, 'members_db_version', '2', 'yes'),
(NULL, 'members_settings', 'a:8:{s:12:"role_manager";i:1;s:19:"content_permissions";i:1;s:12:"private_blog";i:0;s:12:"private_feed";i:0;s:17:"login_form_widget";i:0;s:12:"users_widget";i:0;s:25:"content_permissions_error";s:85:"<p class="restricted">Sorry, but you do not have permission to view this content.</p>";s:18:"private_feed_error";s:80:"<p class="restricted">You must be logged into the site to view this content.</p>";}', 'yes'),
(NULL, 'bit51_bwps_data', 'a:2:{s:7:"version";s:4:"3063";s:13:"activatestamp";i:1384495845;}', 'yes'),
(NULL, 'bit51_bwps', 'a:74:{s:10:"bu_banlist";s:1:"\n";s:12:"id_whitelist";s:0:"";s:13:"st_writefiles";i:1;s:17:"initial_filewrite";i:1;s:14:"ssl_forcelogin";s:1:"0";s:14:"ssl_forceadmin";s:1:"0";s:12:"ssl_frontend";i:1;s:14:"initial_backup";s:1:"0";s:10:"am_enabled";s:1:"0";s:7:"am_type";s:1:"0";s:12:"am_startdate";s:1:"1";s:10:"am_enddate";s:1:"1";s:12:"am_starttime";s:1:"1";s:10:"am_endtime";s:1:"1";s:12:"backup_email";s:1:"1";s:19:"backup_emailaddress";s:0:"";s:11:"backup_time";s:1:"1";s:15:"backup_interval";s:1:"1";s:14:"backup_enabled";s:1:"0";s:11:"backup_last";s:0:"";s:11:"backup_next";s:0:"";s:17:"backups_to_retain";s:2:"10";s:10:"bu_enabled";s:1:"0";s:11:"bu_banagent";s:0:"";s:12:"bu_blacklist";s:1:"0";s:10:"hb_enabled";s:1:"0";s:8:"hb_login";s:5:"login";s:11:"hb_register";s:8:"register";s:8:"hb_admin";s:5:"admin";s:6:"hb_key";s:0:"";s:10:"ll_enabled";s:1:"0";s:18:"ll_maxattemptshost";s:1:"5";s:18:"ll_maxattemptsuser";s:2:"10";s:16:"ll_checkinterval";s:1:"5";s:12:"ll_banperiod";s:2:"15";s:14:"ll_blacklistip";s:1:"1";s:23:"ll_blacklistipthreshold";s:1:"3";s:14:"ll_emailnotify";s:1:"1";s:15:"ll_emailaddress";s:0:"";s:10:"id_enabled";s:1:"0";s:14:"id_emailnotify";s:1:"1";s:16:"id_checkinterval";s:1:"5";s:12:"id_threshold";s:2:"20";s:12:"id_banperiod";s:2:"15";s:14:"id_blacklistip";s:1:"0";s:23:"id_blacklistipthreshold";s:1:"3";s:15:"id_emailaddress";s:0:"";s:14:"id_fileenabled";s:1:"0";s:18:"id_fileemailnotify";s:1:"1";s:19:"id_filedisplayerror";s:1:"1";s:19:"id_fileemailaddress";s:0:"";s:14:"id_specialfile";s:0:"";s:12:"id_fileincex";s:1:"1";s:16:"id_filechecktime";s:0:"";s:11:"st_ht_files";s:1:"0";s:14:"st_ht_browsing";s:1:"0";s:13:"st_ht_request";s:1:"0";s:11:"st_ht_query";s:1:"0";s:13:"st_ht_foreign";s:1:"0";s:12:"st_generator";s:1:"0";s:11:"st_manifest";s:1:"0";s:10:"st_edituri";s:1:"0";s:11:"st_themenot";s:1:"0";s:12:"st_pluginnot";s:1:"0";s:10:"st_corenot";s:1:"0";s:17:"st_enablepassword";s:1:"0";s:11:"st_passrole";s:13:"administrator";s:13:"st_loginerror";s:1:"0";s:11:"st_fileperm";s:1:"0";s:10:"st_comment";s:1:"0";s:16:"st_randomversion";s:1:"0";s:10:"st_longurl";s:1:"0";s:11:"st_fileedit";s:1:"0";s:14:"oneclickchosen";s:1:"0";}', 'yes'),
(NULL, '_site_transient_update_plugins', 'O:8:"stdClass":4:{s:12:"last_checked";i:1384496887;s:7:"checked";a:12:{s:30:"advanced-custom-fields/acf.php";s:5:"4.3.0";s:42:"acf-location-field-master/acf-location.php";s:5:"1.0.0";s:19:"akismet/akismet.php";s:5:"2.5.9";s:35:"backupwordpress/backupwordpress.php";s:5:"2.3.3";s:41:"better-wp-security/better-wp-security.php";s:5:"3.5.6";s:43:"custom-post-type-ui/custom-post-type-ui.php";s:5:"0.8.2";s:17:"jarvis/jarvis.php";s:3:"0.2";s:19:"members/members.php";s:5:"0.2.4";s:33:"w3-total-cache/w3-total-cache.php";s:5:"0.9.3";s:41:"wordpress-importer/wordpress-importer.php";s:5:"0.6.1";s:24:"wordpress-seo/wp-seo.php";s:6:"1.4.19";s:42:"yet-another-related-posts-plugin/yarpp.php";s:5:"4.0.8";}s:8:"response";a:0:{}s:12:"translations";a:0:{}}', 'yes');
