
--------------------------------------------------------

-- Generado por Oracle SQL Developer Data Modeler 20.4.1.406.0906
--   en:        2024-11-12 16:57:42 CLST
--   sitio:      Oracle Database 21c
--   tipo:      Oracle Database 21c



--  CREATE DATABASE incluus_app 
 --     CONTROLFILE REUSE
 --     MAXLOGFILES 1 
 --     MAXLOGMEMBERS 1 
 --     MAXLOGHISTORY 0 
 --     MAXDATAFILES 10 
 --     MAXINSTANCES 1

-- predefined type, no DDL - MDSYS.SDO_GEOMETRY

-- predefined type, no DDL - XMLTYPE


DROP DATABASE IF EXISTS incluus_app;

CREATE DATABASE incluus_app;

USE incluus_app;


CREATE TABLE curso (
    id_curso    INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nivel       INTEGER NOT NULL,
    id_materia  INTEGER NOT NULL,
    id_usuario  INTEGER NOT NULL
);

CREATE TABLE ejercicio (
    id_juego       INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_juego  VARCHAR(50) NOT NULL,
    dificultad    VARCHAR(50) NOT NULL,
    categoria     VARCHAR(50) NOT NULL,
    respuesta_a   VARCHAR(50) NOT NULL,
    respuesta_b   VARCHAR(50) NOT NULL,
    respuesta_c   VARCHAR(50) NOT NULL,
    respuesta_d   VARCHAR(50) NOT NULL,
    correcta      VARCHAR(50) NOT NULL,
    id_leccion    INTEGER NOT NULL
);

CREATE TABLE leccion (
    id_leccion       INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    numero_leccion  INTEGER NOT NULL,
    puntos_leccion  INTEGER NOT NULL,
    estado          CHAR(1) NOT NULL,
    id_curso        INTEGER NOT NULL,
    id_usuario      INTEGER NOT NULL
);

CREATE TABLE materia (
    id_materia       INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_materia  VARCHAR(50) NOT NULL
);

CREATE TABLE progreso (
    id_progreso        INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    descripcion        VARCHAR(50) NOT NULL,
    puntos_acumulados  INTEGER NOT NULL,
    id_leccion         INTEGER NOT NULL
);

CREATE TABLE usuario (
    id_usuario      INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    rut             VARCHAR(15) NOT NULL,
    password        VARCHAR(255) NOT NULL,
    nombre          VARCHAR(50) NOT NULL,
    apellido        VARCHAR(50) NOT NULL,
    edad            INTEGER NOT NULL,
    correo          VARCHAR(100) NOT NULL,
    rol             VARCHAR(20) NOT NULL,
    puntos_totales  INTEGER NOT NULL,
    foto_perfil     BLOB NOT NULL
);

ALTER TABLE curso
    ADD CONSTRAINT curso_materia_fk FOREIGN KEY ( id_materia )
        REFERENCES materia ( id_materia );

ALTER TABLE curso
    ADD CONSTRAINT curso_usuario_fk FOREIGN KEY ( id_usuario )
        REFERENCES usuario ( id_usuario );

ALTER TABLE ejercicio
    ADD CONSTRAINT ejercicio_leccion_fk FOREIGN KEY ( id_leccion )
        REFERENCES leccion ( id_leccion );

ALTER TABLE leccion
    ADD CONSTRAINT leccion_curso_fk FOREIGN KEY ( id_curso)
        REFERENCES curso ( id_curso);

ALTER TABLE leccion
    ADD CONSTRAINT leccion_usuario_fk FOREIGN KEY ( id_usuario )
        REFERENCES usuario ( id_usuario );        
    

ALTER TABLE progreso
    ADD CONSTRAINT progreso_leccion_fk FOREIGN KEY ( id_leccion )
        REFERENCES leccion ( id_leccion );

----------------------------------------------------------------------------------------------------------------------

-- CONSULTAS SQL --

SELECT * from usuario;
SELECT * FROM materia;

INSERT INTO materia (nombre_materia) VALUES ('Matemáticas'), ('Lenguaje'), ('Ciencias'), ('Historia');

select * from materia;

SELECT leccion.id_leccion FROM leccion JOIN curso 

SELECT leccion.id_leccion, curso.nivel, materia.nombre_materia
FROM leccion
JOIN curso ON leccion.id_curso = curso.id_curso
JOIN materia ON curso.id_materia = materia.id_materia 
 where materia.nombre_materia = "matemáticas" ;

SELECT nivel, nombre_materia 
 FROM curso 
 JOIN materia ON curso.id_materia = materia.id_materia 
 WHERE nombre_materia = "Lenguaje";

SELECT nombre_materia FROM materia;
 