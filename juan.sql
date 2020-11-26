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


--------------- QUERYS DE KARDEX -----------
-- db_rosas1.rs_kardex definition


-- eliminar llave foranea de kardex
ALTER TABLE rs_kardex DROP FOREIGN KEY fk_kardex_curso;

-- eliminar index
ALTER TABLE `rs_kardex` DROP INDEX `fk_kardex_curso`;

-- cambiar nombre de columna
ALTER TABLE `rs_kardex` CHANGE `id_curso` `id_curso_paralelo` INT(11) NOT NULL;

-- agregar foreign key curso paralelo
alter table rs_kardex  add CONSTRAINT `fk_kardex_cursoparalelo` FOREIGN KEY (`id_curso_paralelo`) REFERENCES rs_curso_paralelo (`id_curso_paralelo`);


-- eliminar tabla pedagogico
drop table rs_pedagogico ;

-- adicionar columnas de fechas en kardex
ALTER TABLE rs_kardex ADD `creado_en` TIMESTAMP NULL DEFAULT NULL AFTER `registrante`;
ALTER TABLE `rs_kardex` ADD `actualizado_en` TIMESTAMP NULL DEFAULT NULL AFTER `creado_en`;
ALTER TABLE rs_kardex ADD estado TINYINT NOT NULL DEFAULT '1' AFTER actualizado_en;

-- eliminar disciplinacio y falta cometida
drop table rs_disciplinario, rs_falta_cometida ;

-- creacion de la tabla tipo de falta
create table rs_tipo_falta(
	id_tipo_falta INT not null auto_increment,
	id_kardex int not null,
	tipo VARCHAR(50) not null,
	contador INT not null,
	descripcion varchar(255) not null,
	fecha date not null,
	creado_en TIMESTAMP not NULL default now(),
	actualizado_en TIMESTAMP NULL DEFAULT null,
	estado TINYINT NOT NULL DEFAULT '1',
	primary key (id_tipo_falta),
	constraint fk_tipofalta_kardex foreign key (id_kardex) references rs_kardex(id_kardex)
);

-- eliminar registrante de kardex
ALTER TABLE `rs_kardex` DROP `registrante`;
ALTER TABLE `rs_tipo_falta` ADD `registrante` TEXT NOT NULL AFTER `fecha`;

create or replace view rs_view_kardex as
select rk.id_kardex, rk.id_estudiante, rk.id_curso_paralelo, concat(rp.nombres, ' ', rp.paterno, ' ', rp.materno)as estudiante, rk.gestion, rk.contador, rk.creado_en, rk.estado
from rs_persona rp inner join rs_estudiante re on rp.id_persona = re.id_estudiante
inner join rs_kardex rk on re.id_estudiante = rk.id_estudiante order by rk.id_kardex desc;

ALTER TABLE `rs_tipo_falta` DROP `contador`;

ALTER TABLE `rs_kardex` ADD `contador` INT NOT NULL DEFAULT '0' AFTER `gestion`;

ALTER TABLE `rs_tipo_falta` ADD `visto` TINYINT NOT NULL DEFAULT '0' AFTER `registrante`;


-- citacion
ALTER TABLE `rs_citacion` DROP `tipo`;
ALTER TABLE `rs_citacion` DROP `citacion`;


-- crear la vista citacion

create or replace view rs_view_citacion  AS
select rc.id_citacion, rc.id_kardex, concat(rp.paterno, ' ', rp.materno, ' ', rp.nombres) as nombres_apellidos, rc.fecha
from rs_citacion rc inner join rs_kardex rk on rc.id_kardex = rk.id_kardex
inner join rs_estudiante re on rk.id_estudiante = re.id_estudiante
inner join rs_persona rp on re.id_estudiante =rp.id_persona;

--   faltas y sus correcciones


-- renama tipo_falta por falta cometida
ALTER TABLE rs_tipo_falta RENAME rs_falta_cometida;
 -- rename id
 ALTER TABLE `rs_falta_cometida` CHANGE `id_tipo_falta` `id_falta_cometida` INT(11) NOT NULL AUTO_INCREMENT;


