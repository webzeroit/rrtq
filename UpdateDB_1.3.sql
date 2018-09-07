
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
  `perc_fad_aula_lab_kc` int(2) NULL DEFAULT NULL COMMENT 'Percentuale massima di FaD sulla durata minima di aula e laboratorio delle KC',
  `flg_uf_modulo` int(1) NULL DEFAULT 0 COMMENT 'Indica se lo standard è redatto per UF o per Moduli \r\n0 = UF\r\n1 = MODULO',
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;


-- ----------------------------
-- Table structure for rrtq_standard_formativo_mod
-- ----------------------------
DROP TABLE IF EXISTS `rrtq_standard_formativo_mod`;
CREATE TABLE `rrtq_standard_formativo_mod`  (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `id_standard_formativo` int(11) NULL DEFAULT NULL,
  `id_profilo` int(11) NULL DEFAULT NULL,
  `titolo_modulo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Modulo Denominazione ',
  `des_contenuti` varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ore_min_durata_mod` int(2) NULL DEFAULT NULL COMMENT 'Durata Minima (ore) Modulo',
  `des_eventuali_vincoli` varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `perc_fad_mod` int(2) NULL DEFAULT NULL,
  `sequenza` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id_modulo`) USING BTREE,
  INDEX `id_standard_formativo`(`id_standard_formativo`) USING BTREE,
  CONSTRAINT `rrtq_standard_formativo_mod_ibfk_1` FOREIGN KEY (`id_standard_formativo`) REFERENCES `rrtq_standard_formativo` (`id_standard_formativo`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

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

-- ----------------------------
-- Table structure for rrtq_isced
-- ----------------------------
DROP TABLE IF EXISTS `rrtq_isced`;
CREATE TABLE `rrtq_isced`  (
  `id_isced` int(11) NOT NULL,
  `des_isced` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `parent_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_isced`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'La tabella è strutturata con modello gerarchico (Hierarchical Data Model). Il campo des_isced è composto da 3 livelli e contiene il Broad field, il Narrow field ed il Detailed field\r\n' ROW_FORMAT = Compact;


-- ----------------------------
-- Records of rrtq_isced
-- ----------------------------
INSERT INTO `rrtq_isced` VALUES (100, '00 Generic programmes and qualifications', NULL);
INSERT INTO `rrtq_isced` VALUES (101, '01 Education', NULL);
INSERT INTO `rrtq_isced` VALUES (102, '02 Arts and humanities', NULL);
INSERT INTO `rrtq_isced` VALUES (103, '03 Social sciences, journalism and information', NULL);
INSERT INTO `rrtq_isced` VALUES (104, '04 Business, administration and law', NULL);
INSERT INTO `rrtq_isced` VALUES (105, '05 Natural sciences, mathematics and statistics', NULL);
INSERT INTO `rrtq_isced` VALUES (106, '06 Information and Communication Technologies\n(ICTs)', NULL);
INSERT INTO `rrtq_isced` VALUES (107, '07 Engineering, manufacturing and construction', NULL);
INSERT INTO `rrtq_isced` VALUES (108, '08 Agriculture, forestry, fisheries and veterinary', NULL);
INSERT INTO `rrtq_isced` VALUES (109, '09 Health and welfare', NULL);
INSERT INTO `rrtq_isced` VALUES (110, '10 Services', NULL);
INSERT INTO `rrtq_isced` VALUES (2001, '001 Basic programmes and qualifications', 100);
INSERT INTO `rrtq_isced` VALUES (2002, '002 Literacy and numeracy ', 100);
INSERT INTO `rrtq_isced` VALUES (2003, '003 Personal skills and development', 100);
INSERT INTO `rrtq_isced` VALUES (2011, '011 Education', 101);
INSERT INTO `rrtq_isced` VALUES (2021, '021 Arts', 102);
INSERT INTO `rrtq_isced` VALUES (2022, '022 Humanities (except languages)', 102);
INSERT INTO `rrtq_isced` VALUES (2023, '023 Languages', 102);
INSERT INTO `rrtq_isced` VALUES (2031, '031 Social and behavioural sciences', 103);
INSERT INTO `rrtq_isced` VALUES (2032, '032 Journalism and information', 103);
INSERT INTO `rrtq_isced` VALUES (2041, '041 Business and administration', 104);
INSERT INTO `rrtq_isced` VALUES (2042, '042 Law', 104);
INSERT INTO `rrtq_isced` VALUES (2051, '051 Biological and related sciences', 105);
INSERT INTO `rrtq_isced` VALUES (2052, '052 Environment', 105);
INSERT INTO `rrtq_isced` VALUES (2053, '053 Physical sciences', 105);
INSERT INTO `rrtq_isced` VALUES (2054, '054 Mathematics and statistics', 105);
INSERT INTO `rrtq_isced` VALUES (2061, '061 Information and Communication Technologies (ICTs)', 106);
INSERT INTO `rrtq_isced` VALUES (2071, '071 Engineering and engineering trades', 107);
INSERT INTO `rrtq_isced` VALUES (2072, '072 Manufacturing and processing', 107);
INSERT INTO `rrtq_isced` VALUES (2073, '073 Architecture and construction', 107);
INSERT INTO `rrtq_isced` VALUES (2081, '081 Agriculture', 108);
INSERT INTO `rrtq_isced` VALUES (2082, '082 Forestry', 108);
INSERT INTO `rrtq_isced` VALUES (2083, '083 Fisheries', 108);
INSERT INTO `rrtq_isced` VALUES (2084, '084 Veterinary', 108);
INSERT INTO `rrtq_isced` VALUES (2091, '091 Health', 109);
INSERT INTO `rrtq_isced` VALUES (2101, '101 Personal services', 110);
INSERT INTO `rrtq_isced` VALUES (2102, '102 Hygiene and occupational health services', 110);
INSERT INTO `rrtq_isced` VALUES (2103, '103 Security services', 110);
INSERT INTO `rrtq_isced` VALUES (2104, '104 Transport services', 110);
INSERT INTO `rrtq_isced` VALUES (30011, '0011 Basic programmes and qualifications ', 2001);
INSERT INTO `rrtq_isced` VALUES (30021, '0021 Literacy and numeracy', 2002);
INSERT INTO `rrtq_isced` VALUES (30031, '0031 Personal skills and development', 2003);
INSERT INTO `rrtq_isced` VALUES (30111, '0111 Education science', 2011);
INSERT INTO `rrtq_isced` VALUES (30112, '0112 Training for pre-school teachers ', 2011);
INSERT INTO `rrtq_isced` VALUES (30113, '0113 Teacher training without subject specialisation', 2011);
INSERT INTO `rrtq_isced` VALUES (30114, '0114 Teacher training with subject specialisation', 2011);
INSERT INTO `rrtq_isced` VALUES (30211, '0211 Audio-visual techniques and media production ', 2021);
INSERT INTO `rrtq_isced` VALUES (30212, '0212 Fashion, interior and industrial design', 2021);
INSERT INTO `rrtq_isced` VALUES (30213, '0213 Fine arts', 2021);
INSERT INTO `rrtq_isced` VALUES (30214, '0214 Handicrafts', 2021);
INSERT INTO `rrtq_isced` VALUES (30215, '0215 Music and performing arts', 2021);
INSERT INTO `rrtq_isced` VALUES (30221, '0221 Religion and theology ', 2022);
INSERT INTO `rrtq_isced` VALUES (30222, '0222 History and archaeology', 2022);
INSERT INTO `rrtq_isced` VALUES (30223, '0223 Philosophy and ethics', 2022);
INSERT INTO `rrtq_isced` VALUES (30231, '0231 Language acquisition ', 2023);
INSERT INTO `rrtq_isced` VALUES (30232, '0232 Literature and linguistics', 2023);
INSERT INTO `rrtq_isced` VALUES (30311, '0311 Economics', 2031);
INSERT INTO `rrtq_isced` VALUES (30312, '0312 Political sciences and civics ', 2031);
INSERT INTO `rrtq_isced` VALUES (30313, '0313 Psychology', 2031);
INSERT INTO `rrtq_isced` VALUES (30314, '0314 Sociology and cultural studies', 2031);
INSERT INTO `rrtq_isced` VALUES (30321, '0321 Journalism and reporting', 2032);
INSERT INTO `rrtq_isced` VALUES (30322, '0322 Library, information and archival studies', 2032);
INSERT INTO `rrtq_isced` VALUES (30411, '0411 Accounting and taxation', 2041);
INSERT INTO `rrtq_isced` VALUES (30412, '0412 Finance, banking and insurance ', 2041);
INSERT INTO `rrtq_isced` VALUES (30413, '0413 Management and administration ', 2041);
INSERT INTO `rrtq_isced` VALUES (30414, '0414 Marketing and advertising', 2041);
INSERT INTO `rrtq_isced` VALUES (30415, '0415 Secretarial and office work ', 2041);
INSERT INTO `rrtq_isced` VALUES (30416, '0416 Wholesale and retail sales ', 2041);
INSERT INTO `rrtq_isced` VALUES (30417, '0417 Work skills', 2041);
INSERT INTO `rrtq_isced` VALUES (30421, '0421 Law', 2042);
INSERT INTO `rrtq_isced` VALUES (30511, '0511 Biology', 2051);
INSERT INTO `rrtq_isced` VALUES (30512, '0512 Biochemistry', 2051);
INSERT INTO `rrtq_isced` VALUES (30521, '0521 Environmental sciences', 2052);
INSERT INTO `rrtq_isced` VALUES (30522, '0522 Natural environments and wildlife', 2052);
INSERT INTO `rrtq_isced` VALUES (30531, '0531 Chemistry', 2053);
INSERT INTO `rrtq_isced` VALUES (30532, '0532 Earth sciences', 2053);
INSERT INTO `rrtq_isced` VALUES (30533, '0533 Physics', 2053);
INSERT INTO `rrtq_isced` VALUES (30541, '0541 Mathematics', 2054);
INSERT INTO `rrtq_isced` VALUES (30542, '0542 Statistics', 2054);
INSERT INTO `rrtq_isced` VALUES (30611, '0611 Computer use', 2061);
INSERT INTO `rrtq_isced` VALUES (30612, '0612 Database and network design and administration', 2061);
INSERT INTO `rrtq_isced` VALUES (30613, '0613 Software and applications development and analysis', 2061);
INSERT INTO `rrtq_isced` VALUES (30711, '0711 Chemical engineering and processes ', 2071);
INSERT INTO `rrtq_isced` VALUES (30712, '0712 Environmental protection technology ', 2071);
INSERT INTO `rrtq_isced` VALUES (30713, '0713 Electricity and energy', 2071);
INSERT INTO `rrtq_isced` VALUES (30714, '0714 Electronics and automation ', 2071);
INSERT INTO `rrtq_isced` VALUES (30715, '0715 Mechanics and metal trades', 2071);
INSERT INTO `rrtq_isced` VALUES (30716, '0716 Motor vehicles, ships and aircraft', 2071);
INSERT INTO `rrtq_isced` VALUES (30721, '0721 Food processing', 2072);
INSERT INTO `rrtq_isced` VALUES (30722, '0722 Materials (glass, paper, plastic and wood) ', 2072);
INSERT INTO `rrtq_isced` VALUES (30723, '0723 Textiles (clothes, footwear and leather) ', 2072);
INSERT INTO `rrtq_isced` VALUES (30724, '0724 Mining and extraction', 2072);
INSERT INTO `rrtq_isced` VALUES (30731, '0731 Architecture and town planning ', 2073);
INSERT INTO `rrtq_isced` VALUES (30732, '0732 Building and civil engineering', 2073);
INSERT INTO `rrtq_isced` VALUES (30811, '0811 Crop and livestock production', 2081);
INSERT INTO `rrtq_isced` VALUES (30812, '0812 Horticulture', 2081);
INSERT INTO `rrtq_isced` VALUES (30821, '0821 Forestry', 2082);
INSERT INTO `rrtq_isced` VALUES (30831, '0831 Fisheries', 2083);
INSERT INTO `rrtq_isced` VALUES (30841, '0841 Veterinary', 2084);
INSERT INTO `rrtq_isced` VALUES (30911, '0911 Dental studies', 2091);
INSERT INTO `rrtq_isced` VALUES (30912, '0912 Medicine', 2091);
INSERT INTO `rrtq_isced` VALUES (30913, '0913 Nursing and midwifery', 2091);
INSERT INTO `rrtq_isced` VALUES (30914, '0914 Medical diagnostic and treatment technology ', 2091);
INSERT INTO `rrtq_isced` VALUES (30915, '0915 Therapy and rehabilitation', 2091);
INSERT INTO `rrtq_isced` VALUES (30916, '0916 Pharmacy', 2091);
INSERT INTO `rrtq_isced` VALUES (30917, '0917 Traditional and complementary medicine and therapy', 2091);
INSERT INTO `rrtq_isced` VALUES (31011, '1011 Domestic services', 2101);
INSERT INTO `rrtq_isced` VALUES (31012, '1012 Hair and beauty services', 2101);
INSERT INTO `rrtq_isced` VALUES (31013, '1013 Hotel, restaurants and catering ', 2101);
INSERT INTO `rrtq_isced` VALUES (31014, '1014 Sports', 2101);
INSERT INTO `rrtq_isced` VALUES (31015, '1015 Travel, tourism and leisure', 2101);
INSERT INTO `rrtq_isced` VALUES (31021, '1021 Community sanitation', 2102);
INSERT INTO `rrtq_isced` VALUES (31022, '1022 Occupational health and safety', 2102);
INSERT INTO `rrtq_isced` VALUES (31031, '1031 Military and defence', 2103);
INSERT INTO `rrtq_isced` VALUES (31032, '1032 Protection of persons and property', 2103);
INSERT INTO `rrtq_isced` VALUES (31041, '1041 Transport services', 2104);

-- ----------------------------
-- Table structure for rrtq_standard_formativo_isced
-- ----------------------------
DROP TABLE IF EXISTS `rrtq_standard_formativo_isced`;
CREATE TABLE `rrtq_standard_formativo_isced`  (
  `id_isced` int(11) NOT NULL,
  `id_standard_formativo` int(11) NOT NULL,
  PRIMARY KEY (`id_isced`, `id_standard_formativo`) USING BTREE,
  INDEX `id_standard_formativo`(`id_standard_formativo`) USING BTREE,
  CONSTRAINT `rrtq_standard_formativo_isced_ibfk_1` FOREIGN KEY (`id_isced`) REFERENCES `rrtq_isced` (`id_isced`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `rrtq_standard_formativo_isced_ibfk_2` FOREIGN KEY (`id_standard_formativo`) REFERENCES `rrtq_standard_formativo` (`id_standard_formativo`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;


ALTER TABLE `rrtq_standard_formativo` 
ADD COLUMN `data_ultima_pubblicazione` timestamp(0) NULL COMMENT 'Indica la data in cui è stata effettuata la pubblicazione\r\nse NULL significa che lo standard non è mai stato pubblicato e si tratta di un nuovo inserimento' AFTER `data_ultima_modifica`;

ALTER TABLE `rrtq_profilo` 
ADD COLUMN `data_ultima_pubblicazione` timestamp(0) NULL COMMENT 'Indica la data in cui è stata effettuata la pubblicazionese NULL significa che la qualificazione non è mai stata pubblicato e si tratta di un nuovo inserimento' AFTER `data_ultimo_export`;

#ATTENZIONE
UPDATE `rrtq_profilo` SET data_ultima_modifica=data_ultima_modifica, data_ultima_pubblicazione='2018-01-01 00:00:00' WHERE id_profilo < 565;

#INSERISCI GERARDO DE PAOLA

#RIDONDANZE ABILITA
CREATE VIEW `v_rrtq_profilo_ridondanze_abilita` AS 
SELECT id_profilo,id_abilita, descrizione_abilita, count(id_abilita) as ridondanze
FROM v_rrtq_profilo_competenze_abilita
GROUP BY id_profilo,id_abilita HAVING count(id_abilita) > 1;

#RIDONDANZE CONOSCENZE
CREATE VIEW `v_rrtq_profilo_ridondanze_conoscenza` AS 
SELECT id_profilo,id_conoscenza, descrizione_conoscenza, count(id_conoscenza) as ridondanze
FROM v_rrtq_profilo_competenze_conoscenza
GROUP BY id_profilo,id_conoscenza HAVING count(id_conoscenza) > 1;

CREATE VIEW `v_rrtq_standard_formativo_uf` AS SELECT
id_unita_formativa,
id_standard_formativo,
id_profilo,
rrtq_standard_formativo_uf.id_competenza,
rrtq_competenza.titolo_competenza AS titolo_unita_formativa,
ore_min_durata_uf,
perc_varianza,
des_eventuali_vincoli,
perc_fad_uf,
sequenza
FROM
rrtq_standard_formativo_uf
INNER JOIN rrtq_competenza ON rrtq_standard_formativo_uf.id_competenza = rrtq_competenza.id_competenza;


DROP TABLE IF EXISTS `rrtq_archivio_pubblicazioni`;
CREATE TABLE `rrtq_archivio_pubblicazioni`  (
  `id_pubblicazione` int(11) NOT NULL AUTO_INCREMENT,
  `id_profilo` int(11) NULL DEFAULT NULL,
  `data_pubblicazione` timestamp(0) NULL DEFAULT NULL,
  `file_qualificazione` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id_pubblicazione`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;


SET FOREIGN_KEY_CHECKS = 1;


/* NON LANCIARE IN PRODUZIONE 
UPDATE sys_users SET password='$2y$08$iKDLQ5Vn1yJuJcFL4JyzwuyFDfEg12SkNLezseWeGutdNnG6tTuFa';
*/