SELECT 
a.nombre AS agencias,
a.valor AS agencia_valor,
top.tope AS tope,
l.nombre AS loteria,
t.numero AS numero,
t.valor AS valor,
t.fecha AS fecha,
ABS(t.valor-top.tope) AS cubierta,
(((ABS(t.valor-top.tope))/100)*a.valor)*1000 AS total_cubierta,
((top.tope/100)*a.valor)*1000 AS total_tope,
((((ABS(t.valor-top.tope))/100)*a.valor)*1000)+(((top.tope/100)*a.valor)*1000) AS total
FROM
tiquetes t,
tiquetes_as_loterias tl,
loterias l,
agencias a,
tope top
WHERE
t.id=tl.tiquetes AND
tl.loterias=l.id AND
t.agencia=a.id AND
top.fecha='2018-02-04'