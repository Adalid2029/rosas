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
<ALTER TABLE rs_kardex DROP FOREIGN KEY fk_kardex_curso;

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


INSERT INTO rs_tipo_falta (nombre,creado_en,actualizado_en,estado) VALUES
	 ('DISCIPLINARIO','2020-11-25 10:16:22.0',NULL,1),
	 ('PEDAGÓGICO','2020-11-25 10:16:22.0',NULL,1);

INSERT INTO rs_falta (id_tipo_falta,descripcion,creado_en,actualizado_en,estado) VALUES
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
INSERT INTO rs_falta (id_tipo_falta,descripcion,creado_en,actualizado_en,estado) VALUES
	 (2,'NO PRESENTÓ SU TAREA','2020-11-25 10:26:08.0',NULL,1),
	 (2,'NO REALIZÓ SU TRABAJO PRÁCTICO','2020-11-25 10:26:08.0',NULL,1),
	 (2,'NO EXPUSO EL TEMA ASIGNADO','2020-11-25 10:27:08.0',NULL,1),
	 (2,'COPIÓ LA TAREA EN CLASES DE SU COMPAÑERO','2020-11-25 10:27:08.0',NULL,1),
	 (2,'REALIZA TRABAJOS DE OTRAS ASIGNATURAS','2020-11-25 10:27:50.0',NULL,1),
	 (2,'NO DIÓ EXAMEN','2020-11-25 10:27:50.0',NULL,1),
	 (2,'NO TIENE MATERIAL DE TRABAJO','2020-11-25 10:28:24.0',NULL,1),
	 (2,'NO TIENE TEXTO DE LECTURA','2020-11-25 10:28:24.0',NULL,1);

drop table rs_falta_cometida;
CREATE TABLE `rs_falta_cometida` (
  `id_falta_cometida` int(11) NOT NULL AUTO_INCREMENT,
  `id_kardex` int(11) NOT NULL,
  `id_falta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `registrante` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `visto` tinyint(4) NOT NULL DEFAULT 0,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_falta_cometida`),
  KEY `fk_tipofalta_kardex` (`id_kardex`),
  KEY `fk_falta_faltacometida` (`id_falta`),
  CONSTRAINT `fk_falta_faltacometida` FOREIGN KEY (`id_falta`) REFERENCES `rs_falta` (`id_falta`),
  CONSTRAINT `fk_tipofalta_kardex` FOREIGN KEY (`id_kardex`) REFERENCES `rs_kardex` (`id_kardex`)
  );


-- cracion de la vista de las faltas cometidas
create or replace view rs_view_falta_cometida as
select rfc.id_falta_cometida, rk.id_kardex, rtf.id_tipo_falta, rtf.nombre, rf.id_falta, rf.descripcion, rfc.fecha, rfc.registrante, rfc.visto, rfc.estado
from rs_falta_cometida rfc
inner join rs_kardex rk on rfc.id_kardex = rk.id_kardex
inner join rs_falta rf on rfc.id_falta = rf.id_falta
inner join rs_tipo_falta rtf on rf.id_tipo_falta = rtf.id_tipo_falta;


---- AGREGAR CAMPO CORREO EN PERSONA Y LA CORRECION DE LAS VISTAS
--- CREACION DE LA COLUMNA CORREO EN PERSONA
ALTER TABLE `rs_persona` ADD `correo` VARCHAR(50) NULL AFTER `nacimiento`;

-- db_rosas1.rs_view_administrativo source

-- correcion de la vista
create or replace view `rs_view_administrativo` as
select
    `rsp`.`id_persona` as `id_persona`,
    `rsa`.`id_administrativo` as `id_administrativo`,
    concat(`rsp`.`ci`, ' ', `rsp`.`exp`) as `ci`,
    concat(`rsp`.`nombres`, ' ', `rsp`.`paterno`, ' ', `rsp`.`materno`) as `nombres_apellidos`,
    rsp.correo,
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

-- correccion de la vista estudiante
-- db_rosas1.rs_view_estudiante source

create or replace view `rs_view_estudiante` as
select
    `rp`.`id_persona` as `id_persona`,
    `re`.`id_estudiante` as `id_estudiante`,
    `re`.`rude` as `rude`,
    concat(`rp`.`ci`, ' ', `rp`.`exp`) as `ci`,
    concat(`rp`.`nombres`, ' ', `rp`.`paterno`, ' ', `rp`.`materno`) as `nombres_apellidos`,
    rp.correo,
    `rp`.`nacimiento` as `nacimiento`,
    `rp`.`telefono` as `telefono`,
    `rp`.`sexo` as `sexo`,
    `rp`.`domicilio` as `domicilio`,
    `re`.`gestion_ingreso` as `gestion_ingreso`,
    `rp`.`estado` as `estado`
