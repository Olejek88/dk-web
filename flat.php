<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Система индивидуального учета энергоресурсов :: Индивидуальный листок потребления</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=900px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>

<tr>
<td>
<table width=900px cellpadding=0 cellspacing=0 bgcolor=#eeedd8 align=center>
	<tr>
	<td width=300px valign=top><table width=300px cellpadding=0 cellspacing=0 bgcolor=#eeedd8 align=center>
	<tr><td valign=top>
	<?php
	 include("config/local.php");
	 if ($_POST["id"]=='' || $_POST["id"]<1 || $_POST["id"]>210) $_POST["id"]=$_GET["id"]=1;
	 else $_GET["id"]=$_POST["id"];
 	 $square=42;
	 $ksquare=0.01;
	 $tarif1=537; $tarif2=4.86; $tarif3=7.55; $tarif4=1.14;
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

		$query = 'SELECT * FROM flats WHERE flat='.$_GET["id"];
		$a = mysql_query ($query,$i);  
		if ($a) $uy = mysql_fetch_row ($a);
		if ($uy) $square=$uy[8];

	 print '<table width=300px cellpadding=1 cellspacing=1 bgcolor=#eeedd8 align=center valign=top>';
 	 print '<tr><td><font class=prnt>Абонент: '.$uy[5].'<br>Квартира №'.$uy[1].' ';
	 print '<form name="find" method=post action="index.php?sel=flat&obj='.$_GET["obj"].'">
 	 <font class="prnt">Выбрать <input name="id" size=3 class=tablz style="height:16px; padding-top:0"><input border=0 src="files/b.gif" type=image width=1 height=1>
	 </form></font></td></tr>';
 	 print '<tr><td><font class=prnt>Общая площадь '.$uy[8].' кв.м.</font></td></tr>';
 	 print '<tr><td><font class=prnt>Количество комнат '.$uy[3].'</font></td></tr>';
 	 print '<tr><td><font class=prnt>Количество жильцов '.$uy[10].'</font></td></tr>';
 	 print '<tr><td><font class=prnt>Тариф на отопление 749руб./Гкал</font></td></tr>';
 	 print '<tr><td><font class=prnt>Тариф на электроэнергию 1.31руб./кВт.ч</font></td></tr>';
 	 print '<tr><td><font class=prnt>Тариф на водоснабжение 7.55руб./м3</font></td></tr>';
 	 print '<tr><td><font class=prnt>Тариф на водоотведение 4.86руб./м3</font></td></tr>';
 	 print '</table></td></tr>';
	?>
	</td></tr>
	<?php print '<tr><td><img border=0 width=300 height=300 src="charts/pieplot.php?id='.$_GET["id"].'&obj='.$_GET["obj"].'"></td></tr>'; ?>
	</table></td>
	<td width=590px><table width=590px cellpadding=0 cellspacing=0 bgcolor=#eeedd8 align=center valign="top">
	<?php
		if ($is_2ip) print '<tr><td><img border=0 width=590 height=130 src="charts/barplots7.php?flat='.$_GET["id"].'&src=6&obj='.$_GET["obj"].'"></td></tr>';
		if ($is_2ip) print '<tr><td><img border=0 width=590 height=130 src="charts/barplots7.php?flat='.$_GET["id"].'&src=5&obj='.$_GET["obj"].'"></td></tr>';
		print '<tr><td><img border=0 width=590 height=130 src="charts/barplots7.php?flat='.$_GET["id"].'&src=13&obj='.$_GET["obj"].'"></td></tr>';
		if ($is_mee) print '<tr><td><img border=0 width=590 height=130 src="charts/barplots7.php?flat='.$_GET["id"].'&src=2&obj='.$_GET["obj"].'"></td></tr>';
	?>
	</table></td>
	</tr>
