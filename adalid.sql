-- Fecha 25/11/2020
ALTER TABLE db_rosas.rs_calificacion MODIFY COLUMN nota1 int NULL;
ALTER TABLE db_rosas.rs_calificacion MODIFY COLUMN nota2 int NULL;
ALTER TABLE db_rosas.rs_calificacion MODIFY COLUMN nota3 int NULL;
ALTER TABLE db_rosas.rs_calificacion MODIFY COLUMN nota_final int NULL;


-- Fecha 29/11/2020
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

INSERT INTO db_rosas.rs_grupo (nombre_grupo, estado_grupo) VALUES('SUPERADMIN', 'ACTIVO');
INSERT INTO db_rosas.rs_grupo (nombre_grupo, estado_grupo) VALUES('ADMINISTRADOR', 'ACTIVO');
INSERT INTO db_rosas.rs_grupo (nombre_grupo, estado_grupo) VALUES('DIRECTOR', 'ACTIVO');
INSERT INTO db_rosas.rs_grupo (nombre_grupo, estado_grupo) VALUES('SECRETARIA', 'ACTIVO');
INSERT INTO db_rosas.rs_grupo (nombre_grupo, estado_grupo) VALUES('PADRE_FAMILIA', 'ACTIVO');
INSERT INTO db_rosas.rs_grupo (nombre_grupo, estado_grupo) VALUES('ESTUDIANTE', 'ACTIVO');
INSERT INTO db_rosas.rs_grupo (nombre_grupo, estado_grupo) VALUES('MAESTRO', 'ACTIVO');
INSERT INTO db_rosas.rs_grupo (nombre_grupo, estado_grupo) VALUES('REGENTE', 'ACTIVO');
INSERT INTO db_rosas.rs_grupo (nombre_grupo, estado_grupo) VALUES('AUXILIAR', 'ACTIVO');
INSERT INTO db_rosas.rs_grupo (nombre_grupo, estado_grupo) VALUES('PORTERA', 'ACTIVO');




 
 -- db_rosas.rs_view_users source

create or replace
view rs_view_users as
 SELECT p.*, u.usuario , u.clave, gu.*, g.nombre_grupo, g.estado_grupo 
   FROM rs_usuario u
     JOIN rs_persona p ON p.id_persona = u.id_usuario 
     left JOIN rs_grupo_usuario gu ON gu.id_usuario = u.id_usuario
     left JOIN rs_grupo g ON g.id_grupo = gu.id_grupo

     
-- INSERT INTO db_rosas.rs_grupo_usuario
-- (id_grupo, id_usuario, fecha_inicio, fecha_fin, id_usuario_registro, fecha_registro, ip_usuario, estado_grupo_usuario) 
-- VALUES(7, 7, null, null, 0,null, '127.0.0.1', 'ACTIVO');
-- 
-- INSERT INTO db_rosas.rs_grupo_usuario
-- (id_grupo, id_usuario, fecha_inicio, fecha_fin, id_usuario_registro, fecha_registro, ip_usuario, estado_grupo_usuario) 
-- VALUES(1, 7, null, null, 0,null, '127.0.0.1', 'ACTIVO');


