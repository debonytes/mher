RENAME TABLE `form_respite_care_progress_note` TO `form_respite_care_progress_note_BAK`;

CREATE TABLE IF NOT EXISTS `form_respite_care_progress_note` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `encounter` varchar(255) DEFAULT NULL,
  `groupname` varchar(255) DEFAULT NULL,
  `authorized` tinyint(4) DEFAULT NULL,
  `activity` tinyint(4) DEFAULT NULL,
  `billing_code` varchar(255) DEFAULT NULL,
  `dateofservice` varchar(255) DEFAULT NULL,
  `starttime` varchar(255) DEFAULT NULL,
  `endtime` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `crit_incidents` tinyint(2) DEFAULT NULL,
  `service_local` varchar(255) DEFAULT NULL,
  `billing_code_id` varchar(255) DEFAULT NULL,
  `intervention_type` text,
  `progress_narrative` text,
  `critical_incidents_explan` text,
  `provider_id` bigint(10) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;