from
    (`rs_persona` `rp`
join `rs_estudiante` `re` on
    (`re`.`id_estudiante` = `rp`.`id_persona`));

-- correcion de la vista maestro
-- db_rosas1.rs_view_maestro source

create or replace view `rs_view_maestro` as
select
    `rsp`.`id_persona` as `id_persona`,
    `rsm`.`id_maestro` as `id_maestro`,
    `rsp`.`ci` as `ci`,
    concat(`rsp`.`nombres`, ' ', `rsp`.`paterno`, ' ', `rsp`.`materno`) as `nombres_apellidos`,
    rsp.correo,
    `rsp`.`nacimiento` as `nacimiento`,
    `rsp`.`telefono` as `telefono`,
    `rsp`.`sexo` as `sexo`,
    `rsm`.`grado_academico` as `grado_academico`,
    `rsp`.`estado` as `estado`
from
    (`rs_persona` `rsp`
join `rs_maestro` `rsm` on
    (`rsp`.`id_persona` = `rsm`.`id_maestro`));

   -- correcion de la vista tutor
-- db_rosas1.rs_view_tutor source

create or replace view `rs_view_tutor` as
select
    `rsp`.`id_persona` as `id_persona`,
    `rst`.`id_tutor` as `id_tutor`,
    concat(`rsp`.`ci`, ' ', `rsp`.`exp`) as `ci`,
    concat(`rsp`.`nombres`, ' ', `rsp`.`paterno`, ' ', `rsp`.`materno`) as `nombres_apellidos`,
    rsp.correo,
    `rsp`.`nacimiento` as `nacimiento`,
    `rsp`.`telefono` as `telefono`,
    `rsp`.`sexo` as `sexo`,
    `rst`.`parentesco` as `parentesco`,
    `rsp`.`estado` as `estado`
from
    (`rs_persona` `rsp`
join `rs_tutor` `rst` on
    (`rsp`.`id_persona` = `rst`.`id_tutor`));

    --- fin de correcion de vistas y de agregar correo



    -- ASISTENCIA

create or replace view rs_view_asistencia as
SELECT p.id_persona, rce.id_curso_estudiante, concat(paterno, ' ', materno, ' ', nombres, ' CI. ', ci, ' ', exp) as nombre_completo,  concat(c.nivel, ' ', rp.paralelo)as curso,
                rg.gestion,c.nivel, rp.paralelo, p.estado
                from rs_estudiante e
                join rs_persona p on p.id_persona = e.id_estudiante
                join rs_curso_estudiante rce on rce.id_estudiante = e.id_estudiante
                join rs_gestion rg on rg.id_gestion = rce.id_gestion
                join rs_curso_paralelo cp on cp.id_curso_paralelo =  rce.id_curso_paralelo
                join rs_curso c on c.id_curso =  cp.id_curso
                join rs_paralelo rp on rp.id_paralelo = cp.id_paralelo;


-- creacion de la tabla de asistencia
create table rs_asistencia(
	id_asistencia int not null auto_increment,
	id_estudiante int not null,
	id_maestro int not null,
	valor varchar(1) not null,
	fecha date not null,
	hora time not null,
	observacion varchar(256),
	creado_en TIMESTAMP not NULL default now(),
	actualizado_en TIMESTAMP NULL DEFAULT null,
	estado TINYINT NOT NULL DEFAULT '1',
	primary key (id_asistencia),
	constraint fk_estudiante_asistencia foreign key(id_estudiante) references rs_estudiante (id_estudiante),
	constraint fk_maestro_asistencia foreign key(id_maestro) references rs_maestro (id_maestro)
);

-- vista asistencia
-- db_rosas1.rs_view_asistencia_curso source

create or replace view `rs_view_asistencia_curso` as
select
    `p`.`id_persona` as `id_persona`,
    `p`.`paterno` as `paterno`,
    `p`.`materno` as `materno`,
    `p`.`nombres` as `nombres`,
    concat(`c`.`nivel`, ' ', `rp`.`paralelo`) as `curso`,
    `ra`.`fecha` as `fecha`,
    `ra`.`valor` as `valor`,
    `c`.`nivel` as `nivel`,
    `rp`.`paralelo` as `paralelo`,
    `rg`.`gestion` as `gestion`,
    `p`.`estado` as `estado`
from
    (((((((`rs_estudiante` `e`
join `rs_persona` `p` on
    (`p`.`id_persona` = `e`.`id_estudiante`))
join `rs_curso_estudiante` `rce` on
    (`rce`.`id_estudiante` = `e`.`id_estudiante`))
join `rs_gestion` `rg` on
    (`rg`.`id_gestion` = `rce`.`id_gestion`))
join `rs_curso_paralelo` `cp` on
    (`cp`.`id_curso_paralelo` = `rce`.`id_curso_paralelo`))
join `rs_curso` `c` on
    (`c`.`id_curso` = `cp`.`id_curso`))
join `rs_paralelo` `rp` on
    (`rp`.`id_paralelo` = `cp`.`id_paralelo`))
join `rs_asistencia` `ra` on
    (`ra`.`id_estudiante` = `e`.`id_estudiante`));


