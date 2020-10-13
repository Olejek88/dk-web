<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Система учета индивидуального потребления энергоресурсов :: Расклад температуры по этажам и стоякам</title>

<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1190px cellpadding=1 cellspacing=1 align=center>
<tr><td width=1190px colspan=2 bgcolor=#ffcf68 align=center><font class=tablz3>Расклад температуры по этажам и стоякам</font></td></tr>
<tr>
<td width=800 valign=top>
<table width=400 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1>
<?php
//if ($_GET["obj"]=='') $_GET["date"]='20111108000000';
$today=getdate();
if ($_GET["date"]=='') $_GET["date"]=sprintf ("%d%02d%02d000000",$today["year"],2,1);
?>
</table>
</td>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = 'SELECT COUNT(id) FROM dev_irp ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $count=$uy[0];

 print '<td width=390 valign=top><table width=390 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr><td bgcolor=#ffcf68 align=center><font class=tablz>name</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Tpod</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T1</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T2</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T3</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T4</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T5</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T6</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T7</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T8</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T9</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Tobr</font></td></tr>';
 
 $query = 'SELECT * FROM dev_irp ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
	  $cn=$uy[3];
	  $query = 'SELECT * FROM prdata WHERE type=0 AND device='.$uy[1].' AND prm=1 AND value>0 AND pipe=0 ORDER BY date DESC';
	  $r = mysql_query ($query,$i);
	  if ($r) $ur = mysql_fetch_row ($r);
	  if ($ur) $irp[$cn][$ur[2]][$ur[7]]=number_format($ur[5],2);
	  $query = 'SELECT * FROM prdata WHERE type=0 AND device='.$uy[1].' AND prm=1 AND value>0 AND pipe=1 ORDER BY date DESC';
	  $r = mysql_query ($query,$i);
	  if ($r) $ur = mysql_fetch_row ($r);
	  if ($ur) $irp[$cn][$ur[2]][$ur[7]]=number_format($ur[5],2);

	  //echo $query;
	  //echo $irp[$cn][$ur[2]][$ur[7]];
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }

 $query = 'SELECT * FROM dev_irp ORDER BY strut';
 $a2 = mysql_query ($query,$i); $cn=1;
 while ($uy2 = mysql_fetch_row ($a2))
	{
	 $str=$uy2[3];
	  print '<tr><td bgcolor=#eeedd8 align=center><font class=tablz>'.$uy2[3].'</font></td>';
	  print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$irp[$str][4][0].'</font></td>';
	 
	  $query = 'SELECT COUNT(id) FROM dev_bit WHERE strut_number='.$str;
	  $a = mysql_query ($query,$i);
	  $uy = mysql_fetch_row ($a);
	  //if ($uy[0]==8) print '<td bgcolor=#e8e8e8 align=center><font class=tablz>n/y</font></td>';

	  $query = 'SELECT * FROM dev_bit WHERE strut_number='.$str.' ORDER BY flat_number';
	  $a = mysql_query ($query,$i);
	  $uy = mysql_fetch_row ($a);
	  while ($uy)
		{
		  $query = 'SELECT * FROM prdata WHERE prm=1 AND type=2 AND device='.$uy[1].' AND pipe=0 AND value>0 ORDER BY date DESC';
		  //echo $query;
		  $r = mysql_query ($query,$i);                                                                                                                   
		  $ur = mysql_fetch_row ($r);
		  if ($ur[5])
			  print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($ur[5],2).' ('.$uy[8].')</font></td>';
		  else print '<td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
		  $uy = mysql_fetch_row ($a);
        	 }
	  print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$irp[$str][4][1].'</font></td></tr>';
	}
?>
</td></tr></table>
