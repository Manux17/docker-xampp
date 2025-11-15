-- Media della capienza di tutti i magazzini
SELECT AVG(M.Capienza) AS Capienza_Media_Magazzini
FROM Magazzini M

-- Numero di volte  che compare il burro nelle ricette
SELECT COUNT(*) AS Numero_Burro
FROM MateriePrime M NATURAL JOIN Ricette R
WHERE R.Tipologia = "Burro";