-- correccion de la vista faltas y para el reporte de la vista de seguimiento de estudiante
create or replace view `rs_view_seguimiento` as
select
    `p`.`id_persona` as `id_persona`,
    `rce`.`id_curso_estudiante` as `id_curso_estudiante`,
    concat(`p`.`paterno`, ' ', `p`.`materno`, ' ', `p`.`nombres`) as `nombre_completo`,
    concat(`c`.`nivel`, ' ', `rp`.`paralelo`) as `curso`,
    `rg`.`gestion` as `gestion`,
    `c`.`nivel` as `nivel`,
    `rp`.`paralelo` as `paralelo`,
    `p`.`estado` as `estado`
from
    ((((((`rs_estudiante` `e`
join `rs_persona` `p` on
    (`p`.`id_persona` = `e`.`id_estudiante`))
join `rs_curso_estudiante` `rce` on
    (`rce`.`id_estudiante` = `e`.`id_estudiante`))
join `rs_gestion` `rg` on
    (`rg`.`id_gestion` = `rce`.`id_gestion`))
join `rs_curso_paralelo` `cp` on
    (`cp`.`id_curso_paralelo` = `rce`.`id_curso_paralelo`))
join `rs_curso` `c` on
    (`c`.`id_curso` = `cp`.`id_curso`))
join `rs_paralelo` `rp` on
    (`rp`.`id_paralelo` = `cp`.`id_paralelo`));


-- seguimiento listar falta de cada estudiante
create or replace view rs_view_falta_estudiante as
select  re.id_estudiante, rf.id_falta, rtf.id_tipo_falta,rk.id_kardex, rp.paterno, rp.materno, rp.nombres, rp.ci,  rtf.nombre, rf.descripcion, rfc.fecha,
rk.gestion, rfc.estado, rfc.registrante
from rs_kardex rk join rs_falta_cometida rfc on rk.id_kardex = rfc.id_kardex
join rs_falta rf on rfc.id_falta = rf.id_falta
join rs_tipo_falta rtf on rtf.id_tipo_falta = rf.id_tipo_falta
join rs_estudiante re on rk.id_estudiante = re.id_estudiante
join rs_persona rp on re.id_estudiante = rp.id_persona;

-- adicionar columna de id materia a falta cometida
ALTER TABLE rs_falta_cometida ADD id_materia int not null AFTER `id_falta`;
alter table rs_falta_cometida  add CONSTRAINT `fk_materia_faltacometida` FOREIGN KEY (`id_materia`) REFERENCES rs_materia (`id_materia`);

-- db_rosas1.rs_view_falta_cometida source

create or replace view `rs_view_falta_cometida` as
select
    `rfc`.`id_falta_cometida` as `id_falta_cometida`,
    `rk`.`id_kardex` as `id_kardex`,
    `rtf`.`id_tipo_falta` as `id_tipo_falta`,
    `rtf`.`nombre` as `nombre`,
    `rf`.`id_falta` as `id_falta`,
    `rf`.`descripcion` as `descripcion`,
    rm.nombre as materia,
    `rfc`.`fecha` as `fecha`,
    `rfc`.`registrante` as `registrante`,
    `rfc`.`visto` as `visto`,
    `rfc`.`estado` as `estado`
from
    (((`rs_falta_cometida` `rfc`
join `rs_kardex` `rk` on
    (`rfc`.`id_kardex` = `rk`.`id_kardex`))
join `rs_falta` `rf` on
    (`rfc`.`id_falta` = `rf`.`id_falta`))
join `rs_tipo_falta` `rtf` on
    (`rf`.`id_tipo_falta` = `rtf`.`id_tipo_falta`))
join rs_materia rm on rm.id_materia = rfc.id_materia;

-- correccion de la vista kardex
create or replace view `rs_view_kardex` as
select
    `rk`.`id_kardex` as `id_kardex`,
    `rk`.`id_estudiante` as `id_estudiante`,
    concat(rc.nivel,' ', rpa.paralelo) as curso,
    concat(`rp`.`nombres`, ' ', `rp`.`paterno`, ' ', `rp`.`materno`) as `estudiante`,
    `rk`.`gestion` as `gestion`,
    `rk`.`contador` as `contador`,
    `rk`.`creado_en` as `creado_en`,
    `rk`.`estado` as `estado`
