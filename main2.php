<?php
print '<title>Список всех категорий</title>';
print '<table cellpadding="0" cellspacing="1" border="0" style="width:900px" align=left>
<tr><td colspan=4 bgcolor=#ffcf68 align=center><font class="zagl">Техническому и обслуживающему персоналу</font></td></td></tr>
<tr><td width="225px" align=center valign=top><a href="index.php?sel=tech4&obj='.$_GET["obj"].'"><img src="pict/1-2-1.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=current&type=1&obj='.$_GET["obj"].'"><img src="pict/tc5.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=current&type=2&obj='.$_GET["obj"].'"><img src="pict/tc6.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=lk56&obj='.$_GET["obj"].'"><img src="pict/1-3-4.jpg" style="border:2px solid #CCC;"></a></td></tr>
<tr><td bgcolor=#e3eaf3 align=center><font class="top4">Списки неотвечающих датчиков по категориям</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Последние значения с датчиков БИТ</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Последние значения с датчиков 2ИП</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Потребление питьевой воды абонентами</font></td></td>
</tr>
<tr><td colspan=4 bgcolor=#ffcf68 align=center><font class="zagl">Техническому и обслуживающему персоналу</font></td></td></tr>
<tr><td width="225px" align=center valign=top><a href="index.php?sel=bit10&obj='.$_GET["obj"].'"><img src="pict/tc33.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=all51&obj='.$_GET["obj"].'"><img src="pict/tc54.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=all6&obj='.$_GET["obj"].'"><img src="pict/2-4-1.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=reports2"><img src="pict/1-3-4.jpg" style="border:2px solid #CCC;"></a></td></tr>
<tr><td bgcolor=#e3eaf3 align=center><font class="top4">Потребление тепловой энергии</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Потребление и анализ всех энергоресурсов</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Потребление ГВС и ХВС</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Отчеты в csv</font></td></td>
</tr>
</table>';
?>