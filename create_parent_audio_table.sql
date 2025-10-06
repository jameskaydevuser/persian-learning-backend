-- Create parent_word_audio table
CREATE TABLE IF NOT EXISTS `parent_word_audio` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL,
  `word_id` bigint(20) unsigned NOT NULL,
  `difficulty` enum('easy','normal','hard') NOT NULL,
  `custom_sentence` text NOT NULL,
  `audio_file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_word_audio_parent_id_word_id_difficulty_unique` (`parent_id`,`word_id`,`difficulty`),
  KEY `parent_word_audio_parent_id_foreign` (`parent_id`),
  KEY `parent_word_audio_word_id_foreign` (`word_id`),
  CONSTRAINT `parent_word_audio_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `parent_word_audio_word_id_foreign` FOREIGN KEY (`word_id`) REFERENCES `words` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
