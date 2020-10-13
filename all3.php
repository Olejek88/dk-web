<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ энергоэффективности Систем на разных объектах</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=800px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td valign=top>

<?php
include("config/local.php");
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
print '<table width=900px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center><tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Анализ энергоэффективности Систем на разных объектах</td></tr></table>';

$today=getdate();          
$today["year"]--; $today["mon"]=12;
if ($_GET["year"]=='') $ye=$today["year"]; else $ye=$_GET["year"];
if ($_GET["month"]=='') $mn='0'.$today["mon"]; else $mn=$_GET["month"];
if ($today["mday"]<20) { $today["mon"]--; $today["mday"]=31; }
for ($tm=1; $tm<=12; $tm++) $data2[$tm]=$data1[$tm]=$data0[$tm]=$data3[$tm]=$data4[$tm]=$data5[$tm]=$data6[$tm]=$data7[$tm]=$data8[$tm]=$data9[$tm]=$data10[$tm]=$data11[$tm]=$data12[$tm]=$data13[$tm]=$data14[$tm]=0;
$tm=$today["mon"];

for ($pm=1; $pm<=5; $pm++)
    {	 
	$it0=$it1=$it2=$it3=$it4=$it5=$it6=$it7=$it8=$it9=$it10=$it11=$it12=$it13=$it14=$it15=$it16=0;
	for ($b=0;$b<300;$b++) { $data02[$b]=$data01[$b]=$data04[$b]=$data03[$b]; }

	include("time.inc");
	print '<table width=900px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=left>
	<tr><td width=890 valign=top>
	<table width=890 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
	<tr>
	<td bgcolor=#ffcf68 align=center><font class=tablz>'.$dat[$cn].'</font></td>
	<td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>Информация</font></td>
	<td bgcolor=#ffcf68 align=center colspan=3><font class=tablz>Вход</font></td>
	<td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>Тепло</font></td>
	<td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>ХВС</font></td>
	<td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>ГВС</font></td>
	<td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>Электроэнергия</font></td>
	<td bgcolor=#ffcf68 align=center colspan=4<font class=tablz>Энергоэффективность</font></td>
	</tr>
	<tr>
	<td bgcolor=#ffcf68 align=center><font class=tablz>объект</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Жителей</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Площадь</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tср.под</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tср.обр</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vсум</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>общ.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>инд.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>общ.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>инд.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>общ.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>инд.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>общ.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>инд.</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Q/м3</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vхв/чел</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Vгв/чел</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>W/чел</font></td>
	</tr>';

	$query = 'SELECT * FROM build';
	$a = mysql_query ($query,$i); $cn=0;
	if ($a) $uy = mysql_fetch_row ($a);
	while ($uy)
	    {
		for ($b=0;$b<300;$b++) { $datad[$b]=$datad1[$b]=$datas[$b]=$datas1[$b]; }

	 	 $_GET["obj"]=$uy[2];
		 include("config/local.php");
		 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
		 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
		 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
		 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
		 $query = 'SELECT SUM(rnum),SUM(square) FROM flats';
		 $e = mysql_query ($query,$i);
		 if ($e) $ui = mysql_fetch_row ($e);  $data0[$cn]=$ui[0]; $data1[$cn]=$ui[1];
 		 $query = 'SELECT * FROM device WHERE type=2 AND ust=1';
		 $e = mysql_query ($query,$i);
		 if ($e) $ui = mysql_fetch_row ($e); $sum2=0;
		 while ($ui) 
			{
			 $query = 'SELECT SUM(rnum) FROM flats WHERE flat='.$ui[10];
			 $b = mysql_query ($query,$i);
			 if ($b) $ug = mysql_fetch_row ($b);  
			 $sum2+=$ug[0];	   
			 $ui = mysql_fetch_row ($e); 
			}
	         $tod=31;
		 if (!checkdate ($tm,31,$today["year"])) { $tod=30; }
		 if (!checkdate ($tm,30,$today["year"])) { $tod=29; }
		 if (!checkdate ($tm,29,$today["year"])) { $tod=28; }
		 $sts=sprintf("%d%02d01000000",$today["year"],$tm); $fns=sprintf("%d%02d01000000",$today["year"],$tm+1);

	         $query = 'SELECT COUNT(id) FROM device WHERE type=5';
		 $e = mysql_query ($query,$i); $ui = mysql_fetch_row ($e); 
		 if ($tm==$today["mon"]) $numm=($today["mday"]-1)*$ui[0]; else $numm=31*$ui[0];

		 $query = 'SELECT AVG(value) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=4 AND source=0';
		 $e = mysql_query ($query,$i); $ui = mysql_fetch_row ($e); 
		 $data2[$cn]=$ui[0]; 
		 $query = 'SELECT AVG(value) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=4 AND source=1';
		 $e = mysql_query ($query,$i); $ui = mysql_fetch_row ($e); 
		 $data3[$cn]=$ui[0];
		 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=12 AND source=0 AND value>0.1';
		 $e = mysql_query ($query,$i); $ui = mysql_fetch_row ($e); 
		 $data4[$cn]=$ui[0];
		 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=13 AND source=2 AND value>0.1';
		 $e = mysql_query ($query,$i); $ui = mysql_fetch_row ($e); 
		 $data5[$cn]=$ui[0];
	    	 $query = 'SELECT SUM(value) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=12 AND source=6';
		 $e = mysql_query ($query,$i); $ui = mysql_fetch_row ($e); $data7[$cn]=$ui[0];
		 $query = 'SELECT SUM(value) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=12 AND source=5';
		 $e = mysql_query ($query,$i); $ui = mysql_fetch_row ($e); $data9[$cn]=$ui[0];
		 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=14 AND value>0.1';
		 $e = mysql_query ($query,$i); $ui = mysql_fetch_row ($e); 
		 $data11[$cn]=$ui[0];
		
	         $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM prdata WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND prm=13 AND value>0';
		 $e = mysql_query ($query,$i);
		 $ui = mysql_fetch_row ($e); 
		 $data6[$cn]=($ui[0]/4184); 

	     	 $query = 'SELECT * FROM device WHERE type=2';
		 $e = mysql_query ($query,$i); if ($e) $ui = mysql_fetch_row ($e); $cm=0;
		 while ($ui) { $dev[$cm]=$ui[1];  $datas[$cm]=$datad[$cm]=$datas1[$cm]=$datad1[$cm]=-1; $cm++; $ui = mysql_fetch_row ($e); }
	
		 $query = 'SELECT * FROM prdata WHERE type=2 AND (prm=8 OR prm=6) AND date<'.$sts.' ORDER BY date DESC LIMIT 10000';
		 $e = mysql_query ($query,$i); if ($e) $ui = mysql_fetch_row ($e);
		 while ($ui)
			{ 
			 for ($b=0;$b<$cm;$b++) 
				{
				 if ($ui[2]==8) if ($dev[$b]==$ui[1] && $datas[$b]<0) $datas[$b]=$ui[5];
				 if ($ui[2]==6) if ($dev[$b]==$ui[1] && $datas1[$b]<0) $datas1[$b]=$ui[5];
				}
			 $ui = mysql_fetch_row ($e);
			}
		 for ($b=0;$b<$cm;$b++) { $data01[$cn]+=$datas[$b]; $data03[$cn]+=$datas1[$b]; }
		 $query = 'SELECT * FROM prdata WHERE type=2 AND (prm=8 OR prm=6) AND date>='.$sts.' AND date<'.$fns.' ORDER BY date DESC';
		 $e = mysql_query ($query,$i); if ($e) $ui = mysql_fetch_row ($e);
		 while ($ui)
			{ 
			 if ($ui[5]>0) 
			 for ($b=0;$b<$cm;$b++)
				{
				 if ($ui[2]==8) if ($dev[$b]==$ui[1] && $datad[$b]<0) $datad[$b]=$ui[5];
				 if ($ui[2]==6) if ($dev[$b]==$ui[1] && $datad1[$b]<0) $datad1[$b]=$ui[5];
				}
			 $ui = mysql_fetch_row ($e);
			}
		 for ($b=0;$b<$cm;$b++) { $data02[$cn]+=$datad[$b]; $data04[$cn]+=$datad1[$b]; }
		 if ($data02[$cn]-$data01[$cn]>0) $data8[$cn]=$data02[$cn]-$data01[$cn];
		 if ($data04[$cn]-$data03[$cn]>0) $data10[$cn]=$data04[$cn]-$data03[$cn];

		 $query = 'SELECT * FROM device WHERE type=4';
		 $e = mysql_query ($query,$i); if ($e) $ui = mysql_fetch_row ($e); $cm=0;
		 while ($ui) { $dev[$cm]=$ui[1];  $datas[$cm]=$datad[$cm]=-1; $cm++; $ui = mysql_fetch_row ($e); }

		 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=2 AND date>='.$sts.' AND date<'.$fns.' ORDER BY date';
		 $e = mysql_query ($query,$i); if ($e) $ui = mysql_fetch_row ($e);
		 while ($ui)
			{ 
			 for ($b=0;$b<$cm;$b++) 
			 if ($dev[$b]==$ui[1] && $datas[$b]<0) $datas[$b]=$ui[5];
			 $ui = mysql_fetch_row ($e);
			}                                                                                                                                                     
		 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=2 AND date>='.$sts.' AND date<'.$fns.' ORDER BY date DESC';
		 $e = mysql_query ($query,$i); if ($e) $ui = mysql_fetch_row ($e);
		 while ($ui)
			{ 
			 if ($ui[5]>0) for ($b=0;$b<$cm;$b++)
			 if ($dev[$b]==$ui[1] && $datad[$b]<0) $datad[$b]=$ui[5];
			 $ui = mysql_fetch_row ($e);
			}
		 for ($b=0;$b<$cm;$b++) if ($datas[$b]>0) if ($datad[$b]>$datas[$b]) $data01[$cn]+=$datas[$b];
		 for ($b=0;$b<$cm;$b++) if ($datad[$b]>0) $data02[$cn]+=$datad[$b];
		 if ($data02[$cn]-$data01[$cn]>0) $data12[$cn]=$data02[$cn]-$data01[$cn];
		 $data13[$cn]=$data5[$cn]/$data1[$cn];
		 $data14[$cn]=$data7[$cn]/$data0[$cn];
		 $data15[$cn]=$data9[$cn]/$data0[$cn];
		 $data16[$cn]=$data11[$cn]/$data0[$cn];

		 print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>'.$uy[1].'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data0[$cn],0).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data1[$cn],1).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data2[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data3[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data4[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data5[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data6[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data7[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data8[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data9[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data10[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data11[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data12[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data13[$cn],3).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data14[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data15[$cn],2).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data16[$cn],2).'</font></td></tr>';
	         $it0+=$data0[$cn]; $it1+=$data1[$cn]; $it2+=$data2[$cn]; $it3+=$data3[$cn]; 
	         $it4+=$data4[$cn]; $it5+=$data5[$cn]; $it6+=$data6[$cn]; $it7+=$data7[$cn]; 
	         $it8+=$data8[$cn]; $it9+=$data9[$cn]; $it10+=$data10[$cn]; $it11+=$data11[$cn]; 
	         $it12+=$data12[$cn]; $it13+=$data13[$cn]; $it14+=$data14[$cn]; $it15+=$data15[$cn]; $it16+=$data16[$cn];

		$uy = mysql_fetch_row ($a);
	  }
	 print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>Итого</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$it0.'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$it1.'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it2,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it3,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it4,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it5,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it6,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it7,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it8,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it9,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it10,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it11,1).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it12,1).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it13,3).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it14,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it15,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($it16,2).'</font></td></tr>';
	 print '</table></td></tr></table><br>';

	if ($tm>1) $tm--;
	else { $tm=12; $today["year"]--; }
	$cn++;
     }
?>
</table>
</td></tr></table>
</body>
</html>                 