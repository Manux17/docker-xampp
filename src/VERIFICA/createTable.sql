-- Tabella Magazzini
CREATE TABLE Magazzini (
    Codice INT PRIMARY KEY,
    Capienza INT,
    Indirizzo VARCHAR(100)
);

-- Tabella Dipendenti
CREATE TABLE Dipendenti (
    Matricola INT PRIMARY KEY,
    CF CHAR(16) NOT NULL,
    Nome VARCHAR(50),
    Cognome VARCHAR(50),
    Indirizzo VARCHAR(100)
);

-- Tabella MateriePrime
CREATE TABLE MateriePrime (
    Tipologia INT PRIMARY KEY,
    CostoUnitario DECIMAL(10,2),
    PesoUnitario DECIMAL(10,2),
    Codice INT,
    FOREIGN KEY (Codice) REFERENCES Magazzini(Codice)
);

-- Tabella Prodotti
CREATE TABLE Prodotti (
    Id INT PRIMARY KEY,
    Codice INT,
    Matricola INT,
    Descrizione VARCHAR(100),
    Nome VARCHAR(50),
    FOREIGN KEY (Codice) REFERENCES Magazzini(Codice),
    FOREIGN KEY (Matricola) REFERENCES Dipendenti(Matricola)
);

-- Tabella Ricette (tabella di relazione molti-a-molti tra MateriePrime e Prodotti)
CREATE TABLE Ricette (
    Tipologia INT,
    Id INT,
    Qta DECIMAL(10,2),
    PRIMARY KEY (Tipologia, Id),
    FOREIGN KEY (Tipologia) REFERENCES MateriePrime(Tipologia),
    FOREIGN KEY (Id) REFERENCES Prodotti(Id)
);