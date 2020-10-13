<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
?>
<title>Система учета индивидуального потребления энергоресурсов :: Анализ неисправностей Системы</title>
<table width=800px cellpadding=1 cellspacing=1 align=center>
<tr><td colspan=2 bgcolor=#ffcf68 align=center><font class=tablz3>Анализ неисправностей Системы</font></td></tr>
<tr>
<td width=400 valign=top>
<table width=400 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>id</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>название датчика</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>дата посл. связи</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>кв.</font></td></tr>
<?php
 $query = 'SELECT * FROM device WHERE conn=0 AND ust=0 AND type<5 ORDER BY type';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	 {
	  print '<tr><td bgcolor=#eeedd8 align=center><font class=tablz>';
	  printf ("0x%x",$uy[1]); print '</font></td>';

	  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
	  $e = mysql_query ($query,$i);
 	  $ui = mysql_fetch_row ($e); 
	
	  print '<td bgcolor=#ff5555 align=center><a href="mnem.php?stg='.$ui[2].'&entr='.$ui[9].'"><font class=top2>'.$uy[20].'</font></td>';
	  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$uy[16].'</font></td>';
	  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$uy[10].'</font></td></tr>';
	  $uy = mysql_fetch_row ($a);
	 }

 $query = 'SELECT * FROM device WHERE ust=0 AND conn=1 AND type<6 ORDER BY type';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	{
	 //echo $uy[20].' '.time().'-'.strtotime($uy[16]).'<br>';
	 if (0 && (time()-strtotime($uy[16])) > 5000000)
		 {
		  print '<tr><td bgcolor=#eeedd8 align=center><font class=tablz>';
		  printf ("0x%x",$uy[1]); print '</font></td>';
		  $query = 'UPDATE device SET conn=0, devtim=devtim, lastdate=lastdate WHERE id='.$uy[0];
		  $e = mysql_query ($query,$i);
		  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
		  $e = mysql_query ($query,$i);
	 	  $ui = mysql_fetch_row ($e); 
		  print '<td bgcolor=#ff5555 align=center><a href="mnem.php?stg='.$ui[2].'&entr='.$ui[9].'"><font class=top2>'.$uy[20].'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$uy[16].'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$uy[10].'</font></td></tr>';
		}
	  $uy = mysql_fetch_row ($a);
	 }

?>
</table>
</td>
<td width=400 valign=top>
	<table width=400 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1>
	<tr><td width=300>
	<table width=300 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1>
	<tr><td width=150 bgcolor=#ffcf68 align=center><font class=tablz>БИТ</font></td><td width=150 bgcolor=#ffcf68 align=center><font class=tablz>2ИП</font></td></tr>
	<tr><td width=150><img width=150 height=150 src="charts/pieplot1.php?type=1<?php print '&obj='.$_GET["obj"]; ?>"></td>
	<td width=150><img width=150 height=150 src="charts/pieplot1.php?type=2<?php print '&obj='.$_GET["obj"]; ?>"></td></tr>
	<tr><td width=150 bgcolor=#ffcf68 align=center><font class=tablz>ИРП</font></td><td width=150 bgcolor=#ffcf68 align=center><font class=tablz>ЛК</font></td></tr>
	<tr><td width=150><img width=150 height=150 src="charts/pieplot1.php?type=5<?php print '&obj='.$_GET["obj"]; ?>"></td>
	<td width=150><img width=150 height=150 src="charts/pieplot1.php?type=6<?php print '&obj='.$_GET["obj"]; ?>"></td></tr>
	</table>
	</td>
	<td width=120 valign=top>
	<table width=120 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
	<tr><td bgcolor=#ffcf68 align=center><font class=tablz>назв</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>общее</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>связь</font></td></tr>
	<?php
	 $query = 'SELECT COUNT(id),SUM(conn) FROM device WHERE type=1 AND ust=0';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a); if ($uy[0]>0) $pr=number_format(100*($uy[1]/$uy[0]),2); else $pr=0;
	 print '<tr><td bgcolor=#eeed88 align=center><font class=tabl><b>БИТ</b></font></td><td bgcolor=#eeedd8 align=center><font class=tabl>'.$uy[0].'</font></td><td bgcolor=#eeed88 align=center><font class=tabl>'.$uy[1].'('.$pr.'%)</font></td>';
	 $query = 'SELECT COUNT(id),SUM(conn) FROM device WHERE type=2 AND ust=0';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a); if ($uy[0]) $pr=number_format(100*($uy[1]/$uy[0]),2); else $pr=0;
	 print '<tr><td bgcolor=#eeed88 align=center><font class=tabl><b>2ИП</b></font></td><td bgcolor=#eeedd8 align=center><font class=tabl>'.$uy[0].'</font></td><td bgcolor=#eeed88 align=center><font class=tabl>'.$uy[1].'('.$pr.'%)</font></td>';
	 $query = 'SELECT COUNT(id),SUM(conn) FROM device WHERE type=5';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a); $pr=number_format(100*($uy[1]/$uy[0]),2);
	 print '<tr><td bgcolor=#eeed88 align=center><font class=tabl><b>ИРП</b></font></td><td bgcolor=#eeedd8 align=center><font class=tabl>'.$uy[0].'</font></td><td bgcolor=#eeed88 align=center><font class=tabl>'.$uy[1].'('.$pr.'%)</font></td>';
	 $query = 'SELECT COUNT(id),SUM(conn) FROM device WHERE type=6';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a); $pr=number_format(100*($uy[1]/$uy[0]),2);
	 print '<tr><td bgcolor=#eeed88 align=center><font class=tabl><b>ЛК</b></font></td><td bgcolor=#eeedd8 align=center><font class=tabl>'.$uy[0].'</font></td><td bgcolor=#eeed88 align=center><font class=tabl>'.$uy[1].'('.$pr.'%)</font></td>';
	?>
	</table>
	</td></tr>
	</table>

	<table width=420 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1>
	<tr><td width=420>
	<table width=420 cellpadding=2 cellspacing=1 align=center bgcolor=#664466>
        <tr><td bgcolor=#ffcf68 width=90 align=center><font class=tablz>время</font></td><td bgcolor=#ffcf68 width=100 align=center><font class=tablz>device</font></td><td bgcolor=#ffcf68 width=60 align=center><font class=tablz>код события</font></td><td bgcolor=#ffcf68 align=center width=150><font class=tablz>описание события</font></td>
 	<?php
	 $query = 'SELECT * FROM register ORDER BY date DESC LIMIT 25';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 while ($uy)                                                   
		 {
		  $query = 'SELECT * FROM device WHERE idd='.$uy[2];
		  $e = mysql_query ($query,$i);
	 	  $ui = mysql_fetch_row ($e); 

		  print '<tr><td bgcolor=#eeedd8 width=90 align=center><font class=top5>'.$uy[3].'</font></td><td bgcolor=#eeedd8 width=100 align=center><font class=top5>'.$ui[20].'</font></td><td bgcolor=#eeedd8 width=60 align=center><font class=top5>';
		  printf ("0x%x",$uy[1]);
		  print '</font></td><td bgcolor=#eeedd8><font class=top5>';
		  if ($uy[1]==0x35000002) print 'device not answer';
		  print '</font></td>';  
		  $uy = mysql_fetch_row ($a);
	         }
	?>	
	</td></tr>
	</table>
</td>
</table></td>

</tr>
</table>
</body>
</html>