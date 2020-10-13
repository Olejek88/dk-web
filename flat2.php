<?php print '<title>Сравнительные данные удельного потребления тепловой энергии по квартире '.$_POST["id"].'</title>'; ?>

<table width=790px cellpadding=0 cellspacing=1 bgcolor=#664466 align=center>
<tr><td valign=top>
<table width=790 bgcolor=#ffcf68 valign=top cellpadding=1 cellspacing=1>
<tr><td valign=top align=center><font class="tablz3"><?php print 'Сравнительные данные удельного потребления тепловой энергии по квартире '.$_POST["id"]; ?></font></td></tr>
</table>
<table width=780 bgcolor=#ffcf68 valign=top cellpadding=1 cellspacing=1>
<?php
if ($_POST["id"]=='' || $_POST["id"]<1 || $_POST["id"]>210) $_POST["id"]=1;
if ($_GET["id"]!='') $_POST["id"]=$_GET["id"];
$query = 'SELECT * FROM flats WHERE flat='.$_POST["id"];
$a = mysql_query ($query,$i);  
if ($a) $uy = mysql_fetch_row ($a);
if ($uy) { $square=$uy[8]; $name=$uy[16]; $pod=$uy[9]; $rnum=$uy[10]; }
$query = 'SELECT SUM(square) FROM flats';
$a = mysql_query ($query,$i);  
if ($a) $uy = mysql_fetch_row ($a);
if ($uy) { $sumsquare=$uy[0];}

