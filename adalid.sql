
CREATE TABLE rs_grupo (
	id_grupo int NOT NULL AUTO_INCREMENT primary key ,
	nombre_grupo varchar(20) NULL,
	estado_grupo varchar(10) NULL
);


CREATE TABLE rs_grupo_usuario (
	id_grupo_usuario int auto_increment primary key,
	id_grupo int NULL,
	id_usuario int NULL,
	fecha_inicio date NULL,
	fecha_fin date NULL,
	id_usuario_registro int NULL,
	fecha_registro date NULL,
	ip_usuario varchar(20) NULL,
	estado_grupo_usuario varchar(10) NULL
);

ALTER TABLE rs_grupo_usuario ADD CONSTRAINT psg_grupo_usuario_grupo FOREIGN KEY (id_grupo) REFERENCES rs_grupo(id_grupo);
ALTER TABLE rs_grupo_usuario ADD CONSTRAINT psg_grupo_usuario_usuario FOREIGN KEY (id_usuario) REFERENCES rs_usuario(id_usuario);


--- 21/11/2020
drop table db_rosas.rs_materia_maestro;
-- db_rosas.rs_materia_maestro definition

CREATE TABLE `rs_materia_maestro` (
  `id_materia_maestro` int NOT NULL AUTO_INCREMENT,
  `id_materia` int NOT NULL,
  `id_curso` int NOT NULL,
  `id_maestro` int NOT NULL,
  `id_gestion` int NOT NULL,
  PRIMARY KEY (`id_materia_maestro`),
  UNIQUE KEY `id_gestion` (`id_gestion`),
  CONSTRAINT `fk_materia_maestro_gestion` FOREIGN KEY (`id_gestion`) REFERENCES `rs_gestion` (`id_gestion`),
  CONSTRAINT `fk_materia_maestro_maestro` FOREIGN KEY (`id_maestro`) REFERENCES `rs_maestro` (`id_maestro`),
  CONSTRAINT `fk_materia_maestro_materia` FOREIGN KEY (`id_materia`) REFERENCES `rs_materia` (`id_materia`),
  CONSTRAINT `fk_materia_maestro_curso` FOREIGN KEY (`id_curso`) REFERENCES `rs_curso` (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO db_rosas.rs_gestion
(gestion)
values
(2015), 
(2016),
(2017),
(2018),
(2019),
(2020);

INSERT INTO db_rosas.rs_materia_maestro (id_materia, id_curso, id_maestro, id_gestion) 
VALUES(5, 6, 7, 60);
