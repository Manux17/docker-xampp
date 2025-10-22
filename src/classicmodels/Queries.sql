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

SELECT o.orderNumber
FROM productLine NATURAL JOIN products NATURAL JOIN orderdetails NATURAL JOIN orders o
WHERE productLine = 'Classic Cars';

SELECT c.customerNumber, c.customerName, c.phone
FROM customers c
WHERE c.customerNumber = (
    SELECT o.customerNumber
    FROM orders o
    GROUP BY o.customerNumber
    ORDER BY COUNT(*) DESC
    LIMIT 1
);

SELECT SUM(p.amount) AS "Somma Totale"
FROM payments p;

SELECT o.officeCode, COUNT(*) AS numero_dipendenti
FROM offices o NATURAL JOIN employees e
GROUP BY o.officeCode
ORDER BY numero_dipendenti DESC
LIMIT 1;

SELECT reportsTo, COUNT(*) AS numero_dipendenti
FROM employees
GROUP BY reportsTo
HAVING COUNT(*) = (
    SELECT COUNT(*)
    FROM employees
    GROUP BY reportsTo
    ORDER BY COUNT(*) DESC
    LIMIT 1
    );