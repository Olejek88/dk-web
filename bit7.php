<title>Система учета индивидуального потребления энергоресурсов :: Расклад энтальпии по этажам и стоякам</title>
<table width=1200px cellpadding=1 cellspacing=1 align=center>
<tr><td width=1200px colspan=2 bgcolor=#ffcf68 align=center><font class=tablz3>Расклад энтальпии по этажам и стоякам</font></td></tr>
<tr>
<td width=800 valign=top>
<table width=400 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1>
<?php
//if ($_GET["obj"]=='2') $_GET["date"]='20090608000000';
$today=getdate();
if ($_GET["date"]=='') $_GET["date"]=sprintf ("%d%02d%02d000000",$today["year"],2,1);

print '
<tr><td><img width=400 height=160 src="charts/barplots11.php?type=11&date='.$_GET["date"].'&obj='.$_GET["obj"].'"></td>
<td><img width=400 height=160 src="charts/barplots11.php?type=1&date='.$_GET["date"].'&obj='.$_GET["obj"].'"></td></tr>
<tr><td><img width=400 height=160 src="charts/barplots11.php?type=32&date='.$_GET["date"].'&obj='.$_GET["obj"].'"></td>
<td><img width=400 height=160 src="charts/barplots11.php?type=15&date='.$_GET["date"].'&obj='.$_GET["obj"].'"></td></tr>
<tr><td><img width=400 height=160 src="charts/barplots11.php?type=41&date='.$_GET["date"].'&obj='.$_GET["obj"].'"></td>
<td><img width=400 height=160 src="charts/barplots11.php?type=28&date='.$_GET["date"].'&obj='.$_GET["obj"].'"></td></tr>
<tr><td><img width=400 height=160 src="charts/barplots11.php?type=24&date='.$_GET["date"].'&obj='.$_GET["obj"].'"></td>
<td><img width=400 height=160 src="charts/barplots11.php?type=42&date='.$_GET["date"].'&obj='.$_GET["obj"].'"></td></tr>';
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
	  $irp[$cn][1][0]=$irp[$cn][1][1]=0;
	  if ($_GET["date"]=='') $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND prm=1 AND value>0 AND date=20090703000000';
	  else $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND prm=1 AND value>1000 AND date<='.$_GET["date"].' ORDER BY date DESC LIMIT 200';
	  $r = mysql_query ($query,$i);
	  $ur = mysql_fetch_row ($r);
	  while ($ur)
		{
		  if ($irp[$cn][1][$ur[7]]==0) $irp[$cn][1][$ur[7]]=$ur[5];
		  //echo $irp[$cn][1][$ur[7]];
		  $ur = mysql_fetch_row ($r);
		}
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }

 for ($str=1;$str<=$count;$str++)
	{
	  print '<tr><td bgcolor=#eeedd8 align=center><font class=tablz>'.$str.'</font></td>';
  	  if ($irp[$str][1][0]>0) $data[0]=$irp[$str][1][0];
	  else $data[0]='-';
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
		  if ($_GET["date"]=='') $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND prm=1 AND value>0 AND date=20090703000000';
		  else $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND prm=1 AND value>1000 AND date='.$_GET["date"];
		  $r = mysql_query ($query,$i);
		  $ur = mysql_fetch_row ($r);
		  if ($ur) $data[$w]=$ur[5];
		  else $data[$w]=0;
		  //print '<td bgcolor=#e8e8e8 align=center><font class=tablz2>'.number_format($ui[5],0).'</font></td>';
		  $w++;
		  $uy = mysql_fetch_row ($a);
        	 }
	  if ($irp[$str][1][1]>0) $data[10]=$irp[$str][1][1];
	  else $data[10]='-';
	  
	  for ($w=0;$w<11;$w++)
		{
		 //if ($data[$w]>100) 
		 if ($data[$w]) print '<td bgcolor=#e8e8e8 align=center><font class=tablz2>'.number_format($data[$w],0).'</font></td>';
		 else print '<td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
		 //else if ($w>0 && $w<10) { $pr=($data[$w-1]+$data[$w+1])/2; print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($pr,2).'</font></td>'; }
		}
	  print '</tr>';
	}
?>
</td></tr></table></td>

</tr>
</table>
