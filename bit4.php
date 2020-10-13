<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>raspredelenie temperaturi</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1200px cellpadding=1 cellspacing=1 align=center>
<tr>
<td width=900 valign=top>
<table width=900 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

 $query = 'SELECT * FROM dev_bit ORDER BY flat_number';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	{
	 print '<tr><td><img width=900 height=100 src="charts/barplots4.php?type=2&id='.$uy[1].'&obj='.$_GET["obj"].'"></td></tr>'; 
	 $uy = mysql_fetch_row ($a);	 
	}
?>
</table>
</td>
<td width=280 valign=top>
<table width=280 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>name</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Nh/Av H</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Nh/Av Hs</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Nh/Av T</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Nd/Av H</font></td></tr>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

 $query = 'SELECT * FROM dev_bit ORDER BY strut_number';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	{
	 $ids=$uy[3]; $ida=$uy[4]; $str=$uy[9];
	 print '<tr bgcolor=#e8e8e8><td align=left bgcolor=#eeedd8><font class=top2>';
	 printf ("[0x%x][0x%x][%02d]",$ids,$ida,$str);
	 print '</font></td>';
	
	 $query = 'SELECT COUNT(id),AVG(value) FROM prdata WHERE type=0 AND prm=1 AND device='.$uy[1];
	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e);
	 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$ui[0].'/'.number_format($ui[1],1).'</font></td>';
	 $query = 'SELECT COUNT(id),AVG(value) FROM prdata WHERE type=2 AND prm=31 AND device='.$uy[1];
	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e);
	 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$ui[0].'/'.number_format($ui[1],0).'</font></td>';
	 $query = 'SELECT COUNT(id),AVG(value) FROM prdata WHERE type=2 AND prm=4 AND device='.$uy[1];
	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e);
	 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$ui[0].'/'.number_format($ui[1],2).'</font></td>';
	 $query = 'SELECT COUNT(id),AVG(value) FROM prdata WHERE type=2 AND prm=1 AND device='.$uy[1];
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
</body>
</html>