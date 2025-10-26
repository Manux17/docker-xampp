CREATE TABLE Autostrada (
    codice_autostradale VARCHAR(100),
    nome VARCHAR(500) NOT NULL,
    lunghezza INT NOT NULL,
    PRIMARY KEY (codice_autostradale)
);

CREATE TABLE Casello (
    codice_casello VARCHAR(100),
    codice_autostradale VARCHAR(100) NOT NULL,
    nome VARCHAR(500) NOT NULL,
    stato VARCHAR(200) NOT NULL,
    km_autostradale INT NOT NULL,
    PRIMARY KEY (codice_casello),
    FOREIGN KEY (codice_autostradale) REFERENCES Autostrada(codice_autostradale)
);

CREATE TABLE Utente (
    cf CHAR(160),
    nome VARCHAR(300) NOT NULL,
    cognome VARCHAR(300) NOT NULL,
    citta VARCHAR(300) NOT NULL,
    cap CHAR(5) NOT NULL,
    indirizzo VARCHAR(100) NOT NULL,
    n_carta VARCHAR(20),
    n_contocorrente VARCHAR(20),
    PRIMARY KEY (cf)
);

CREATE TABLE Telepass (
    codice_telepass VARCHAR(15),
    cf CHAR(16) NOT NULL,
    versione VARCHAR(20) NOT NULL,
    modello VARCHAR(20) NOT NULL,
    PRIMARY KEY (codice_telepass),
    FOREIGN KEY (cf) REFERENCES Utente(cf)
);

CREATE TABLE Veicolo (
    targa VARCHAR(10),
    codice_telepass VARCHAR(15) NOT NULL,
    classe VARCHAR(20) NOT NULL,
    tipo VARCHAR(15) NOT NULL, -- auto, moto, furgone, camion
    PRIMARY KEY (targa),
    FOREIGN KEY (codice_telepass) REFERENCES Telepass(codice_telepass)
);

CREATE TABLE Auto (
    targa VARCHAR(10),
    max_passeggeri INT NOT NULL,
    cilindrata INT NOT NULL,
    potenza INT NOT NULL,
    PRIMARY KEY (targa),
    FOREIGN KEY (targa) REFERENCES Veicolo(targa)
);

CREATE TABLE Moto (
    targa VARCHAR(10),
    potenza INT NOT NULL,
    cilindrata INT NOT NULL,
    PRIMARY KEY (targa),
    FOREIGN KEY (targa) REFERENCES Veicolo(targa)
);

CREATE TABLE Furgone (
    targa VARCHAR(10),
    lunghezza INT NOT NULL,
    peso_a_vuoto INT NOT NULL,
    PRIMARY KEY (targa),
    FOREIGN KEY (targa) REFERENCES Veicolo(targa)
);

CREATE TABLE Camion (
    targa VARCHAR(10),
    lunghezza INT NOT NULL,
    peso_a_vuoto INT NOT NULL,
    capienza INT NOT NULL,
    PRIMARY KEY (targa),
    FOREIGN KEY (targa) REFERENCES Veicolo(targa)
);

CREATE TABLE Passaggio (
    codice_telepass VARCHAR(15),
    data_ora TIMESTAMP,
    codice_casello VARCHAR(10),
    targa VARCHAR(10),
    PRIMARY KEY (codice_telepass, data_ora),
    FOREIGN KEY (codice_telepass) REFERENCES Telepass(codice_telepass),
    FOREIGN KEY (codice_casello) REFERENCES Casello(codice_casello),
    FOREIGN KEY (targa) REFERENCES Veicolo(targa)
);

CREATE TABLE Entrata (
    codice_telepass VARCHAR(15),
    data_ora TIMESTAMP,
    PRIMARY KEY (codice_telepass, data_ora),
    FOREIGN KEY (codice_telepass, data_ora) REFERENCES Passaggio(codice_telepass, data_ora)
);

CREATE TABLE Uscita (
    codice_telepass VARCHAR(15),
    data_ora TIMESTAMP,
    costo_pedaggio FLOAT,
    PRIMARY KEY (codice_telepass, data_ora),
    FOREIGN KEY (codice_telepass, data_ora) REFERENCES Passaggio(codice_telepass, data_ora)
);
