<title>Анализ данных ЮУрГУ</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>Анализ данных по тепловой энергии и газу (дневные значения)</font></td></tr>
<tr><td style="width:1190px" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr>
<td style="width:490px" valign=top>
    <table width=490px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
    <tr><td bgcolor=#ffcf68 align=center width=60px><font class=tablz>дата</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Темп. под.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Темп. обр.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Расход под.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Расход обр.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Тепловая энергия</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Давление P газа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Температура T газа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Расход газа</font></td></tr>
	<?php  
		$dbar0='&name=Температура подающего теплоносителя';
		$dbar1='&name=Температура обратного теплоносителя';
		$dbar2='&name=Расход  подающего теплоносителя';
		$dbar3='&name=Расход  обратного теплоносителя';
		$dbar4='&name=Тепловая энергия';
		$dbar5='&name=Давление P газа';
		$dbar6='&name=Температура T газа';
		$dbar7='&name=Расход газа';

		include("config/local2.php");
		$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
                $today=getdate();
		if ($_GET["year"]=='') $ye=$today["year"];
		else $ye=$_GET["year"];
		if ($_GET["month"]=='') $mn=$today["mon"];
		else $mn=$_GET["month"];
		$x=0; $tm=$dy=$today["mday"]-1;
		for ($tn=1; $tn<=30; $tn++)
			{		
			 $date1=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
			 $dat[$x]=sprintf ("%02d-%02d-%d",$mn,$tm,$ye);			     
			 $dats[$x]=sprintf ("%02d-%02d",$mn,$tm);
			 $query = 'SELECT * FROM daydata WHERE MeasureDate='.$date1;
			 $a = mysql_query ($query,$i);
			 if ($a) $uy = mysql_fetch_row ($a);
			 $data0=$data1=$data2=$data3=$data4=$data5=$data6=$data7=$data8=$data9=$data10=$data11=$data12=$data13='-';
			 while ($uy)
			      {          
			       if ($uy[0]==1014) $data0=$uy[2];
			       if ($uy[0]==1004) $data1=$uy[2];
			       if ($uy[0]==1027) $data2=$uy[2];
			       if ($uy[0]==1037) $data3=$uy[2]; 
			       if ($uy[0]==1028) $data4=$uy[2];
			       if ($uy[0]==1116) $data5=$uy[2];
			       if ($uy[0]==1104) $data6=$uy[2];
			       if ($uy[0]==1112) $data7=$uy[2];
			       $uy = mysql_fetch_row ($a);	     
			      }
			 if ($data0!='-' || $data1!='-')
				{
			         print '<tr><td align=center bgcolor=#ffcf68 width=100><font class=top2>'.$dat[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data0,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data1,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data2,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data3,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data4,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data5,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data6,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data7,2).'</font></td></tr>';
				 $dbar0.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data0;
				 $dbar1.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data1;
				 $dbar2.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data2;
				 $dbar3.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data3;
				 $dbar4.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data4;
				 $dbar5.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data5;
				 $dbar6.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data6;
				 $dbar7.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data7;
				}                                
   		         $x++; $tm--;
		         if ($tm==0)
				{
				$mn--;
				if ($mn==0) { $mn=12; $ye--; }
				$dy=31;
				if (!checkdate ($mn,31,$ye)) { $dy=30; }
				if (!checkdate ($mn,30,$ye)) { $dy=29; }
				if (!checkdate ($mn,29,$ye)) { $dy=28; }
				$tm=$dy;
			    }
		       }
			?>
	</table>
    </td>
<td width=700 valign=top>
<img src="charts/barplot29.php?obj=<?php print $_GET["obj"].$dbar0; ?>" width=700 height=250>
<img src="charts/barplot29.php?obj=<?php print $_GET["obj"].$dbar1; ?>" width=700 height=250>
<img src="charts/barplot29.php?obj=<?php print $_GET["obj"].$dbar2; ?>" width=700 height=250>
<img src="charts/barplot29.php?obj=<?php print $_GET["obj"].$dbar3; ?>" width=700 height=250>
<img src="charts/barplot29.php?obj=<?php print $_GET["obj"].$dbar4; ?>" width=700 height=250>
<img src="charts/barplot29.php?obj=<?php print $_GET["obj"].$dbar5; ?>" width=700 height=250>
<img src="charts/barplot29.php?obj=<?php print $_GET["obj"].$dbar6; ?>" width=700 height=250>
</td></tr>

</table>
</td></tr></table>

