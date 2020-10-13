<title>Полная информация по количеству архивных записей по датчикам воды</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1190px cellpadding=1 cellspacing=1 align=center>
<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>Полная информация по количеству архивных записей по датчикам воды</font></td></tr>
<tr>
<td width=900 valign=top>
<table width=900 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

 $query = 'SELECT * FROM dev_2ip ORDER BY flat_number';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	{
	 print '<tr><td><img width=350 height=100 src="barplots4.php?type=2&prm=7&id='.$uy[1].'&obj='.$_GET["obj"].'"></td><td><img width=350 height=100 src="barplots4.php?type=2&prm=5&id='.$uy[1].'&obj='.$_GET["obj"].'"></td></tr>'; 
	 $uy = mysql_fetch_row ($a);	 
	}
?>
</table>
</td>
<td width=280 valign=top>
<table width=280 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>name</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Nh/Av Q1</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Nh/Av V1</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Nh/Av Q2</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Nh/Av V2</font></td>
</tr>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

 $query = 'SELECT * FROM dev_2ip ORDER BY flat_number';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	{
	 $ids=$uy[3]; $ida=$uy[4]; $str=$uy[9];
	 print '<tr bgcolor=#e8e8e8><td align=left bgcolor=#eeedd8><font class=top2>';
	 printf ("[0x%x][0x%x]",$ids,$ida);
	 print '</font></td>';
	
	 $query = 'SELECT COUNT(id),AVG(value) FROM prdata WHERE type=2 AND prm=5 AND device='.$uy[1];
	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e);
	 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$ui[0].'/'.number_format($ui[1],1).'</font></td>';
	 $query = 'SELECT COUNT(id),AVG(value) FROM prdata WHERE type=2 AND prm=7 AND device='.$uy[1];
	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e);
	 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$ui[0].'/'.number_format($ui[1],1).'</font></td>';

	 $query = 'SELECT COUNT(id),AVG(value) FROM prdata WHERE type=2 AND prm=6 AND device='.$uy[1];
	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e);
	 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$ui[0].'/'.number_format($ui[1],1).'</font></td>';
	 $query = 'SELECT COUNT(id),AVG(value) FROM prdata WHERE type=2 AND prm=8 AND device='.$uy[1];
	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e);
	 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$ui[0].'/'.number_format($ui[1],1).'</font></td>';
	 $uy = mysql_fetch_row ($a);	 
	}
?>

</td>
</tr></table></td>

</tr>
</table>
