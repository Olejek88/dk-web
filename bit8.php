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
<td width=800 valign=top>
<table width=400 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1>
<tr><td><img width=400 height=160 src="barplots6.php?type=11"></td>
<td><img width=400 height=160 src="barplots6.php?type=1"></td></tr>
<tr><td><img width=400 height=160 src="barplots6.php?type=32"></td>
<td><img width=400 height=160 src="barplots6.php?type=15"></td></tr>
<tr><td><img width=400 height=160 src="barplots6.php?type=41"></td>
<td><img width=400 height=160 src="barplots6.php?type=28"></td></tr>
<tr><td><img width=400 height=160 src="barplots6.php?type=24"></td>
<td><img width=400 height=160 src="barplots6.php?type=42"></td></tr>
</table>
</td>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 print '<td width=400 valign=top><table width=400 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr><td bgcolor=#ffcf68 align=center><font class=tablz>name</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Hpod</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>1</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>2</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>3</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>4</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>5</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>6</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>7</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>8</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>9</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Hobr</font></td></tr>';
 
 $query = 'SELECT * FROM dev_irp ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
	  $query = 'SELECT * FROM prdata WHERE type=0 AND device='.$uy[1].' ORDER BY prm,pipe';
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  while ($ui)
         	{
		  $query = 'SELECT * FROM prdata WHERE type=1 AND device='.$uy[1].' AND prm='.$ui[2].' AND pipe='.$ui[7].' AND value>0 ORDER BY date DESC';
		  $r = mysql_query ($query,$i);
		  $ur = mysql_fetch_row ($r);
		  if (!$ui[5]) $ui[5]=$ur[5];
			else $prev=$ui[5];
		  $irp[$cn][$ui[2]][$ui[7]]=number_format($ui[5],2);
		  $ui = mysql_fetch_row ($e);
		}
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }

 for ($str=1;$str<43;$str++)
	{
	  print '<tr><td bgcolor=#eeedd8 align=center><font class=tablz>'.$str.'</font></td>';
  	  if ($irp[$str][12][0]>0) $data[0]=$irp[$str][1][0];
	 
	  $query = 'SELECT COUNT(id) FROM dev_bit WHERE strut_number='.$str;
	  $a = mysql_query ($query,$i);
	  $uy = mysql_fetch_row ($a);
	  //if ($uy[0]==8) print '<td bgcolor=#e8e8e8 align=center><font class=tablz>n/y</font></td>';
	  $w=1;

	  $query = 'SELECT * FROM dev_bit WHERE strut_number='.$str.' ORDER BY flat_number';
	  $a = mysql_query ($query,$i);
	  $uy = mysql_fetch_row ($a);
	  while ($uy)
		{
		  $query = 'SELECT * FROM prdata WHERE prm=1 AND type=0 AND device='.$uy[1];
		  $e = mysql_query ($query,$i);
		  $ui = mysql_fetch_row ($e);
		  if ($ui)
		  while ($ui)
         		{
			  $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND prm='.$ui[2].' AND pipe='.$ui[7].' AND value>0 ORDER BY date DESC';
			  $r = mysql_query ($query,$i);
			  $ur = mysql_fetch_row ($r);
			  if (!$ui[5]) $ui[5]=2*$ur[5];
				else $prev=$ui[5];
			  $data[$w]=$ui[5];
			  //print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($ui[5],2).'</font></td>';
			  $ui = mysql_fetch_row ($e);
			}
		  else $data[$w]=0;
		  $w++;
		  $uy = mysql_fetch_row ($a);
        	 }
	  if ($irp[$str][12][0]>0) $data[10]=$irp[$str][1][1];
	  for ($w=0;$w<11;$w++)
		{
		 //if ($data[$w]>100) 
		 if ($data[$w]) print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($data[$w],2).'</font></td>';
		 else print '<td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
		 //else if ($w>0 && $w<10) { $pr=($data[$w-1]+$data[$w+1])/2; print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($pr,2).'</font></td>'; }
		}
	  print '</tr>';
	}
?>
</td></tr></table></td>

</tr>
</table>
</body>
</html>