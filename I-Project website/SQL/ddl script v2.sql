DROP DATABASE EenmaalAndermaal

create database EenmaalAndermaal;

use EenmaalAndermaal;
-------------------------------Tabel Vraag----------------------------------


create table Vraag(
vraagnummer int primary key not null IDENTITY(1,1),
tekst_vraag varchar(100) not null
)


create table Gebruiker(
gebruikersnaam varchar(100) not null,
voornaam varchar(100) not null,
achternaam varchar(100) not null,
adresregel1 varchar(100) not null,
adresregel2 varchar(100),
postcode varchar(10) not null,
plaatsnaam varchar(100) not null,
landnaam varchar (100) not null default('Nederland'),
antwoordtekst varchar(100)not null,
geboorteDag date not null,
mailbox varchar(100)not null,
wachtwoord varchar(100) not null,
vraag int not null,
verkoper bit not null default 0,
CONSTRAINT FK_vraag FOREIGN KEY (vraag) REFERENCES Vraag(vraagnummer),
CONSTRAINT PK_Gebruikeranaam PRIMARY KEY (Gebruikersnaam),
CONSTRAINT CK_Geboortedag CHECK (Geboortedag < CURRENT_TIMESTAMP),
CONSTRAINT CK_EMailValid CHECK (Mailbox like '%@%.%'),
CONSTRAINT CK_PWLenght CHECK (len(wachtwoord) > 6)
)

-------------------------------Tabel Gebruikerstelefoon----------------------------------

create table Gebruikerstelefoon(
gebruikersnaam varchar(100) not null,
telefoon char(11) not null,
volgnr int not null IDENTITY(1,1),
CONSTRAINT FK_Gebruiker FOREIGN KEY (Gebruikersnaam) REFERENCES Gebruiker(gebruikersnaam),
CONSTRAINT PK_telefoon_Gebruikeranaam PRIMARY KEY (Gebruikersnaam, volgnr)
)

-------------------------------Tabel Verkoper----------------------------------


create table Verkoper(
gebruiker varchar(100) not null,
bank varchar(15),
bankrekening varchar(34),
controleoptie char(10) not null,
creditcard char(19),
CONSTRAINT FK_Gebruiker_verkoper FOREIGN KEY (Gebruiker) REFERENCES Gebruiker(gebruikersnaam),
CONSTRAINT PK_Gebruiker PRIMARY KEY (Gebruiker),
CONSTRAINT CHK_Controleoptie CHECK (Controle_optie in('Creditcard','Post'))
)
-------------------------------Tabel Voorwerp----------------------------------

create table Voorwerp(
voorwerpnummer numeric(10) not null ,
titel varchar(100) not null,
beschrijving varchar(7001) not null,
startprijs int not null,
betalingswijze varchar(10) not null default('bank'),	
betalingsinstructie varchar(100),
plaatsnaam varchar(100) not null,
land varchar(100) not null default('Nederland'),
looptijd int not null default(5),
looptijdBegindag date not null,
looptijdBeginTijdstip TIME not null,
verzendkosten numeric(3,1),
verzendinstructie varchar(40),
verkoper varchar(100) not null,
koper varchar(100),
looptijdeindeDag date not null,
looptijdeindeTijdstip time not null,
veilingGesloten  bit not null default(0),
verkoopprijs numeric(5,2),
CONSTRAINT FK_Voorwerp_verkoper FOREIGN KEY (verkoper) REFERENCES verkoper(gebruiker),
CONSTRAINT FK_koper FOREIGN KEY (koper) REFERENCES Gebruiker(gebruikersnaam),
CONSTRAINT PK_voorwerpnummer PRIMARY KEY (voorwerpnummer),
constraint CH_BetalingsWijze check(Betalingswijze in('Bank', 'Acceptgiro')),
CONSTRAINT CH_StartprijsPositief check (Startprijs > 0)
)

-------------------------------Tabel Rubriek----------------------------------

create table Rubriek(
rubrieknummer int not null primary key,
rubrieknaam varchar(100) not null, 
rubriek int,
volgnr int not null IDENTITY(1,1),
CONSTRAINT FK_rubriek FOREIGN KEY (Rubriek) REFERENCES Rubriek(rubrieknummer),
) 

-------------------------------Tabel Rubriek----------------------------------

