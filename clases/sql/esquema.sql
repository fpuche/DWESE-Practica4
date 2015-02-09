create database bdrestaurante default
character set utf8 collate utf8_unicode_ci;

grant all on bdrestaurante.* to
root@localhost identified by 'root';

flush privileges;

create table plato (
  idplato int(11) not null auto_increment primary key,
  nombre varchar(30) not null,
  descripcion varchar(150) not null,
  precio decimal(6,2) not null
) engine=innodb charset=utf8 collate=utf8_unicode_ci;

CREATE TABLE foto (
idfoto int (11) NOT NULL auto_increment,
idplato int (11) NOT NULL,    
url varchar(200)NOT NULL,
CONSTRAINT PK_id_foto PRIMARY KEY(idfoto),
CONSTRAINT FK_id_plato FOREIGN KEY (idplato) REFERENCES plato(idplato) ON DELETE CASCADE ON UPDATE CASCADE
)

CREATE TABLE IF NOT EXISTS `usuario` (
`login` varchar(30) NOT NULL primary key,
`clave` varchar(40) NOT NULL,
`nombre` varchar(30) NOT NULL,
`apellidos` varchar(60) NOT NULL,
`email` varchar(40) NOT NULL,
`fechaalta` date NOT NULL,
`isactivo` tinyint(1) NOT NULL,
`isroot` tinyint(1) NOT NULL DEFAULT 0,
`rol` enum('administrador', 'usuario') NOT NULL DEFAULT 'usuario',
`fechalogin` datetime
) ENGINE=InnoDB;