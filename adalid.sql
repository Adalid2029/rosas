
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
