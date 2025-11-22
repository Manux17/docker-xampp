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
SELECT *
FROM Dipendenti d
WHERE d.Matricola NOT IN (
    SELECT p.Matricola
    FROM Prodotti p
    WHERE p.Matricola
);

-- le migliori 10 materie prime che vengono utilizzata in maggior quantità (intesa come peso totale, non numero di utilizzi)
SELECT R.Tipologia, SUM(M.PesoUnitario*R.Qta) as Somma_Totale
FROM MateriePrime M NATURAL JOIN Ricette R
GROUP BY M.Tipologia
ORDER BY Somma_Totale DESC
LIMIT 10

-- il numero di prodotti contenuti in ciascun magazzino, mantenendo soltanto quelli che ne hanno più di 50
SELECT P.Codice, COUNT(*) AS Numero_Magazzino
FROM Prodotti P
GROUP BY P.Codice
HAVING Numero_Magazzino > 50


-- la lista dei prodotti che utilizzano almeno una materia rpima che non è contenuta in alcun magazzino

-- la lista dei prodotti il cui costa totale delle materie prime supera la media dei costi totali di tutti i prodotti
