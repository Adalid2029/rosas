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
