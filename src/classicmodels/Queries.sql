SELECT c.customerNumber, c.customerName, p.amount
FROM customers c NATURAL JOIN payments p
WHERE p.amount = (
    SELECT MAX(amount)
    FROM payments
);

SELECT reportsTo, COUNT(*) AS numero_dipendenti
FROM employees
GROUP BY reportsTo
ORDER BY numero_dipendenti DESC
LIMIT 5;