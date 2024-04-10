---- inserts jugadores
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (1,'Beto Arango',null,'actor , 58');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Camilo Diaz(Culotauro)',null,'comediante,26');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Diana Angel',null,'actriz y cantante');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Eduardo Ferrer',null,'Influencer');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Isabella Santiago',null,'Actriz y exreina de belleza ');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Isabella Sierra',null,'Actriz, cantante y bailarina ');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'José Rodríguez Medina',null,'Cantante, actor y bailarín ');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Juan David Zapata',null,'Deportista');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Julián Trujillo ',null,'Actor');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Karen Sevillano',null,'Influencer');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Kevin Fuentes',null,'Modelo, deportista y experto en realities ');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Mafe Walker',null,'Influencer');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Martha Isabel Bolaños',null,'Actriz y experta en realities');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Miguel Melfi',null,'Cantante');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Natalia Segura',null,'Influencer');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Nataly Umaña',null,'Actriz');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Omar Murillo',null,'Actor y humorista');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Sandra Muñoz',null,'Actriz y experta en realities');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Sebastián Gutiérrez',null,'Actor');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Johana Velandia',null,'Comediante');
INSERT INTO `jugador`(`id`, `nombre`, `imagen`, `descripcion`) VALUES (null,'Naren Daryanani',null,'Actor');
--- inserts posiciones o ranking
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,1);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,2);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,3);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,4);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,5);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,6);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,7);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,8);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,9);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,10);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,11);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,12);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,13);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,14);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,15);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,16);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,17);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,18);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,19);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,20);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,21);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,22);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,23);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,24);
INSERT INTO `ranking`(`id`, `posicion`) VALUES (null,25);

-- updates de imagenes
UPDATE `jugador` SET `imagen`= LOAD_FILE('D:\proyectoPrediccionRealities\php-sql-login-master\img\isabella-sierra-.jpg') 
 WHERE id = 1;
---- consultas para llenar tabla de puntaje para prediccion
SELECT p.id_jugador,j.nombre,p.id_ranking, re.id_jugador FROM `prediccion`p , jugador j, resultado_evento re 
where p.id_usuario = 5 and j.id = p.id_jugador and re.id_ranking (+)= p.id_ranking;

SELECT p.id_jugador,j.nombre,p.id_ranking, IFNULL(re.id_jugador,0) AS re.id_jugador FROM  jugador j, `prediccion`p left join resultado_evento re on  p.id_ranking = re.id_ranking 
where p.id_usuario = 5 and j.id = p.id_jugador;

SELECT p.id_jugador,j.nombre,p.id_ranking, IFNULL(re.id_jugador,0) AS re_id_jugador FROM jugador j, `prediccion`p left join resultado_evento re on
 p.id_ranking = re.id_ranking where p.id_usuario = 5 and j.id = p.id_jugador; 

SELECT p.id_jugador,j.nombre,p.id_ranking, CASE WHEN re.id_jugador is null THEN 0 ELSE 1 END FROM jugador j, `prediccion`p 
left join resultado_evento re on p.id_ranking = re.id_ranking where p.id_usuario = 5 and j.id = p.id_jugador; 

----- consulta para mostrar las predicciones de TODOS LOS JUGADORES
SELECT p.id_usuario, u.nombre,sum(CASE WHEN re.id_jugador is null THEN 0 ELSE 1 END) from jugador j, usuario u,
 `prediccion`p left join resultado_evento re on p.id_ranking = re.id_ranking where j.id = p.id_jugador 
 and u.id = p.id_usuario GROUP by p.id_usuario; 

 SELECT p.id_usuario, u.nombre,sum(CASE WHEN re.id_jugador is null THEN 0 ELSE 1 END) from 
 jugador j, usuario u, `prediccion`p left join resultado_evento re on p.id_ranking = re.id_ranking
  where j.id = p.id_jugador and u.id = p.id_usuario GROUP by p.id_usuario order by 3 desc; 



ALTER TABLE jugador
ADD CONSTRAINT FK_jugadorReality
FOREIGN KEY (id_reality) REFERENCES reality(id); 

----- inserts para torneo de candidatos jugadores
INSERT INTO `jugador` (`id`, `nombre`, `imagen`, `descripcion`, `activo`, `id_reality`)
 VALUES (NULL, 'R Praggnanandhaa', NULL, '', '1', '3');
INSERT INTO `jugador` (`id`, `nombre`, `imagen`, `descripcion`, `activo`, `id_reality`)
 VALUES (NULL, 'Fabiano Caruana', NULL, '', '1', '3');
 INSERT INTO `jugador` (`id`, `nombre`, `imagen`, `descripcion`, `activo`, `id_reality`)
 VALUES (NULL, 'Nijat Abasov', NULL, '', '1', '3');
 INSERT INTO `jugador` (`id`, `nombre`, `imagen`, `descripcion`, `activo`, `id_reality`)
 VALUES (NULL, 'Vidit Gujrathi', NULL, '', '1', '3');
 INSERT INTO `jugador` (`id`, `nombre`, `imagen`, `descripcion`, `activo`, `id_reality`)
 VALUES (NULL, 'Hikaru Nakamura', NULL, '', '1', '3');
 INSERT INTO `jugador` (`id`, `nombre`, `imagen`, `descripcion`, `activo`, `id_reality`)
 VALUES (NULL, 'Gukesh D', NULL, '', '1', '3');
 INSERT INTO `jugador` (`id`, `nombre`, `imagen`, `descripcion`, `activo`, `id_reality`)
 VALUES (NULL, 'Alireza Firouzja', NULL, '', '1', '3');
--- para ranking
INSERT INTO `ranking` (`id`, `posicion`, `id_reality`) VALUES (NULL, '2', '3');
INSERT INTO `ranking` (`id`, `posicion`, `id_reality`) VALUES (NULL, '3', '3');
INSERT INTO `ranking` (`id`, `posicion`, `id_reality`) VALUES (NULL, '4', '3');
INSERT INTO `ranking` (`id`, `posicion`, `id_reality`) VALUES (NULL, '5', '3');
INSERT INTO `ranking` (`id`, `posicion`, `id_reality`) VALUES (NULL, '6', '3');
INSERT INTO `ranking` (`id`, `posicion`, `id_reality`) VALUES (NULL, '7', '3');
INSERT INTO `ranking` (`id`, `posicion`, `id_reality`) VALUES (NULL, '8', '3');
