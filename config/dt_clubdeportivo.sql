create database dt_club_deportivo
USE clubdeportivo

CREATE TABLE usuarios (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(50) NOT NULL,
  Email VARCHAR(75) NOT NULL UNIQUE,
  Clave VARCHAR(75) NOT NULL,
  Rol ENUM('socio', 'admin') NOT NULL
);

CREATE TABLE socios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Numero_socio INT NOT NULL UNIQUE,
    Telefono INT NOT NULL,
    Direccion VARCHAR(75) NOT NULL,
    fecha_ingreso DATE NOT NULL,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(ID)
);


CREATE TABLE Membresias (
ID INT AUTO_INCREMENT PRIMARY KEY,
Nombre_membresia VARCHAR(50) NOT NULL,
Precio DECIMAL(8,2) NOT NULL,
Descripcion VARCHAR(5000)
);

USE clubdeportivo

CREATE TABLE Pagos (
ID INT AUTO_INCREMENT PRIMARY KEY,
Fecha_pago DATE NOT NULL,
Monto DECIMAL(8,2) NOT NULL,
Estado ENUM('pendiente', 'pagado', 'cancelado') NOT NULL,
id_socio INT NOT NULL,
id_membresia INT NOT NULL,
FOREIGN KEY (id_socio) REFERENCES socios(ID),
FOREIGN KEY (id_membresia) REFERENCES Membresias (ID)
);

CREATE TABLE Instalaciones( 
ID INT AUTO_INCREMENT PRIMARY KEY,
Nombre VARCHAR(50) NOT NULL,
Descripcion VARCHAR(5000) NOT NULL,
Capacidad INT NOT NULL
);

CREATE TABLE Reservas (
ID INT AUTO_INCREMENT PRIMARY KEY,
Fecha_reserva DATE NOT NULL,
Hora_inicio TIME NOT NULL,
Hora_fin TIME NOT NULL,
id_socio INT NOT NULL,
id_instalacion INT NOT NULL,
FOREIGN KEY (id_socio) REFERENCES Socios(ID),
FOREIGN KEY (id_instalacion) REFERENCES Instalaciones(ID)
);

CREATE TABLE Eventos (
ID INT AUTO_INCREMENT PRIMARY KEY,
Nombre VARCHAR(50) NOT NULL,
Descripcion VARCHAR(5000) NOT NULL,
Fecha_evento DATE NOT NULL,
Lugar VARCHAR(100) NOT NULL
);

CREATE TABLE Inscripciones_evento(
ID INT AUTO_INCREMENT PRIMARY KEY,
Fecha_inscripcion DATE NOT NULL,
id_evento INT NOT NULL,
id_socio INT NOT NULL,
FOREIGN KEY (id_evento) REFERENCES Eventos (ID),
FOREIGN KEY (id_socio) REFERENCES Socios (ID)
);

CREATE TABLE configuracion (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  Nombre_club VARCHAR(100),
  Moneda VARCHAR(10),
  Horario VARCHAR(50)
);

ALTER TABLE configuracion ADD COLUMN Logo VARCHAR(255);

ALTER TABLE usuarios 
ADD COLUMN reset_token VARCHAR(255) NULL,
ADD COLUMN reset_expira DATETIME NULL;
