<?php
for ($z=0;$z<=23;$z++)
   {
    print '<option value="'; print $z; print '" ';
    if ($z==$today[hour]) print 'selected ';
    print '>'; print $z.':00';
   }
?>
