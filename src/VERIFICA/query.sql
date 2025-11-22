-- Media della capienza di tutti i magazzini
SELECT AVG(M.Capienza) AS Capienza_Media_Magazzini
FROM Magazzini M

-- Numero di volte  che compare il burro nelle ricette
SELECT COUNT(*) AS Numero_Burro
FROM MateriePrime M NATURAL JOIN Ricette R
WHERE R.Tipologia = "Burro";

-- Numero di ingredienti utilizzati per ciascuon prodotto
SELECT COUNT(*) AS Numero, R.Id, P.Nome
FROM Ricette R NATURAL JOIN Prodotti P
GROUP BY R.Id;

-- La lista dei dipendenti che non sono responsabili di alcun prodotto
SELECT
FROM Dipendenti d
WHERE d.Matricola NOT IN { 
	SELECT
    FROM

-- le migliori 10 materie prime che vengono utilizzata in maggior quantità (intesa come peso totale, non numero di utilizzi)

-- il numero di prodotti contenuti in ciascun magazzino, mantenendo soltanto quelli che ne hanno più di 50

-- la lista dei prodotti che utilizzano almeno una materia rpima che non è contenuta in alcun magazzino

-- la lista dei prodotti il cui costa totale delle materie prime supera la media dei costi totali di tutti i prodotti