from
    ((`rs_persona` `rp`
join `rs_estudiante` `re` on
    (`rp`.`id_persona` = `re`.`id_estudiante`))
join `rs_kardex` `rk` on
    (`re`.`id_estudiante` = `rk`.`id_estudiante`))
join rs_curso_paralelo rcp on rcp.id_curso_paralelo = rk.id_curso_paralelo
join rs_curso rc on rcp.id_curso = rc.id_curso
join rs_paralelo rpa on rpa.id_paralelo = rcp.id_paralelo
order by
    `rk`.`id_kardex` desc;



    -- creacion de la vista de estudiantes y paralelos
create or replace view rs_view_estudiantes_cursos as
SELECT e.id_estudiante , rce.id_curso_paralelo , concat(paterno, ' ', materno, ' ', nombres, ' CI. ', ci, ' ', exp) as nombre_completo,  concat(c.nivel, ' ', rp.paralelo)as curso,
                rg.gestion,c.nivel, rp.paralelo, p.estado
                from rs_estudiante e
                join rs_persona p on p.id_persona = e.id_estudiante
                join rs_curso_estudiante rce on rce.id_estudiante = e.id_estudiante
                join rs_gestion rg on rg.id_gestion = rce.id_gestion
                join rs_curso_paralelo cp on cp.id_curso_paralelo =  rce.id_curso_paralelo
                join rs_curso c on c.id_curso =  cp.id_curso
                join rs_paralelo rp on rp.id_paralelo = cp.id_paralelo;


----------------------------------
-- db_rosas3.rs_view_estudiantes_cursos source

create or replace view `rs_view_estudiantes_cursos_consulta` as
select
    `e`.`id_estudiante` as `id_estudiante`,
    `cp`.`id_curso_paralelo`,
	e.rude,
	concat(`p`.`ci`, ' ', `p`.`exp`) as ci,
    concat(`p`.`paterno`, ' ', `p`.`materno`, ' ', `p`.`nombres`) as `nombre_completo`,
    p.nacimiento,
    p.telefono,
    p.sexo,
    concat(`c`.`nivel`, ' ', `rp`.`paralelo`) as `curso`,
    `rg`.`gestion` as `gestion`,
    `c`.`nivel` as `nivel`,
    `rp`.`paralelo` as `paralelo`,
    `p`.`estado` as `estado`
from
    ((((((`rs_estudiante` `e`
join `rs_persona` `p` on
    (`p`.`id_persona` = `e`.`id_estudiante`))
join `rs_curso_estudiante` `rce` on
    (`rce`.`id_estudiante` = `e`.`id_estudiante`))
join `rs_gestion` `rg` on
    (`rg`.`id_gestion` = `rce`.`id_gestion`))
join `rs_curso_paralelo` `cp` on
    (`cp`.`id_curso_paralelo` = `rce`.`id_curso_paralelo`))
join `rs_curso` `c` on
    (`c`.`id_curso` = `cp`.`id_curso`))
join `rs_paralelo` `rp` on
    (`rp`.`id_paralelo` = `cp`.`id_paralelo`));

    -- vista calificacion
    create or replace view rs_view_calificacion as
   select rc.id_calificacion, rc.id_estudiante, rc.id_curso_paralelo, rc.id_materia, rm.codigo, rc.nota1, rc.nota2, rc.nota3, rc.fecha_registro
   from rs_calificacion rc
   inner join rs_estudiante re ON rc.id_estudiante = re.id_estudiante
   inner join rs_persona rp on re.id_estudiante =rp.id_persona
   inner join rs_materia rm on rm.id_materia = rc.id_materia

   --
   create or replace view rs_estudiante_notas_curso as
   select rc.id_calificacion,rc.id_estudiante, rc.id_curso_paralelo,rm.id_materia, rm.codigo, rm.nombre, rc.nota1, rc.nota2, rc.nota3, rc.nota_final, year (rc.fecha_registro) as gestion
   from rs_calificacion rc inner join rs_materia rm on rc.id_materia = rm.id_materia;


-- db_rosas3.rs_estudiante_notas_curso source

create or replace view `rs_estudiante_notas_curso` as
select
    `rc`.`id_calificacion` as `id_calificacion`,
    `rc`.`id_estudiante` as `id_estudiante`,
    `rc`.`id_curso_paralelo` as `id_curso_paralelo`,
    `rm`.`id_materia` as `id_materia`,
    `rm`.`codigo` as `codigo`,
    `rm`.`nombre` as `nombre`,
    `rc`.`nota1` as `nota1`,
    `rc`.`nota2` as `nota2`,
    `rc`.`nota3` as `nota3`,
    `rc`.`nota_final` as `nota_final`,
    year(`rc`.`fecha_registro`) as `gestion`
from
    (`rs_calificacion` `rc`
join `rs_materia` `rm` on
    (`rc`.`id_materia` = `rm`.`id_materia`));
