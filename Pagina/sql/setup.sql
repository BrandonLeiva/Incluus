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
    id_curso            INTEGER NOT NULL,
    nivel               INTEGER NOT NULL,
    usuario_id_usuario  INTEGER,
    materia_id_materia  INTEGER NOT NULL
);

ALTER TABLE curso ADD CONSTRAINT curso_pk PRIMARY KEY ( id_curso );

CREATE TABLE ejercicio (
    id_juego            INTEGER NOT NULL,
    nombre_juego        VARCHAR(50) NOT NULL,
    dificultad          VARCHAR(50) NOT NULL,
    categoria           VARCHAR(50) NOT NULL,
    id_usuario          INTEGER NOT NULL,
    leccion_id_leccion  INTEGER NOT NULL
);

ALTER TABLE ejercicio ADD CONSTRAINT juego_pk PRIMARY KEY ( id_juego );

CREATE TABLE leccion (
    id_leccion      INTEGER NOT NULL,
    numero_leccion  INTEGER NOT NULL,
    progreso        INTEGER NOT NULL,
    estado          CHAR(1) NOT NULL,
    curso_id_curso  INTEGER NOT NULL
);

ALTER TABLE leccion ADD CONSTRAINT leccion_pk PRIMARY KEY ( id_leccion );

CREATE TABLE materia (
    id_materia      INTEGER NOT NULL,
    nombre_materia  VARCHAR(50) NOT NULL,
    id_juego        INTEGER NOT NULL
);

ALTER TABLE materia ADD CONSTRAINT materia_pk PRIMARY KEY ( id_materia );

CREATE TABLE premio (
    id_premio           INTEGER NOT NULL,
    descripcion         VARCHAR(50) NOT NULL,
    leccion_id_leccion  INTEGER NOT NULL,
    puntos_premio       INTEGER NOT NULL
);

ALTER TABLE premio ADD CONSTRAINT premiov1_pk PRIMARY KEY ( id_premio );

CREATE TABLE progreso (
    id_progreso                INTEGER NOT NULL,
    descripcion                VARCHAR(50) NOT NULL,
    resultado_ev_id_resultado  INTEGER NOT NULL
);

ALTER TABLE progreso ADD CONSTRAINT premio_pk PRIMARY KEY ( id_progreso );

CREATE TABLE resultado_ev (
    id_resultado        INTEGER NOT NULL,
    materia             VARCHAR(15) NOT NULL,
    nombre_alumno       VARCHAR(20) NOT NULL,
    puntos_resultado    INTEGER NOT NULL,
    ejercicio_id_juego  INTEGER NOT NULL
);

ALTER TABLE resultado_ev ADD CONSTRAINT resultado_ev_pk PRIMARY KEY ( id_resultado );

CREATE TABLE usuario (
    id_usuario  INTEGER NOT NULL,
    rut         VARCHAR(15) NOT NULL,
    nombre      VARCHAR(50) NOT NULL,
    apellido    VARCHAR(50) NOT NULL,
    edad        INTEGER NOT NULL,
    correo      VARCHAR(100) NOT NULL,
    rol         VARCHAR(20) NOT NULL
);

ALTER TABLE usuario ADD CONSTRAINT usuario_pk PRIMARY KEY ( id_usuario );

ALTER TABLE curso
    ADD CONSTRAINT curso_materia_fk FOREIGN KEY ( materia_id_materia )
        REFERENCES materia ( id_materia );

ALTER TABLE curso
    ADD CONSTRAINT curso_usuario_fk FOREIGN KEY ( usuario_id_usuario )
        REFERENCES usuario ( id_usuario );

ALTER TABLE ejercicio
    ADD CONSTRAINT ejercicio_leccion_fk FOREIGN KEY ( leccion_id_leccion )
        REFERENCES leccion ( id_leccion );

ALTER TABLE ejercicio
    ADD CONSTRAINT juego_usuario_fk FOREIGN KEY ( id_usuario )
        REFERENCES usuario ( id_usuario );

ALTER TABLE leccion
    ADD CONSTRAINT leccion_curso_fk FOREIGN KEY ( curso_id_curso )
        REFERENCES curso ( id_curso );

ALTER TABLE materia
    ADD CONSTRAINT materia_juego_fk FOREIGN KEY ( id_juego )
        REFERENCES ejercicio ( id_juego );

ALTER TABLE premio
    ADD CONSTRAINT premiov1_leccion_fk FOREIGN KEY ( leccion_id_leccion )
        REFERENCES leccion ( id_leccion );

ALTER TABLE progreso
    ADD CONSTRAINT progreso_resultado_ev_fk FOREIGN KEY ( resultado_ev_id_resultado )
        REFERENCES resultado_ev ( id_resultado );

ALTER TABLE resultado_ev
    ADD CONSTRAINT resultado_ev_ejercicio_fk FOREIGN KEY ( ejercicio_id_juego )
        REFERENCES ejercicio ( id_juego );

ALTER TABLE `usuario` ADD COLUMN `password` VARCHAR(255) NOT NULL;

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
