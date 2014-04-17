-- -----------------------------------------------------
-- Table `music`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `music` ;

CREATE TABLE IF NOT EXISTS `music` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `owner` BIGINT(20) NOT NULL,
  `owner2` BIGINT(2) NULL DEFAULT NULL,
  `email` VARCHAR(55) NOT NULL,
  `name` VARCHAR(55) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `picture` VARCHAR(255) NULL DEFAULT NULL,
  `date` DATETIME NOT NULL,
  `file` VARCHAR(255) NOT NULL,
  `tags` VARCHAR(255) NULL DEFAULT NULL,
  `likes` INT NOT NULL DEFAULT 0,
  `downloads` INT NOT NULL DEFAULT 0,
  `private` TINYINT(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `users_following`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users_following` ;

CREATE TABLE IF NOT EXISTS `users_following` (
  `user_id` BIGINT(20) NOT NULL,
  `following` BIGINT(20) NOT NULL,
  PRIMARY KEY (`user_id`, `following`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `saved_music`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `saved_music` ;

CREATE TABLE IF NOT EXISTS `saved_music` (
  `user_id` INT NOT NULL,
  `music_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `music_id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `logs` for the API
-- -----------------------------------------------------

CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text DEFAULT NULL,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `a3m_account`
--

CREATE TABLE IF NOT EXISTS `a3m_account` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(24) NOT NULL,
  `email` varchar(160) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `createdon` datetime NOT NULL,
  `verifiedon` datetime DEFAULT NULL,
  `lastsignedinon` datetime DEFAULT NULL,
  `resetsenton` datetime DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `suspendedon` datetime DEFAULT NULL,
  `forceresetpass` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 ROW_FORMAT = DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `a3m_account_details`
--

CREATE TABLE IF NOT EXISTS `a3m_account_details` (
  `account_id` bigint(20) unsigned NOT NULL,
  `firstname` varchar(80) DEFAULT NULL,
  `lastname` varchar(80) DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `country` char(2) DEFAULT NULL,
  `language` char(2) DEFAULT NULL,
  `timezone` varchar(40) DEFAULT NULL,
  `citimezone` varchar(6) DEFAULT NULL,
  `picture` varchar(240) DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------
--
-- Table structure for table `a3m_providers`
--

CREATE TABLE IF NOT EXISTS `a3m_providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'refer to a3m_account.id',
  `provider` varchar(100) NOT NULL,
  `provider_uid` varchar(255) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `display_name` varchar(150) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `profile_url` varchar(300) DEFAULT NULL,
  `website_url` varchar(300) DEFAULT NULL,
  `photo_url` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `provider_uid` (`provider_uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `a3m_acl_permission`
--

CREATE TABLE IF NOT EXISTS `a3m_acl_permission` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suspendedon` datetime DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `key` (`key`)
) ENGINE = InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `a3m_acl_permission`
--

INSERT INTO `a3m_acl_permission` (`key`, `description`, `is_system`) VALUES
('create_roles', 'Create new roles', 1),
('retrieve_roles', 'View existing roles', 1),
('update_roles', 'Update existing roles', 1),
('delete_roles', 'Delete existing roles', 1),
('create_permissions', 'Create new permissions', 1),
('retrieve_permissions', 'View existing permissions', 1),
('update_permissions', 'Update existing permissions', 1),
('delete_permissions', 'Delete existing permissions', 1),
('create_users', 'Create new users', 1),
('retrieve_users', 'View existing users', 1),
('update_users', 'Update existing users', 1),
('delete_users', 'Delete existing users', 1),
('ban_users', 'Ban and Unban existing users', 1),
('password_reset_users', 'Force user to reset password upon next login', 1);

-- --------------------------------------------------------

--
-- Table structure for table `a3m_acl_role`
--

CREATE TABLE IF NOT EXISTS `a3m_acl_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suspendedon` datetime DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`name`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `a3m_acl_role`
--

INSERT INTO `a3m_acl_role` (`name`, `description`, `is_system`) VALUES
('Admin', 'Website Administrator', 1),
('User', 'Website user', 0);

-- --------------------------------------------------------

--
-- Table structure for table `a3m_rel_account_permission`
--

CREATE TABLE IF NOT EXISTS `a3m_rel_account_permission` (
  `account_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`account_id`,`permission_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a3m_rel_account_role`
--

CREATE TABLE IF NOT EXISTS `a3m_rel_account_role` (
  `account_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`account_id`,`role_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `a3m_rel_role_permission`
--

CREATE TABLE IF NOT EXISTS `a3m_rel_role_permission` (
  `role_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Giving the Admin role (1) all permissions
--

INSERT INTO `a3m_rel_role_permission` (`role_id`, `permission_id`) 
SELECT 1, `id` FROM `a3m_acl_permission`;


-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS  `ci_sessions` (
    `session_id` varchar(40) DEFAULT '0' NOT NULL,
    `ip_address` varchar(45) DEFAULT '0' NOT NULL,
    `user_agent` varchar(120) NOT NULL,
    `last_activity` int(10) unsigned DEFAULT 0 NOT NULL,
    `user_data` text NOT NULL,
    PRIMARY KEY (`session_id`, `ip_address`, `user_agent`),
    KEY `last_activity_idx` (`last_activity`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_country`
--

CREATE TABLE IF NOT EXISTS `ref_country` (
  `alpha2` char(2) NOT NULL,
  `alpha3` char(3) NOT NULL,
  `numeric` varchar(3) NOT NULL,
  `country` varchar(80) NOT NULL,
  PRIMARY KEY (`alpha2`),
  UNIQUE KEY `alpha3` (`alpha3`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Adding default user as admin `a3m_acl_role`
--

INSERT INTO `a3m_rel_account_role` (`account_id`, `role_id`) VALUES (1, 1);

-- --------------------------------------------------------

--
-- Dumping data for table `ref_country`
--

INSERT INTO `ref_country` (`alpha2`, `alpha3`, `numeric`, `country`) VALUES
('ao', 'ago', '024', 'Angola'),
('ai', 'aia', '660', 'Anguilla'),
('aq', 'ata', '010', 'Antarctica'),
('ag', 'atg', '028', 'Antigua and Barbuda'),
('ar', 'arg', '032', 'Argentina'),
('am', 'arm', '051', 'Armenia'),
('aw', 'abw', '533', 'Aruba'),
('au', 'aus', '036', 'Australia'),
('at', 'aut', '040', 'Austria'),
('az', 'aze', '031', 'Azerbaijan'),
('bs', 'bhs', '044', 'Bahamas'),
('bh', 'bhr', '048', 'Bahrain'),
('bd', 'bgd', '050', 'Bangladesh'),
('bb', 'brb', '052', 'Barbados'),
('by', 'blr', '112', 'Belarus'),
('be', 'bel', '056', 'Belgium'),
('bz', 'blz', '084', 'Belize'),
('bj', 'ben', '204', 'Benin'),
('bm', 'bmu', '060', 'Bermuda'),
('bt', 'btn', '064', 'Bhutan'),
('bo', 'bol', '068', 'Bolivia, Plurinational State of'),
('ba', 'bih', '070', 'Bosnia and Herzegovina'),
('bw', 'bwa', '072', 'Botswana'),
('bv', 'bvt', '074', 'Bouvet Island'),
('br', 'bra', '076', 'Brazil'),
('io', 'iot', '086', 'British Indian Ocean Territory'),
('bn', 'brn', '096', 'Brunei Darussalam'),
('bg', 'bgr', '100', 'Bulgaria'),
('bf', 'bfa', '854', 'Burkina Faso'),
('bi', 'bdi', '108', 'Burundi'),
('kh', 'khm', '116', 'Cambodia'),
('cm', 'cmr', '120', 'Cameroon'),
('ca', 'can', '124', 'Canada'),
('cv', 'cpv', '132', 'Cape Verde'),
('ky', 'cym', '136', 'Cayman Islands'),
('cf', 'caf', '140', 'Central African Republic'),
('td', 'tcd', '148', 'Chad'),
('cl', 'chl', '152', 'Chile'),
('cn', 'chn', '156', 'China'),
('cx', 'cxr', '162', 'Christmas Island'),
('cc', 'cck', '166', 'Cocos (Keeling) Islands'),
('co', 'col', '170', 'Colombia'),
('km', 'com', '174', 'Comoros'),
('cg', 'cog', '178', 'Congo'),
('cd', 'cod', '180', 'Congo, the Democratic Republic of the'),
('ck', 'cok', '184', 'Cook Islands'),
('cr', 'cri', '188', 'Costa Rica'),
('ci', 'civ', '384', 'Côte d''Ivoire'),
('hr', 'hrv', '191', 'Croatia'),
('cu', 'cub', '192', 'Cuba'),
('cy', 'cyp', '196', 'Cyprus'),
('cz', 'cze', '203', 'Czech Republic'),
('dk', 'dnk', '208', 'Denmark'),
('dj', 'dji', '262', 'Djibouti'),
('dm', 'dma', '212', 'Dominica'),
('do', 'dom', '214', 'Dominican Republic'),
('ec', 'ecu', '218', 'Ecuador'),
('eg', 'egy', '818', 'Egypt'),
('sv', 'slv', '222', 'El Salvador'),
('gq', 'gnq', '226', 'Equatorial Guinea'),
('er', 'eri', '232', 'Eritrea'),
('ee', 'est', '233', 'Estonia'),
('et', 'eth', '231', 'Ethiopia'),
('fk', 'flk', '238', 'Falkland Islands (Malvinas)'),
('fo', 'fro', '234', 'Faroe Islands'),
('fj', 'fji', '242', 'Fiji'),
('fi', 'fin', '246', 'Finland'),
('fr', 'fra', '250', 'France'),
('gf', 'guf', '254', 'French Guiana'),
('pf', 'pyf', '258', 'French Polynesia'),
('tf', 'atf', '260', 'French Southern Territories'),
('ga', 'gab', '266', 'Gabon'),
('gm', 'gmb', '270', 'Gambia'),
('ge', 'geo', '268', 'Georgia'),
('de', 'deu', '276', 'Germany'),
('gh', 'gha', '288', 'Ghana'),
('gi', 'gib', '292', 'Gibraltar'),
('gr', 'grc', '300', 'Greece'),
('gl', 'grl', '304', 'Greenland'),
('gd', 'grd', '308', 'Grenada'),
('gp', 'glp', '312', 'Guadeloupe'),
('gu', 'gum', '316', 'Guam'),
('gt', 'gtm', '320', 'Guatemala'),
('gg', 'ggy', '831', 'Guernsey'),
('gn', 'gin', '324', 'Guinea'),
('gw', 'gnb', '624', 'Guinea-Bissau'),
('gy', 'guy', '328', 'Guyana'),
('ht', 'hti', '332', 'Haiti'),
('hm', 'hmd', '334', 'Heard Island and McDonald Islands'),
('va', 'vat', '336', 'Holy See (Vatican City State)'),
('hn', 'hnd', '340', 'Honduras'),
('hk', 'hkg', '344', 'Hong Kong'),
('hu', 'hun', '348', 'Hungary'),
('is', 'isl', '352', 'Iceland'),
('in', 'ind', '356', 'India'),
('id', 'idn', '360', 'Indonesia'),
('ir', 'irn', '364', 'Iran, Islamic Republic of'),
('iq', 'irq', '368', 'Iraq'),
('ie', 'irl', '372', 'Ireland'),
('im', 'imn', '833', 'Isle of Man'),
('il', 'isr', '376', 'Israel'),
('it', 'ita', '380', 'Italy'),
('jm', 'jam', '388', 'Jamaica'),
('jp', 'jpn', '392', 'Japan'),
('je', 'jey', '832', 'Jersey'),
('jo', 'jor', '400', 'Jordan'),
('kz', 'kaz', '398', 'Kazakhstan'),
('ke', 'ken', '404', 'Kenya'),
('ki', 'kir', '296', 'Kiribati'),
('kp', 'prk', '408', 'Korea, Democratic People''s Republic of'),
('kr', 'kor', '410', 'Korea, Republic of'),
('kw', 'kwt', '414', 'Kuwait'),
('kg', 'kgz', '417', 'Kyrgyzstan'),
('la', 'lao', '418', 'Lao People''s Democratic Republic'),
('lv', 'lva', '428', 'Latvia'),
('lb', 'lbn', '422', 'Lebanon'),
('ls', 'lso', '426', 'Lesotho'),
('lr', 'lbr', '430', 'Liberia'),
('ly', 'lby', '434', 'Libyan Arab Jamahiriya'),
('li', 'lie', '438', 'Liechtenstein'),
('lt', 'ltu', '440', 'Lithuania'),
('lu', 'lux', '442', 'Luxembourg'),
('mo', 'mac', '446', 'Macao'),
('mk', 'mkd', '807', 'Macedonia, the former Yugoslav Republic of'),
('mg', 'mdg', '450', 'Madagascar'),
('mw', 'mwi', '454', 'Malawi'),
('my', 'mys', '458', 'Malaysia'),
('mv', 'mdv', '462', 'Maldives'),
('ml', 'mli', '466', 'Mali'),
('mt', 'mlt', '470', 'Malta'),
('mh', 'mhl', '584', 'Marshall Islands'),
('mq', 'mtq', '474', 'Martinique'),
('mr', 'mrt', '478', 'Mauritania'),
('mu', 'mus', '480', 'Mauritius'),
('yt', 'myt', '175', 'Mayotte'),
('mx', 'mex', '484', 'Mexico'),
('fm', 'fsm', '583', 'Micronesia, Federated States of'),
('md', 'mda', '498', 'Moldova, Republic of'),
('mc', 'mco', '492', 'Monaco'),
('mn', 'mng', '496', 'Mongolia'),
('me', 'mne', '499', 'Montenegro'),
('ms', 'msr', '500', 'Montserrat'),
('ma', 'mar', '504', 'Morocco'),
('mz', 'moz', '508', 'Mozambique'),
('mm', 'mmr', '104', 'Myanmar'),
('na', 'nam', '516', 'Namibia'),
('nr', 'nru', '520', 'Nauru'),
('np', 'npl', '524', 'Nepal'),
('nl', 'nld', '528', 'Netherlands'),
('an', 'ant', '530', 'Netherlands Antilles'),
('nc', 'ncl', '540', 'New Caledonia'),
('nz', 'nzl', '554', 'New Zealand'),
('ni', 'nic', '558', 'Nicaragua'),
('ne', 'ner', '562', 'Niger'),
('ng', 'nga', '566', 'Nigeria'),
('nu', 'niu', '570', 'Niue'),
('nf', 'nfk', '574', 'Norfolk Island'),
('mp', 'mnp', '580', 'Northern Mariana Islands'),
('no', 'nor', '578', 'Norway'),
('om', 'omn', '512', 'Oman'),
('pk', 'pak', '586', 'Pakistan'),
('pw', 'plw', '585', 'Palau'),
('ps', 'pse', '275', 'Palestinian Territory, Occupied'),
('pa', 'pan', '591', 'Panama'),
('pg', 'png', '598', 'Papua New Guinea'),
('py', 'pry', '600', 'Paraguay'),
('pe', 'per', '604', 'Peru'),
('ph', 'phl', '608', 'Philippines'),
('pn', 'pcn', '612', 'Pitcairn'),
('pl', 'pol', '616', 'Poland'),
('pt', 'prt', '620', 'Portugal'),
('pr', 'pri', '630', 'Puerto Rico'),
('qa', 'qat', '634', 'Qatar'),
('re', 'reu', '638', 'Réunion'),
('ro', 'rou', '642', 'Romania'),
('ru', 'rus', '643', 'Russian Federation'),
('rw', 'rwa', '646', 'Rwanda'),
('bl', 'blm', '652', 'Saint Barthélemy'),
('sh', 'shn', '654', 'Saint Helena'),
('kn', 'kna', '659', 'Saint Kitts and Nevis'),
('lc', 'lca', '662', 'Saint Lucia'),
('mf', 'maf', '663', 'Saint Martin (French part)'),
('pm', 'spm', '666', 'Saint Pierre and Miquelon'),
('vc', 'vct', '670', 'Saint Vincent and the Grenadines'),
('ws', 'wsm', '882', 'Samoa'),
('sm', 'smr', '674', 'San Marino'),
('st', 'stp', '678', 'Sao Tome and Principe'),
('sa', 'sau', '682', 'Saudi Arabia'),
('sn', 'sen', '686', 'Senegal'),
('rs', 'srb', '688', 'Serbia'),
('sc', 'syc', '690', 'Seychelles'),
('sl', 'sle', '694', 'Sierra Leone'),
('sg', 'sgp', '702', 'Singapore'),
('sk', 'svk', '703', 'Slovakia'),
('si', 'svn', '705', 'Slovenia'),
('sb', 'slb', '090', 'Solomon Islands'),
('so', 'som', '706', 'Somalia'),
('za', 'zaf', '710', 'South Africa'),
('gs', 'sgs', '239', 'South Georgia and the South Sandwich Islands'),
('es', 'esp', '724', 'Spain'),
('lk', 'lka', '144', 'Sri Lanka'),
('sd', 'sdn', '736', 'Sudan'),
('sr', 'sur', '740', 'Suriname'),
('sj', 'sjm', '744', 'Svalbard and Jan Mayen'),
('sz', 'swz', '748', 'Swaziland'),
('se', 'swe', '752', 'Sweden'),
('ch', 'che', '756', 'Switzerland'),
('sy', 'syr', '760', 'Syrian Arab Republic'),
('tw', 'twn', '158', 'Taiwan, Province of China'),
('tj', 'tjk', '762', 'Tajikistan'),
('tz', 'tza', '834', 'Tanzania, United Republic of'),
('th', 'tha', '764', 'Thailand'),
('tl', 'tls', '626', 'Timor-Leste'),
('tg', 'tgo', '768', 'Togo'),
('tk', 'tkl', '772', 'Tokelau'),
('to', 'ton', '776', 'Tonga'),
('tt', 'tto', '780', 'Trinidad and Tobago'),
('tn', 'tun', '788', 'Tunisia'),
('tr', 'tur', '792', 'Turkey'),
('tm', 'tkm', '795', 'Turkmenistan'),
('tc', 'tca', '796', 'Turks and Caicos Islands'),
('tv', 'tuv', '798', 'Tuvalu'),
('ug', 'uga', '800', 'Uganda'),
('ua', 'ukr', '804', 'Ukraine'),
('ae', 'are', '784', 'United Arab Emirates'),
('gb', 'gbr', '826', 'United Kingdom'),
('us', 'usa', '840', 'United States'),
('um', 'umi', '581', 'United States Minor Outlying Islands'),
('uy', 'ury', '858', 'Uruguay'),
('uz', 'uzb', '860', 'Uzbekistan'),
('vu', 'vut', '548', 'Vanuatu'),
('ve', 'ven', '862', 'Venezuela, Bolivarian Republic of'),
('vn', 'vnm', '704', 'Viet Nam'),
('vg', 'vgb', '092', 'Virgin Islands, British'),
('vi', 'vir', '850', 'Virgin Islands, U.S.'),
('wf', 'wlf', '876', 'Wallis and Futuna'),
('eh', 'esh', '732', 'Western Sahara'),
('ye', 'yem', '887', 'Yemen'),
('zm', 'zmb', '894', 'Zambia'),
('zw', 'zwe', '716', 'Zimbabwe'),
('af', 'afg', '004', 'Afghanistan'),
('ax', 'ala', '248', 'Åland Islands'),
('al', 'alb', '008', 'Albania'),
('dz', 'dza', '012', 'Algeria'),
('as', 'asm', '016', 'American Samoa'),
('ad', 'and', '020', 'Andorra');

-- --------------------------------------------------------

--
-- Table structure for table `ref_zoneinfo`
--

CREATE TABLE IF NOT EXISTS `ref_zoneinfo` (
  `zoneinfo` varchar(40) NOT NULL,
  `offset` varchar(16) DEFAULT NULL,
  `summer` varchar(16) DEFAULT NULL,
  `country` char(2) NOT NULL,
  `cicode` varchar(6) NOT NULL,
  `cicodesummer` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`zoneinfo`),
  KEY `country` (`country`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ref_zoneinfo`
--

INSERT INTO `ref_zoneinfo` (`zoneinfo`, `offset`, `summer`, `country`, `cicode`, `cicodesummer`) VALUES
('Europe/Andorra', 'UTC+1', 'UTC+2', 'ad', 'UP1', 'UP2'),
('Asia/Dubai', 'UTC+4', NULL, 'ae', 'UP4', NULL),
('Asia/Kabul', 'UTC+4:30', NULL, 'af', 'UP45', NULL),
('America/Antigua', 'UTC-4', NULL, 'ag', 'UM4', NULL),
('America/Anguilla', 'UTC-4', NULL, 'ai', 'UM4', NULL),
('Europe/Tirane', 'UTC+1', 'UTC+2', 'al', 'UP1', 'UP2'),
('Asia/Yerevan', 'UTC+4', 'UTC+5', 'am', 'UP4', 'UP5'),
('America/Curacao', 'UTC-4', NULL, 'an', 'UM4', NULL),
('Africa/Luanda', 'UTC+1', NULL, 'ao', 'UP1', NULL),
('Antarctica/McMurdo', 'UTC+12', 'UTC+13', 'aq', 'UP12', 'UP13'),
('Antarctica/South_Pole', 'UTC+12', 'UTC+13', 'aq', 'UP12', 'UP13'),
('Antarctica/Rothera', 'UTC-3', NULL, 'aq', 'UM3', NULL),
('Antarctica/Palmer', 'UTC-4', 'UTC-3', 'aq', 'UM4', 'UM3'),
('Antarctica/Mawson', 'UTC+6', NULL, 'aq', 'UP6', NULL),
('Antarctica/Davis', 'UTC+7', NULL, 'aq', 'UP7', NULL),
('Antarctica/Casey', 'UTC+8', NULL, 'aq', 'UP8', NULL),
('Antarctica/Vostok', NULL, NULL, 'aq', 'UTC', NULL),
('Antarctica/DumontDUrville', 'UTC+10', NULL, 'aq', 'UP10', NULL),
('Antarctica/Syowa', 'UTC+3', NULL, 'aq', 'UP3', NULL),
('America/Argentina/Buenos_Aires', 'UTC-3', 'UTC-2', 'ar', 'UM3', 'UM2'),
('America/Argentina/Cordoba', 'UTC-3', 'UTC-2', 'ar', 'UM3', 'UM2'),
('America/Argentina/Salta', 'UTC-3', NULL, 'ar', 'UM3', NULL),
('America/Argentina/Jujuy', 'UTC-3', NULL, 'ar', 'UM3', NULL),
('America/Argentina/Tucuman', 'UTC-3', 'UTC-2', 'ar', 'UM3', NULL),
('America/Argentina/Catamarca', 'UTC-3', NULL, 'ar', 'UM3', NULL),
('America/Argentina/La_Rioja', 'UTC-3', NULL, 'ar', 'UM3', NULL),
('America/Argentina/San_Juan', 'UTC-3', NULL, 'ar', 'UM3', NULL),
('America/Argentina/Mendoza', 'UTC-3', NULL, 'ar', 'UM3', NULL),
('America/Argentina/San_Luis', 'UTC-4', 'UTC-3', 'ar', 'UM4', 'UM3'),
('America/Argentina/Rio_Gallegos', 'UTC-3', NULL, 'ar', 'UM3', NULL),
('America/Argentina/Ushuaia', 'UTC-3', NULL, 'ar', 'UM3', NULL),
('Pacific/Pago_Pago', 'UTC-11', NULL, 'as', 'UM11', NULL),
('Europe/Vienna', 'UTC+1', 'UTC+2', 'at', 'UP1', 'UP2'),
('Australia/Lord_Howe', 'UTC+10:30', 'UTC+11', 'au', 'UP105', 'UP11'),
('Australia/Hobart', 'UTC+10', 'UTC+11', 'au', 'UP10', 'UP11'),
('Australia/Currie', 'UTC+10', 'UTC+11', 'au', 'UP10', 'UP11'),
('Australia/Melbourne', 'UTC+10', 'UTC+11', 'au', 'UP10', 'UP11'),
('Australia/Sydney', 'UTC+10', 'UTC+11', 'au', 'UP10', 'UP11'),
('Australia/Broken_Hill', 'UTC+9:30', 'UTC+10:30', 'au', 'UP95', 'UP105'),
('Australia/Brisbane', 'UTC+10', NULL, 'au', 'UP10', NULL),
('Australia/Lindeman', 'UTC+10', NULL, 'au', 'UP10', NULL),
('Australia/Adelaide', 'UTC+9:30', 'UTC+10:30', 'au', 'UP95', 'UP105'),
('Australia/Darwin', 'UTC+9:30', NULL, 'au', 'UP95', NULL),
('Australia/Perth', 'UTC+8', NULL, 'au', 'UP8', NULL),
('Australia/Eucla', 'UTC+8:45', 'UTC+9:45', 'au', 'UP875', 'UP975'),
('America/Aruba', 'UTC-4', NULL, 'aw', 'UM4', NULL),
('Europe/Mariehamn', 'UTC+2', 'UTC+3', 'ax', 'UP2', 'UP3'),
('Asia/Baku', 'UTC+4', 'UTC+5', 'az', 'UP4', 'UP5'),
('Europe/Sarajevo', 'UTC+1', 'UTC+2', 'ba', 'UP1', 'UP2'),
('America/Barbados', 'UTC-4', NULL, 'bb', 'UP4', NULL),
('Asia/Dhaka', 'UTC+6', NULL, 'bd', 'UP6', NULL),
('Europe/Brussels', 'UTC+1', 'UTC+2', 'be', 'UP1', 'UP2'),
('Africa/Ouagadougou', 'UTC', NULL, 'bf', 'UTC', NULL),
('Europe/Sofia', 'UTC+2', 'UTC+3', 'bg', 'UP2', NULL),
('Asia/Bahrain', 'UTC+3', NULL, 'bh', 'UP3', NULL),
('Africa/Bujumbura', 'UTC+2', NULL, 'bi', 'UP2', NULL),
('Africa/Porto-Novo', 'UTC+1', NULL, 'bj', 'UP1', NULL),
('America/St_Barthelemy', 'UTC-4', NULL, 'bl', 'UM4', NULL),
('Atlantic/Bermuda', 'UTC-4', NULL, 'bm', 'UM4', NULL),
('Asia/Brunei', 'UTC+8', NULL, 'bn', 'UP8', NULL),
('America/La_Paz', 'UTC-4', NULL, 'bo', 'UM4', NULL),
('America/Noronha', 'UTC-2', NULL, 'br', 'UM2', NULL),
('America/Belem', 'UTC-3', NULL, 'br', 'UM3', NULL),
('America/Fortaleza', 'UTC-3', NULL, 'br', 'UM3', NULL),
('America/Recife', 'UTC-3', NULL, 'br', 'UM3', NULL),
('America/Araguaina', 'UTC-3', NULL, 'br', 'UM3', NULL),
('America/Maceio', 'UTC-3', NULL, 'br', 'UM3', NULL),
('America/Bahia', 'UTC-3', NULL, 'br', 'UM3', NULL),
('America/Sao_Paulo', 'UTC-3', 'UTC-2', 'br', 'UM3', 'UM2'),
('America/Campo_Grande', 'UTC-4', 'UTC-3', 'br', 'UM4', 'UM3'),
('America/Cuiaba', 'UTC-4', 'UTC-3', 'br', 'UM4', 'UM3'),
('America/Santarem', 'UTC-3', NULL, 'br', 'UM3', NULL),
('America/Porto_Velho', 'UTC-4', NULL, 'br', 'UM4', NULL),
('America/Boa_Vista', 'UTC-4', NULL, 'br', 'UM4', NULL),
('America/Manaus', 'UTC-4', NULL, 'br', 'UM4', NULL),
('America/Eirunepe', 'UTC-4', NULL, 'br', 'UM4', NULL),
('America/Rio_Branco', 'UTC-4', NULL, 'br', 'UM4', NULL),
('America/Nassau', 'UTC-4', 'UTC-3', 'bs', 'UM4', 'UM3'),
('Asia/Thimphu', 'UTC+6', NULL, 'bt', 'UP6', NULL),
('Africa/Gaborone', 'UTC+2', NULL, 'bw', 'UP2', NULL),
('Europe/Minsk', 'UTC+2', 'UTC+3', 'by', 'UP2', 'UP3'),
('America/Belize', 'UTC-6', NULL, 'bz', 'UM6', NULL),
('America/St_Johns', 'UTC-3:30', 'UTC-2:30', 'ca', 'UM35', 'UM25'),
('America/Halifax', 'UTC-4', 'UTC-3', 'ca', 'UM4', 'UM3'),
('America/Glace_Bay', 'UTC-4', 'UTC-3', 'ca', 'UM4', 'UM3'),
('America/Moncton', 'UTC-4', 'UTC-3', 'ca', 'UM4', 'UM3'),
('America/Goose_Bay', 'UTC-4', 'UTC-3', 'ca', 'UM4', 'UM3'),
('America/Blanc-Sablon', 'UTC-4', NULL, 'ca', 'UM4', NULL),
('America/Montreal', 'UTC-5', 'UTC-4', 'ca', 'UM5', 'UM4'),
('America/Toronto', 'UTC-5', 'UTC-4', 'ca', 'UM5', 'UM4'),
('America/Nipigon', 'UTC-5', 'UTC-4', 'ca', 'UM5', 'UM4'),
('America/Thunder_Bay', 'UTC-5', 'UTC-4', 'ca', 'UM5', 'UM4'),
('America/Iqaluit', 'UTC-5', 'UTC-4', 'ca', 'UM5', 'UM4'),
('America/Pangnirtung', 'UTC-5', 'UTC-4', 'ca', 'UM5', 'UM4'),
('America/Resolute', 'UTC-5', 'UTC-4', 'ca', 'UM5', 'UM4'),
('America/Atikokan', 'UTC-5', NULL, 'ca', 'UM5', NULL),
('America/Rankin_Inlet', 'UTC-6', 'UTC-5', 'ca', 'UM6', 'UM5'),
('America/Winnipeg', 'UTC-6', 'UTC-5', 'ca', 'UM6', 'UM5'),
('America/Rainy_River', 'UTC-6', 'UTC-5', 'ca', 'UM6', 'UM5'),
('America/Regina', 'UTC-6', NULL, 'ca', 'UM6', NULL),
('America/Swift_Current', 'UTC-6', NULL, 'ca', 'UM6', NULL),
('America/Edmonton', 'UTC-7', 'UTC-6', 'ca', 'UM7', 'UM6'),
('America/Cambridge_Bay', 'UTC-7', 'UTC-6', 'ca', 'UM7', 'UM6'),
('America/Yellowknife', 'UTC-7', 'UTC-6', 'ca', 'UM7', 'UM6'),
('America/Inuvik', 'UTC-7', 'UTC-6', 'ca', 'UM7', 'UM6'),
('America/Dawson_Creek', 'UTC-7', NULL, 'ca', 'UM7', NULL),
('America/Vancouver', 'UTC-8', 'UTC-7', 'ca', 'UM8', 'UM7'),
('America/Whitehorse', 'UTC-8', 'UTC-7', 'ca', 'UM8', 'UM7'),
('America/Dawson', 'UTC-8', 'UTC-7', 'ca', 'UM8', 'UM7'),
('Indian/Cocos', 'UTC+6:30', NULL, 'cc', 'UP65', NULL),
('Africa/Kinshasa', 'UTC+1', NULL, 'cd', 'UP1', NULL),
('Africa/Lubumbashi', 'UTC+2', NULL, 'cd', 'UP2', NULL),
('Africa/Bangui', 'UTC+1', NULL, 'cf', 'UP1', NULL),
('Africa/Brazzaville', 'UTC+1', NULL, 'cg', 'UP1', NULL),
('Europe/Zurich', 'UTC+1', 'UTC+2', 'ch', 'UP1', 'UP2'),
('Africa/Abidjan', 'UTC', NULL, 'ci', 'UTC', NULL),
('Pacific/Rarotonga', 'UTC-10', NULL, 'ck', 'UM10', NULL),
('America/Santiago', 'UTC-4', 'UTC-3', 'cl', 'UM4', 'UM3'),
('Pacific/Easter', 'UTC-6', 'UTC-5', 'cl', 'UM6', 'UM5'),
('Africa/Douala', 'UTC+1', NULL, 'cm', 'UP1', NULL),
('Asia/Shanghai', 'UTC+8', NULL, 'cn', 'UP8', NULL),
('Asia/Harbin', 'UTC+8', NULL, 'cn', 'UP8', NULL),
('Asia/Chongqing', 'UTC+8', NULL, 'cn', 'UP8', NULL),
('Asia/Urumqi', 'UTC+8', NULL, 'cn', 'UP8', NULL),
('Asia/Kashgar', 'UTC+8', NULL, 'cn', 'UP8', NULL),
('America/Bogota', 'UTC-5', NULL, 'co', 'UM5', NULL),
('America/Costa_Rica', 'UTC-6', NULL, 'cr', 'UM6', NULL),
('America/Havana', 'UTC-5', 'UTC-4', 'cu', 'UM5', 'UM4'),
('Atlantic/Cape_Verde', 'UTC-1', NULL, 'cv', 'UM1', NULL),
('Indian/Christmas', 'UTC+7', NULL, 'cx', 'UP7', NULL),
('Asia/Nicosia', 'UTC+2', 'UTC+3', 'cy', 'UP2', 'UP3'),
('Europe/Prague', 'UTC+1', 'UTC+2', 'cz', 'UP1', 'UP2'),
('Europe/Berlin', 'UTC+1', 'UTC+2', 'de', 'UP1', 'UP2'),
('Africa/Djibouti', 'UTC+3', NULL, 'dj', 'UP3', NULL),
('Europe/Copenhagen', 'UTC+1', 'UTC+2', 'dk', 'UP1', 'UP2'),
('America/Dominica', 'UTC-4', NULL, 'dm', 'UM4', NULL),
('America/Santo_Domingo', 'UTC-4', NULL, 'do', 'UM4', NULL),
('Africa/Algiers', 'UTC+1', NULL, 'dz', 'UP1', NULL),
('America/Guayaquil', 'UTC-5', NULL, 'ec', 'UM5', NULL),
('Pacific/Galapagos', 'UTC-6', NULL, 'ec', 'UM6', NULL),
('Europe/Tallinn', 'UTC+2', 'UTC+3', 'ee', 'UP2', 'UP3'),
('Africa/Cairo', 'UTC+2', NULL, 'eg', 'UP2', NULL),
('Africa/El_Aaiun', 'UTC', NULL, 'eh', 'UTC', NULL),
('Africa/Asmara', 'UTC+3', NULL, 'er', 'UP3', NULL),
('Europe/Madrid', 'UTC+1', 'UTC+2', 'es', 'UP1', 'UP2'),
('Africa/Ceuta', 'UTC+1', 'UTC+2', 'es', 'UP1', 'UP2'),
('Atlantic/Canary', 'UTC', 'UTC+1', 'es', 'UTC', 'UP1'),
('Africa/Addis_Ababa', 'UTC+3', NULL, 'et', 'UP3', NULL),
('Europe/Helsinki', 'UTC+2', 'UTC+3', 'fi', 'UP2', 'UP3'),
('Pacific/Fiji', 'UTC+12', NULL, 'fj', 'UP12', NULL),
('Atlantic/Stanley', 'UTC-4', 'UTC-3', 'fk', 'UM4', 'UM3'),
('Pacific/Truk', 'UTC+10', NULL, 'fm', 'UP10', NULL),
('Pacific/Ponape', 'UTC+11', NULL, 'fm', 'UP11', NULL),
('Pacific/Kosrae', 'UTC+11', NULL, 'fm', 'UP11', NULL),
('Atlantic/Faroe', 'UTC', 'UTC+1', 'fo', 'UTC', 'UP1'),
('Europe/Paris', 'UTC+1', 'UTC+2', 'fr', 'UP1', 'UP2'),
('Africa/Libreville', 'UTC+1', NULL, 'ga', 'UP1', NULL),
('Europe/London', 'UTC', 'UTC+1', 'gb', 'UP1',NULL),
('America/Grenada', 'UTC-4', NULL, 'gd', 'UM4', NULL),
('Asia/Tbilisi', 'UTC+4', NULL, 'ge', 'UP4', NULL),
('America/Cayenne', 'UTC-3', NULL, 'gf', 'UM3', NULL),
('Europe/Guernsey', 'UTC', 'UTC+1', 'gg', 'UTC', 'UP1'),
('Africa/Accra', 'UTC', NULL, 'gh', 'UTC', NULL),
('Europe/Gibraltar', 'UTC+1', 'UTC+2', 'gi', 'UP1', 'UP2'),
('America/Godthab', 'UTC-3', 'UTC-2', 'gl', 'UM3', 'UM2'),
('America/Danmarkshavn', 'UTC', NULL, 'gl', 'UTC', NULL),
('America/Scoresbysund', 'UTC-1', 'UTC', 'gl', 'UM1', 'UTC'),
('America/Thule', 'UTC-4', 'UTC-3', 'gl', 'UM4', 'UM3'),
('Africa/Banjul', 'UTC', NULL, 'gm', 'UTC', NULL),
('Africa/Conakry', 'UTC', NULL, 'gn', 'UTC', NULL),
('America/Guadeloupe', 'UTC-4', NULL, 'gp', 'UM4', NULL),
('Africa/Malabo', 'UTC+1', NULL, 'gq', 'UP1', NULL),
('Europe/Athens', 'UTC+2', 'UTC+3', 'gr', 'UP2', 'UP3'),
('Atlantic/South_Georgia', 'UTC-2', NULL, 'gs', 'UM2', NULL),
('America/Guatemala', 'UTC-6', NULL, 'gt', 'UM6', NULL),
('Pacific/Guam', 'UTC+10', NULL, 'gu', 'UP10', NULL),
('Africa/Bissau', 'UTC', NULL, 'gw', 'UTC', NULL),
('America/Guyana', 'UTC-4', NULL, 'gy', 'UM4', NULL),
('Asia/Hong_Kong', 'UTC+8', NULL, 'hk', 'UP8', NULL),
('America/Tegucigalpa', 'UTC-6', NULL, 'hn', 'UM6', NULL),
('Europe/Zagreb', 'UTC+1', 'UTC+2', 'hr', 'UP1', 'UP2'),
('America/Port-au-Prince', 'UTC-5', NULL, 'ht', 'UM5', NULL),
('Europe/Budapest', 'UTC+1', 'UTC+2', 'hu', 'UP1', 'UP2'),
('Asia/Jakarta', 'UTC+7', NULL, 'id', 'UP7', NULL),
('Asia/Pontianak', 'UTC+7', NULL, 'id', 'UP7', NULL),
('Asia/Makassar', 'UTC+8', NULL, 'id', 'UP8', NULL),
('Asia/Jayapura', 'UTC+9', NULL, 'id', 'UP9', NULL),
('Europe/Dublin', 'UTC', 'UTC+1', 'ie', 'UTC', 'UP1'),
('Asia/Jerusalem', 'UTC+2', 'UTC+3', 'il', 'UP2', 'UP3'),
('Europe/Isle_of_Man', 'UTC', 'UTC+1', 'im', 'UTC', 'UP1'),
('Asia/Kolkata', 'UTC+5:30', NULL, 'in', 'UP55', NULL),
('Indian/Chagos', 'UTC+6', NULL, 'io', 'UP6', NULL),
('Asia/Baghdad', 'UTC+3', NULL, 'iq', 'UP3', NULL),
('Asia/Tehran', 'UTC+3:30', 'UTC+4:30', 'ir', 'UP35', 'UP45'),
('Atlantic/Reykjavik', 'UTC', NULL, 'is', 'UTC', NULL),
('Europe/Rome', 'UTC+1', 'UTC+2', 'it', 'UP1', 'UP2'),
('Europe/Jersey', 'UTC', 'UTC+1', 'je', 'UTC', 'UP1'),
('America/Jamaica', 'UTC-5', NULL, 'jm', 'UM5', NULL),
('Asia/Amman', 'UTC+2', 'UTC+3', 'jo', 'UP2', 'UP3'),
('Asia/Tokyo', 'UTC+9', NULL, 'jp', 'UP9', NULL),
('Africa/Nairobi', 'UTC+3', NULL, 'ke', 'UP3', NULL),
('Asia/Bishkek', 'UTC+6', NULL, 'kg', 'UP6', NULL),
('Asia/Phnom_Penh', 'UTC+7', NULL, 'kh', 'UP7', NULL),
('Pacific/Tarawa', 'UTC+12', NULL, 'ki', 'UP12', NULL),
('Pacific/Enderbury', 'UTC+13', NULL, 'ki', 'UP13', NULL),
('Pacific/Kiritimati', 'UTC+14', NULL, 'ki', 'UP13', NULL),
('Indian/Comoro', 'UTC+3', NULL, 'km', 'UP3', NULL),
('America/St_Kitts', 'UTC-4', NULL, 'kn', 'UM4', NULL),
('Asia/Pyongyang', 'UTC+9', NULL, 'kp', 'UP9', NULL),
('Asia/Seoul', 'UTC+9', NULL, 'kr', 'UP9', NULL),
('Asia/Kuwait', 'UTC+3', NULL, 'kw', 'UP3', NULL),
('America/Cayman', 'UTC-5', NULL, 'ky', 'UM5', NULL),
('Asia/Almaty', 'UTC+6', NULL, 'kz', 'UP6', NULL),
('Asia/Qyzylorda', 'UTC+6', NULL, 'kz', 'UP6', NULL),
('Asia/Aqtobe', 'UTC+5', NULL, 'kz', 'UP5', NULL),
('Asia/Aqtau', 'UTC+5', NULL, 'kz', 'UP5', NULL),
('Asia/Oral', 'UTC+5', NULL, 'kz', 'UP5', NULL),
('Asia/Vientiane', 'UTC+7', NULL, 'la', 'UP7', NULL),
('Asia/Beirut', 'UTC+2', 'UTC+3', 'lb', 'UP2', 'UP3'),
('America/St_Lucia', 'UTC-4', NULL, 'lc', 'UM4', NULL),
('Europe/Vaduz', 'UTC+1', 'UTC+2', 'li', 'UP1', 'UP2'),
('Asia/Colombo', 'UTC+5:30', NULL, 'lk', 'UP55', NULL),
('Africa/Monrovia', 'UTC', NULL, 'lr', 'UTC', NULL),
('Africa/Maseru', 'UTC+2', NULL, 'ls', 'UP2', NULL),
('Europe/Vilnius', 'UTC+2', 'UTC+3', 'lt', 'UP2', 'UP3'),
('Europe/Luxembourg', 'UTC+1', 'UTC+2', 'lu', 'UP1', 'UP2'),
('Europe/Riga', 'UTC+2', 'UTC+3', 'lv', 'UP2', 'UP3'),
('Africa/Tripoli', 'UTC+2', NULL, 'ly', 'UP2', NULL),
('Africa/Casablanca', 'UTC', NULL, 'ma', 'UTC', NULL),
('Europe/Monaco', 'UTC+1', 'UTC+2', 'mc', 'UP1', 'UP2'),
('Europe/Chisinau', 'UTC+2', 'UTC+3', 'md', 'UP2', 'UP3'),
('Europe/Podgorica', 'UTC+1', 'UTC+2', 'me', 'UP1', 'UP2'),
('America/Marigot', 'UTC-4', NULL, 'mf', 'UM4', NULL),
('Indian/Antananarivo', 'UTC+3', NULL, 'mg', 'UP3', NULL),
('Pacific/Majuro', 'UTC+12', NULL, 'mh', 'UP12', NULL),
('Pacific/Kwajalein', 'UTC+12', NULL, 'mh', 'UP12', NULL),
('Europe/Skopje', 'UTC+1', 'UTC+2', 'mk', 'UP1', 'UP2'),
('Africa/Bamako', 'UTC', NULL, 'ml', 'UTC', NULL),
('Asia/Rangoon', 'UTC+6:30', NULL, 'mm', 'UP65', NULL),
('Asia/Ulaanbaatar', 'UTC+8', NULL, 'mn', 'UP8', NULL),
('Asia/Hovd', 'UTC+7', NULL, 'mn', 'UP7', NULL),
('Asia/Choibalsan', 'UTC+8', NULL, 'mn', 'UP8', NULL),
('Asia/Macau', 'UTC+8', NULL, 'mo', 'UP8', NULL),
('Pacific/Saipan', 'UTC+10', NULL, 'mp', 'UP10', NULL),
('America/Martinique', 'UTC-4', NULL, 'mq', 'UM4', NULL),
('Africa/Nouakchott', 'UTC', NULL, 'mr', 'UTC', NULL),
('America/Montserrat', 'UTC-4', NULL, 'ms', 'UM4', NULL),
('Europe/Malta', 'UTC+1', 'UTC+2', 'mt', 'UP1', 'UP2'),
('Indian/Mauritius', 'UTC+4', NULL, 'mu', 'UP4', NULL),
('Indian/Maldives', 'UTC+5', NULL, 'mv', 'UP5', NULL),
('Africa/Blantyre', 'UTC+2', NULL, 'mw', 'UP2', NULL),
('America/Mexico_City', 'UTC-6', 'UTC-5', 'mx', 'UM6', 'UM5'),
('America/Cancun', 'UTC-6', 'UTC-5', 'mx', 'UM6', 'UM5'),
('America/Merida', 'UTC-6', 'UTC-5', 'mx', 'UM6', 'UM5'),
('America/Monterrey', 'UTC-6', 'UTC-5', 'mx', 'UM6', 'UM5'),
('America/Mazatlan', 'UTC-7', 'UTC-6', 'mx', 'UM7', 'UM6'),
('America/Chihuahua', 'UTC-7', 'UTC-6', 'mx', 'UM7', 'UM6'),
('America/Hermosillo', 'UTC-7', NULL, 'mx', 'UM7', NULL),
('America/Tijuana', 'UTC-8', 'UTC-7', 'mx', 'UM8', 'UM7'),
('Asia/Kuala_Lumpur', 'UTC+8', NULL, 'my', 'UP8', NULL),
('Asia/Kuching', 'UTC+8', NULL, 'my', 'UP8', NULL),
('Africa/Maputo', 'UTC+2', NULL, 'mz', 'UP2', NULL),
('Africa/Windhoek', 'UTC+1', 'UTC+2', 'na', 'UP1', 'UP2'),
('Pacific/Noumea', 'UTC+11', NULL, 'nc', 'UP11', NULL),
('Africa/Niamey', 'UTC+1', NULL, 'ne', 'UP1', NULL),
('Pacific/Norfolk', 'UTC+11:30', NULL, 'nf', 'UP115', NULL),
('Africa/Lagos', 'UTC+1', NULL, 'ng', 'UP1', NULL),
('America/Managua', 'UTC-6', NULL, 'ni', 'UM6', NULL),
('Europe/Amsterdam', 'UTC+1', NULL, 'nl', 'UP1', NULL),
('Europe/Oslo', 'UTC+1', 'UTC+2', 'no', 'UP1', 'UP2'),
('Asia/Katmandu', 'UTC+5:45', NULL, 'np', 'UP575', NULL),
('Pacific/Nauru', 'UTC+12', NULL, 'nr', 'UP12', NULL),
('Pacific/Niue', 'UTC-11', NULL, 'nu', 'UM11', NULL),
('Pacific/Auckland', 'UTC+12', 'UTC+13', 'nz', 'UP12', 'UP13'),
('Pacific/Chatham', 'UTC+12:45', 'UTC+13:45', 'nz', 'UP1275', 'UP1375'),
('Asia/Muscat', 'UTC+4', NULL, 'om', 'UP4', NULL),
('America/Panama', 'UTC-5', NULL, 'pa', 'UM5', NULL),
('America/Lima', 'UTC-5', NULL, 'pe', 'UM5', NULL),
('Pacific/Tahiti', 'UTC-10', NULL, 'pf', 'UM10', NULL),
('Pacific/Marquesas', 'UTC+9:30', NULL, 'pf', 'UP95', NULL),
('Pacific/Gambier', 'UTC-9', NULL, 'pf', 'UM9', NULL),
('Pacific/Port_Moresby', 'UTC+10', NULL, 'pg', 'UP10', NULL),
('Asia/Manila', 'UTC+8', NULL, 'ph', 'UP8', NULL),
('Asia/Karachi', 'UTC+6', NULL, 'pk', 'UP6', NULL),
('Europe/Warsaw', 'UTC+1', 'UTC+2', 'pl', 'UP1', 'UP2'),
('America/Miquelon', 'UTC-3', 'UTC-2', 'pm', 'UM3', 'UM2'),
('Pacific/Pitcairn', 'UTC-8', NULL, 'pn', 'UM8', NULL),
('America/Puerto_Rico', 'UTC-4', NULL, 'pr', 'UM4', NULL),
('Asia/Gaza', 'UTC+2', 'UTC+3', 'ps', 'UP2', 'UP3'),
('Europe/Lisbon', 'UTC', 'UTC+1', 'pt', 'UTC', 'UP1'),
('Atlantic/Madeira', 'UTC', 'UTC+1', 'pt', 'UTC', 'UP1'),
('Atlantic/Azores', 'UTC-1', 'UTC', 'pt', 'UM1', 'UTC'),
('Pacific/Palau', 'UTC+9', NULL, 'pw', 'UP9', NULL),
('America/Asuncion', 'UTC-4', 'UTC-3', 'py', 'UM4', 'UM3'),
('Asia/Qatar', 'UTC+3', NULL, 'qa', 'UP3', NULL),
('Indian/Reunion', 'UTC+4', NULL, 're', 'UP4', NULL),
('Europe/Bucharest', 'UTC+2', 'UTC+3', 'ro', 'UP2', 'UP3'),
('Europe/Belgrade', 'UTC+1', 'UTC+2', 'rs', 'UP1', 'UP2'),
('Europe/Kaliningrad', 'UTC+2', 'UTC+3', 'ru', 'UP2', 'UP3'),
('Europe/Moscow', 'UTC+3', 'UTC+4', 'ru', 'UP3', 'UP4'),
('Europe/Volgograd', 'UTC+3', 'UTC+4', 'ru', 'UP3', 'UP4'),
('Europe/Samara', 'UTC+4', 'UTC+5', 'ru', 'UP4', 'UP5'),
('Asia/Yekaterinburg', 'UTC+5', 'UTC+6', 'ru', 'UP5', 'UP6'),
('Asia/Omsk', 'UTC+6', 'UTC+7', 'ru', 'UP6', 'UP7'),
('Asia/Novosibirsk', 'UTC+6', 'UTC+7', 'ru', 'UP6', 'UP7'),
('Asia/Krasnoyarsk', 'UTC+7', 'UTC+8', 'ru', 'UP7', 'UP8'),
('Asia/Irkutsk', 'UTC+8', 'UTC+9', 'ru', 'UP8', 'UP9'),
('Asia/Yakutsk', 'UTC+9', 'UTC+10', 'ru', 'UP9', 'UP10'),
('Asia/Vladivostok', 'UTC+10', 'UTC+11', 'ru', 'UP10', 'UP11'),
('Asia/Sakhalin', 'UTC+10', 'UTC+11', 'ru', 'UP10', 'UP11'),
('Asia/Magadan', 'UTC+11', 'UTC+12', 'ru', 'UP11', 'UP12'),
('Asia/Kamchatka', 'UTC+12', 'UTC+13', 'ru', 'UP12', 'UP13'),
('Asia/Anadyr', 'UTC+12', 'UTC+13', 'ru', 'UP12', 'UP13'),
('Africa/Kigali', 'UTC+2', NULL, 'rw', 'UP2', NULL),
('Asia/Riyadh', 'UTC+3', NULL, 'sa', 'UP3', NULL),
('Pacific/Guadalcanal', 'UTC+11', NULL, 'sb', 'UP11', NULL),
('Indian/Mahe', 'UTC+4', NULL, 'sc', 'UP4', NULL),
('Africa/Khartoum', 'UTC+3', NULL, 'sd', 'UP3', NULL),
('Europe/Stockholm', 'UTC+1', 'UTC+2', 'se', 'UP1', 'UP2'),
('Asia/Singapore', 'UTC+8', NULL, 'sg', 'UP8', NULL),
('Atlantic/St_Helena', 'UTC', NULL, 'sh', 'UTC', NULL),
('Europe/Ljubljana', 'UTC+1', 'UTC+2', 'si', 'UP1', 'UP2'),
('Arctic/Longyearbyen', 'UTC+1', 'UTC+2', 'sj', 'UP1', 'UP2'),
('Europe/Bratislava', 'UTC+1', 'UTC+2', 'sk', 'UP1', 'UP2'),
('Africa/Freetown', 'UTC', NULL, 'sl', 'UTC', NULL),
('Europe/San_Marino', 'UTC+1', 'UTC+2', 'sm', 'UP1', 'UP2'),
('Africa/Dakar', 'UTC', NULL, 'sn', 'UTC', NULL),
('Africa/Mogadishu', 'UTC+3', NULL, 'so', 'UTC3', NULL),
('America/Paramaribo', 'UTC-3', NULL, 'sr', 'UM3', NULL),
('Africa/Sao_Tome', 'UTC', NULL, 'st', 'UTC', NULL),
('America/El_Salvador', 'UTC-6', NULL, 'sv', 'UM6', NULL),
('Asia/Damascus', 'UTC+2', 'UTC+3', 'sy', 'UP2', 'UP3'),
('Africa/Mbabane', 'UTC+2', NULL, 'sz', 'UP2', NULL),
('America/Grand_Turk', 'UTC-5', 'UTC-4', 'tc', 'UM5', 'UM4'),
('Africa/Ndjamena', 'UTC+1', NULL, 'td', 'UP1', NULL),
('Indian/Kerguelen', 'UTC+5', NULL, 'tf', 'UP5', NULL),
('Africa/Lome', 'UTC', NULL, 'tg', 'UTC', NULL),
('Asia/Bangkok', 'UTC+7', NULL, 'th', 'UP7', NULL),
('Asia/Dushanbe', 'UTC+5', NULL, 'tj', 'UP5', NULL),
('Pacific/Fakaofo', 'UTC-10', NULL, 'tk', 'UM10', NULL),
('Asia/Dili', 'UTC+9', NULL, 'tl', 'UP9', NULL),
('Asia/Ashgabat', 'UTC+5', NULL, 'tm', 'UP5', NULL),
('Africa/Tunis', 'UTC+1', 'UTC+2', 'tn', 'UP1', 'UP2'),
('Pacific/Tongatapu', 'UTC+13', NULL, 'to', 'UP13', NULL),
('Europe/Istanbul', 'UTC+2', 'UTC+3', 'tr', 'UP2', 'UP3'),
('America/Port_of_Spain', 'UTC-4', NULL, 'tt', 'UM4', NULL),
('Pacific/Funafuti', 'UTC+12', NULL, 'tv', 'UP12', NULL),
('Asia/Taipei', 'UTC+8', NULL, 'tw', 'UP8', NULL),
('Africa/Dar_es_Salaam', 'UTC+3', NULL, 'tz', 'UP3', NULL),
('Europe/Kiev', 'UTC+2', 'UTC+3', 'ua', 'UP2', 'UP3'),
('Europe/Uzhgorod', 'UTC+2', 'UTC+3', 'ua', 'UP2', 'UP3'),
('Europe/Zaporozhye', 'UTC+2', 'UTC+3', 'ua', 'UP2', 'UP3'),
('Europe/Simferopol', 'UTC+2', 'UTC+3', 'ua', 'UP2', 'UP3'),
('Africa/Kampala', 'UTC+3', NULL, 'ug', 'UP3', NULL),
('Pacific/Johnston', 'UTC-10', NULL, 'um', 'UM10', NULL),
('Pacific/Midway', 'UTC-11', NULL, 'um', 'UM11', NULL),
('Pacific/Wake', 'UTC+12', NULL, 'um', 'UP12', NULL),
('America/New_York', 'UTC-5', 'UTC-4', 'us', 'UM5', 'UM4'),
('America/Detroit', 'UTC-5', 'UTC-4', 'us', 'UM5', 'UM4'),
('America/Kentucky/Louisville', 'UTC-5', 'UTC-4', 'us', 'UM5', 'UM4'),
('America/Kentucky/Monticello', 'UTC-5', 'UTC-4', 'us', 'UM5', 'UM4'),
('America/Indiana/Indianapolis', 'UTC-5', 'UTC-4', 'us', 'UM5', 'UM4'),
('America/Indiana/Vincennes', 'UTC-5', 'UTC-4', 'us', 'UM5', 'UM4'),
('America/Indiana/Winamac', 'UTC-5', 'UTC-4', 'us', 'UM5', 'UM4'),
('America/Indiana/Marengo', 'UTC-5', 'UTC-4', 'us', 'UM5', 'UM4'),
('America/Indiana/Petersburg', 'UTC-5', 'UTC-4', 'us', 'UM5', 'UM4'),
('America/Indiana/Vevay', 'UTC-5', 'UTC-4', 'us', 'UM5', 'UM4'),
('America/Chicago', 'UTC-6', 'UTC-5', 'us', 'UM6', 'UM5'),
('America/Indiana/Tell_City', 'UTC-6', 'UTC-5', 'us', 'UM6', 'UM5'),
('America/Indiana/Knox', 'UTC-6', 'UTC-5', 'us', 'UM6', 'UM5'),
('America/Menominee', 'UTC-6', 'UTC-5', 'us', 'UM6', 'UM5'),
('America/North_Dakota/Center', 'UTC-6', 'UTC-5', 'us', 'UM6', 'UM5'),
('America/North_Dakota/New_Salem', 'UTC-6', 'UTC-5', 'us', 'UM6', 'UM5'),
('America/Denver', 'UTC-7', 'UTC-6', 'us', 'UM7', 'UM6'),
('America/Boise', 'UTC-7', 'UTC-6', 'us', 'UM7', 'UM6'),
('America/Shiprock', 'UTC-7', 'UTC-6', 'us', 'UM7', 'UM6'),
('America/Phoenix', 'UTC-7', NULL, 'us', 'UM7', NULL),
('America/Los_Angeles', 'UTC-8', 'UTC-7', 'us', 'UM8', 'UM7'),
('America/Anchorage', 'UTC-9', 'UTC-8', 'us', 'UM9', 'UM8'),
('America/Juneau', 'UTC-9', 'UTC-8', 'us', 'UM9', 'UM8'),
('America/Yakutat', 'UTC-9', 'UTC-8', 'us', 'UM9', 'UM8'),
('America/Nome', 'UTC-9', 'UTC-8', 'us', 'UM9', 'UM8'),
('America/Adak', 'UTC-10', 'UTC-9', 'us', 'UM10', 'UM9'),
('Pacific/Honolulu', 'UTC-10', NULL, 'us', 'UM10', NULL),
('America/Montevideo', 'UTC-3', 'UTC-2', 'uy', 'UM3', 'UM2'),
('Asia/Samarkand', 'UTC+5', NULL, 'uz', 'UP5', NULL),
('Asia/Tashkent', 'UTC+5', NULL, 'uz', 'UP5', NULL),
('Europe/Vatican', 'UTC+1', 'UTC+2', 'va', 'UP1', 'UP2'),
('America/St_Vincent', 'UTC-4', NULL, 'vc', 'UM4', NULL),
('America/Caracas', 'UTC-4:30', NULL, 've', 'UM45', NULL),
('America/Tortola', 'UTC-4', NULL, 'vg', 'UM4', NULL),
('America/St_Thomas', 'UTC-4', NULL, 'vi', 'UM4', NULL),
('Asia/Ho_Chi_Minh', 'UTC+7', NULL, 'vn', 'UP7', NULL),
('Pacific/Efate', 'UTC+11', NULL, 'vu', 'UP11', NULL),
('Pacific/Wallis', 'UTC+12', NULL, 'wf', 'UP12', NULL),
('Pacific/Apia', 'UTC-11', NULL, 'ws', 'UM11', NULL),
('Asia/Aden', 'UTC+3', NULL, 'ye', 'UP3', NULL),
('Indian/Mayotte', 'UTC+3', NULL, 'yt', 'UP3', NULL),
('Africa/Johannesburg', 'UTC+2', NULL, 'za', 'UP2', NULL),
('Africa/Lusaka', 'UTC+2', NULL, 'zm', 'UP2', NULL),
('Africa/Harare', 'UTC+2', NULL, 'zw', 'UP2', NULL);