create table Voorwerp_in_Rubriek(
rubriekOpLaagsteNiveau int,
voorwerpnummer numeric(10),
CONSTRAINT PK_Voorwerp_in_Rubriek PRIMARY KEY (voorwerpnummer,Rubriek_op_Laagste_Niveau),
constraint FK_Rubriek_op_Laagste_Niveau foreign key(Rubriek_op_Laagste_Niveau) references Rubriek(rubrieknummer),
constraint FK_voorwerpnummer foreign key(voorwerpnummer) references Voorwerp(voorwerpnummer)
);

-------------------------------Tabel Bestand----------------------------------

create table Bestand(
filenaam char(13) not null,
voorwerp numeric(10) not null,
CONSTRAINT PK_filenaam PRIMARY KEY (filenaam),
constraint FK_Voorwerp foreign key(Voorwerp) references Voorwerp(voorwerpnummer)
);


-------------------------------Tabel Bod----------------------------------

create table Bod(
bodbedrag int not null,
bodDag date not null,
gebruiker varchar(100) not null,
bodTijdstip time not null,
voorwerp numeric(10) not null,
CONSTRAINT PK_euro_Voorwep PRIMARY KEY (Voorwerp,Bodbedrag),
constraint FK_Voorwerp_Bod foreign key(Voorwerp) references Voorwerp(voorwerpnummer),
CONSTRAINT FK_Bod_Gebruiker FOREIGN KEY (Gebruiker) REFERENCES Gebruiker(gebruikersnaam),
);


-------------------------------Tabel Feedback----------------------------------
create table Feedback(
voorwerp numeric(10) not null,
soortGebruiker char(8) not null,
feedbackSoort char(8) not null,
dag date not null,
tijdstip time not null,
commentaar varchar(100),
CONSTRAINT PK_Feedback PRIMARY KEY (Voorwerp,Soort_Gebruiker),
constraint FK_Feedback foreign key(Voorwerp) references Voorwerp(voorwerpnummer),
CONSTRAINT CHK_Feedback_Soort_Gebruiker CHECK (Soort_Gebruiker in('Koper','Verkoper')),
CONSTRAINT CHK_Feedback_Soort CHECK (Feedbacksoort in('negatief','neutraal','positief'))
)




 use EenmaalAndermaal


 --------------------insert een vraag-----------------
insert into Vraag(tekst_vraag) values('uw favorite huisdier');
select * from Vraag

----------Insert een gebruiker---------------------
insert into Gebruiker(Gebruikersnaam,voornaam,achternaam,adresregel1,postcode,
plaatsnaam,landnaam ,antwoordtekst ,GeboorteDag,Mailbox ,wachtwoord ,vraag,Verkoper) 
values ('Mahmoud93','Mahmoud','Fares','kerkstraat 9','6953bk','Dieren','Nederland','kat','01-01-1993','Mahmut.faris1993@gmail.com','masfabdsbgmnbfm',1,1);

--------------------------insert een verkoper------------------

insert into Verkoper (gebruiker,bank,bankrekening,Controle_optie,creditcard) values('Mahmoud93','ing','adsnbfmansdbvmasd','Post','asnfvknafdbmndsgm,');
-----------------------insert veling---------------------------

insert into Voorwerp(voorwerpnummer,title,beschrijving,Startprijs,Betalingswijze,betalingsinstructie,plaatsnaam,land,looptijd,looptijdbegindag,
looptijdbeginTijdstip,verkoper,looptijdeindeDag,looptijdeindetijdstip) 
values(12345,'Audi A4','Heel Mooie auto',150,'Bank','so snel mogelijk','Arnhem','Nederland',5,CONVERT (date, GETDATE()),CONVERT (time, GETDATE()),'Mahmoud93',
DATEADD(DAY, 5, CONVERT (date, GETDATE())),CONVERT (time, GETDATE()));


insert into Voorwerp(voorwerpnummer,title,beschrijving,Startprijs,Betalingswijze,betalingsinstructie,plaatsnaam,land,looptijd,looptijdbegindag,
looptijdbeginTijdstip,verkoper,looptijdeindeDag,looptijdeindetijdstip) 
values(7895,'Wasmachine','Een goede wasmachine',500,'Bank','so snel mogelijk','Arnhem','Nederland',5,CONVERT (date, GETDATE()),CONVERT (time, GETDATE()),'Mahmoud93',
DATEADD(DAY, 5, CONVERT (date, GETDATE())),CONVERT (time, GETDATE()));


