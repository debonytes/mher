--
-- Table structure for table `form_clinical_instructions`
--

CREATE TABLE IF NOT EXISTS `form_cbrs_progress_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pid` bigint(20) DEFAULT NULL,
  `cbrs` varchar(255) DEFAULT NULL,
  `encounter` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `billing_code` varchar(255) DEFAULT NULL,
  `dateofservice` varchar(255) DEFAULT NULL,
  `starttime` varchar(255) DEFAULT NULL,
  `endtime` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `services_place` varchar(255) DEFAULT NULL,
  `services_with` varchar(255) DEFAULT NULL,
  `goals_object_1` varchar(100) DEFAULT NULL,
  `goals_object_1_status` varchar(100) DEFAULT NULL,
  `goals_object_2` varchar(100) DEFAULT NULL,
  `goals_object_2_status` varchar(100) DEFAULT NULL,
  `goals_object_3` varchar(100) DEFAULT NULL,
  `goals_object_3_status` varchar(100) DEFAULT NULL,
  `narrative_services` text DEFAULT NULL,
  `meet_again_date` varchar(255) DEFAULT NULL,
  `meet_again_time` varchar(255) DEFAULT NULL,
  `work_on` varchar(255) DEFAULT NULL,
  `activity` TINYINT DEFAULT 1 NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB;

