<?php
print '<title>Система индивидуального учета энергоресурсов :: Обслуживающему и техническому персоналу</title>';
print '<table cellpadding="0" cellspacing="1" border="0" style="width:900px" align=center>
<tr><td colspan=4 bgcolor=#ffcf68 align=center><font class="tablz3">Техническому и обслуживающему персоналу</font></td></td></tr>
<tr><td width="225px" align=center valign=top><a href="index.php?sel=trend2&obj='.$_GET["obj"].'"><img src="pict/tc1.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=trend3&obj='.$_GET["obj"].'"><img src="pict/tc2.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=tech&obj='.$_GET["obj"].'"><img src="pict/tc3.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=signal&obj='.$_GET["obj"].'"><img src="pict/tc4.jpg" style="border:2px solid #CCC;"></a></td></tr>
<tr><td bgcolor=#e3eaf3 align=center><font class="top4">Архивы по коммерческому узлу учета по дням</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Тренды по входным значениям ИТП по часам</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Списки неотвечающих датчиков по категориям</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Зона видимости ЛК, построенная на уровнях сигналов</font></td></td>
</tr>

<tr><td width="225px" align=center valign=top><a href="index.php?sel=current&type=1&obj='.$_GET["obj"].'"><img src="pict/tc5.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=current&type=2&obj='.$_GET["obj"].'"><img src="pict/tc6.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=current&type=4&obj='.$_GET["obj"].'"><img src="pict/tc7.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=current&type=5&obj='.$_GET["obj"].'"><img src="pict/tc8.jpg" style="border:2px solid #CCC;"></a></td></tr>
<tr><td bgcolor=#e3eaf3 align=center><font class="top4">Текущие показания датчиков энтальпии</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Текущие показания водосчетчиков</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Текущие показания счетчиков электроэнергии</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Текущие показания стояковых вычислителей</font></td>
</tr>

<tr><td width="225px" align=center valign=top><a href="mnem.php?obj='.$_GET["obj"].'"><img src="pict/tc9.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=lk1&obj='.$_GET["obj"].'"><img src="pict/tc56.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=irp3&obj='.$_GET["obj"].'"><img src="pict/tc57.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=bit2&obj='.$_GET["obj"].'"><img src="pict/tc12.jpg" style="border:2px solid #CCC;"></td></tr>
<tr><td bgcolor=#e3eaf3 align=center><font class="top4">Мнемосхема дома с текущими показаниями датчиков и авариями</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Статистика работы датчиков 2ИП</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Статистика работы ИРП</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Расклад температуры по этажам и стоякам</font></td></tr>

<tr><td width="225px" align=center valign=top><a href="index.php?sel=bit10&obj='.$_GET["obj"].'"><img src="pict/tc53.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=balans&month=11&obj='.$_GET["obj"].'"><img src="pict/tc17.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=irp7&obj='.$_GET["obj"].'"><img src="pict/tc15.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=irp4&obj='.$_GET["obj"].'"><img src="pict/tc16.jpg" style="border:2px solid #CCC;"></td></tr>
<tr><td bgcolor=#e3eaf3 align=center><font class="top4">Потребление тепловой энергии, вычисленное по различным алгоритмам</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Сведение балансов по всем квартирам</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Срез по температуре на текущий момент и значения по стояковым тепловычислителям</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Суточные архивы по всем стояковым вычислителям</font></td></td>
</tr>
</table>';
?>