insert into Voorwerp(voorwerpnummer,title,beschrijving,Startprijs,Betalingswijze,betalingsinstructie,plaatsnaam,land,looptijd,looptijdbegindag,
looptijdbeginTijdstip,verkoper,looptijdeindeDag,looptijdeindetijdstip) 
values(8866,'TV','Heel Mooie TV',550,'Bank','so snel mogelijk','Arnhem','Nederland',5,CONVERT (date, GETDATE()),CONVERT (time, GETDATE()),'Mahmoud93',
DATEADD(DAY, 5, CONVERT (date, GETDATE())),CONVERT (time, GETDATE()));



insert into Voorwerp(voorwerpnummer,title,beschrijving,Startprijs,Betalingswijze,betalingsinstructie,plaatsnaam,land,looptijd,looptijdbegindag,
looptijdbeginTijdstip,verkoper,looptijdeindeDag,looptijdeindetijdstip) 
values(46545,'Printer','Heel Mooie Printer',780,'Bank','so snel mogelijk','Arnhem','Nederland',7,CONVERT (date, GETDATE()),CONVERT (time, GETDATE()),'Mahmoud93',
DATEADD(DAY, 7, CONVERT (date, GETDATE())),CONVERT (time, GETDATE()));



insert into Voorwerp(voorwerpnummer,title,beschrijving,Startprijs,Betalingswijze,betalingsinstructie,plaatsnaam,land,looptijd,looptijdbegindag,
looptijdbeginTijdstip,verkoper,looptijdeindeDag,looptijdeindetijdstip) 
values(54654654,'Zonnebril','Heel Mooie Zonnebril',2,'Bank','so snel mogelijk','Arnhem','Nederland',9,CONVERT (date, GETDATE()),CONVERT (time, GETDATE()),'Mahmoud93',
DATEADD(DAY, 9, CONVERT (date, GETDATE())),CONVERT (time, GETDATE()));



insert into Voorwerp(voorwerpnummer,title,beschrijving,Startprijs,Betalingswijze,betalingsinstructie,plaatsnaam,land,looptijd,looptijdbegindag,
looptijdbeginTijdstip,verkoper,looptijdeindeDag,looptijdeindetijdstip) 
values(12347,'Audi A4','Heel Mooie auto',150,'Bank','so snel mogelijk','Arnhem','Nederland',5,CONVERT (date, GETDATE()),CONVERT (time, GETDATE()),'Mahmoud93',
DATEADD(DAY, 5, CONVERT (date, GETDATE())),CONVERT (time, GETDATE()));




insert into Voorwerp(voorwerpnummer,title,beschrijving,Startprijs,Betalingswijze,betalingsinstructie,plaatsnaam,land,looptijd,looptijdbegindag,
looptijdbeginTijdstip,verkoper,looptijdeindeDag,looptijdeindetijdstip) 
values(146345,'Audi A4','Heel Mooie auto',150,'Bank','so snel mogelijk','Arnhem','Nederland',5,CONVERT (date, GETDATE()),CONVERT (time, GETDATE()),'Mahmoud93',
DATEADD(DAY, 5, CONVERT (date, GETDATE())),CONVERT (time, GETDATE()));



insert into Voorwerp(voorwerpnummer,title,beschrijving,Startprijs,Betalingswijze,betalingsinstructie,plaatsnaam,land,looptijd,looptijdbegindag,
looptijdbeginTijdstip,verkoper,looptijdeindeDag,looptijdeindetijdstip) 
values(12545,'Audi A4','Heel Mooie auto',150,'Bank','so snel mogelijk','Arnhem','Nederland',5,CONVERT (date, GETDATE()),CONVERT (time, GETDATE()),'Mahmoud93',
DATEADD(DAY, 5, CONVERT (date, GETDATE())),CONVERT (time, GETDATE()));



insert into Voorwerp(voorwerpnummer,title,beschrijving,Startprijs,Betalingswijze,betalingsinstructie,plaatsnaam,land,looptijd,looptijdbegindag,
looptijdbeginTijdstip,verkoper,looptijdeindeDag,looptijdeindetijdstip) 
values(24345,'Audi A4','Heel Mooie auto',150,'Bank','so snel mogelijk','Arnhem','Nederland',5,CONVERT (date, GETDATE()),CONVERT (time, GETDATE()),'Mahmoud93',
DATEADD(DAY, 5, CONVERT (date, GETDATE())),CONVERT (time, GETDATE()));



/**
select * from Vraag
select * from Gebruiker
select * from Verkoper
select * from Voorwerp
select * from Voorwerp v join Gebruiker G on  G.Gebruikersnaam = v.verkoper order by V.looptijdbegindag
**/











