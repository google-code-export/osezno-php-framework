select tbm03ctr04.m03sal_id || lpad(cast (tbm03ctr04.m03ctr_id as varchar), 4,
 '0') as contrato,
       tbm03ctr04.m01asi_id,
       soc.m01soc_nombres || ' ' || soc.m01soc_apellidos AS socio,
       email4.m01ema_email as email
from tbm06crp06
     left OUTER join tbm03ctr04 on (tbm06crp06.m01asi_id = tbm03ctr04.m01asi_id)
     LEFT OUTER JOIN 
     (select tbm01soc01.m01asi_id, tbm01soc01.m01soc_nombres,
      tbm01soc01.m01soc_apellidos, tbm01soc01.m01soc_id from tbm01soc01 where
       tbm01soc01.m01soc_titular = 1) as soc on (tbm03ctr04.m01asi_id =
        soc.m01asi_id)
     inner join 
     (select tbm01ema01.m01soc_id, max(tbm01ema01.m01ema_email) as m01ema_email
      from tbm01ema01 group by tbm01ema01.m01soc_id) as email4 on (soc.m01soc_id
       = email4.m01soc_id)
     left outer join tbm01dir01 on (soc.m01soc_id = tbm01dir01.m01soc_id)
     left outer join tbmciudad on (tbm01dir01.mciudad_id = tbmciudad.mciudad_id
      and tbm01dir01.mestdir_id = 1)
where tbm06crp06.mpais_id = 'PA' and
      tbm06crp06.m06crp_mes = 9 and
      tbmciudad.mciudad_estado = 'Veraguas'