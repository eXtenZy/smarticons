DROP TABLE IF EXISTS `#__smarticons`;
CREATE TABLE IF NOT EXISTS `#__smarticons` (
  `idIcon` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  'FK to the #__assets table.',
  `catid` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Text` varchar(255) NOT NULL,
  `Target` varchar(255) NOT NULL,
  `Icon` varchar(255) NOT NULL,
  `Display` tinyint(3) NOT NULL,
  `state` tinyint(3) NOT NULL,
  `ordering` int(11) NOT NULL,
  `params` text NOT NULL,
  `checked_out` int(10) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY (`idIcon`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;