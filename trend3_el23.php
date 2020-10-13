<title>Система учета индивидуального потребления энергоресурсов :: Показания коммерческого узла учета на входе в дом (дневные значения)</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr><td width="100%" bgcolor=#ffcf68 align=center><font class=tablz3>Показания коммерческого узла учета на входе в дом (дневные значения)</font></td></tr>
<tr><td style="width:100%" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr>
<td style="width:700px" valign=top>
    <table width=700px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
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
		 $dated=sprintf ("%d%02d%02d000000",$today["year"],$today["mon"],$today["mday"]);
		 $query = 'SELECT * FROM data WHERE flat=0 AND date<'.$dated.' ORDER BY date DESC';
		 //echo $query;
		 $a = mysql_query ($query,$i);
		 if ($a) $uy = mysql_fetch_row ($a);			 
		 if ($uy)
		    {
		     sscanf ($uy[2],"%d-%d-%d %d:%d:%d",$ye,$mn,$dy,$n,$n,$n);
		     $tm=$dy;
		    }
		else
		    {
		     $today=getdate();
		     if ($_GET["year"]=='') $ye=$today["year"];
		     else $ye=$_GET["year"];
		     if ($_GET["month"]=='') $mn=$today["mon"];
		     else $mn=$_GET["month"];
		     $tm=$dy=$today["mday"]-1;
		    }

		$x=0; $nn=1; $ts=23;
		for ($tn=0; $tn<=200; $tn++)
			{		
			 $date1[$tn]=sprintf ("%d%02d%02d%02d0000",$ye,$mn,$tm,$ts);
			 $dat[$tn]=sprintf ("%d-%02d-%02d %02d:00:00",$ye,$mn,$tm,$ts);
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
	
		 $query = 'SELECT * FROM data WHERE type=1 AND flat=0 ORDER BY date DESC LIMIT 20000';
		 $a = mysql_query ($query,$i);
		 if ($a) $uy = mysql_fetch_row ($a);			 
		 while ($uy)
		      	{
			 $x=201;
			 for ($tn=0; $tn<=200; $tn++) 
			 if ($uy[2]==$dat[$tn]) $x=$tn;
			 
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

		 for ($tn=0; $tn<=200; $tn++) 
				{
		        	 print '<tr><td align=center bgcolor=#ffcf68 style="width:100px"><font class=top2>'.$dat[$tn].'</font></td>';
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
	?>
	</table>
    </td>

<td valign=top>
<?php
$cnt=120; $id=0; $title='Температура подающего (С)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],5,5);  $date1[$cnt-$rr-1]=$data0[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=1; $title='Температура обратного (С)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],5,5);  $date1[$cnt-$rr-1]=$data1[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=4; $title='Расход подающего (т.)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],5,5);  $date1[$cnt-$rr-1]=$data2[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=5; $title='Расход обратного (т.)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],5,5);  $date1[$cnt-$rr-1]=$data3[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=6; $title='Тепловая энергия (ГКал)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],5,5);  $date1[$cnt-$rr-1]=$data6[$rr]; }
include ("highcharts/trend.php");
?>
</td></tr>
</table>
</td></tr></table>

