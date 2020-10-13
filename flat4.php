<?php print '<title>Данные потребления всех ресурсов по квартире '.$_POST["id"].'</title>'; ?>
<table width=990px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td><table width=990px cellpadding=0 cellspacing=0 bgcolor=#eeedd8 align=center>
<tr><td width=990px valign=top><table width=990px cellpadding=0 cellspacing=0 bgcolor=#eeedd8 align=center>
<tr><td valign=top>
<?php
 include("config/local.php");
 if ($_POST["id"]=='' || $_POST["id"]<1 || $_POST["id"]>210) $_POST["id"]=$_GET["id"];
 else $_GET["id"]=$_POST["id"];
 $square=42; $ksquare=0.01; $tarif1=537; $tarif2=4.86; $tarif3=7.55; $tarif4=1.14;

 $max=300;

 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = 'SELECT * FROM flats WHERE flat='.$_GET["id"];
 $a = mysql_query ($query,$i);  
 if ($a) $uy = mysql_fetch_row ($a);
 if ($uy) $square=$uy[8];
 $today=getdate(); 
 if ($_GET["year"]=='') $ye=$today["year"];
 else $ye=$_GET["year"];
 if ($_GET["month"]=='') $mn=$today["mon"];
 else $mn=$_GET["month"];
 $x=0; 
 if ($today["mday"]>2) $tm=$dy=$today["mday"]-1;
 else $tm=$dy=$today["mday"];
 for ($tn=1; $tn<=$max; $tn++)
	{		
	 $date1[$x]=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $dat[$x]=sprintf ("%02d-%02d-%02d 00:00:00",$ye,$mn,$tm);
	 $dats[$x]=sprintf ("%02d-%02d-%02d",$ye,$mn,$tm);
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

 $query = 'SELECT * FROM device WHERE type=2 AND flat='.$_GET["id"];
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e); $ip2=$ui[1];
 $query = 'SELECT * FROM device WHERE type=4 AND flat='.$_GET["id"];
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e); $mee=$ui[1];
 
 $query = 'SELECT * FROM dev_bit WHERE flat_number='.$_GET["id"];
 $b = mysql_query ($query,$i); $struts=0; $ors='';
 $ut = mysql_fetch_row ($b);
 while ($ut)
         {
	  $query = 'SELECT * FROM dev_irp WHERE strut='.$ut[9];
	  $e = mysql_query ($query,$i);
       	  if ($e) $ui = mysql_fetch_row ($e);
	  $st[$struts]=$ut[9];
	  $irp[$struts]=$ui[1];
	  $ors.=' OR device='.$irp[$struts];
	  $struts++;
	  $ut = mysql_fetch_row ($b); 
	 }

 $query = 'SELECT * FROM data WHERE flat=0 AND type=2 AND (prm=14 OR prm=13 OR prm=12)';
 $a = mysql_query ($query,$i); $x=max+1;
 if ($a) $uy = mysql_fetch_row ($a);
 while ($uy)
      {	
	$x=$max+3;
	for ($tn=0; $tn<$max; $tn++) 
	if ($uy[2]==$dat[$tn]) $x=$tn;
//                                                              echo $dat[$x].' '.$uy[3].'<br>';
       if ($uy[8]==14) { $data0[$x]+=$uy[3]; }
       if ($uy[8]==13 && $uy[6]==2) $data3[$x]=number_format($uy[3],2);
       if ($uy[8]==13 && $uy[6]==3) $data4[$x]=number_format($uy[3],2);
       if ($uy[8]==12 && $uy[6]==6) $data2[$x]=number_format($uy[3],2);
       if ($uy[8]==12 && $uy[6]==5) $data1[$x]=number_format($uy[3],2);
       $uy = mysql_fetch_row ($a);	     
      }

 for ($tn=0; $tn<$max; $tn++) 
	{
	 $query = 'SELECT SUM(value) FROM data WHERE flat>0 AND type=2 AND prm=11 AND source=5 AND value>0 AND date='.$date1[$tn];
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);
	 if ($uy) $data102[$tn]=$uy[0];
	 //$query = 'SELECT SUM(value) FROM data WHERE flat>0 AND type=2 AND prm=11 AND source=6 AND value>0 AND date='.$date1[$tn];
	 //$a = mysql_query ($query,$i);
	 //if ($a) $uy = mysql_fetch_row ($a);
	 //if ($uy) $data101[$tn]=$uy[0];
	}

 $query = 'SELECT * FROM data WHERE flat='.$_GET["id"].' AND type=2 AND (prm=2 OR prm=13 OR prm=11) ORDER BY date DESC';
 $a = mysql_query ($query,$i); $x=max+1;
 if ($a) $uy = mysql_fetch_row ($a);
 while ($uy)
      {	
	for ($tn=0; $tn<$max; $tn++) 
	if ($uy[2]==$dat[$tn]) $x=$tn;
       if ($uy[8]==2 && $uy[6]==0) $data5[$x]=number_format($uy[3],1);
       if ($uy[8]==2 && $uy[6]==1) $data6[$x]=number_format($uy[3],1);
       if ($uy[8]==13 && $uy[6]==0) $data14[$x]=number_format($uy[3],2);
       if ($uy[8]==13 && $uy[6]==1) $data15[$x]=number_format($uy[3],2);
       if ($uy[8]==11 && $uy[6]==6) $data8[$x]=number_format($uy[3],2);
       if ($uy[8]==11 && $uy[6]==5) $data11[$x]=number_format($uy[3],2);
       if ($uy[8]==11 && $uy[6]==16) $data9[$x]=number_format($uy[3],2);
       if ($uy[8]==11 && $uy[6]==15) $data12[$x]=number_format($uy[3],2);
       $uy = mysql_fetch_row ($a);	     
      }

 $query = 'SELECT * FROM prdata WHERE (device='.$ip2.' OR device='.$mee.' '.$ors.') AND type=2 ORDER BY date DESC';   
 $a = mysql_query ($query,$i); $x=max+1;
 if ($a) $uy = mysql_fetch_row ($a);
 while ($uy)
      {	
	for ($tn=0; $tn<$max; $tn++) 
	if ($uy[4]==$dat[$tn]) $x=$tn;

       if ($uy[2]==2 && $uy[7]==0) $data7[$x]=number_format($uy[5],1);
       if ($uy[2]==8 && $uy[7]==0) $data10[$x]=number_format($uy[5],1);
       if ($uy[2]==6 && $uy[7]==0) $data13[$x]=number_format($uy[5],1);
//	echo $uy[1].' '.$uy[2].'<br>';
	for ($str=0;$str<$struts;$str++) if ($irp[$str]==$uy[1])
	if ($uy[2]==13)	$datas[$str][$x]=number_format($uy[5],2);	

       $uy = mysql_fetch_row ($a);	     
      }

 $query = 'SELECT * FROM flats WHERE flat='.$_GET["id"];
 $a = mysql_query ($query,$i);  
 if ($a) $uy = mysql_fetch_row ($a);
 print '<table width=990px cellpadding=1 cellspacing=1 bgcolor=#ffcf68 align=center valign=top>';
 print '<tr><td><font class="prnt">Абонент: '.$uy[16].'</font></td><td><font class="prnt">Квартира №'.$uy[1].'</font></td>';
 print '<td><font class="prnt">Общая площадь '.$uy[8].' кв.м.</font></td>';
 print '<td><font class="prnt">Количество жильцов '.$uy[10].'</font></td></tr>';
 print '</table></td></tr>';
 print '<tr><td>
	<table width=990px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center>
		<tr><td bgcolor=#eeedd8 align=center width=100px rowspan=2><font class=tablz>Дата</font></td>
		<td bgcolor=#eeedd8 align=center colspan=5><font class=tablz>Вход</font></td>
		<td bgcolor=#eeedd8 align=center colspan=3><font class=tablz>Электроэнергия</font></td>
		<td bgcolor=#eeedd8 align=center colspan=3><font class=tablz>ХВС</font></td>
		<td bgcolor=#eeedd8 align=center colspan=3><font class=tablz>ГВС</font></td>
		<td bgcolor=#eeedd8 align=center colspan=4><font class=tablz>Тепловая энергия (кКал)</font></td>
		<td bgcolor=#eeedd8 align=center colspan='.$struts.'><font class=tablz>ПО стоякам (кКал)</font></td>
		</tr>
		<tr>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>W1,2</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>Vгвс</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>Vхвс</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>Qсо</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>Qгвс</font></td>

		<td bgcolor=#e8e8e8 align=center><font class=tablz>Wабс</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>Wобщ</font></td>
		<td bgcolor=#ffcf68 align=center><font class=tablz>Wнак</font></td>

		<td bgcolor=#e8e8e8 align=center><font class=tablz>Vабс</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>Vобщ</font></td>
		<td bgcolor=#ffcf68 align=center><font class=tablz>Vнак</font></td>

		<td bgcolor=#e8e8e8 align=center><font class=tablz>Vабс</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>Vобщ</font></td>
		<td bgcolor=#ffcf68 align=center><font class=tablz>Vнак</font></td>

		<td bgcolor=#e8e8e8 align=center><font class=tablz>Qот</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>Qобщ</font></td>
		<td bgcolor=#e8e8e8 align=center><font class=tablz>Qгвс</font></td>
		<td bgcolor=#ffcf68 align=center><font class=tablz>Qсум</font></td>';
	for ($str=0;$str<$struts;$str++)
		print '<td bgcolor=#e8e8e8 align=center><font class=tablz>Q'.$st[$str].'</font></td>';
	  print '</tr>';

	for ($tn=0; $tn<$max; $tn++) 
		  {
		    $data4[$tn]=number_format($data4[$tn]-$data3[$tn],2);
		    $data2[$tn]=number_format($data2[$tn]-$data1[$tn],2);
		    if ($data102[$tn]>0) $data16[$tn]=number_format(1000*$data4[$tn]*($data11[$tn]/$data102[$tn]),2);
		    print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>'.$dats[$tn].'</font></td>';
		    print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($data0[$tn],1).'</font></td>'; 
		    //print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$data1[$tn].'('.number_format($data101[$tn],2).')</font></td>';
		    //print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$data2[$tn].'('.number_format($data102[$tn],2).')</font></td>';
		    print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$data1[$tn].'</font></td>';
		    print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$data2[$tn].'</font></td>';
		    print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$data3[$tn].'</font></td>';
		    print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$data4[$tn].'</font></td>';

		    print '<td bgcolor=#e8e8e8 align=center><font class=top3>'.$data5[$tn].'</font></td>';
		    print '<td bgcolor=#e8e8e8 align=center><font class=top3>'.$data6[$tn].'</font></td>';
		    print '<td bgcolor=#ffcf68 align=center><font class=top3>'.$data7[$tn].'</font></td>';

		    print '<td bgcolor=#e8e8e8 align=center><font class=top3>'.$data8[$tn].'</font></td>';
		    print '<td bgcolor=#e8e8e8 align=center><font class=top3>'.$data9[$tn].'</font></td>';
		    print '<td bgcolor=#ffcf68 align=center><font class=top3>'.$data10[$tn].'</font></td>';

		    print '<td bgcolor=#e8e8e8 align=center><font class=top3>'.$data11[$tn].'</font></td>';
		    print '<td bgcolor=#e8e8e8 align=center><font class=top3>'.$data12[$tn].'</font></td>';
		    print '<td bgcolor=#ffcf68 align=center><font class=top3>'.$data13[$tn].'</font></td>';

		    print '<td bgcolor=#e8e8e8 align=center><font class=top3>'.$data14[$tn].'</font></td>';
		    print '<td bgcolor=#e8e8e8 align=center><font class=top3>'.$data15[$tn].'</font></td>';
		    print '<td bgcolor=#e8e8e8 align=center><font class=top3>'.$data16[$tn].'</font></td>';
		    print '<td bgcolor=#ffcf68 align=center><font class=top3>'.number_format($data14[$tn]+$data15[$tn]+$data16[$tn],2).'</font></td>';
		    for ($str=0;$str<$struts;$str++) 
			{
			 //$datas[$str][$tn]=1000*$datas[$str][$tn]/4184;
			 print '<td bgcolor=#e8e8e8 align=center><font class=top3>'.number_format($datas[$str][$tn],2).'</font></td>';
			 $dts[$str]+=$datas[$str][$tn];
			}

		    print '</tr>';
		    $dt[0]+=$data0[$tn]; $dt[1]+=$data1[$tn]; $dt[2]+=$data2[$tn];
		    $dt[3]+=$data3[$tn]; $dt[4]+=$data4[$tn]; $dt[5]+=$data5[$tn];
		    $dt[6]+=$data6[$tn]; $dt[7]+=$data7[$tn]; $dt[8]+=$data8[$tn];
		    $dt[9]+=$data9[$tn]; $dt[10]+=$data10[$tn]; $dt[11]+=$data11[$tn];
		    $dt[12]+=$data12[$tn]; $dt[13]+=$data13[$tn]; $dt[14]+=$data14[$tn];
		    $dt[15]+=$data15[$tn]; $dt[16]+=$data16[$tn]; $dt[17]+=$data14[$tn]+$data15[$tn]+$data16[$tn];
		  }
         print '<tr align=center><td bgcolor=#ffcf68><font class="zagl3">Итого: </font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[0],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[1],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[2],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[3],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[4],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[5],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[6],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[7],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[8],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[9],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[10],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[11],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[12],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[13],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[14],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[15],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[16],2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dt[17],2).'</font></td>';
	 for ($str=0;$str<$struts;$str++) 
		 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($dts[$str],2).'</font></td>';
	 print '</tr>';
 ?>
</td></tr>
</table>
</td></tr>
</table>

</body>
</html>
