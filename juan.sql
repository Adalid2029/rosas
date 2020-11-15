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
