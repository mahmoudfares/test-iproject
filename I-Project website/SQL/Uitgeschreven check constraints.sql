

CREATE TABLE Users
( 
  Username VARCHAR(200),
  Postalcode VARCHAR(9),
  Location VARCHAR(MAX),
  Country VARCHAR(100),
  Rating NUMERIC(4,1),

  -- postcode < 11 tekens
  --??Nodig??
  -- username mooet unique zijn
  CONSTRAINT CK_UsernameUnique UNIQUE (Username),
  -- rating tussen 0 en 100
  CONSTRAINT CK_RatingValid CHECK (Rating > 0 AND Rating < 100)
)

CREATE TABLE Categorieen
(
	ID int NOT NULL,
	Name varchar(100) NULL,
	Parent int NULL,
	CONSTRAINT PK_Categorieen PRIMARY KEY (ID)
)


CREATE TABLE Items
(
	ID bigint NOT NULL,
	Titel varchar(max) NULL,
	Beschrijving nvarchar(max) NULL,
	Categorie int NULL,
	Postcode varchar(10) NULL,
	Locatie varchar(max) NULL,
	Land varchar(max) NULL,
	Verkoper varchar(200) NULL,
	Prijs varchar(max) NULL,
	Valuta varchar(max) NULL,
	Conditie varchar(max) NULL,
	Thumbnail varchar(max) NULL,
	CONSTRAINT PK_Items PRIMARY KEY (ID),
	-- Categorie moet uit tabel Categorieen komen
	CONSTRAINT FK_Items_In_Categorie FOREIGN KEY (Categorie) REFERENCES Categorieen (ID),
	-- Verkoper moet in user register staan
	CONSTRAINT FK_Verkoper FOREIGN KEY (Verkoper) REFERENCES Users(Username),
	-- prijs moet hoger zijn dan 0
	CONSTRAINT CK_PRIJS CHECK (PRIJS > 0),
	-- valuta moet een . bevatten en mag max 2 characters na de . hebben
	CONSTRAINT CK_ValutaDot CHECK (Valuta LIKE '%.__')
	)

CREATE TABLE Illustraties
(
	ItemID bigint NOT NULL,
	IllustratieFile varchar(100) NOT NULL,
    CONSTRAINT PK_ItemPlaatjes PRIMARY KEY (ItemID, IllustratieFile),
	CONSTRAINT [ItemsVoorPlaatje] FOREIGN KEY(ItemID) REFERENCES Items (ID)
)

-- voor tble tblIMAOLand
-- heeft al check constraints

--voor table gebruiker
-- gebruikers naam moet uniek zijn
-- postcode korter dan 11 tekens
-- geboortedag voor dag van maken
-- mailbox moet een @ en . bevatten en minimaal 2 en maximaal 3 tekens achter de punt hebben. 
-- wachtwoord moet langer dan 6 karakters zijn

ALTER TABLE Gebruiker
	ADD CONSTRAINT CK_GebruikersnaamUnique UNIQUE,
	CONSTRAINT CK_GeboorteDag CHECK (GeboorteDag < CURRENT_TIMESTAMP),
	CONSTRAINT CK_EMailValid CHECK (Mailbox like '%@%.%'),
	CONSTRAINT CK_PWLenght CHECK (len(wachtwoord) > 6);




CREATE INDEX IX_Items_Categorie ON Items (Categorie)
CREATE INDEX IX_Categorieen_Parent ON Categorieen (Parent)
