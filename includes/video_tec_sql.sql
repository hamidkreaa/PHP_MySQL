----datenbank erstellen
create database if not exists video_tec;

-- datenbank öffne
use video_tec;

create table if not exists film(
id int (3) primary key auto_increment,
titel varchar (80) not null,
jahr int (4) not null,
beschreibung text not null,
Runtime varchar (20),
bild varchar (100),
land varchar (50)
);

insert into film(titel,jahr,beschreibung,runtime,land,bild) values
('The Godfather','1972','The aging patriarch of an organize...','175 min','USA','godfather.jpg'),
('Rambo','2008','In Thailand, John Rambo joins a group of ...','92 min','France','rambo.jpg'),
('James Bond 007','2005','Experience the living world in...','N/A','England','bond1.jpg');

create table if not exists actors(
id int (3) primary key auto_increment,
vorname varchar(30) not null,
nachname varchar(30) not null
);

insert into actors(vorname,nachname) values
('Sean','Connery'),
('Natasha','Bedingfield'),
('Sylvester','Stallone'),
('Julie','Benz'),
('Marlon','Brando'),
('Al','Pacino');

create table if not exists genre(
id int (3) primary key auto_increment,
genre varchar(30) not null
);

insert into genre(genre) values
('Crime'),
('Drama'),
('Action'),
('Comedy'),
('War');

create table if not exists filmactors(
film_id int (3) not null,
actor_id int (3) not null,
primary key(film_id, actor_id)
);

insert into filmactors(film_id,actor_id) values
(1,5),(1,6),(2,3),(2,4),(3,1),(3,2);


create table if not exists filmgenre(
film_id int (3) not null,
genre_id int (3) not null,
primary key(film_id, genre_id)
);
insert into filmgenre(film_id,genre_id) values
(1,1),(1,2),(2,3),(2,5),(3,3);


select film.id, titel,genre.genre From film
 join filmgenre on film.id=filmgenre.film_id 
join genre on genre.id=filmgenre.genre_id;



create table if not exists benutzer(
id int (4) primary key auto_increment,
anrede varchar (20) not null,
vorname varchar (50) not null,
nachname varchar (60) not null,
benutzername varchar(20) not null,
passwort varchar(20) not null,
typ varchar(1) not null
);


insert into benutzer(anrede,vorname,nachname,benutzername,passwort,typ) values
('Herr','Max','Schmit','max','max','N'),
('Frau','Petra','Schultz','petra','petra','N'),
('Herr','John','Khan','john','john','N'),
('Herr.','Hamid','Kreaa','hamid','hamid','A'),
('Frau','Silke','Peterson','silke','silke','N'),
('Frau','Maria','Goldbach','maria','maria','N');


--
