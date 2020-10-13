<title>Система учета индивидуального потребления энергоресурсов :: Показания коммерческого узла учета на входе в дом (часовые значения)</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr><td width=100% bgcolor=#ffcf68 align=center><font class=tablz3>Показания коммерческого узла учета на входе в дом (часовые значения)</font></td></tr>
<tr><td style="width:100%" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr>
<td style="width:500px" valign=top>
    <table width=500px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
	<tr><td bgcolor=#ffcf68 align=center width=70px><font class=tablz>дата</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Tпд,C</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Tоб,C</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Qп,Г</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Qо,Г</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G1,т</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>G2,т</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>QСО</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Qпот</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Gхв,t</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Gгв,t</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>W,kWt</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>W2,kWt</font></td></tr>
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
			for ($tn=0; $tn<=300; $tn++)
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
				 $x=301;
				 for ($tn=0; $tn<=300; $tn++) 
				 if ($uy[2]==$dat[$tn]) $x=$tn;
					
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
			       	 if ($uy[8]==14 && $uy[6]==0 && $uy[3]>0 && $uy[3]<300) $data12[$x]=number_format($uy[3],5);
			       	 if ($uy[8]==14 && $uy[6]==1 && $uy[3]>0 && $uy[3]<300) $data13[$x]=number_format($uy[3],5);
			       	 $uy = mysql_fetch_row ($a);	     
			      	}
			 for ($tn=0; $tn<=300; $tn++) 
				{
				 if ($_GET["obj"]==1 || $_GET["obj"]==2) $data10[$tn]=$data10[$tn]-$data11[$tn];
				 if ($data0[$tn]!='-' || $data1[$tn]!='-')
					{
					 if ($data10[$tn]<0) $data10[$tn]=0;
					 if ($data11[$tn]<0) $data11[$tn]=0;
			        	 print '<tr><td align=center bgcolor=#ffcf68><font class=top2>'.$dat[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data0[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data1[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data2[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data3[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data4[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data5[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data6[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data9[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data10[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data11[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data12[$tn].'</font></td>';
					 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data13[$tn].'</font></td></tr>';
				       }
			       }
		?>
	</table>
    </td>
<td width="100%" valign=top>
<?php
$cnt=120; $id=0; $title='Температура подающего (С)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],5,5);  $date1[$cnt-$rr-1]=$data0[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=1; $title='Температура обратного (С)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],5,5);  $date1[$cnt-$rr-1]=$data1[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=4; $title='Расход подающего (т.)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],5,5);  $date1[$cnt-$rr-1]=$data4[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=5; $title='Расход обратного (т.)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],5,5);  $date1[$cnt-$rr-1]=$data5[$rr]; }
include ("highcharts/trend.php");
$cnt=120; $id=6; $title='Тепловая энергия (ГКал)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],5,5);  $date1[$cnt-$rr-1]=$data8[$rr]; }
include ("highcharts/trend.php");
?>
</td></tr>

</table>
</td></tr></table>

