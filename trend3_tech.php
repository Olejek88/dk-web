<title>Система учета  :: Показания узла учета</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr><td width="100%" bgcolor=#ffcf68 align=center><font class=tablz3>Показания узла учета (дневные значения)</font></td></tr>
<tr><td style="width:100%" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:100%" align=center>
<tr>
<td style="width:100%" valign=top>
    <table width="100%" cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
	<tr><td bgcolor=#ffcf68 colspan=1></td><td bgcolor=#ffcf68 colspan=7 align="center">тепло</td>
	<td bgcolor=#ffcf68 colspan=1 align="center">вода</td></tr>

	<tr><td bgcolor=#ffcf68 align=center width=120px><font class=tablz>дата</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tп,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tо,C</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Pп,МПа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Pо,МПа</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vпод,т.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vобр,т.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Qпотр,ГКал</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>V,м3</font></td></tr>
	<?php
		include("config/local5.php");
		mysql_close($i);
		$i = mysql_connect ($mysql_host_srv,$mysql_user_srv,$mysql_password_srv); 
		$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
		$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
		$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
		$e=mysql_select_db ($mysql_db_name_srv);

		 $today=getdate();
		 $dated=sprintf ("%d%02d%02d000000",$today["year"],$today["mon"],$today["mday"]);
		 $query = 'SELECT * FROM hours WHERE date<'.$dated.' ORDER BY date DESC';
		 $a = mysql_query ($query,$i);
		 if ($a) $uy = mysql_fetch_row ($a);			 
		 if ($uy)
		    {
		     sscanf ($uy[4],"%d-%d-%d %d:%d:%d",$ye,$mn,$dy,$n,$n,$n);
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
	
		 $query = 'SELECT * FROM hours WHERE type=1 AND device='.$_GET["id"].' ORDER BY date DESC LIMIT 20000';
		 $a = mysql_query ($query,$i);
		 if ($a) $uy = mysql_fetch_row ($a);			 
		 while ($uy)
		      	{
			 $x=201;
			 for ($tn=0; $tn<=200; $tn++) 
			 if ($uy[4]==$dat[$tn]) $x=$tn;
			 
			 if ($uy[2]==4 && $uy[7]==0) $data0[$x]=number_format($uy[5],3);
			 if ($uy[2]==4 && $uy[7]==1) $data1[$x]=number_format($uy[5],3);
			 if ($uy[2]==11 && $uy[7]==0) $data2[$x]=number_format($uy[5],3);
			 if ($uy[2]==11 && $uy[7]==1) $data3[$x]=number_format($uy[5],3);
			       	if ($uy[2]==16 && $uy[7]==0) $data4[$x]=number_format($uy[5],3);
			       	if ($uy[2]==16 && $uy[7]==1) $data5[$x]=number_format($uy[5],3);
			       	if ($uy[2]==13 && $uy[7]==2) $data6[$x]=number_format($uy[5],4);
			       	if ($uy[2]==11 && $uy[7]==5) $data7[$x]=number_format($uy[5],4);

		       	 $uy = mysql_fetch_row ($a);	     
		      	}

		 for ($tn=0; $tn<=200; $tn++) 
				{
		        	 print '<tr><td align=center bgcolor=#ffcf68 style="width:100px"><font class=top2>'.$dat[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data0[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data1[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data4[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data5[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data2[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data3[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data6[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data7[$tn].'</font></td>';
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
</tr>
<tr>
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
$cnt=120; $id=7; $title='Расход  (м3)';
for ($rr=0;$rr<$cnt;$rr++)	{ $data[$cnt-$rr-1]=substr($dat[$rr],5,5);  $date1[$cnt-$rr-1]=$data7[$rr]; }
include ("highcharts/trend.php");
?>
</td></tr>
</table>
</td></tr></table>

