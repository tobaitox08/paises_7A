-- ============================================================
-- Base de datos: Paises_7A
-- Tablas: paises, provincias
-- ============================================================

CREATE DATABASE IF NOT EXISTS `Paises_7A`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `Paises_7A`;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS provincias;
DROP TABLE IF EXISTS paises;

CREATE TABLE paises (
  pais_id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  pais_descripcion VARCHAR(50)  NOT NULL,
  PRIMARY KEY (pais_id)
) ENGINE=InnoDB;

CREATE TABLE provincias (
  pro_id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  pais_id         INT UNSIGNED NOT NULL,
  pro_descripcion VARCHAR(50)  NOT NULL,
  PRIMARY KEY (pro_id),
  CONSTRAINT fk_provincias_pais
    FOREIGN KEY (pais_id) REFERENCES paises (pais_id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------- Países de Latinoamérica ----------
INSERT INTO paises (pais_id, pais_descripcion) VALUES
  (1,  'Argentina'),
  (2,  'Bolivia'),
  (3,  'Brasil'),
  (4,  'Chile'),
  (5,  'Colombia'),
  (6,  'Costa Rica'),
  (7,  'Cuba'),
  (8,  'Ecuador'),
  (9,  'El Salvador'),
  (10, 'Guatemala'),
  (11, 'Haití'),
  (12, 'Honduras'),
  (13, 'México'),
  (14, 'Nicaragua'),
  (15, 'Panamá'),
  (16, 'Paraguay'),
  (17, 'Perú'),
  (18, 'República Dominicana'),
  (19, 'Uruguay'),
  (20, 'Venezuela');

-- ---------- Provincias de Argentina (pais_id = 1) ----------
INSERT INTO provincias (pais_id, pro_descripcion) VALUES
  (1, 'Buenos Aires'),
  (1, 'Catamarca'),
  (1, 'Chaco'),
  (1, 'Chubut'),
  (1, 'Córdoba'),
  (1, 'Corrientes'),
  (1, 'Entre Ríos'),
  (1, 'Formosa'),
  (1, 'Jujuy'),
  (1, 'La Pampa'),
  (1, 'La Rioja'),
  (1, 'Mendoza'),
  (1, 'Misiones'),
  (1, 'Neuquén'),
  (1, 'Río Negro'),
  (1, 'Salta'),
  (1, 'San Juan'),
  (1, 'San Luis'),
  (1, 'Santa Cruz'),
  (1, 'Santa Fe'),
  (1, 'Santiago del Estero'),
  (1, 'Tierra del Fuego'),
  (1, 'Tucumán'),
  (1, 'Ciudad Autónoma de Buenos Aires');
