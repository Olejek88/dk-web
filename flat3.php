<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Система индивидуального учета энергоресурсов :: Индивидуальное потребление ресурсов</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=900px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td>
<table width=900px cellpadding=0 cellspacing=0 bgcolor=#eeedd8 align=center>
<tr><td width=900px valign=top><table width=900px cellpadding=0 cellspacing=0 bgcolor=#eeedd8 align=center>
<tr><td valign=top>
<?php
 include("config/local.php");
 if ($_POST["id"]=='' || $_POST["id"]<1 || $_POST["id"]>210) $_POST["id"]=$_GET["id"];
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

 print '<table width=900px cellpadding=1 cellspacing=1 bgcolor=#ffcf68 align=center valign=top>';
 print '<tr><td><font class="prnt">Абонент: '.$uy[5].'</font></td><td><font class="prnt">Квартира №'.$uy[1].'</font></td>';
 print '<td><font class="prnt">Общая площадь '.$uy[8].' кв.м.</font></td>';
 print '<td><font class="prnt">Количество жильцов '.$uy[10].'</font></td></tr>';
 print '</table></td></tr>';
 print '<tr><td>';

 $query = 'SELECT SUM(square) FROM flats';
 $a = mysql_query ($query,$i);  
 if ($a) $uy = mysql_fetch_row ($a);
 if ($uy) $ss=$uy[0];
 $ksquare=$square/$ss;
 
 $today=getdate ();
 $get1.='type=1';
 $get2.='type=2';
 $get3.='type=3';
 $get4.='type=4';
 $cn=18; $tep=$tep1=$gvs=$gvs1=$hvs=$hvs1=$ee=$ee1=$sum1=0;
 if ($_GET["id"]=='') $_GET["id"]=1;
 while ($cn>=0)
       {
	$norm1=$norm2=$norm3=$norm4=$count=0;
	if ($today["mon"]<10)  $today["mon"]='0'.$today["mon"];
 	$summa=0; $sm=$sums=0; $month=$today["mon"]; 
	include ("time.inc");
	$tim=$today["year"].$today["mon"].'01000000';
	$mon=$today["mon"]+1;
	$tim2=sprintf ("%d%02d01000000",$today["year"],$mon);

	if ($today["mon"]==1) $dat='Январь';
	if ($today["mon"]==2) $dat='Февраль';
	if ($today["mon"]==3) $dat='Март';
	if ($today["mon"]==4) $dat='Апрель';
	if ($today["mon"]==5) $dat='Май';
	if ($today["mon"]==6) $dat='Июнь';
	if ($today["mon"]==7) $dat='Июль';
	if ($today["mon"]==8) $dat='Август';
	if ($today["mon"]==9) $dat='Сентябрь';
	if ($today["mon"]==10) $dat='Октябрь';
	if ($today["mon"]==11) $dat='Ноябрь';
	if ($today["mon"]==12) $dat='Декабрь';

	// select input GVS
	$query = 'SELECT SUM(value) FROM data WHERE type=2 AND date>='.$tim.' AND date<'.$tim2.' AND flat=0 AND prm=12 AND source=5';
	$a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);		    
	if ($uy) $sgvs=$uy[0]; 

	// select teplo flat
	$query = 'SELECT SUM(value),COUNT(id) FROM data WHERE type=2 AND prm=13 AND source=2 AND date>='.$tim.' AND date<'.$tim2.' AND value>0.1';	
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
	if (($sm-$sums/4168)>0) $data1[$cn]=(($sm-$sums/4168))*($square/$ss);
	else $data1[$cn]=0;
	$ind=$sums/4168;
	if ($data1[$cn]<0) $data1[$cn]=0;

	$get1.='&tm'.$cn.'='.$dat.'&x'.$cn.'n='.number_format($data0[$cn]+$data1[$cn],2);

	// HVS
    	$query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=11 AND source=6 AND date>='.$tim.' AND date<'.$tim2.' AND flat='.$_GET["id"];
	$e = mysql_query ($query,$i); $rt=0;
	if ($e) $ui = mysql_fetch_row ($e);
	if ($ui) $rt=$ui[0];

	// select sum HVS flat
	$query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=11 AND source=6 AND date>='.$tim.' AND date<'.$tim2.' AND flat>0';
	//echo $query.'<br>';
	$a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);		    
	if ($uy) $steplo=$uy[0];

	// select input HVS
	$query = 'SELECT SUM(value) FROM data WHERE type=2 AND date>='.$tim.' AND date<'.$tim2.' AND flat=0 AND prm=12 AND source=6';
	//echo $query.'<br>';
	$a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);
	//echo $uy[0].' '.$steplo.'<br>';	    
	if ($uy) {  if ($steplo>0) $obsh=($uy[0]-$sgvs-$steplo)*($rt/$steplo); else $obsh=0; if ($obsh<0) $obsh=0; $qvs1+=$obsh; $summa+=($rt+$obsh)*$tarif2; }
	else $obsh='-';

	$get2.='&tm'.$cn.'='.$dat.'&x'.$cn.'n='.number_format($rt+$obsh,2);

	// GVS		
    	$query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=11 AND source=5 AND date>='.$tim.' AND date<'.$tim2.' AND flat='.$_GET["id"];	
	$e = mysql_query ($query,$i); $rt=0;
	if ($e) $ui = mysql_fetch_row ($e);
	if ($ui) $rt=$ui[0];

	// select sum GVS flat
	$query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=11 AND source=5 AND date>='.$tim.' AND date<'.$tim2.' AND flat>0';
	$a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);
	//echo $query;
	if ($uy) $steplo=$uy[0];

	// select input GVS
	$query = 'SELECT SUM(value) FROM data WHERE type=2 AND flat=0 AND date>='.$tim.' AND date<'.$tim2.' AND prm=12 AND source=5';
	$a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);	
	//echo $uy[0].' '.$steplo.'<br>';	    	    
	if ($uy) { $obsh=($uy[0]-$steplo)*$ksquare; if ($obsh<0) $obsh=0; $qvs2+=$obsh; $summa+=($rt+$obsh)*$tarif3; }
	else $obsh='-';

	$get3.='&tm'.$cn.'='.$dat.'&x'.$cn.'n='.number_format($rt+$obsh,2);

	// EE
	$query = 'SELECT SUM(value) FROM data WHERE type=2 AND date>='.$tim.' AND date<'.$tim2.' AND flat='.$_GET["id"].' AND prm=2';
	//echo $query;
	$a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a); $rt=0;
	if ($uy) { $rt=$uy[0]; $qee+=$rt; $summa+=$rt*$tarif4; }

	//$query = 'SELECT SUM(value) FROM data WHERE type=2 AND flat>0 AND date>='.$tim.' AND date<'.$tim2.' AND prm=2';
	//$a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);	
	//if ($uy) $steplo=$uy[0]; else $steplo=0;

	//$query = 'SELECT SUM(value) FROM data WHERE type=2 AND flat=0 AND date>='.$tim.' AND date<'.$tim2.' AND prm=14';
	//$a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);	
	//if ($uy) { $obsh=($uy[0]-$steplo)*$nab/$srnum; if ($obsh<0) $obsh=0; $ee1+=$obsh; $summa+=($obsh)*$tarif4; }

	$get4.='&tm'.$cn.'='.$dat.'&x'.$cn.'n='.number_format($rt,2);

	if ($today[mon]>1) $today[mon]--;
	else { $today[year]--; $today[mon]=12; }
	$cn--;
       }
 print '<tr><td><a href="index.php?sel=flat4&id='.$_GET["id"].'&obj='.$_GET["obj"].'"><img border=0 width=890 height=300 src="charts/barplots31.php?'.$get1.'"></a></td></tr>';
 print '<tr><td><a href="index.php?sel=flat4&id='.$_GET["id"].'&obj='.$_GET["obj"].'"><img border=0 width=890 height=300 src="charts/barplots31.php?'.$get2.'"></a></td></tr>';
 print '<tr><td><a href="index.php?sel=flat4&id='.$_GET["id"].'&obj='.$_GET["obj"].'"><img border=0 width=890 height=300 src="charts/barplots31.php?'.$get3.'"></a></td></tr>';
 print '<tr><td><a href="index.php?sel=flat4&id='.$_GET["id"].'&obj='.$_GET["obj"].'"><img border=0 width=890 height=300 src="charts/barplots31.php?'.$get4.'"></a></td></tr>';
?>
</table></td></tr>
</td></tr></table>
</td></tr></table>

</body>
</html>
