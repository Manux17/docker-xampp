-- 1. Caselli di entrata con numero di transazioni superiori a 500
SELECT c.codice_casello, COUNT(*) AS numero_transazioni
FROM Entrata e
    JOIN Passaggio p ON e.codice_telepass = p.codice_telepass  AND e.data_ora = p.data_ora
    JOIN Casello c 
        ON p.codice_casello = c.codice_casello
GROUP BY c.codice_casello
HAVING COUNT(*) > 500;


-- 2. Spesa totale per modello di veicolo.
select sum(u.costo_pedaggio) as somma_pedaggio, v.tipo
from Veicolo v 
	join Passaggio p on v.targa = p.targa
    join Uscita u on u.codice_telepass = p.codice_telepass and u.data_ora = p.data_ora
group by tipo;


-- 3. Autostrade con importo medio di uscita minore di 15€.
SELECT a.codice_autostradale, avg(u.costo_pedaggio) as media_pedaggi
FROM Autostrada a 
	join Casello c on a.codice_autostradale = c.codice_autostradale
    join Passaggio p on p.codice_casello = c.codice_casello
    join Uscita u on p.codice_telepass = u.codice_telepass AND p.data_ora = u.data_ora
group by a.codice_autostradale
having avg(u.costo_pedaggio) < 15;

-- 4. Proprietari con più di due veicoli.
-- niente

-- 5. Spesa totale per regione (entrata) sopra soglia di 10.000€.
-- niente

-- 6. I caselli di uscita più utilizzati
SELECT c.codice_casello
from Casello c 
	join Passaggio p on c.codice_casello = p.codice_casello
GROUP by c.codice_casello
having count(*) = (
        select count(*)
    from Passaggio p 
        join Casello c on p.codice_casello = c.codice_casello
    group by c.codice_casello
    order by count(*) desc
    limit 1);


-- 7. Veicoli che non hanno mai transato in una data regione.
--fatta

-- 8. Caselli con importo medio superiore alla media di una specifica autostrada.
--fatta

-- 9. Veicoli con spesa totale superiore alla media generale.
--fatta

-- 10. Volume (numero) di transazioni per mese e anno.
--fatta