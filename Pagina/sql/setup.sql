-- Generado por Oracle SQL Developer Data Modeler 20.4.1.406.0906
--   en:        2024-10-15 22:07:23 CLST
--   sitio:      Oracle Database 11g
--   tipo:      Oracle Database 11g

-- predefined type, no DDL - MDSYS.SDO_GEOMETRY

-- predefined type, no DDL - XMLTYPE

DROP DATABASE IF EXISTS incluus_app;

CREATE DATABASE incluus_app;

USE incluus_app;

CREATE TABLE curso (
    id_curso            INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nivel               INTEGER NOT NULL,
    id_materia  INTEGER NOT NULL
);

CREATE TABLE ejercicio (    
    id_juego            INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_juego        VARCHAR(50) NOT NULL,
    dificultad          VARCHAR(50) NOT NULL,
    categoria           VARCHAR(50) NOT NULL,
    respuesta_a           VARCHAR(50) NOT NULL,
    respuesta_b           VARCHAR(50) NOT NULL,
    respuesta_c           VARCHAR(50) NOT NULL,
    respuesta_d           VARCHAR(50) NOT NULL,
    correcta           VARCHAR(50) NOT NULL,
    id_leccion  INTEGER NOT NULL
);

CREATE TABLE leccion (
    id_leccion      INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    numero_leccion  INTEGER NOT NULL,
    progreso        INTEGER NOT NULL,
    estado          CHAR(1) NOT NULL,
    id_curso  INTEGER NOT NULL
);


CREATE TABLE materia (
    id_materia      INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_materia  VARCHAR(50) NOT NULL
);


CREATE TABLE premio (
    id_premio           INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    descripcion         VARCHAR(50) NOT NULL,
    puntos_premio       INTEGER NOT NULL,
    id_leccion          INTEGER NOT NULL
);


CREATE TABLE progreso (
    id_progreso          INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    descripcion          VARCHAR(50) NOT NULL,
    id_resultado         INTEGER NOT NULL
);


CREATE TABLE resultado_ev (
    id_resultado        INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    materia             VARCHAR(15) NOT NULL,
    nombre_alumno       VARCHAR(20) NOT NULL,
    puntos_resultado    INTEGER NOT NULL,
    id_juego            INTEGER NOT NULL
);


CREATE TABLE usuario (
    id_usuario  INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    rut         VARCHAR(15) NOT NULL,
    nombre      VARCHAR(50) NOT NULL,
    apellido    VARCHAR(50) NOT NULL,
    edad        INTEGER NOT NULL,
    correo      VARCHAR(100) NOT NULL,
    rol         VARCHAR(20) NOT NULL,
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
    ADD CONSTRAINT leccion_curso_fk FOREIGN KEY ( id_curso )
        REFERENCES curso ( id_curso );

ALTER TABLE premio
    ADD CONSTRAINT premiov1_leccion_fk FOREIGN KEY ( id_leccion )
        REFERENCES leccion ( id_leccion );

ALTER TABLE progreso
    ADD CONSTRAINT progreso_resultado_ev_fk FOREIGN KEY ( id_resultado )
        REFERENCES resultado_ev ( id_resultado );

ALTER TABLE resultado_ev
    ADD CONSTRAINT resultado_ev_ejercicio_fk FOREIGN KEY ( id_juego )
        REFERENCES ejercicio ( id_juego );

ALTER TABLE `usuario` ADD COLUMN `password` VARCHAR(255) NOT NULL;

ALTER TABLE `materia` ADD COLUMN `banner` BLOB NOT NULL

ALTER TABLE `usuario` ADD COLUMN `foto_perfil` BLOB;
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
-- Informe de Resumen de Oracle SQL Developer Data Modeler: 
-- 
-- CREATE TABLE                             8
-- CREATE INDEX                             0
-- ALTER TABLE                             17
-- CREATE VIEW                              0
-- ALTER VIEW                               0
-- CREATE PACKAGE                           0
-- CREATE PACKAGE BODY                      0
-- CREATE PROCEDURE                         0
-- CREATE FUNCTION                          0
-- CREATE TRIGGER                           0
-- ALTER TRIGGER                            0
-- CREATE COLLECTION TYPE                   0
-- CREATE STRUCTURED TYPE                   0
-- CREATE STRUCTURED TYPE BODY              0
-- CREATE CLUSTER                           0
-- CREATE CONTEXT                           0
-- CREATE DATABASE                          0
-- CREATE DIMENSION                         0
-- CREATE DIRECTORY                         0
-- CREATE DISK GROUP                        0
-- CREATE ROLE                              0
-- CREATE ROLLBACK SEGMENT                  0
-- CREATE SEQUENCE                          0
-- CREATE MATERIALIZED VIEW                 0
-- CREATE MATERIALIZED VIEW LOG             0
-- CREATE SYNONYM                           0
-- CREATE TABLESPACE                        0
-- CREATE USER                              0
-- 
-- DROP TABLESPACE                          0
-- DROP DATABASE                            0
-- 
-- REDACTION POLICY                         0
-- 
-- ORDS DROP SCHEMA                         0
-- ORDS ENABLE SCHEMA                       0
-- ORDS ENABLE OBJECT                       0
-- 
-- ERRORS                                   1
-- WARNINGS                                 0