--- creacion de tipo de falta
create table rs_tipo_falta (
	id_tipo_falta INT not null auto_increment,
	nombre VARCHAR(100) not null,
	creado_en TIMESTAMP NULL DEFAULT now(),
	actualizado_en TIMESTAMP NULL DEFAULT null,
	estado TINYINT NOT NULL DEFAULT '1',
	primary key(id_tipo_falta)
);

drop table falta;

create table rs_falta(
	id_falta INT not null auto_increment,
	id_tipo_falta int not null,
	descripcion varchar(150) not null,
	creado_en TIMESTAMP NULL DEFAULT now(),
	actualizado_en TIMESTAMP NULL DEFAULT null,
	estado TINYINT NOT NULL DEFAULT '1',
	primary key(id_falta),
	constraint fk_faltas_tipofalta foreign key(id_tipo_falta) references rs_tipo_falta(id_tipo_falta)
);

--------------------------

INSERT INTO rs_tipo_falta (nombre,creado_en,actualizado_en,estado) VALUES
	 ('DISCIPLINARIO','2020-11-25 10:16:22.0',NULL,1),
	 ('PEDAGÓGICO','2020-11-25 10:16:22.0',NULL,1);

INSERT INTO db_rosas1.rs_falta (id_tipo_falta,descripcion,creado_en,actualizado_en,estado) VALUES
	 (1,'ABANDONÓ EL CURSO SIN AUTORIZACIÓN','2020-11-25 10:22:05.0',NULL,1),
	 (1,'NO PORTA EL UNIFORME','2020-11-25 10:22:05.0',NULL,1),
	 (1,'DESCUIDA SU HIGIENE PERSONAL','2020-11-25 10:22:58.0',NULL,1),
	 (1,'NO RESPETA A SUS COMPAÑEROS','2020-11-25 10:22:58.0',NULL,1),
	 (1,'JUEGA CON EL DESAYUNO ESCOLAR','2020-11-25 10:23:55.0',NULL,1),
	 (1,'MOLESTA Y SE DISTRAE EN LAS CLASES','2020-11-25 10:23:55.0',NULL,1),
	 (1,'USA CELULAR EN LAS CLASES','2020-11-25 10:24:26.0',NULL,1),
	 (1,'TRAE OBJETOS DE VALOR','2020-11-25 10:24:26.0',NULL,1),
	 (1,'SE EXPRESA CON PALABRAS GROSERAS','2020-11-25 10:25:22.0',NULL,1),
	 (1,'DESTROZA EL MOBILIARIO DEL CURSO','2020-11-25 10:25:22.0',NULL,1);
INSERT INTO db_rosas1.rs_falta (id_tipo_falta,descripcion,creado_en,actualizado_en,estado) VALUES
	 (2,'NO PRESENTÓ SU TAREA','2020-11-25 10:26:08.0',NULL,1),
	 (2,'NO REALIZÓ SU TRABAJO PRÁCTICO','2020-11-25 10:26:08.0',NULL,1),
	 (2,'NO EXPUSO EL TEMA ASIGNADO','2020-11-25 10:27:08.0',NULL,1),
	 (2,'COPIÓ LA TAREA EN CLASES DE SU COMPAÑERO','2020-11-25 10:27:08.0',NULL,1),
	 (2,'REALIZA TRABAJOS DE OTRAS ASIGNATURAS','2020-11-25 10:27:50.0',NULL,1),
	 (2,'NO DIÓ EXAMEN','2020-11-25 10:27:50.0',NULL,1),
	 (2,'NO TIENE MATERIAL DE TRABAJO','2020-11-25 10:28:24.0',NULL,1),
	 (2,'NO TIENE TEXTO DE LECTURA','2020-11-25 10:28:24.0',NULL,1);




-- cracion de la vista de las faltas cometidas
create or replace view rs_view_falta_cometida as
select rfc.id_falta_cometida, rk.id_kardex, rtf.id_tipo_falta, rtf.nombre, rf.id_falta, rf.descripcion, rfc.fecha, rfc.registrante, rfc.visto, rfc.estado
from rs_falta_cometida rfc inner join rs_kardex rk on rfc.id_kardex = rk.id_kardex
inner join rs_falta rf on rfc.id_falta = rf.id_falta
inner join rs_tipo_falta rtf on rf.id_tipo_falta = rtf.id_tipo_falta;






