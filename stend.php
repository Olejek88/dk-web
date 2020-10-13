<title>Анализ данных ЮУрГУ</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>Анализ данных по тепловой энергии и газу (дневные значения)</font></td></tr>
<tr><td style="width:1190px" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr>
<td style="width:490px" valign=top>
    <table width=490px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
    <tr><td bgcolor=#ffcf68 align=center width=60px><font class=tablz>дата</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Температура</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Расход м3/ч</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Расход т./ч</font></td></tr>
	<?php  
		$dbar0='&name=Температура';
		$dbar1='&name=Расход объемный';
		$dbar2='&name=Расход массовый';

		include("config/local2.php");
		$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

		$query = 'SELECT * FROM mains ORDER BY MeasureDate DESC LIMIT 20000';
		$a = mysql_query ($query,$i);
		if ($a) $uy = mysql_fetch_row ($a);			 
		if ($uy) $prev=$uy[1][17];
		while ($uy)
		      	{
		         if ($uy[0]==1014) $data0[$x]=$uy[2];
		         if ($uy[0]==1022) $data1[$x]=$uy[2];
		         if ($uy[0]==1023) $data2[$x]=$uy[2];
			 $dat[$x]=sprintf ("%c%c:%c%c:%c0",$uy[1][11],$uy[1][12],$uy[1][14],$uy[1][15],$uy[1][17]);
			 if ($uy[1][17]!=$prev) $x++;
		       	 $uy = mysql_fetch_row ($a);	     
		      	}
		 $x=0;
		 for ($tn=0; $tn<=550; $tn++) 
			{
			 if ($data0[$tn]!='-' || $data1[$tn]!='-')
				{
			         print '<tr><td align=center bgcolor=#ffcf68 width=100><font class=top2>'.$dat[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data0[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data1[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data2[$tn],2).'</font></td></tr>';
				 $dbar0.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data0;
				 $dbar1.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data1;
				 $dbar2.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data2;
				}                                
   		         $x++; 
		       }

	?>
	</table>
    </td>
<td width=700 valign=top>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar0; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar1; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar2; ?>" width=700 height=250>
</td></tr>

</table>
</td></tr></table>

