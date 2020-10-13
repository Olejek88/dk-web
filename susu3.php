<title>Анализ данных ЮУрГУ</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>Анализ данных (часовые значения)</font></td></tr>
<tr><td style="width:1190px" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr>
<td style="width:1190px" valign=top>
    <table width=1190px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
    <tr><td bgcolor=#ffcf68 align=center width=60px><font class=tablz>дата</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Темп. под.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Темп. обр.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Расход под.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Расход обр.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Тепловая энергия</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Давление P газа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Температура T газа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Расход газа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Общ. 0.4кВ</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Общ. РП</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>НИИ ЦС</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Гл. корпус центр</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Насос + вставка</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>ОНИЛ ТД</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>АТ корпус</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Дом 151 + хим. корпус</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>РСУ</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Гл. корпус левый</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Теплотех. корпус</font></td></tr></tr>

	<?php  
		$dbar1='&name=Температура подающего теплоносителя';
		$dbar2='&name=Температура обратного теплоносителя';
		$dbar3='&name=Расход  подающего теплоносителя';
		$dbar4='&name=Расход  обратного теплоносителя';
		$dbar5='&name=Тепловая энергия';
		$dbar6='&name=Давление P газа';
		$dbar7='&name=Температура T газа';
		$dbar8='&name=Расход газа';

		include("config/local2.php");
		$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
                $today=getdate();
		if ($_GET["year"]=='') $ye=$today["year"];
		else $ye=$_GET["year"];
		if ($_GET["month"]=='') $mn=$today["mon"];
		else $mn=$_GET["month"];

		$x=0; $nn=1; $ts=23;
		$tm=$dy=$today["mday"]-10;
		
		for ($tn=0; $tn<=150; $tn++)
			{		
			 $date1[$tn]=sprintf ("%d%02d%02d%02d0000",$ye,$mn,$tm,$ts);
			 $dat[$tn]=sprintf ("%d-%02d-%02d %02d:00:00",$ye,$mn,$tm,$ts);
			 $dat2[$tn]=sprintf ("%d-%02d-%02d %02d:30:00",$ye,$mn,$tm,$ts);
			 $data0[$tn]=$data1[$tn]=$data2[$tn]=$data3[$tn]=$data4[$tn]=$data5[$tn]=$data6[$tn]=$data7[$tn]=$data8[$tn]=$data9[$tn]=$data10[$tn]=$data11[$tn]=$data12[$tn]='-';
		         if ($tm==1 && $ts==0)
				{
				 $mn--; $ts=24;					
				 $dy=31;
				 if (!checkdate ($mn,31,$ye)) { $dy=30; }
				 if (!checkdate ($mn,30,$ye)) { $dy=29; }
				 if (!checkdate ($mn,29,$ye)) { $dy=28; }
				 $tm=$dy;
			        }
			 if ($ts==0) { $ts=24; $tm--; }
			 $ts--;
			}

		 $query = 'SELECT * FROM mains WHERE MeasureDate<'.$date1[0].' ORDER BY MeasureDate DESC LIMIT 20000';
		 $a = mysql_query ($query,$i);
		 if ($a) $uy = mysql_fetch_row ($a);			 
		 while ($uy)
		      	{
			 $x=151;
			 for ($tn=0; $tn<=150; $tn++) 
				{
				 if ($tn<5) echo $uy[0].' '.$dat[$tn].' '.$uy[1].'<br>';
				 if ($uy[1]==$dat[$tn] || $uy[1]==$dat2[$tn]) { $x=$tn; break; }
				}	

		         if ($uy[0]==1014) $data0[$x]=$uy[2];
		         if ($uy[0]==1004) $data1[$x]=$uy[2];
		         if ($uy[0]==1027) $data2[$x]=$uy[2];
		         if ($uy[0]==1037) $data3[$x]=$uy[2]; 
		         if ($uy[0]==1028) $data4[$x]+=$uy[2];
		         if ($uy[0]==1116) $data5[$x]=$uy[2];
		         if ($uy[0]==1104) $data6[$x]=$uy[2];
		         if ($uy[0]==1112) $data7[$x]=$uy[2];
		         if ($uy[0]==44 ||  $uy[0]==150) $data8[$x]+=$uy[2];
		         if ($uy[0]==68 ||  $uy[0]==174) $data9[$x]+=$uy[2];
		         if ($uy[0]==215 || $uy[0]==527) $data10[$x]+=$uy[2]; 
		         if ($uy[0]==239) $data11[$x]+=$uy[2];      
		         if ($uy[0]==263 || $uy[0]==407) $data12[$x]+=$uy[2];
		         if ($uy[0]==287) $data13[$x]+=$uy[2];
		         if ($uy[0]==311 || $uy[0]==503) $data14[$x]+=$uy[2];
		         if ($uy[0]==335 || $uy[0]==359 || $uy[0]==479) $data15[$x]+=$uy[2];
		         if ($uy[0]==383) $data16[$x]+=$uy[2];
		         if ($uy[0]==431) $data17[$x]+=$uy[2];
		         if ($uy[0]==455) $data18[$x]+=$uy[2];
			 echo $data0[$x].' '.$data1[$x].' '.$data2[$x].' '.$data3[$x].' '.$data4[$x].' '.$data5[$x].' '.$data6[$x].' '.$data7[$x].'<br>';
		       	 $uy = mysql_fetch_row ($a);	     
		      	}
		 $x=0;
		 for ($tn=0; $tn<=150; $tn++) 
			{
			 if ($data0[$tn]!='-' || $data1[$tn]!='-')
				{
			         print '<tr><td align=center bgcolor=#ffcf68 width=100><font class=top2>'.$dat[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data0[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data1[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data2[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data3[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data4[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data5[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data6[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data7[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data8[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data9[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data10[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data11[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data12[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data13[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data14[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data15[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data16[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data17[$tn],2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data18[$tn],2).'</font></td></tr>';
				 $dbar0.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data0;
				 $dbar1.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data1;
				 $dbar2.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data2;
				 $dbar3.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data3;
				 $dbar4.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data4;
				 $dbar5.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data5;
				 $dbar6.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data6;
				 $dbar7.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data7;
				}                                
   		         $x++; 
		       }
			?>
	</table>
    </td>
</tr>

</table>
</td></tr></table>