print '<tr><td valign=top><font class="tablz3">Абонент: '.$name.'</font></td><td><font class="tablz3">Подъезд: '.$pod.'</font></td>';
print '<td valign=top><font class="tablz3">Площадь: '.$square.'м2</font></td><td><font class="tablz3">Прописано: '.$rnum.' человек</font></td></tr>';
?>
<tr><td valign=top colspan=4>
<table width=785px cellpadding=1 cellspacing=0 bgcolor=#ffffff align=center>
<tr><td>
	<table width=785px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center>
		<tr><td bgcolor=#eeedd8 align=center width=100px rowspan=2><font class=tablz3>Месяц</font></td>
		<td bgcolor=#eeedd8 align=center rowspan=2><font class=tablz3>Норматив</font></td>
		<td bgcolor=#eeedd8 align=center colspan=3><font class=tablz3>Фактические данные</font></td>
		</tr>
		<tr><td bgcolor=#ffcf68 align=center><font class=tablz3>среднее</font></td>
		<td bgcolor=#ffcf68 align=center><font class=tablz3>минимальное</font></td>
		<td bgcolor=#ffcf68 align=center><font class=tablz3>данные вашей квартиры</font></td></tr>
	 <?php
		$query = 'SELECT SUM(square) FROM flats';
		$a = mysql_query ($query,$i);  
		if ($a) $uy = mysql_fetch_row ($a);
		if ($uy) $ss=$uy[0];
		$ksquare=$square/$ss;
	
	        $today=getdate ();
		$today["mon"]=12;	
	        $cn=12; $cm=0; $tep=$tep1=$gvs=$gvs1=$hvs=$hvs1=$ee=$ee1=$sum1=0;
	        if ($_GET["id"]=='') $_GET["id"]=1;
  	        while ($cn)
	           {
		    if ($today["mon"]<10)  $today["mon"]='0'.$today["mon"];
	  	    $summa=0; $sm=$sums=0; $month=$today["mon"]; 
		    include ("time.inc");
		    $tim=$today["year"].$today["mon"].'01000000';
		    $mon=$today["mon"]+1;
		    if ($mon<10) $tim2=$today["year"].'0'.$mon.'01000000';
		    else $tim2=$today["year"].$mon.'01000000';

		    if ($today[mon]>1) $today[mon]--;
		    else { $today[year]--; $today[mon]=12; }
		    print '<tr><td bgcolor=#eeedd8 align=center><font class=tablz3>'.$month.'</font></td>';
		    print '<td bgcolor=#eeedd8 align=center><font class=tablz3>'.number_format(0.0322,4).'</font></td>';

			// select input GVS
		    $query = 'SELECT SUM(value) FROM data WHERE type=2 AND date>='.$tim.' AND date<'.$tim2.' AND flat=0 AND prm=12 AND source=5';
		    $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);		    
		    if ($uy) $sgvs=$uy[0]; 

			// select teplo flat
		    $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND source=2 AND date>='.$tim.' AND date<'.$tim2;	
		    $e = mysql_query ($query,$i);
		    if ($e) $ui = mysql_fetch_row ($e);
		    if ($ui[0]) $sm=$ui[0]; 
		    $query = 'SELECT COUNT(id) FROM device WHERE type=5';
		    $a = mysql_query ($query,$i);
	  	    $uy = mysql_fetch_row ($a); 

	 	    if ($cn==12) $numm=($today["mday"]-1);
	 	    else $numm=31;

		    $query = 'SELECT * FROM dev_irp ORDER BY adr';
		    $a = mysql_query ($query,$i);
		    $uy = mysql_fetch_row ($a); $sums=0;
		    while ($uy)
		        {
			 $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM prdata WHERE type=2 AND value>13 AND (prm=13 OR prm=11) AND device='.$uy[1].' AND date>='.$tim.' AND date<'.$tim2;
			 $e = mysql_query ($query,$i);
		         if ($e) $ui = mysql_fetch_row ($e);	 	 
			 $irpdata[$uy[2]]=$ui[0]; 
			 //echo $ui[0].'<br>';
			 if ($ui[1]<$numm) $irpdata[$uy[2]]+=($numm-$ui[1])*$ui[2];
			 //echo $numm.' '.$ui[0].' '.$ui[1].' '.$ui[2].' '.$irpdata[$uy[2]].'<br>';
			 $sums+=$irpdata[$uy[2]];
			 $uy = mysql_fetch_row ($a); 
			}
		    print '<td bgcolor=#eeedd8 align=center><font class=tablz3>'.number_format(($sm/$sumsquare),4).'</font></td>';
		    print '<td bgcolor=#eeedd8 align=center><font class=tablz3>'.number_format(($sm/$sumsquare)-0.3*($sm/$sumsquare),4).'</font></td>';

		    $query = 'SELECT * FROM flats WHERE flat='.$_GET["id"];
	 	    $e = mysql_query ($query,$i);
		    $ui = mysql_fetch_row ($e);
	  	    $flat[$cn]=$ui[1]; $abn=$ui[5]; $square=$ui[8]; $cold[$cn]=number_format($ui[8]*0.0322*($today["mday"])/31,2);
		    $nab=$ui[10];
	 	
		    $query = 'SELECT * FROM dev_bit WHERE flat_number='.$_GET["id"];
	 	    $b = mysql_query ($query,$i);
	  	    $ut = mysql_fetch_row ($b); $data0[$cn]=0;
	 	    while ($ut)
	         	{
		  	 $query = 'SELECT * FROM dev_irp WHERE strut='.$ut[9];
		  	 $e = mysql_query ($query,$i);
        	  	 if ($e) $ui = mysql_fetch_row ($e);
		  	 $data0[$cn]+=$irpdata[$ui[2]]/(10*4168);
			 //echo $irpdata[$ui[2]].'<br>';
		  	 $ut = mysql_fetch_row ($b); 
		 	}
	 	    //$data0[$cn]=(1000/$square)*$data0[$cn];		    
	  	    if (($sm-$sums/4168)>0) $data1[$cn]=(($sm-$sums/4168))*($square/$ss);
		    else $data1[$cn]=0;
		    $ind=$sums/4168;
		    //echo $sm.' '.$ind.'<br>';
	  	    if ($data1[$cn]<0) $data1[$cn]=0;

		    print '<td bgcolor=#e8e8e8 align=center><font class=tablz3>'.number_format(($data0[$cn]+$data1[$cn])/($square*0.8),4).'</font></td>'; 
		        // select sum teplo flat
			// select input teplo
		    //print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($data1[$cn],2).'</font></td>';
	            $data91.='&dat'.$cm.'='.$month.'&datas'.$cm.'='.number_format(($data0[$cn]+$data1[$cn])/($square*0.8),4).'&datad'.$cm.'='.number_format(($sm/$sumsquare),4);

		    $cn--; $cm++;
		   }
	    /*     print '<tr align=center><td bgcolor=#ffcf68><font class="zagl3">Итого: </font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($tep,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($tep1,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($qvso1,1).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($qvs1,1).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($qvso2,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($qvs2,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($qee,0).'</font></td>';		 
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>-</font></td></tr>';*/
	 ?>

</td></tr>
</table>
</td></tr></table>
</td></tr>
<tr><td valign=top colspan=4><img src="charts/barplots25.php?type=1&obj=<?php print $_GET["obj"].$data91;?>"></td></tr>
</table>
