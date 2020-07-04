ALTER TABLE `st_cats` CHANGE `name` `title` VARCHAR(70) NOT NULL DEFAULT '';
ALTER TABLE `st_cats` CHANGE `type` `type` VARCHAR(20) NOT NULL DEFAULT '1';
UPDATE `st_cats` SET `verof`=`id`;


CREATE TABLE IF NOT EXISTS st_config(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL DEFAULT '',
	value TEXT NOT NULL DEFAULT '',
	autoload INT(1) NOT NULL DEFAULT 0
)DEFAULT CHARSET = UTF8;

INSERT INTO st_config(name, value) VALUES
('site_title',''),
('site_descrip',''),
('site_url',''),
('site_email',''),
('site_lang','es'),
('site_langmulti','1'),
('site_plugins',''),
('site_login_attempts','10'),
('theme_name','default'),
('theme_dir','themes/default'),
('cms_name','Stradow CMS'),
('cms_version','Alfa 2.0'),
('cms_updated','2019-08-01'),
('count_users','1'),
('count_pages','0'),
('count_blog_post','0'),
('count_blog_cat','0'),
('count_blog_tag','0');

ALTER TABLE `st_cats` ADD `cover` VARCHAR(250) NOT NULL AFTER `superior`;
ALTER TABLE `st_profiles` DROP `s_facebook`, DROP `s_twitter`, DROP `s_google`;
ALTER TABLE `st_profiles` ADD `social` TEXT NOT NULL AFTER `site`, ADD `avatar` VARCHAR(250) NOT NULL AFTER `social`, ADD `avatarlocal` VARCHAR(250) NOT NULL AFTER `avatar`, ADD `cover` VARCHAR(250) NOT NULL AFTER `avatarlocal`, ADD `coverlocal` VARCHAR(250) NOT NULL AFTER `cover`;

ALTER TABLE `st_posts` ADD `publidate` DATETIME NOT NULL DEFAULT '2017-01-01 00:00:00' AFTER `verof`, ADD `visibility` INT(2) NOT NULL DEFAULT '1' AFTER `publidate`, ADD `sticky` INT(1) NOT NULL DEFAULT '0' AFTER `visibility`, ADD `suporder` INT(11) NOT NULL DEFAULT '1' AFTER `sticky`, ADD `target` INT(1) NOT NULL DEFAULT '0' AFTER `suporder`, ADD `specialtype` VARCHAR(20) NOT NULL DEFAULT '' AFTER `target`;

CREATE TABLE IF NOT EXISTS st_collections(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(70) NOT NULL DEFAULT '',
	slug VARCHAR(70) NOT NULL DEFAULT '',
	permalink VARCHAR(250) NOT NULL DEFAULT '',
	descrip VARCHAR(70) NOT NULL DEFAULT '',
	type VARCHAR(20) NOT NULL DEFAULT '',
	superior INT(11) NOT NULL DEFAULT 0,
	suporder INT(11) NOT NULL DEFAULT 1,
	cover VARCHAR(250) NOT NULL DEFAULT '',
	image VARCHAR(250) NOT NULL DEFAULT '',
	state INT(2) NOT NULL DEFAULT 1,
	created DATETIME NOT NULL DEFAULT '2017-01-01 00:00:00',
	updated DATETIME NOT NULL DEFAULT '2017-01-01 00:00:00',
	count INT(11) NOT NULL DEFAULT 0,
	lang VARCHAR(20) NOT NULL DEFAULT 'es',
	verof INT(11) NOT NULL DEFAULT 0
)DEFAULT CHARSET = UTF8;
CREATE TABLE IF NOT EXISTS st_collections_rel(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	post_id INT(11) NOT NULL DEFAULT 0,
	collection_id INT(11) NOT NULL DEFAULT 0
)DEFAULT CHARSET = UTF8;