</table>
</td>
</tr>
<tr><td>
	<table width=790px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center>
		<tr><td bgcolor=#eeedd8 align=center width=100px rowspan=2><font class=tablz>Месяц</font></td>
		<td bgcolor=#eeedd8 align=center colspan=3><font class=tablz>Тепловая энергия, ГКал</font></td>
		<td bgcolor=#eeedd8 align=center colspan=3><font class=tablz>ХВС</font></td>
		<td bgcolor=#eeedd8 align=center colspan=3><font class=tablz>ГВС</font></td>
		<td bgcolor=#eeedd8 align=center colspan=3><font class=tablz>Электроэнергия</font></td>
		<td bgcolor=#eeedd8 align=center width=100px rowspan=2><font class=tablz>Сумма (факт./норм.)</font></td>
		</tr>
		<tr><td bgcolor=#e8e8e8 align=center><font class=tablz>инд.</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>общ.</font></td>
		<td bgcolor=#ffcf68 align=center><font class=tablz>нор.</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>инд.</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>общ.</font></td>
		<td bgcolor=#ffcf68 align=center><font class=tablz>нор.</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>инд.</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>общ.</font></td>
		<td bgcolor=#ffcf68 align=center><font class=tablz>нор.</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>инд.</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>общ.</font></td>
		<td bgcolor=#ffcf68 align=center><font class=tablz>нор.</font></td></tr>
	 <?php
		$query = 'SELECT SUM(square),SUM(rnum) FROM flats';
		$a = mysql_query ($query,$i);  
		if ($a) $uy = mysql_fetch_row ($a);
		if ($uy) { $ss=$uy[0]; $srnum=$uy[1]; }
		$ksquare=$square/$ss;
	
	       $today=getdate ();
		//if ($today["mon"]>1) $today["mon"]=$today["mon"]-1;
		//else { $today["mon"]=12; $today["year"]=$today["year"]-1; }
		
	       $cn=10; $tep=$tep1=$gvs=$gvs1=$hvs=$hvs1=$ee=$ee1=$sum1=0;
	       if ($_GET["id"]=='') $_GET["id"]=1;
  	       while ($cn)
	           {
		    $norm1=$norm2=$norm3=$norm4=$count=0;
		    if ($today["mon"]<10)  $today["mon"]='0'.$today["mon"];
	  	    $summa=0; $sm=$sums=0; $month=$today["mon"]; 
		    include ("time.inc");
		    $tim=$today["year"].$today["mon"].'01000000';
		    $mon=$today["mon"]+1;
		    $tim2=sprintf ("%d%02d01000000",$today["year"],$mon);

		    print '<tr><td bgcolor=#eeedd8 align=center width=100px><font class=tablz>'.$month.','.$today["year"].'</font></td>';

			// select input GVS
		    if  ($is_tekon)
			{
			 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND date>='.$tim.' AND date<'.$tim2.' AND flat=0 AND prm=12 AND source=5';
			 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);		    
			 if ($uy) $sgvs=$uy[0]; 
			}
  		    // select teplo flat
		    $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE type=2 AND prm=13 AND source=2 AND date>='.$tim.' AND date<'.$tim2.' AND value>0.01';	
		    $e = mysql_query ($query,$i);
		    if ($e) $ui = mysql_fetch_row ($e);
		    if ($ui[0]) { $sm=$ui[0]; $count=$ui[1]; }

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

		    $query = 'SELECT * FROM flats WHERE flat='.$_GET["id"];
	 	    $e = mysql_query ($query,$i);
		    $ui = mysql_fetch_row ($e);
	  	    $flat[$cn]=$ui[1]; $abn=$ui[5]; $square=$ui[8]; $cold[$cn]=number_format($ui[8]*0.0322*($today["mday"])/31,2);
		    $nab=$ui[10];
	 	    $norm1=($count/31)*0.0322*$square;

		    if (0)
			{		    
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
			}
		    if ($is_bit)
			{
			 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND flat='.$_GET["id"].' AND date>='.$tim.' AND date<'.$tim2;
			 $e = mysql_query ($query,$i);
		         if ($e) $ui = mysql_fetch_row ($e);	 	 
			 $data0[$cn]=$ui[0]/4168;
		        }
		    print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($data0[$cn],4).'</font></td>'; $tep+=$data0[$cn]; $tep1+=$data1[$cn]; $summa+=($data0[$cn]+$data1[$cn])*$tarif1;
		        // select sum teplo flat
			// select input teplo
		    print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($data1[$cn],2).'</font></td>';
		    print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($norm1,2).'</font></td>';

			// HVS
    		    $query = 'SELECT SUM(value) FROM data WHERE type=2 AND (prm=11 OR prm=12) AND source=6 AND date>='.$tim.' AND date<'.$tim2.' AND flat='.$_GET["id"];
		    //echo $query.'<br>';
	     	    $e = mysql_query ($query,$i); $rt=0;
	     	    if ($e) $ui = mysql_fetch_row ($e);
	     	    if ($ui) $rt=$ui[0];

                    print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($rt,3).'</font></td>';
	 	    $qvso1+=$rt;

		        // select sum HVS flat
		    if ($is_2ip)
			{
			 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND (prm=11 OR prm=12) AND source=6 AND date>='.$tim.' AND date<'.$tim2.' AND flat>0';
		    	 //echo $query.'<br>';
		    	 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);		    
		    	 if ($uy) $steplo=$uy[0];
		    	}
			// select input HVS
		    if  ($is_2ip && $is_tekon)
			{
			 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND date>='.$tim.' AND date<'.$tim2.' AND flat=0 AND prm=12 AND source=6';
		    	 //echo $query.'<br>';
		    	 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);
		    	 //echo $uy[0].' '.$steplo.'<br>';	    
		    	 if ($uy) {  if ($steplo>0) $obsh=($uy[0]-$sgvs-$steplo)*($rt/$steplo); else $obsh=0; if ($obsh<0) $obsh=0; $qvs1+=$obsh; $summa+=($rt+$obsh)*$tarif2; }
		    	 else $obsh='-';
			}
		    $norm2=$nab*5.4;
		    $norm3=$nab*3.6;
		    $norm4=$nab*130;
		    print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($obsh,2).'</font></td>';
		    print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($norm2,2).'</font></td>';  $hvs+=$uy[0];

			// GVS		
    		    $query = 'SELECT SUM(value) FROM data WHERE type=2 AND (prm=11 OR prm=12) AND source=5 AND date>='.$tim.' AND date<'.$tim2.' AND flat='.$_GET["id"];	
	     	    $e = mysql_query ($query,$i); $rt=0;
	     	    if ($e) $ui = mysql_fetch_row ($e);
	     	    if ($ui) $rt=$ui[0];

                    print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($rt,3).'</font></td>';
	 	    $qvso2+=$rt;

		    // select sum GVS flat
		    if ($is_2ip)
			{
			 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND (prm=11 OR prm=12) AND source=5 AND date>='.$tim.' AND date<'.$tim2.' AND flat>0';
		    	 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);
		    	 //echo $query;
		    	 if ($uy) $steplo=$uy[0];
		    	}
		    // select input GVS
		    if  ($is_2ip && $is_tekon)
			{
			 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND flat=0 AND date>='.$tim.' AND date<'.$tim2.' AND prm=12 AND source=5';
		    	 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);	
		    	 //echo $uy[0].' '.$steplo.'<br>';	    	    
		    	 if ($uy) { $obsh=($uy[0]-$steplo)*$ksquare; if ($obsh<0) $obsh=0; $qvs2+=$obsh; $summa+=($rt+$obsh)*$tarif3; }
		    	 else $obsh='-';
			}		    
		    print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($obsh,2).'</font></td>';  
		    print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($norm3,2).'</font></td>'; $gvs+=$uy[0];


		    // EE
		    if ($is_mee)
			{
		 	 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND date>='.$tim.' AND date<'.$tim2.' AND flat='.$_GET["id"].' AND prm=2';
			 //echo $query;
			 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a); $rt=0;
	     	    	 if ($uy) { $rt=$uy[0]; $qee+=$rt; $summa+=$rt*$tarif4; }
	     	    	}
		    else { $qee+=0; $summa+=0; $rt=0; }
		    if  ($is_mee && $is_tekon)
			{
			 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND flat>0 AND date>='.$tim.' AND date<'.$tim2.' AND prm=2';
		    	 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);	
		    	 if ($uy) $steplo=$uy[0]; else $steplo=0;
		    	 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND flat=0 AND date>='.$tim.' AND date<'.$tim2.' AND prm=14';
		    	 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);	
		    	 if ($uy) { $obsh=($uy[0]-$steplo)*$nab/$srnum; if ($obsh<0) $obsh=0; $ee1+=$obsh; $summa+=($obsh)*$tarif4; }		    
			}
		    $obsh='-';
		    print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($rt,2).'</font></td>';
		    $sum_norm=$norm1*$tarif1+$norm2*$tarif2+$norm3*$tarif3+$norm4*$tarif4;
		    $snorm1+=$norm1; $snorm2+=$norm2; $snorm3+=$norm3; $snorm4+=$norm4;
		    print '<td bgcolor=#e8e8e8 align=center><font class=top2>'.number_format($obsh,2).'</font></td>';
		    print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($norm4,2).'</font></td>';
		    print '<td bgcolor=#e8e8e8 align=center><font class=top3>'.number_format($summa,2).' / '.number_format($sum_norm,2).'</font></td></tr>';
	            $sum1+=$summa;
	            $sum11+=$sum_norm;
		    if ($today[mon]>1) $today[mon]--;
		    else { $today[year]--; $today[mon]=12; }

		    $cn--;
		   }
	         print '<tr align=center><td bgcolor=#ffcf68><font class="zagl3">Итого: </font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($tep,4).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($tep1,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($snorm1,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($qvso1,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($qvs1,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($snorm2,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($qvso2,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($qvs2,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($snorm3,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($qee,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>-</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($snorm4,2).'</font></td>';
		 print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($sum1,2).' Экономия['.number_format($sum11-$sum1,2).']</font></td></tr>';

	 ?>

</td></tr>
</table>
</td></tr>
</table>

</body>
</html>
