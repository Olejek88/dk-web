<title>Система учета  :: Статус узлов учета и последние данные</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr><td width="100%" bgcolor=#ffcf68 align=center></td></tr>
<tr><td style="width:100%" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr>
<td style="width:100%" valign=top>
    <table width="100%" cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
	<tr><td bgcolor=#ffcf68 colspan=1></td><td bgcolor=#ffcf68 colspan=3 align="center">информация</td>
	<td bgcolor=#ffcf68 colspan=8 align="center">данные</td>
	<td bgcolor=#ffcf68 colspan=2 align="center">ссылки</td></tr>

	<tr><td bgcolor=#ffcf68 align=center width=20px><font class=tablz>#</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>название</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>ip</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дата</font></td>

	<td bgcolor=#ffcf68 align=center><font class=tablz>T1,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>T2,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vпод,т.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vобр,т.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Pп,МПа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Pо,МПа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Qпотр,ГКал</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vгвс,</font></td>

	<td bgcolor=#ffcf68 align=center><font class=tablz>часовые</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>суточные</font></td></tr>
	<?php
		include("config/local5.php");
		//ini_set('display_errors', 'On'); error_reporting(E_ALL);
		mysql_close($i);
		$i = mysql_connect ($mysql_host_srv,$mysql_user_srv,$mysql_password_srv); 
		 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
		 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
		 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

		$e=mysql_select_db ($mysql_db_name_srv);
		$device=0;	
		$query = 'SELECT * FROM device';
		if ($a2 = mysql_query ($query,$i)) 
		while ($uy2 = mysql_fetch_row ($a2))
		      {
			 $query = 'SELECT * FROM objects WHERE build='.$uy2[10];
			 $a3 = mysql_query ($query,$i);
			 if ($a3) $uy3 = mysql_fetch_row ($a3);

			 $query = 'SELECT * FROM prdata WHERE type=0 AND device='.$uy2[1];
			 if ($a=mysql_query ($query,$i))
			 while ($uy = mysql_fetch_row ($a))
			      {
			        //echo $uy[5];
			       	if ($uy[2]==4 && $uy[7]==0) $data1[$device]=number_format($uy[5],3);
			       	if ($uy[2]==4 && $uy[7]==1) $data2[$device]=number_format($uy[5],3);
			       	if ($uy[2]==11 && $uy[7]==0) $data3[$device]=number_format($uy[5],3);
			       	if ($uy[2]==11 && $uy[7]==1) $data4[$device]=number_format($uy[5],3);
			       	if ($uy[2]==16 && $uy[7]==0) $data5[$device]=number_format($uy[5],3);
			       	if ($uy[2]==16 && $uy[7]==1) $data6[$device]=number_format($uy[5],3);
			       	if ($uy[2]==13 && $uy[7]==2) $data7[$device]=number_format($uy[5],4);
			       	if ($uy[2]==11 && $uy[7]==5) $data8[$device]=number_format($uy[5],4);
			       	if ($uy[2]==4 && $uy[7]==0) $dat[$device]=$uy[4];
  		       	      }
	        	 print '<tr><td align=center bgcolor=#ffcf68 style="width:100px"><font class=top2>'.$uy2[1].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$uy3[1].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$uy2[9].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$dat[$device].'</font></td>';

			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data1[$device].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data2[$device].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data3[$device].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data4[$device].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data5[$device].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data6[$device].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data7[$device].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data8[$device].'</font></td>';

			 print '<td align=center bgcolor=#e8e8e8><font class=top2><a href="index.php?sel=trend3_tech&id='.$uy2[1].'&obj='.$uy2[10].'">ссылка</a></font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2><a href="index.php?sel=trend2_tech&id='.$uy2[1].'&obj='.$uy2[10].'">ссылка</a></font></td>';
			 print '</tr>';
                         $device++;
			}
  		       	    
	?>
	</table>
    </td>
</tr>
</table>
</td></tr></table>

