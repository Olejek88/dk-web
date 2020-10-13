<title>Система учета индивидуального потребления энергоресурсов :: Показания коммерческого узла учета на входе в дом (дневные значения)</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr><td width="100%" bgcolor=#ffcf68 align=center><font class=tablz3>Показания коммерческого узла учета на входе в дом (дневные значения)</font></td></tr>
<tr><td style="width:100%" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr>
<td style="width:400px" valign=top>
    <table width=400px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
	<tr><td bgcolor=#ffcf68 colspan=1></td><td bgcolor=#ffcf68 colspan=5 align="center">отопление</td>
	<td bgcolor=#ffcf68 colspan=5 align="center">отопление жилой части</td>
	<td bgcolor=#ffcf68 colspan=5 align="center">отопление встроек</td>
	<td bgcolor=#ffcf68 colspan=3 align="center">гвс</td></tr>

	<tr><td bgcolor=#ffcf68 align=center width=120px><font class=tablz>дата</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tп,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tо,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vп,м3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vо,м3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Qпотр</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tп,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tо,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vп,м3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vо,м3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Qпотр</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tп,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tо,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vп,м3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vо,м3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Qпотр</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G1,т</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G2,т</font></td></tr>
	<?php  
		include("config/local.php");
		$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
                $today=getdate();
		if ($_GET["year"]=='') $ye=$today["year"];
		else $ye=$_GET["year"];
		if ($_GET["month"]=='') $mn=$today["mon"]-2;
		else $mn=$_GET["month"];
		$x=0;
		if ($today["mday"]>2) $tm=$dy=$today["mday"]=28;
		else $tm=$dy=$today["mday"];
		for ($tn=0; $tn<100; $tn++)
			{
			 $date1=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
			 $dat[$x]=sprintf ("%02d-%02d-%d",$mn,$tm,$ye);
			 $query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND date='.$date1;
			 $a = mysql_query ($query,$i);
			 if ($a) $uy = mysql_fetch_row ($a);
			 while ($uy)
			      {
      			       	 if ($uy[8]==4 && $uy[6]==0 && $uy[3]<110) $data0[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==4 && $uy[6]==1 && $uy[3]<110) $data1[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==11 && $uy[6]==0) $data2[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==11 && $uy[6]==1) $data3[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==13 && $uy[6]==0 && $uy[3]<50) $data6[$x]=number_format($uy[3],3);

			       	 if ($uy[8]==4 && $uy[6]==3 && $uy[3]<110) $data10[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==4 && $uy[6]==4 && $uy[3]<110) $data11[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==11 && $uy[6]==3) $data12[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==11 && $uy[6]==4) $data13[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==13 && $uy[6]==4 && $uy[3]<40) $data16[$x]=number_format($uy[3],3);

			       	 if ($uy[8]==4 && $uy[6]==5 && $uy[3]<110) $data20[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==4 && $uy[6]==6 && $uy[3]<110) $data21[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==11 && $uy[6]==5) $data22[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==11 && $uy[6]==6) $data23[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==13 && $uy[6]==5 && $uy[3]<50) $data26[$x]=number_format($uy[3],3);

			       	 if ($uy[8]==11 && $uy[6]==6) $data53[$x]=number_format($uy[3],1);
			       	 if ($uy[8]==11 && $uy[6]==9) $data55[$x]=number_format($uy[3],1);

			       $uy = mysql_fetch_row ($a);
			      }

			 //if ($data0[$tn]>0 || $data1[$tn]>0)
if (1)
				{
		        	 print '<tr><td align=center bgcolor=#ffcf68><font class=top2>'.$dat[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data0[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data1[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data2[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data3[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data6[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data10[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data11[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data12[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data13[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data16[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data20[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data21[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data22[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data23[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data26[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data53[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data55[$tn].'</font></td>';
				 //if ($data53[$tn]-$data55[$tn]>0) $qgvs=($data6[$tn]-$data16[$tn]-$data26[$tn])/($data53[$tn]-$data55[$tn]);
				 //print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($qgvs,5).'</font></td>';
				 print '</tr>';
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

<td valign=top>
<?php
$cnt=80; $id=4; $name='Расход подающего (т.)';
for ($rr=0;$rr<=$cnt;$rr++)	{ $date2[$rr]=substr($dat[$rr],0,5);  $data2[$rr]=$data2[$rr]; }
include ("highcharts/bar.php");
$cnt=80; $id=6; $name='Тепловая энергия (ГКал)';
for ($rr=0;$rr<=$cnt;$rr++)	{ $date2[$rr]=substr($dat[$rr],0,5);  if ($data6[$rr]<30) $data2[$rr]=$data6[$rr]; else if ($rr>0) $data2[$rr]=$data6[$rr-1]; }
include ("highcharts/bar.php");
$cnt=80; $id=2; $name='Температура подающей (C)';
for ($rr=0;$rr<=$cnt;$rr++)	{ $date2[$rr]=substr($dat[$rr],0,5);  if ($data0[$rr]<110) $data2[$rr]=$data0[$rr]; else if ($rr>0) $data2[$rr]=$data0[$rr-1]; }
include ("highcharts/bar.php");
$cnt=80; $id=3; $name='Температура обратной (C)';
for ($rr=0;$rr<=$cnt;$rr++)	{ $date2[$rr]=substr($dat[$rr],0,5);  if ($data1[$rr]<110) $data2[$rr]=$data1[$rr]; else if ($rr>0) $data2[$rr]=$data1[$rr-1]; }
include ("highcharts/bar.php");
?>
</td></tr>
</table>
</td></tr></table>

