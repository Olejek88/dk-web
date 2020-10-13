<title>Система учета индивидуального потребления энергоресурсов :: Показания коммерческого узла учета на входе в дом (дневные значения)</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr><td width=100% bgcolor=#ffcf68 align=center><font class=tablz3>Показания коммерческого узла учета на входе в дом (дневные значения)</font></td></tr>
<tr><td style="width:100%" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr>
<td style="width:490px" valign=top>
    <table width=490px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
	<tr><td bgcolor=#ffcf68 align=center width=60px><font class=tablz>дата</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Tп,C</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Tо,C</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Qп,ГК</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Qо,ГК2</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G1,т</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>G2,т</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>QСО</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Qпотр</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Gхв,т</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Gгв,т</font></td>
	<?php
	 if ($_GET["obj"]<=3)  print '<td bgcolor=#ffcf68 align=center><font class=tablz>W1,kW</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>W2,kW</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Tнв</font></td>';
	?>
	</tr>
	<?php  
		include("config/local.php");
		$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
                $today=getdate();
		if ($_GET["year"]=='') $ye=$today["year"];
		else $ye=$_GET["year"];
		if ($_GET["month"]=='') $mn=$today["mon"];
		else $mn=$_GET["month"];
		$x=0; 
		if ($today["mday"]>2) $tm=$dy=$today["mday"]-1;
		else $tm=$dy=$today["mday"];
		for ($tn=1; $tn<=1060; $tn++)
			{		
			 $date1=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
			 $dat[$x]=sprintf ("%02d-%02d-%d",$mn,$tm,$ye);			     
			 $query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND date='.$date1;
			 $a = mysql_query ($query,$i);
			 if ($a) $uy = mysql_fetch_row ($a);
			 $data0[$x]=$data1[$x]='-1';
			 while ($uy)
			      {          
			       if ($uy[8]==4 && $uy[6]==0) $data0[$x]=number_format($uy[3],2);
			       if ($uy[8]==4 && $uy[6]==1) $data1[$x]=number_format($uy[3],2);
			       if ($uy[8]==11 && $uy[6]==0) $data2[$x]=number_format($uy[3],2);
			       if ($uy[8]==11 && $uy[6]==1) $data3[$x]=number_format($uy[3],2);
			       if ($uy[8]==12 && $uy[6]==0) $data4[$x]=number_format($uy[3],1);
			       if ($uy[8]==12 && $uy[6]==1) $data5[$x]=number_format($uy[3],1);
			       if ($uy[8]==13 && $uy[6]==0) $data6[$x]=number_format($uy[3],2);
			       if ($uy[8]==13 && $uy[6]==2) $data8[$x]=number_format($uy[3],2);
			       if ($uy[8]==13 && $uy[6]==3) $data9[$x]=number_format($uy[3],2);
			       if ($uy[8]==12 && $uy[6]==6) $data10[$x]=number_format($uy[3],2);
			       if ($uy[8]==12 && $uy[6]==5) $data11[$x]=number_format($uy[3],2);
			       if ($uy[8]==14 && $uy[6]==0) $data12[$x]=number_format($uy[3],1);
			       if ($uy[8]==14 && $uy[6]==1) $data13[$x]=number_format($uy[3],1);
			       if ($uy[8]==4 && $uy[6]==10) $data14[$x]=number_format($uy[3],0);
			       if ($uy[8]==13 && $uy[6]==4) $data15[$x]=number_format($uy[3],2);
			       $uy = mysql_fetch_row ($a);	     
			      }
			 if ($_GET["obj"]==1 || $_GET["obj"]==2) $data10[$x]=$data10[$x]-$data11[$x];
			 //else $data11=$data11-$data10;
			 if ($data0[$x]!='-1' || $data1[$x]!='-1')
				{
			         print '<tr><td align=center bgcolor=#ffcf68 width=100><font class=top2>'.$dat[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data0[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data1[$x].'</font></td>';
				 if ($_GET["obj"]==1 || $_GET["obj"]==2 || $_GET["obj"]==3)
					{
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data2[$x].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data3[$x].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data4[$x].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data5[$x].'</font></td>';
					}
				 else
					{
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data6[$x].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data15[$x].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data4[$x].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data5[$x].'</font></td>';
					}
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data8[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data9[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data10[$x].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data11[$x].'</font></td>';
				 if ($_GET["obj"]<=3) print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data12[$x].'</font></td>';
				 if ($_GET["obj"]<=3) print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data13[$x].'</font></td>';
				 if ($_GET["obj"]<=3) print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data14[$x].'</font></td>';
				 print '</tr>';
				 $x++;
				 if ($x>60) break;
				}
   		         $tm--;
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
			$cnt=$x;
		?>
	</table>
    </td>
<td width="100%" valign=top>
<?php
$cnt=80; $id=0; $title='Температура подающего (С)';
for ($rr=0;$rr<$cnt;$rr++) if ($data0[$rr]!='-1')	{ $date2[$rr]=substr($dat[$rr],0,5);  $data2[$rr]=$data0[$rr]; }
include ("highcharts/bar.php");
$cnt=80; $id=1; $title='Температура обратного (С)';
for ($rr=0;$rr<$cnt;$rr++) if ($data0[$rr]!='-1')	{ $date2[$rr]=substr($dat[$rr],0,5);  $data2[$rr]=$data1[$rr]; }
include ("highcharts/bar.php");

$cnt=80; $id=4; $title='Расход подающего (т.)';
for ($rr=0;$rr<$cnt;$rr++) if ($data0[$rr]!='-1')	{ $date2[$rr]=substr($dat[$rr],0,5);  $data2[$rr]=$data4[$rr]; }
include ("highcharts/bar.php");
$cnt=80; $id=5; $title='Расход обратного (т.)';
for ($rr=0;$rr<$cnt;$rr++) if ($data0[$rr]!='-1')	{ $date2[$rr]=substr($dat[$rr],0,5);  $data2[$rr]=$data5[$rr]; }
include ("highcharts/bar.php");
$cnt=80; $id=6; $title='Тепловая энергия (ГКал)';
for ($rr=0;$rr<$cnt;$rr++) if ($data0[$rr]!='-1')	{ $date2[$rr]=substr($dat[$rr],0,5);  $data2[$rr]=$data8[$rr]; }
include ("highcharts/bar.php");
?>
</td></tr>

</table>
</td></tr></table>

