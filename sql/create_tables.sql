DROP TABLE IF EXISTS `upload_file`;
CREATE TABLE `upload_file` (
  `upload_file_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `unique_code` VARCHAR(255) NOT NULL,
  `filename` VARCHAR(255) NULL,
  `original_filename` VARCHAR(255) NULL,
  `file_size` INT UNSIGNED NOT NULL DEFAULT 0,
  `mimetype` VARCHAR(255) NOT NULL,
  `comment` MEDIUMTEXT NULL,
  `delete_key` VARCHAR(255) NULL,
  `file_status` TINYINT(1) NOT NULL DEFAULT 1,
  `user_unique_id` VARCHAR(255) NULL,
  `user_ip_address` VARCHAR(255) NULL,
  `created_datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`upload_file_id`));