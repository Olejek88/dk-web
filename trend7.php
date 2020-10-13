<title>Система учета индивидуального потребления энергоресурсов :: Показания коммерческого узла учета на входе в дом (часовые значения)</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>Показания коммерческого узла учета на входе в дом (часовые значения)</font></td></tr>
<tr><td style="width:1190px" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr><td width=1200 valign=top>
</td></tr>
</table>

<table width=1000px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr><td bgcolor=#ffcf68 align=center width=120px><font class=tablz>дата</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Tпд,C</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Tоб,C</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Qп,Г</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Qо,Г</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>G1,т</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>G2,т</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>QСО</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Qпот</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Gхв,t</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Gгв,t</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>W,kWt</font></td></tr>
<?php  
include("config/local.php"); $x=0;
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
for ($tn=0; $tn<=1250; $tn++)
	{		
	 $data0[$tn]=$data1[$tn]=$data2[$tn]=$data3[$tn]=$data4[$tn]=$data5[$tn]=$data6[$tn]=$data7[$tn]=$data8[$tn]=$data9[$tn]=$data10[$tn]=$data11[$tn]=$data12[$tn]='-';
	 $query = 'SELECT * FROM ctek ORDER BY date DESC LIMIT 3000';
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);			 
	 while ($uy)
	      	{
	       	 if ($uy[2]==4 && $uy[7]==0) $data0[$x]=number_format($uy[5],4);
	       	 if ($uy[2]==4 && $uy[7]==1) $data1[$x]=number_format($uy[5],4);
	       	 if ($uy[2]==11 && $uy[7]==0) $data2[$x]=number_format($uy[5],4);
	       	 if ($uy[2]==11 && $uy[7]==1) $data3[$x]=number_format($uy[5],4);
	       	 if ($uy[2]==12 && $uy[7]==0) $data4[$x]=number_format($uy[5],4);
	       	 if ($uy[2]==12 && $uy[7]==1) $data5[$x]=number_format($uy[5],4);
	       	 if ($uy[2]==13 && $uy[7]==0) $data6[$x]=number_format($uy[5],4);
	       	 if ($uy[2]==13 && $uy[7]==2) $data8[$x]=number_format($uy[5],4);
	       	 if ($uy[2]==13 && $uy[7]==3) $data9[$x]=number_format($uy[5],4);
	       	 if ($uy[2]==12 && $uy[7]==6) $data10[$x]=number_format($uy[5],4);
	       	 if ($uy[2]==12 && $uy[7]==5) $data11[$x]=number_format($uy[5],4);
	       	 if ($uy[2]==14 && $uy[7]==0) { $data12[$x]=number_format($uy[5],4); $dat[$x]=$uy[4]; $x++; } 
	       	 $uy = mysql_fetch_row ($a);	     
	      	}
	 for ($tn=0; $tn<=1250; $tn++) 
		{
		 if ($data0[$tn]!='-' || $data1[$tn]!='-')
			{
			  print '<tr><td align=center bgcolor=#ffcf68><font class=top2>'.$dat[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data0[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data1[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data2[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data3[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data4[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data5[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data8[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data9[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data10[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data11[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data12[$tn].'</font></td></tr>';
		       }
	       }
	}
?>
</table>	
</td></tr></table>