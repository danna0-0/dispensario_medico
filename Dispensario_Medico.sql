create database Dispensario_Medico; 
use Dispensario_Medico; 
CREATE TABLE registro (
    id_doctor INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(30), 
    apellidos VARCHAR(30),
    usuario VARCHAR(50) NOT NULL,
    clave VARCHAR(100) NOT NULL
);

CREATE TABLE pacientes (
    id_pacientes INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellidos VARCHAR(50),
    fecha_nacimiento DATE, 
    peso INT, 
    tipoRH VARCHAR(100),
    alergias VARCHAR(200),
    P_A INT  
);

CREATE TABLE diagnostico (
    id_diag INT AUTO_INCREMENT PRIMARY KEY, 
    diagnostico VARCHAR(500),
    tratamiento VARCHAR(500), 
    valoracion_medica VARCHAR(500),
    fecha DATETIME,
    id_pacientes INT,
    FOREIGN KEY (id_pacientes) REFERENCES pacientes(id_pacientes)
);

CREATE TABLE emergencia (
    id_emer INT AUTO_INCREMENT PRIMARY KEY, 
    tipo_emergencia VARCHAR(500), 
    traslado VARCHAR(100),
    id_pacientes INT,
    FOREIGN KEY (id_pacientes) REFERENCES pacientes(id_pacientes)
);

ALTER TABLE `dispensario_medico`.`registro` 
ADD COLUMN `email` VARCHAR(100) NULL AFTER `clave`;