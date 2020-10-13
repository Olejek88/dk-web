<title>Система учета индивидуального потребления энергоресурсов :: Распределение температуры подающего и обратного стояков</title>
<table width=1200px cellpadding=1 cellspacing=1 align=center>
<tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Распределение температуры подающего и обратного стояков, зафиксированные в момент времени 
<?php
 include("config/local.php");
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = 'SELECT * FROM prdata WHERE type=0 AND device<40000000 AND device>30000000 ORDER BY date DESC';
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);
 print $ui[4];
?>
</font></td></tr>

<tr>
<td width=800 valign=top>
<?php
 $type=1; include ("highcharts/barplots.php");
// $type=2; include ("highcharts/barplots.php");
 $type=3; include ("highcharts/barplots.php");
?>
</td>

<?php
 print '<td width=400 valign=top><table width=400 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr><td bgcolor=#ffcf68 align=center><font class=tablz>#</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>H1</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>H2</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T1</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>T2</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>V1</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>M1</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Q</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>дата</font></td></tr>';
 $query = 'SELECT * FROM dev_irp ORDER BY stype,strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=0;
 while ($uy)
         {
	  print '<tr><td bgcolor=#ffcf68 align=center>';
	  print '<a style="cursor: pointer" onclick="(imgs)=window.open(\'edit.php?id='.$uy[1].'\',\'_blank\',\'width=790,height=520,toolbar=no,menubar=no,location=no,status=no,resizable=no,scrollbars=no,top=0,left=0\');">';
	  if ($_GET["obj"]!=6) print '<font class=tablz>'.$uy[3].'</font></a>';
	  else print '<font class=tablz>'.$uy[4].'/'.$uy[3].'</font></a>';
	  print '</td>';
	  $query = 'SELECT * FROM prdata WHERE type=0 AND device='.$uy[1].' ORDER BY prm,pipe';
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e); $nc=0; $status=0;
	  while ($ui)
         	{
		  if (!$ui[5])
			{
			 $query = 'SELECT * FROM prdata WHERE type=1 AND device='.$uy[1].' AND prm='.$ui[2].' AND pipe='.$ui[7].' AND value>0 ORDER BY date DESC';
			 $r = mysql_query ($query,$i);
			 $ur = mysql_fetch_row ($r);
			 if (!$ur[5]) $ui[5]=$ur[5];
			}
		  $date=$ui[4];
		  if ($ui[2]<11 || $ui[7]==0) 
			{
			  $nc++;
			  if (($ui[2]==11 || $ui[2]==12) && $ui[5]<0.09)
				  print '<td bgcolor=#5555f0 align=center><font class=tablz>'.number_format($ui[5],2).'</font></td>';
			  else	  
				  if ($ui[5]<-10 && $ui[2]==13) print '<td bgcolor=#5555f0 align=center><font class=tablz>!</font></td>';
				  else
				  print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($ui[5],2).'</font></td>';
			}
		  $status=$ui[6];		  
		  $ui = mysql_fetch_row ($e);
		}
 	  $act='';
	  for ($g=$nc;$g<7;$g++) print '<td bgcolor=#e86666 align=center><font class=tablz>-</font></td>';
	  print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$date.'</font></td>';
	  if ($ui[6]&0x1) $act=$act.' Тпр меньше нуля';
	  if ($ui[6]&0x2) $act=$act.' Тобр меньше нуля';
	  if ($ui[6]&0x4) $act=$act.' Hпр меньше нуля';
	  if ($ui[6]&0x8) $act=$act.' Hобр меньше нуля';
	  if ($ui[6]&0x10) $act=$act.' Vпр меньше нуля';
	  if ($ui[6]&0x20) $act=$act.' Vобр меньше нуля';
	  if ($ui[6]&0x40) $act=$act.' Тпр > 120С';
	  if ($ui[6]&0x80) $act=$act.' Тобр > 120C';
	  if ($ui[6]&0x100) $act=$act.' Hпр > 1000';
	  if ($ui[6]&0x200) $act=$act.' Hобр > 1000';
	  if ($ui[6]&0x400) $act=$act.' V > 100000';
	  if ($ui[6]&0x800) $act=$act.' M > 100000';
	  //if ($act!='') print '<td bgcolor=#ff5555 align=center><font class=tablz>'.$act.'</font></td></tr>';
	  //else print '<td bgcolor=#e8e8e8 align=center></td></tr>';
	  $uy = mysql_fetch_row ($a);
         }
?>
</tr>
</table>
