<?php
print '<title>Система индивидуального учета энергоресурсов :: Абонентам</title>';
print '<table cellpadding="0" cellspacing="1" border="0" style="width:900px" align=center>
<tr><td colspan=4 bgcolor=#ffcf68 align=center><font class="zagl">Абонентам</font></td></td></tr>
<tr><td width="225px" align=center valign=top><a href="index.php?sel=flat&obj='.$_GET["obj"].'"><img src="pict/'.$_GET["obj"].'-1-1.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=analis2&obj='.$_GET["obj"].'"><img src="pict/1-1-2.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=analis4&obj='.$_GET["obj"].'"><img src="pict/tc52.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=trend5&obj='.$_GET["obj"].'"><img src="pict/1-1-4.jpg" style="border:2px solid #CCC;"></td></tr>
<tr><td bgcolor=#e3eaf3 align=center><font class="top4">Отчет потребления энергоресурсов абонентом по месяцам и дням с анализом</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Распределение потребления воды по времени суток</font></td></td>';
print '<td bgcolor=#e3eaf3 align=center><font class="top4">Анализ качества поставляемых коммунальных услуг</font></td></td>';
print '<td bgcolor=#e3eaf3 align=center><font class="top4">Качественный анализ поставляемого тепла, в зависимости от температуры</font></td></td>
</tr></table>';
?>