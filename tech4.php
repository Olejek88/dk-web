<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
?>
<title>Система учета индивидуального потребления энергоресурсов :: Анализ неисправностей Системы</title>
<table width=1200px cellpadding=1 cellspacing=1 align=left>
<tr><td colspan=2 bgcolor=#ffcf68 align=center><font class=tablz3>Анализ неисправностей БИТ</font></td></tr>
<tr>
<td width=900 valign=top>
<table width=900 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr>
<td bgcolor=#ffcf68 align=center><font class=tablz>id</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>квартира</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>стояк</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>адрес ЛК</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>адрес</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>установка</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>H нак</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>H инт</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dB</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>вердикт</font></td>
</tr>
<?php
 $sos[0]=$sos[1]=$sos[2]=$sos[3]=$sos[4]=$sos[5]=0;
 $query = 'SELECT * FROM device WHERE type=1 AND ust=0 ORDER BY flat,adr';
 $e = mysql_query ($query,$i); $cn=0;
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui) 
	{
	 $query = 'SELECT * FROM dev_bit WHERE device='.$ui[1];
	 $f = mysql_query ($query,$i);
	 if ($f) $uo = mysql_fetch_row ($f);
	 if ($uo) { $str[$cn]=$uo[9]; $ids[$cn]=$uo[3]; $adr[$cn]=$uo[4]; $flat[$cn]=$uo[8]; }

	 $device[$cn]=$ui[1]; 
	 $cn++;
	 $ui = mysql_fetch_row ($e);
	}
 $max=$cn-1; $cn=0; 
 for ($w=0;$w<=$max;$w++) $data11[$w]=$data12[$w]=$data13[$w]=0;

 $today=getdate();
 if ($today["mon"]) $date1=sprintf ("%d%02d%02d000000",$today["year"],$today["mon"]-1,$today["mday"]);
 else $date1=sprintf ("%d%02d%02d000000",$today["year"]-1,12,$today["mday"]);

