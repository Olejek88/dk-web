<?php
for ($z=1;$z<=12;$z++)
   {
    print '<option value="'; if ($z>9) print $z; else print '0'.$z; print '" ';
    if ($z==$today[mon]) print 'selected '; print '>'; 
    if ($z==1) print 'Январь'; if ($z==2) print 'Февраль';
    if ($z==3) print 'Март';  if ($z==4) print 'Апрель';
    if ($z==5) print 'Май';    if ($z==6) print 'Июнь';
    if ($z==7) print 'Июль';   if ($z==8) print 'Август';
    if ($z==9) print 'Сентябрь';   if ($z==10) print 'Октябрь';
    if ($z==11) print 'Ноябрь';    if ($z==12) print 'Декабрь';
   }
?>