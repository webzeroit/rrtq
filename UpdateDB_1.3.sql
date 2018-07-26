SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for rrtq_standard_formativo
-- ----------------------------
DROP TABLE IF EXISTS `rrtq_standard_formativo`;
CREATE TABLE `rrtq_standard_formativo`  (
  `id_standard_formativo` int(11) NOT NULL,
  `id_profilo` int(11) NOT NULL,
  `des_standard_formativo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `req_min_partecipanti` varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Requisiti minimi di ingresso dei partecipanti',
  `req_min_didattici` varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Requisiti minimi didattici comuni a tutte le UF/segmenti',
  `req_min_risorse` varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Requisiti minimi di risorse professionali e strumentali',
  `req_min_valutazione` varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Requisiti minimi di valutazione e di attestazione degli apprendimenti',
  `req_crediti_formativi` varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Gestione dei crediti formativi',
  `altre_indicazioni` varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Eventuali ulteriori indicazioni',
  `ore_min_durata_percorso` int(2) NULL DEFAULT NULL COMMENT ' Durata minima complessiva del percorso (ore)',
  `ore_min_aula_lab` int(2) NULL DEFAULT NULL COMMENT ' Durata minima di aula e laboratorio (ore)',
  `ore_min_aula_lab_kc` int(2) NULL DEFAULT NULL COMMENT 'Durata minima delle attivita` di aula e laboratorio rivolte alle KC (ore)',
  `ore_min_tirocinio` int(2) NULL DEFAULT NULL COMMENT 'Durata minima tirocinio in impresa (ore)',
  `perc_fad_aula_lab` int(2) NULL DEFAULT NULL COMMENT 'Percentuale massima di FaD sulla durata minima di aula e laboratorio',
  `data_ultima_modifica` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_standard_formativo`) USING BTREE,
  INDEX `id_profilo`(`id_profilo`) USING BTREE,
  CONSTRAINT `rrtq_standard_formativo_ibfk_1` FOREIGN KEY (`id_profilo`) REFERENCES `rrtq_profilo` (`id_profilo`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrtq_standard_formativo_uf
-- ----------------------------
DROP TABLE IF EXISTS `rrtq_standard_formativo_uf`;
CREATE TABLE `rrtq_standard_formativo_uf`  (
  `id_unita_formativa` int(11) NOT NULL AUTO_INCREMENT,
  `id_standard_formativo` int(11) NULL DEFAULT NULL,
  `id_profilo` int(11) NULL DEFAULT NULL,
  `id_competenza` int(11) NULL DEFAULT NULL,
  `titolo_unita_formativa` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT ' UF Denominazione ',
  `ore_min_durata_uf` int(2) NULL DEFAULT NULL COMMENT ' Durata Minima (ore) UF',
  `perc_varianza` int(2) NULL DEFAULT NULL,
  `des_eventuali_vincoli` varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `perc_fad_uf` int(2) NULL DEFAULT NULL,
  `sequenza` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id_unita_formativa`) USING BTREE,
  INDEX `id_standard_formativo`(`id_standard_formativo`) USING BTREE,
  INDEX `id_profilo`(`id_profilo`, `id_competenza`) USING BTREE,
  CONSTRAINT `rrtq_standard_formativo_uf_ibfk_1` FOREIGN KEY (`id_standard_formativo`) REFERENCES `rrtq_standard_formativo` (`id_standard_formativo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `rrtq_standard_formativo_uf_ibfk_2` FOREIGN KEY (`id_profilo`, `id_competenza`) REFERENCES `rrtq_profilo_competenza` (`id_profilo`, `id_competenza`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sys_messages
-- ----------------------------
DROP TABLE IF EXISTS `sys_messages`;
CREATE TABLE `sys_messages`  (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `user_to` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `subject` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `message` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `receiver_open` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_message`) USING BTREE,
  UNIQUE INDEX `idx_id_message`(`id_message`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;