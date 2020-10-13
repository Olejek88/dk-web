<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = 'SELECT SUM(rnum),SUM(square) FROM flats';
 $a = mysql_query ($query,$i);
 if ($a) $uy = mysql_fetch_row ($a);  $sum=$uy[0]; $sum0=$uy[1];
 $norm1=$sum*5.4/(6*31*24); $norm2=$sum*3.6/(6*31*24);

 $query = 'SELECT MAX(devtim) FROM device WHERE ust=0 AND type=1';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); 
 if ($uy) $maxdate=$uy[0];

 $query = 'SELECT * FROM device WHERE ust=0 AND type=1 ORDER BY devtim';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $n1=$n2=$n3=0;
 while ($uy)
	{
	 if (strtotime($maxdate)-strtotime($uy[16])<10000000) $n1++;
	 if (strtotime($maxdate)-strtotime($uy[16])>10000000 && strtotime($maxdate)-strtotime($uy[16])<50000000) $n2++;
	 if (strtotime($maxdate)-strtotime($uy[16])>50000000) $n3++;
	 $uy = mysql_fetch_row ($a); 
	}
 $pr1=number_format($n1*100/($n1+$n2+$n2),2);
 $pr2=number_format($n2*100/($n1+$n2+$n2),2);
 $pr3=number_format($n3*100/($n1+$n2+$n2),2);

 $query = 'SELECT * FROM device WHERE ust=0 AND type=2 ORDER BY devtim';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $i1=$i2=$i3=0;
 while ($uy)
	{
	 if (strtotime($maxdate)-strtotime($uy[16])<10000000) $i1++;
	 if (strtotime($maxdate)-strtotime($uy[16])>10000000 && strtotime($maxdate)-strtotime($uy[16])<50000000) $i2++;
	 if (strtotime($maxdate)-strtotime($uy[16])>50000000) $i3++;
	 $uy = mysql_fetch_row ($a); 
	}
 $pi1=number_format($i1*100/($i1+$i2+$i3),2);
 $pi2=number_format($i2*100/($i1+$i2+$i3),2);
 $pi3=number_format($i3*100/($i1+$i2+$i3),2);
?>
<title>Система учета индивидуального потребления энергоресурсов :: Индикация отказов и состояния ИТП</title>
<table width=800px cellpadding=1 cellspacing=1 align=center>
<tr><td colspan=2 bgcolor=#ffcf68 align=center><font class=tablz3>Индикация отказов и состояния ИТП</font></td></tr>
<tr><td width=800 valign=top>
<table width=800 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td width=100 bgcolor=#ffcf68 align=center><font class=tablz>БИТ</font></td><td width=100 bgcolor=#ffcf68 align=center><font class=tablz>2ИП</font></td><td width=100 bgcolor=#ffcf68 align=center><font class=tablz>МЭЭ</font></td>
<td width=100 bgcolor=#ffcf68 align=center><font class=tablz>ИРП</font></td><td width=100 bgcolor=#ffcf68 align=center><font class=tablz>ЛК</font></td><td width=100 bgcolor=#ffcf68 align=center><font class=tablz>Тэкон</font></td></tr>
<tr>
<td bgcolor=#ffffff align=center><img width=100 height=100 src="charts/pieplot1.php?type=1<?php print '&obj='.$_GET["obj"]; ?>"></td>
<td bgcolor=#ffffff align=center><img width=100 height=100 src="charts/pieplot1.php?type=2<?php print '&obj='.$_GET["obj"]; ?>"></td>
<td bgcolor=#ffffff align=center><img width=100 height=100 src="charts/pieplot1.php?type=4<?php print '&obj='.$_GET["obj"]; ?>"></td>
<td bgcolor=#ffffff align=center><img width=100 height=100 src="charts/pieplot1.php?type=5<?php print '&obj='.$_GET["obj"]; ?>"></td>
<td bgcolor=#ffffff align=center><img width=100 height=100 src="charts/pieplot1.php?type=6<?php print '&obj='.$_GET["obj"]; ?>"></td>
<td bgcolor=#ffffff align=center><img width=100 height=100 src="charts/pieplot1.php?type=11<?php print '&obj='.$_GET["obj"]; ?>"></td>
</tr>
<tr>
<td width=120 bgcolor=#ffffff align=center>
	<table width=120 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
	<?php
	 print '<tr><td bgcolor=green><font class=tablz>норма</font></td><td bgcolor=#eeeeee><font class="tablz">'.$n1.'('.$pr1.'%)</font></td></tr>';
	 print '<tr><td bgcolor=#eeee33><font class=tablz>средне</font></td><td bgcolor=#eeeeee><font class="tablz">'.$n2.'('.$pr2.'%)</font></td></tr>';
	 print '<tr><td bgcolor=#ee5544><font class=tablz>плохо</font></td><td bgcolor=#eeeeee><font class="tablz">'.$n3.'('.$pr3.'%)</font></td></tr>';
	?>
	</table>
