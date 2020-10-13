<title>Анализ данных ЮУрГУ</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>Анализ данных по электричеству (дневные значения)</font></td></tr>
<tr><td style="width:1190px" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr>
<td style="width:490px" valign=top>
    <table width=490px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
    <tr><td bgcolor=#ffcf68 align=center width=60px><font class=tablz>дата</font></td>
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
	<td bgcolor=#ffcf68 align=center><font class=tablz>Теплотех. корпус</font></td></tr>
	<?php  
		$dbar1='&name=Общий вход 0.4кВ';
		$dbar2='&name=Общий вход СН';
		$dbar3='&name=НИИ ЦС';
		$dbar4='&name=Гл.корпус Центр.';
		$dbar5='&name=Насосная + Стройка вставки (кран)';
		$dbar6='&name=ОНИЛ ТД';
		$dbar7='&name=Автотракторный корпус';
		$dbar8='&name=Жилой дом ул. Коммуны 151 + Новый кабель вставка';
		$dbar9='&name=РСУ(Ремонтно-строительное управление)';
		$dbar10='&name=Гл.корпус Левое крыло';
		$dbar11='&name=Теплотехнический корпус';		

		include("config/local2.php");
		$i = mysql_connect ("62.165.35.90","root",""); $e=mysql_select_db ($mysql_db_name);
		echo $i.'<br>';
		echo $e.'<br>';
                $today=getdate();
		if ($_GET["year"]=='') $ye=$today["year"];
		else $ye=$_GET["year"];
		if ($_GET["month"]=='') $mn=$today["mon"];
		else $mn=$_GET["month"];
		$x=0; $tm=$dy=$today["mday"]-1;
		for ($tn=1; $tn<=180; $tn++)
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
			       if ($uy[0]==3 ||  $uy[0]==109) $data0+=$uy[2];
			       if ($uy[0]==44 ||  $uy[0]==150) $data1+=$uy[2];
			       if ($uy[0]==68 ||  $uy[0]==174) $data2+=$uy[2];
			       if ($uy[0]==215 || $uy[0]==527) $data3+=$uy[2]; 
			       if ($uy[0]==239) $data4+=$uy[2];
			       if ($uy[0]==263 || $uy[0]==407) $data5+=$uy[2];
			       if ($uy[0]==287) $data6+=$uy[2];
			       if ($uy[0]==311 || $uy[0]==503) $data7+=$uy[2];
			       if ($uy[0]==335 || $uy[0]==359 || $uy[0]==479) $data8+=$uy[2];
			       if ($uy[0]==383) $data9+=$uy[2];
			       if ($uy[0]==431) $data10+=$uy[2];
			       if ($uy[0]==455) $data11+=$uy[2];
			       $uy = mysql_fetch_row ($a);	     
			      }
			 if ($data0!='-' || $data1!='-')
				{
			         print '<tr><td align=center bgcolor=#ffcf68 width=100><font class=top2>'.$dat[$x].'</font></td>';
				 //print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data0/1000,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data1*80/1000,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data2*20/1000,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data3*20/1000,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data4*30/1000,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data5*30/1000,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data6*30/1000,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data7*30/1000,2).'</font></td>';

				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data8*30/1000,2).'</font></td>';

				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data9*30/1000,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data10*30/1000,2).'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data11*30/1000,2).'</font></td></tr>';
				 $dbar0.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data0;
				 $dbar1.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data1;
				 $dbar2.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data2;
				 $dbar3.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data3;
				 $dbar4.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data4;
				 $dbar5.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data5;
				 $dbar6.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data6;
				 $dbar7.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data7;
				 $dbar8.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data8;
				 $dbar9.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data9;
				 $dbar10.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data10;
				 $dbar11.='&dat'.$x.'='.$dats[$x].'&d'.$x.'='.$data11;
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
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar1; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar2; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar3; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar4; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar5; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar6; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar7; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar8; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar9; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar10; ?>" width=700 height=250>
<img src="charts/xyplot29.php?obj=<?php print $_GET["obj"].$dbar11; ?>" width=700 height=250>
</td></tr>

</table>
</td></tr></table>

