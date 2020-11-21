-- INICIO DEL SQL EN EL ADMINISTRATIVO
-- vista
create or replace view `rs_view_administrativo` as
select
    `rsp`.`id_persona` as `id_persona`,
    `rsa`.`id_administrativo` as `id_administrativo`,
    concat(`rsp`.`ci`, ' ', `rsp`.`exp`) as `ci`,
    concat(`rsp`.`nombres`, ' ', `rsp`.`paterno`, ' ', `rsp`.`materno`) as `nombres_apellidos`,
    `rsp`.`nacimiento` as `nacimiento`,
    `rsp`.`telefono` as `telefono`,
    `rsp`.`sexo` as `sexo`,
    `rsa`.`cargo` as `cargo`,
    `rsa`.`gestion_ingreso` as `gestion_ingreso`,
    `rsp`.`estado` as `estado`
from
    (`rs_persona` `rsp`
join `rs_administrativo` `rsa` on
    (`rsp`.`id_persona` = `rsa`.`id_administrativo`));

-- Query de la tabla MATERIA
-- Unique columna codigo
ALTER TABLE `rs_materia` ADD UNIQUE(`codigo`);
-- Unique columna codigo
ALTER TABLE `rs_materia` ADD UNIQUE(`nombre`);
--add column estado
ALTER TABLE `rs_materia` ADD `estado` TINYINT NOT NULL DEFAULT '1' AFTER `actualizado_en`;

-- adicionar columnas
ALTER TABLE `rs_responsable` ADD `creado_en` TIMESTAMP NULL DEFAULT NULL AFTER `id_estudiante`;
ALTER TABLE `rs_responsable` ADD `actualizado_en` TIMESTAMP NULL DEFAULT NULL AFTER `creado_en`;
ALTER TABLE rs_responsable ADD estado TINYINT NOT NULL DEFAULT '1' AFTER actualizado_en;


-- QUERYS DE LA ASIGNACION DE TUTORES A UN ESTUDIANTE
create or replace view rs_view_estudiantes_tutores as
select rr.id_responsable, concat(rp.nombres, ' ', rp.paterno, ' ', rp.materno) as nombres_est, concat(rp.ci, ' ', rp.`exp`) as ci_est, rp.telefono as telefono_est,
concat(rpt.nombres, ' ', rpt.paterno, ' ', rpt.materno) as nombres_tutor, concat(rpt.ci, ' ', rpt.`exp`) as ci_tutor, rpt.telefono as telefono_tutor, rt.parentesco, rr.estado
from rs_estudiante re inner join rs_persona rp on re.id_estudiante = rp.id_persona
inner join rs_responsable rr on re.id_estudiante =rr.id_estudiante
inner join rs_tutor rt on rr.id_tutor =rt.id_tutor
inner join rs_persona rpt on rpt.id_persona = rt.id_tutor ;

-- correccion de la vista tutor

create or replace view `rs_view_tutor` as
select
    `rsp`.`id_persona` as `id_persona`,
    `rst`.`id_tutor` as `id_tutor`,
    concat(rsp.ci,' ', rsp.exp) as ci ,
    concat(`rsp`.`nombres`, ' ', `rsp`.`paterno`, ' ', `rsp`.`materno`) as `nombres_apellidos`,
    `rsp`.`nacimiento` as `nacimiento`,
    `rsp`.`telefono` as `telefono`,
    `rsp`.`sexo` as `sexo`,
    `rst`.`parentesco` as `parentesco`,
    `rsp`.`estado` as `estado`
from
    (`rs_persona` `rsp`
join `rs_tutor` `rst` on
    (`rsp`.`id_persona` = `rst`.`id_tutor`));