</td>
<td width=120 bgcolor=#ffffff align=center>
	<table width=120 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
	<?php
	 print '<tr><td bgcolor=green><font class=tablz>норма</font></td><td bgcolor=#eeeeee><font class="tablz">'.$i1.'('.$pi1.'%)</font></td></tr>';
	 print '<tr><td bgcolor=#eeee33><font class=tablz>средне</font></td><td bgcolor=#eeeeee><font class="tablz">'.$i2.'('.$pi2.'%)</font></td></tr>';
	 print '<tr><td bgcolor=#ee5544><font class=tablz>плохо</font></td><td bgcolor=#eeeeee><font class="tablz">'.$i3.'('.$pi3.'%)</font></td></tr>';
	?>
	</table>
</td>
<td width=100 bgcolor=#ffcf68 align=center></td>
<td width=100 bgcolor=#ffcf68 align=center></td>
<td width=100 bgcolor=#ffcf68 align=center></td>
<td width=100 bgcolor=#ffcf68 align=center></td>
</tr>

</table></td></tr>
<tr><td width=800 valign=top>
<table width=800 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr>
<td width=100 bgcolor=#ffcf68 align=center><font class=tablz>Тепло [Q]</font></td>
<td width=100 bgcolor=#ffcf68 align=center><font class=tablz>Температура под</font></td>
<td width=100 bgcolor=#ffcf68 align=center><font class=tablz>Температура обр</font></td>
<td width=100 bgcolor=#ffcf68 align=center><font class=tablz>Расход ХВС</font></td>
<td width=100 bgcolor=#ffcf68 align=center><font class=tablz>Расход ГВС</font></td>
<td width=100 bgcolor=#ffcf68 align=center><font class=tablz>Электричество</font></td>
</tr>
<tr>
<td bgcolor=#ffffff align=center><img width=130 height=100 src="charts/barplots21.php?prm=13&src=0&ras=0<?php print '&obj='.$_GET["obj"]; ?>"></td>
<td bgcolor=#ffffff align=center><img width=130 height=100 src="charts/barplots21.php?prm=4&src=0&ras=70<?php print '&obj='.$_GET["obj"]; ?>"></td>
<td bgcolor=#ffffff align=center><img width=130 height=100 src="charts/barplots21.php?prm=4&src=1&ras=60<?php print '&obj='.$_GET["obj"]; ?>"></td>
<td bgcolor=#ffffff align=center><img width=130 height=100 src="charts/barplots21.php?prm=12&src=5&ras=<?php print $norm1.'&obj='.$_GET["obj"]; ?>"></td>
<td bgcolor=#ffffff align=center><img width=130 height=100 src="charts/barplots21.php?prm=12&src=6&ras=<?php print $norm2.'&obj='.$_GET["obj"]; ?>"></td>
<td bgcolor=#ffffff align=center><img width=130 height=100 src="charts/barplots21.php?prm=14&src=1&ras=6<?php print '&obj='.$_GET["obj"]; ?>"></td>
</tr>
</table></td></tr>
<tr><td width=800 valign=top>
<table width=800 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<?php
 print '<img width=800 height=200 src="charts/barplots.php?type=1&hg=200&wd=800&obj='.$_GET["obj"].'">';
 print '<img width=800 height=200 src="charts/barplots.php?type=2&hg=200&wd=800obj='.$_GET["obj"].'">';
?>
</table></td></tr>

</table>
</body>
</html>