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

