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

-- adicionar columnas
ALTER TABLE `rs_responsable` ADD `creado_en` TIMESTAMP NULL DEFAULT NULL AFTER `id_estudiante`;
ALTER TABLE `rs_responsable` ADD `actualizado_en` TIMESTAMP NULL DEFAULT NULL AFTER `creado_en`;
ALTER TABLE rs_responsable ADD estado TINYINT NOT NULL DEFAULT '1' AFTER actualizado_en;

-- QUERYS DE CURSO Y PARALELO

alter table rs_curso drop paralelo;

create table rs_paralelo(
	id_paralelo INT not null auto_increment,
	paralelo VARCHAR(1) not null unique,
	primary KEY(id_paralelo)
);

create table rs_curso_paralelo(
	id_curso_paralelo INT not null auto_increment,
	id_curso INT not null,
	id_paralelo INT not null,
	creado_en timestamp not null default now(),
	actualizado_en timestamp null default null,
	estado tinyint not null default '1',
	primary key (id_curso_paralelo),
	constraint fk_curso_cursoparalelo foreign key(id_curso) references rs_curso(id_curso),
	constraint fk_paralelo_cursoparalelo foreign key(id_paralelo) references rs_paralelo(id_paralelo)
);

ALTER TABLE rs_curso ADD UNIQUE (nivel);

-- creacion de la vista
create or replace view rs_view_curso_paralelo as
select rcp.id_curso_paralelo, rc.id_curso, rp.id_paralelo, rc.nivel, rp.paralelo, rcp.creado_en, rcp.estado
from rs_curso rc inner join rs_curso_paralelo rcp on rc.id_curso = rcp.id_curso
inner join rs_paralelo rp on rcp.id_paralelo =rp.id_paralelo;

ALTER TABLE rs_paralelo ADD `creado_en` TIMESTAMP NULL DEFAULT NULL AFTER `paralelo`;
ALTER TABLE `rs_paralelo` ADD `actualizado_en` TIMESTAMP NULL DEFAULT NULL AFTER `creado_en`;
ALTER TABLE rs_paralelo ADD estado TINYINT NOT NULL DEFAULT '1' AFTER actualizado_en;


ALTER TABLE rs_curso ADD `creado_en` TIMESTAMP NULL DEFAULT NULL AFTER `nivel`;
ALTER TABLE `rs_curso` ADD `actualizado_en` TIMESTAMP NULL DEFAULT NULL AFTER `creado_en`;
ALTER TABLE rs_curso ADD estado TINYINT NOT NULL DEFAULT '1' AFTER actualizado_en;