// $query = 'SELECT * FROM prdata WHERE type=2 AND prm=31 AND date>'.$date1.' ORDER BY date DESC';
 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=31 ORDER BY date DESC LIMIT '.($max*25);
 if ($e = mysql_query ($query,$i))
 while ($ui = mysql_fetch_row ($e))
    {
     for ($w=0;$w<=$max;$w++) 
	if ($device[$w]==$ui[1]) 
		{
	         if ($data12[$w]==0)  $data12[$w]=$ui[5]; else $data02[$w]=$ui[5];
		 break;
		}
    }                                                
 $query = 'SELECT * FROM prdata WHERE (type=0) AND (prm=1 OR prm=32) AND value<100000000';
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     for ($w=0;$w<=$max;$w++) 
	if ($device[$w]==$ui[1]) 
		{
		 if ($ui[2]==1) if ($data11[$w]==0)  $data11[$w]=$ui[5];
	         if ($ui[2]==32) if ($data13[$w]==0)  $data13[$w]=$ui[5];
		 break;
		}
     $ui = mysql_fetch_row ($e);    
    }                                                

 $query = 'SELECT * FROM device WHERE type=1 AND ust=0 ORDER BY flat,adr';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	 {
	  $sos[0]++;
	  $sost=0;	  
//	  if ($data13[$cn]==0) $sost=1;
	  if ($uy[21]) $sost=2;
	  if ($data13[$cn]<-101) $sost=3;
          //if ($data12[$cn]==$data02[$cn] || ($data12[$cn]-$data02[$cn]<100 && $data12[$cn]-$data02[$cn]>=0)) $sost=4;
          if ($data11[$cn]==0 || $data12[$cn]==$data02[$cn]) $sost=4;

          if ($data12[$cn]-$data02[$cn]<0 && $data12[$cn]>10 && $data02[$cn]>10) $sost=5;
          if ($sost)
		{
		  if ($sost==1) $sos[1]++;
		  if ($sost==2) $sos[2]++;
		  if ($sost==3) $sos[3]++;
		  if ($sost==4) $sos[4]++;
		  if ($sost==5) $sos[5]++;

		  print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>';
		  printf ("%d",$uy[1]); print '</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$flat[$cn].'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$str[$cn].'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$ids[$cn].'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$adr[$cn].'</font></td>';
		  if ($uy[21]==0) print '<td bgcolor=#e8e8e8 align=center><font class=top2>установлен</font></td>';
		  if ($uy[21]==1) print '<td bgcolor=#ff9999 align=center><font class=top2>не установлен</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($data12[$cn],0).'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($data11[$cn],2).'</font></td>';
		  print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.$data13[$cn].'</font></td>';
		  if ($sost==1)  print '<td bgcolor=#ee5544 align=center><font class=top2>давно не отвечает</font></td>';
		  if ($sost==2)  print '<td bgcolor=#eeee33 align=center><font class=top2>не установлен</font></td>';
		  if ($sost==3)  print '<td bgcolor=#ee80ee align=center><font class=top2>низкий уровень сигнала</font></td>';
		  if ($sost==4)  print '<td bgcolor=#775577 align=center><font class=top2>значения не изменяются ('.number_format($data12[$cn]-$data02[$cn],2).')</font></td>';
		  if ($sost==5)  print '<td bgcolor=#999999 align=center><font class=top2>походу переинициализирован</font></td>';
		  print '</tr>';
		}
	  $uy = mysql_fetch_row ($a); $cn++;
	 } 
 print '</table></td>';
 print '<td align="center" valign="top">';
 $data[0]=number_format($sos[0]-($sos[1]+$sos[2]+$sos[3]+$sos[4]+$sos[5]),0);
 $data[1]=$sos[1];
 $data[2]=$sos[2];
 $data[3]=$sos[3];
 $data[4]=$sos[4];
 $data[5]=$sos[5];
 $data[6]=0;
 include ("highcharts/pieplot15.php");
 print '<table width=290 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr>
	<td bgcolor=#ffcf68 align=center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>причина</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>количество</font></td>
 	<td bgcolor=#ffcf68 align=center><font class=tablz>%</font></td></tr>';
 print '<tr><td bgcolor="green"></td><td bgcolor=#e8e8e8 align=center><font class=top2>работают без проблем</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($sos[0]-($sos[1]+$sos[2]+$sos[3]+$sos[4]+$sos[5]),0).'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*($sos[0]-($sos[1]+$sos[2]+$sos[3]+$sos[4]+$sos[5]))/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#ee5544"></td><td bgcolor=#e8e8e8 align=center><font class=top2>давно не отвечает</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[1].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[1]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#eeee33"></td><td bgcolor=#e8e8e8 align=center><font class=top2>не установлен</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[2].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[2]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#ee80ee"></td><td bgcolor=#e8e8e8 align=center><font class=top2>низкий уровень сигнала</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[3].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[3]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#775577"></td><td bgcolor=#e8e8e8 align=center><font class=top2>значения не изменяются</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[4].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[4]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#999999"></td><td bgcolor=#e8e8e8 align=center><font class=top2>переинициализирован</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.$sos[5].'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*$sos[5]/$sos[0],2).'%</font></td></tr>';
 print '<tr><td bgcolor="#999999"></td><td bgcolor=#e8e8e8 align=center><font class=top2>в целом порядок</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($sos[0]-($sos[1]+$sos[4]),0).'</font></td><td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format(100*($sos[0]-($sos[1]+$sos[4]))/$sos[0],2).'%</font></td></tr>';
 print '</table>';
 print '</td></tr>';
// print '</table></td></tr>';
?>             

<?php
 if ($is_2ip) include ("tech4_2ip.php");
 if ($is_mee) include ("tech4_mee.php");
?>

</table>
</td>
</table></td>

</tr>
</table>
</body>
</html>