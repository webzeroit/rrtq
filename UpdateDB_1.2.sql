/* SWITCH STATO PROFILO */
INSERT INTO rrtq_stato_profilo(`id_stato_profilo`, `des_stato_profilo`) VALUES (0, 'Pubblicato');
UPDATE rrtq_stato_profilo SET `des_stato_profilo`= 'Revisioni Validate' WHERE `id_stato_profilo`= 1;
UPDATE rrtq_profilo SET id_stato_profilo=0 WHERE id_stato_profilo = 1; #result [474]
UPDATE rrtq_profilo SET id_stato_profilo=2 WHERE id_stato_profilo = 3; #result [6]
UPDATE sys_groups SET `name` = 'supervisore', `description` = 'Supervisore' WHERE `id` = 4
INSERT INTO sys_groups(`id`, `name`, `description`) VALUES (5, 'api', 'Utente API');
CREATE OR REPLACE  VIEW `v_rrtq_competenza` AS SELECT
	`rrtq_competenza`.`id_competenza` AS `id_competenza`,
	`rrtq_competenza`.`titolo_competenza` AS `titolo_competenza`,
	`rrtq_competenza`.`descrizione_competenza` AS `descrizione_competenza`,
	`rrtq_competenza`.`risultato_competenza` AS `risultato_competenza`,
	`rrtq_competenza`.`oggetto_di_osservazione` AS `oggetto_di_osservazione`,
	`rrtq_competenza`.`indicatori` AS `indicatori`,
	`rrtq_competenza`.`livello_eqf` AS `livello_eqf`,
	count( `rrtq_profilo_competenza`.`id_profilo` ) AS `profili_associati` 
FROM
	( `rrtq_competenza` LEFT JOIN `rrtq_profilo_competenza` ON ( ( `rrtq_profilo_competenza`.`id_competenza` = `rrtq_competenza`.`id_competenza` ) ) ) 
GROUP BY
	`rrtq_competenza`.`id_competenza`,
	`rrtq_competenza`.`titolo_competenza`,
	`rrtq_competenza`.`descrizione_competenza`,
	`rrtq_competenza`.`risultato_competenza`,
	`rrtq_competenza`.`oggetto_di_osservazione`,
	`rrtq_competenza`.`indicatori` ;