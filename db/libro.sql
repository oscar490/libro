DROP TABLE IF EXISTS temas CASCADE;

CREATE TABLE temas
(
       id     BIGSERIAL    PRIMARY KEY
    ,  nombre VARCHAR(255) NOT NULL
);


DROP TABLE IF EXISTS libros CASCADE;

CREATE TABLE libros
(
       id       BIGSERIAL     PRIMARY KEY
    ,  titulo   VARCHAR(255)  NOT NULL
    ,  autor    VARCHAR(255)
    ,  num_pags NUMERIC(5)    DEFAULT 0
    ,  resumen  VARCHAR(255)
                              CONSTRAINT ck_num_positivos
                              CHECK (num_pags >= 0)
    ,  tema_id  BIGINT        REFERENCES temas (id)
                              ON DELETE NO ACTION
                              ON UPDATE CASCADE
);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
        id      BIGSERIAL     PRIMARY KEY
    ,   usuario VARCHAR(255)  UNIQUE
    ,   password VARCHAR(255) NOT NULL
);

INSERT INTO usuarios (usuario, password)
     VALUES ('oscar', crypt('oscar', gen_salt('bf', 10)));


INSERT INTO temas (nombre)
     VALUES ('Amor'),
            ('Drama'),
            ('Suspense'),
            ('Erótico'),
            ('Aventuras');




INSERT INTO libros (titulo, autor, num_pags, resumen, tema_id)
     VALUES ('50 sombras de grey', 'Rosalia de Castro', 200,
                'Grey, jóven multimillonario le gusta el sexo',4),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 ),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 ),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 ),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 ),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 ),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 ),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 ),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 ),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 ),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 ),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 ),
            ('El niño del pijama de rayas', 'Cristian Pérez', 200,
                'Historia de nazis y un niño...', 2),
            ('La venganza de los museilines','Álvaro Roco', 300,
                'Aventura sobre un secuestro..', 5 );
