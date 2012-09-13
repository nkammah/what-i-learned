CREATE TABLE IF NOT EXISTS `whatilearned_knowledgebit` (
   `id` INTEGER unsigned NOT NULL auto_increment,
   `title` varchar(50) collate utf8_unicode_ci NOT NULL default '',
   `description` varchar(50) collate utf8_unicode_ci,
   `category` varchar(100),
   `url` text,
   `date_added` datetime,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `whatilearned_knowledgebit` VALUES (1, 'Re-run the last command using !', 'javin@testenv1 ~/java : !find\nfind . -name "*.java"\t--last find command executed', 'unix', 'http://javarevisited.blogspot.com/2011/03/10-find-command-in-unix-examples-basic.html#ixzz26MeEEnNF','');
