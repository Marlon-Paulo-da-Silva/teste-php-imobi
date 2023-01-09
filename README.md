# imobibrasil

CONFORME O TESTE SEGUE O PROJETINHO FEITO EM FULL PHP com o auxílio do Bootstrap 5

##SCRIPTS DO BANCO UTILIZADO

#create database imobibrasil;

#use imobibrasil;

#create table imoveis( id int primary key not null auto_increment, title varchar(100), name varchar(150) not null, email varchar(150) not null, description varchar(100), fullAddress varchar(350), price double(10,2), createdAt datetime, ativo bool );

#create table medias( id int primary key not null auto_increment, idImovel int,
imageName varchar(100), localImage varchar(200), createdAt datetime, foreign key(idImovel) references imoveis(id) )
