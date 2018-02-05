SELECT 
a.nombre AS agencias,
a.valor AS agencia_valor,
top.tope AS tope,
l.nombre AS loteria,
t.numero AS numero,
t.valor/(SELECT COUNT(*) FROM tiquetes_as_loterias WHERE tiquetes=t.id) AS valor,
t.fecha AS fecha
FROM
tiquetes t,
tiquetes_as_loterias tl,
loterias l,
agencias a,
tope top,
ganadores ga
WHERE
t.id=tl.tiquetes AND
tl.loterias=l.id AND
t.agencia=a.id AND
ga.numero=t.numero AND
ga.loteria=tl.loterias AND  
top.fecha='2018-02-04'
ORDER BY a.nombre ASC