<title>Система индивидуального учета энергоресурсов :: Текущие значения с датчиков</title>
<table width=500px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center>
<tr><td width=500px colspan=2 bgcolor=#ffcf68 align=center><font class=tablz3>Текущие значения датчиков</font></td></tr>
<tr><td width=500px bgcolor=#ffffff valign=top>
<table width=500px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center valign=top>
<tr>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

 print '<td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center width="120px"><font class=tablz>дата</font></td>'; 
 if ($_GET["type"]=='')
	{
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>P1</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>P2</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>P3</font></td>'; 
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>P4</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>P5</font></td>'; 
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>P6</font></td>'; 
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>P7</font></td>'; 
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>P8</font></td>';  
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>P9</font></td>'; 
	}
 if ($_GET["type"]=='1')
	{
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>H0</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Tводы</font></td>'; 
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Hсум</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>RSSI</font></td>';
	}
 if ($_GET["type"]=='2')
	{
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Q0</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>V0</font></td>'; 
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Q1</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>V1</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>RSSI</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Vdd</font></td>';
	}
 if ($_GET["type"]=='4')
	{
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Wсум</font></td>'; 
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Wмгн</font></td>';
	}
 if ($_GET["type"]=='5')
	{
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>H1</font></td>'; 
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>H2</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T1</font></td>'; 
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T2</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>V</font></td>'; 
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Q</font></td>'; 
	}
?>
</tr>

<?php
 if ($_GET["type"]=='') $query = 'SELECT * FROM device WHERE type=1 OR type=2 OR type=4 OR type=5 OR type=11 ORDER BY flat';
 if ($_GET["type"]!='') $query = 'SELECT * FROM device WHERE type='.$_GET["type"].' AND ust=0 ORDER BY flat';
// if ($_GET["type"]=='1') $query = 'SELECT * FROM dev_bit ORDER BY strut_number,flat_number'; 
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
         {
	  print '<tr bgcolor=#e8e8e8>';
	  //if ($_GET["type"]=='1') print '<td align=left bgcolor=#ffcf68><font class=tablz>'.$uy[8].'/'.$uy[9]. '('.$uy[1].')</font></td>';
	  print '<td align=center bgcolor=#ffcf68><font class=tablz>'.$uy[20].' ('.$uy[1].')</font></td>';
	  $query = 'SELECT * FROM prdata WHERE device='.$uy[1].' AND type=0 ORDER BY prm,pipe LIMIT 9';
	  //echo $query;
	  $e = mysql_query ($query,$i);
	  $cn=0; 
	  while ($ui = mysql_fetch_row ($e))
	    {	  
	      if ($cn==0) 
		if (($_GET["type"]==1 || $_GET["type"]==4) && (time() - strtotime ($ui[4])) > 2000000) { print '<td align=center bgcolor=#ee4455><font class=top2>'.$ui[4].'</font></td>'; $cn++; }
		else  { print '<td align=center bgcolor=#eeedd8><font class=top2>'.$ui[4].'</font></td>'; $cn++; }
	      if ($ui[2]==1) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],1).'</font></td>';
	      if ($ui[2]==2) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],3).'</font></td>';	      
	      if ($ui[2]==4) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],2).'</font></td>';
	      if ($ui[2]==5) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],2).'</font></td>';
	      if ($ui[2]==7) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],2).'</font></td>';	      
	      if ($ui[2]==6) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],2).'</font></td>';	      
	      if ($ui[2]==8) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],2).'</font></td>';
	      if ($ui[2]==11 && $ui[7]==0) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],2).'</font></td>';
	      if ($ui[2]==13 && $ui[7]==0) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],2).'</font></td>';
	      if ($ui[2]==14) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],2).'</font></td>';
	      if ($ui[2]==31) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],0).'</font></td>';
	      if ($ui[2]==32) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],1).'</font></td>';
	      if ($ui[2]==33) print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($ui[5],2).'</font></td>';
	      $cn++;
	    }
	 if ($_GET["type"]=='') for ($r=$cn;$r<12;$r++) print '<td align=center bgcolor=#eeedd8><font class=top2>-</td>';
	 print '</tr>';
	 $uy = mysql_fetch_row ($a);
	}
?>
</table>
</td>
<td width=800px bgcolor=#ffffff valign=top>
<table width=800px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<?php
 if ($_GET["type"]=='1')
	{
	 print '<tr><td>';  $_GET["prm"]=1; include ("highcharts/barplots20.php");  print '</td></tr>';
	 print '<tr><td>';  $_GET["prm"]=4; include ("highcharts/barplots20.php");  print '</td></tr>';
	 print '<tr><td>';  $_GET["prm"]=31; include ("highcharts/barplots20.php");  print '</td></tr>';
	 print '<tr><td>';  $_GET["prm"]=32; include ("highcharts/barplots20.php");  print '</td></tr>';
	 print '<tr><td>';  $_GET["prm"]=33; include ("highcharts/barplots20.php");  print '</td></tr>';
	}
 if ($_GET["type"]=='2')
	{
	 print '<tr><td>';  $_GET["prm"]=5; include ("highcharts/barplots20.php");  print '</td></tr>';
	 print '<tr><td>';  $_GET["prm"]=7; include ("highcharts/barplots20.php");  print '</td></tr>';
	 print '<tr><td>';  $_GET["prm"]=6; include ("highcharts/barplots20.php");  print '</td></tr>';
	 print '<tr><td>';  $_GET["prm"]=8; include ("highcharts/barplots20.php");  print '</td></tr>';
	 print '<tr><td>';  $_GET["prm"]=32; include ("highcharts/barplots20.php");  print '</td></tr>';
	}
 if ($_GET["type"]=='4')
	{
	 print '<tr><td>';  $_GET["prm"]=2; include ("highcharts/barplots20.php");  print '</td></tr>';
	 print '<tr><td>';  $_GET["prm"]=14; include ("highcharts/barplots20.php");  print '</td></tr>';
	}
 if ($_GET["type"]=='5')
	{
	 print '<tr><td>';  $_GET["prm"]=1; include ("highcharts/barplots20.php");  print '</td></tr>';
	 print '<tr><td>';  $_GET["prm"]=4; include ("highcharts/barplots20.php");  print '</td></tr>';
	}
?>
</table>
</tr></table>
