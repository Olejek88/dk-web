<?php
print '<title>Список всех категорий</title>';
print '<table cellpadding="0" cellspacing="1" border="0" style="width:900px" align=left>
<tr><td colspan=4 bgcolor=#ffcf68 align=center><font class="zagl">Техническому и обслуживающему персоналу</font></td></td></tr>
<tr><td width="225px" align=center valign=top><a href="index.php?sel=tech4&obj='.$_GET["obj"].'"><img src="pict/1-2-1.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="mnem.php?obj='.$_GET["obj"].'"><img src="pict/1-2-2.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=irp2&obj='.$_GET["obj"].'"><img src="pict/1-2-3.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=signal&obj='.$_GET["obj"].'"><img src="pict/1-2-4.jpg" style="border:2px solid #CCC;"></a></td></tr>
<tr><td bgcolor=#e3eaf3 align=center><font class="top4">Списки неотвечающих датчиков по категориям</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Мнемосхема дома с текущими показаниями датчиков и авариями</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Срез по температуре на текущий момент и значения по стояковым тепловычислителям</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Зона видимости ЛК, построенная на уровнях сигналов</font></td></td>
</tr>

<tr><td colspan=4 align=center><br></td></tr>

<tr><td colspan=4 bgcolor=#ffcf68 align=center><font class="zagl">Управляющим компаниям</font></td></td></tr>
<tr>
<td width="225px" align=center valign=top><a href="mnem2.php?obj='.$_GET["obj"].'"><img src="pict/2-3-2.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=all5&obj='.$_GET["obj"].'"><img src="pict/tc54.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=all2&obj='.$_GET["obj"].'"><img src="pict/tc55.jpg" style="border:2px solid #CCC;"></a></td>
<td width="225px" align=center valign=top><a href="index.php?sel=lk5&obj='.$_GET["obj"].'"><img src="pict/1-3-4.jpg" style="border:2px solid #CCC;"></a></td></tr>
<tr><td bgcolor=#e3eaf3 align=center><font class="top4">Распределение удельного потребления в зависимости от расположения квартиры</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Распределение и анализ потребления всех энергоресурсов</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Анализ энергоэффективности Системы</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Потребление питьевой воды абонентами</font></td>
</tr>

<tr><td colspan=4 align=center><br></td></tr>

<tr><td colspan=4 bgcolor=#ffcf68 align=center><font class="zagl">Поставщикам энергоресурсов</font></td></td></tr>
<tr><td width="225px" align=center valign=top><a href="index.php?sel=trend3&obj='.$_GET["obj"].'"><img src="pict/1-4-1.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=trend2&obj='.$_GET["obj"].'"><img src="pict/1-4-2.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=all2&obj='.$_GET["obj"].'"><img src="pict/1-4-3.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=lk6&obj='.$_GET["obj"].'"><img src="pict/1-4-4.jpg" style="border:2px solid #CCC;"></td></tr>
<tr><td bgcolor=#e3eaf3 align=center><font class="top4">Тренды по входным значениям ИТП по часам</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Архивы по коммерческому узлу учета</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Сравнение потребления дома с нормативными показателями по месяцам</font></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Потребление электроэнергии абонентами</font></td></td>

<tr><td colspan=4 align=center><br></td></tr>

<tr><td colspan=4 bgcolor=#ffcf68 align=center><font class="zagl">Абонентам</font></td></td></tr>
<tr><td width="225px" align=center valign=top><a href="index.php?sel=flat&obj='.$_GET["obj"].'"><img src="pict/1-1-1.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=analis2&obj='.$_GET["obj"].'"><img src="pict/1-1-2.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=trend4&obj='.$_GET["obj"].'"><img src="pict/1-1-3.jpg" style="border:2px solid #CCC;"></td>
<td width="225px" align=center valign=top><a href="index.php?sel=trend5&obj='.$_GET["obj"].'"><img src="pict/1-1-4.jpg" style="border:2px solid #CCC;"></td></tr>
<tr><td bgcolor=#e3eaf3 align=center><font class="top4">Отчет потребления энергоресурсов абонентом по месяцам и дням с анализом</font></td></td>
<td bgcolor=#e3eaf3 align=center><font class="top4">Распределение потребления воды по времени суток</font></td></td>';
if ($_GET["obj"]==1) print '<td bgcolor=#e3eaf3 align=center><font class="top4">Температура горячей воды и тепловая энергия на ее подготовку</font></td></td>';
if ($_GET["obj"]==2) print '<td bgcolor=#e3eaf3 align=center><font class="top4">Подробный анализ расходов</font></td></td>';
print '<td bgcolor=#e3eaf3 align=center><font class="top4">Качественный анализ поставляемого тепла, в зависимости от температуры</font></td></td>
</tr>

</tr>
</table>';
?>