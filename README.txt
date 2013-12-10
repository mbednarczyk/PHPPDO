U¿ywany serwer bazy danych: MySQL
W pliku config_mysql.php podajemy dane po³¹czeniowe do bazy.



Potrzebne tabele:
CREATE TABLE kat(
  id_kat INTEGER PRIMARY KEY AUTO_INCREMENT,
  nazwa VARCHAR(50) NOT NULL,
  id_nadkat INTEGER references kat(id_kat)
);



CREATE TABLE zad(
  id_zad INTEGER PRIMARY KEY AUTO_INCREMENT,
  id_kat INTEGER NOT NULL,
  nazwa VARCHAR(50) NOT NULL,
  plik_pdf VARCHAR(50) NOT NULL,
  trudnosc INTEGER NOT NULL
);



CREATE TABLE user(
  id_user INTEGER PRIMARY KEY AUTO_INCREMENT,
  login VARCHAR(20) NOT NULL,
  haslo VARCHAR(20) NOT NULL,
);


Przyk³adowe rekordy userów:

INSERT INTO user(login, haslo)
VALUES ('zenek',  'zenek123');





