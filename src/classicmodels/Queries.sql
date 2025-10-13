SELECT c.customerNumber, c.customerName, p.amount
FROM customers c NATURAL JOIN payments p
WHERE p.amount = (
    SELECT MAX(amount)
    FROM payments
);