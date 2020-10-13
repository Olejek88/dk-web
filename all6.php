<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ показаний по ХВС, ГВС по всем квартирам</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
 $query = 'SELECT * FROM build WHERE build_id='.$_GET["obj"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $build=$uy[1];

 $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
      {
       $dev2ip[$uy[10]]=$uy[1];
       $ust[$uy[10]]=$uy[21];
       $uy = mysql_fetch_row ($a);
      }
 $query = 'SELECT * FROM device WHERE type=4 ORDER BY flat';
 $a = mysql_query ($query,$i); $count=1;
 $uy = mysql_fetch_row ($a);
 while ($uy)
      {
       $devmee[$uy[10]]=$uy[1]; $count++;
       $uy = mysql_fetch_row ($a);
      }

 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i); $count=1;
 $uy = mysql_fetch_row ($a);
 while ($uy)
      {
       $name[$count]=$uy[16]; $nab[$count]=$uy[10]; $count++;
       $uy = mysql_fetch_row ($a);
      }

 $today=getdate (); //if ($today["mon"]>1) $today["mon"]--;
 $cn=6; $tep=$tep1=$gvs=$gvs1=$hvs=$hvs1=$ee=$ee1=$sum1=0;
 if ($_GET["id"]=='') $_GET["id"]=1;
 print '<table width=1190px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center><tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Распределение и анализ потребления холодной и горячей воды по объекту ул.'.$build.'</td></tr></table>';
 print '<table width=1190px cellpadding=0 cellspacing=0 bgcolor=#ffffff align=center><tr><td valign=top>';
 print '<table width=590px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center><tr><td bgcolor=#ffcf68 align=center width=160px><font class=tablz>Квартира</font></td>';
 while ($cn)
      {
       if ($today["mon"]<10)  $today["mon"]='0'.$today["mon"];
       $summa=0; $sm=$sums=0; $month=$today["mon"]; 
       include ("time.inc");
       $st=$today["year"].$today["mon"].'01000000';
       $mon=$today["mon"]+1;
       if ($mon<10) $fn=$today["year"].'0'.$mon.'01000000';
       else $fn=$today["year"].$mon.'01000000';

       if ($today[mon]>1) $today[mon]--;
       else { $today[year]--; $today[mon]=12; }
       print '<td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>'.$month.'</font></td>';
       $dat[$cn]=$month;
       $cn--;
      }
 print '<td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>Итого</font></td></tr>';
 
 print '<tr><td bgcolor=#ffcf68 align=center width=160px><font class=tablz>'.$today["year"].'</font></td>';
 for ($cn=1;$cn<=7;$cn++) print '<td bgcolor=#eeedd8 align=center><font class=tablz>хвс</font></td><td bgcolor=#eeedd8 align=center><font class=tablz>гвс</font></td>';
 print '</tr>';
 $cn=6;
 $today=getdate();  //if ($today["mon"]>1) $today["mon"]--;
 while ($cn)
      {
        if ($today["mon"]<10)  $today["mon"]='0'.$today["mon"];
        $summa=0; $sm=$sums=0; $month=$today["mon"]; 
        include ("time.inc");
        $st=$today["year"].$today["mon"].'01000000';
        $mon=$today["mon"]+1;
        if ($mon<10) $fn=$today["year"].'0'.$mon.'01000000';
        else $fn=$today["year"].$mon.'01000000';

        if ($today[mon]>1) $today[mon]--;
        else { $today[year]--; $today[mon]=12; }

	if ($is_tekon)
		{
	 	$query = 'SELECT * FROM data WHERE type=4 AND prm=12 AND flat=0 AND date='.$st;
		$e = mysql_query ($query,$i);
		if ($e) $ui = mysql_fetch_row ($e);
		while ($ui)
		      {	
			if ($ui[8]==12 && $ui[6]==6) $sgvs[$cn]=$ui[3];
			if ($ui[8]==12 && $ui[6]==5) $shvs[$cn]=$ui[3];
		        $ui = mysql_fetch_row ($e);
		      } 
		}

 	$query = 'SELECT * FROM data WHERE type=2 AND prm=12 AND (source=5 OR source=6) AND date>='.$st.' AND date<='.$fn.' AND value>0 ORDER BY date';
	$e = mysql_query ($query,$i);
	if ($e) $ui = mysql_fetch_row ($e);
	while ($ui)
	      {
		if ($ui[6]==6)
		for ($ll=1;$ll<=$count;$ll++) 
		if ($ll==$ui[4]) 
			{
			 $k2ipg[$cn][$ll]+=$ui[3];
			 break;
			}

		if ($ui[6]==5)
		for ($ll=1;$ll<=$count;$ll++) 
		if ($ll==$ui[4]) 
    			{
			 $k2iph[$cn][$ll]+=$ui[3];
			 break;
    			}
	        $ui = mysql_fetch_row ($e);
	      } 
	 $cn--;
	}

 for ($flat=1;$flat<$count;$flat++)
         {	  
	  $ssum0=$ssum1=0;
	  if ($ust[$flat]==0) print '<tr><td bgcolor=#ffcf68 align=left><font class=tablz>['.$flat.']</font><font class=top5>'.$name[$flat].'</font></td>'; 
	  else print '<tr><td bgcolor=#ffffff align=left><font class=tablz>['.$flat.']</font><font class=top5> н/у</font></td>'; 
	  for ($cn=6;$cn>0;$cn--)
		{
		  $akt0=$akt1=0;
		  $sum0=$k2iph[$cn][$flat];
		  $akt0=0;
		  if ($sum0<0 && $sum0>10000) $sum0=0; $ssum0+=$sum0;

		  $sum1=$k2ipg[$cn][$flat];
		  $akt1=0;
		  if ($sum1<0 && $sum1>10000) $sum1=0; $ssum1+=$sum1;

		  $hnum[$cn]+=$sum0;
		  $gnum[$cn]+=$sum1;

		  if ($akt0==1) print '<td align=center bgcolor=#ffffff><font class=top2>-</font></td>';
		  else print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($sum0,2).'</font></td>';
		  if ($akt1==1) print '<td align=center bgcolor=#ffffff><font class=top2>-</font></td>'; 
		  else print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($sum1,2).'</font></td>';
		}
	  $data1[$flat]=$ssum0;
	  $data2[$flat]=$ssum1;
	  print '<td align=center bgcolor=#ffcf68><font class=top2>'.number_format($ssum0,2).'</font></td>';
	  print '<td align=center bgcolor=#ffcf68><font class=top2>'.number_format($ssum1,2).'</font></td></tr>';
	}
  print '<tr><td bgcolor=#ffcf68 align=left><font class=tablz>Итого: </font></td>'; 
  for ($cn=6;$cn>0;$cn--)
	{
	  print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($hnum[$cn],0).'</font></td>';
	  print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($gnum[$cn],0).'</font></td>';
	  $sshv+=$hnum[$cn]; $ssgv+=$gnum[$cn]; $sshv1+=$shvs[$cn]; $ssgv1+=$sgvs[$cn];
	}

 print '<td align=center bgcolor=#ffffff><font class=tablz>'.number_format($sshv,0).'</font></td><td align=center bgcolor=#ffffff><font class=tablz>'.number_format($ssgv,0).'</font></td></tr>';
 print '<tr><td bgcolor=#ffcf68 align=left><font class=tablz>Вход: </font></td>'; 
 for ($cn=6;$cn>0;$cn--)
	{
	  print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($sgvs[$cn]-$shvs[$cn],0).'</font></td>';
	  print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($shvs[$cn],0).'</font></td>';
	}
 print '<td align=center bgcolor=#ffffff><font class=tablz>'.number_format($ssgv1-$sshv1,0).'</font></td><td align=center bgcolor=#ffffff><font class=tablz>'.number_format($sshv1,0).'</font></td></tr>';

 for ($yy=1;$yy<=10;$yy++)
	{
	 $tmax=1;
	 for ($flat=1;$flat<$count;$flat++)
	 if ($data1[$flat] > $datas1[$yy]) 
		{ 
		 $datas1[$yy]=$data1[$flat]; 
		 $fl1[$yy]=$flat; 
		 $tmax=$flat; 
		}
	 $data1[$tmax]=0;
	 $tmax=1;
	 for ($flat=1;$flat<$count;$flat++)
	 if ($data2[$flat] > $datas2[$yy]) { $datas2[$yy]=$data2[$flat]; $fl2[$yy]=$flat; $tmax=$flat; }
	 $data2[$tmax]=0;
	}
?>
</table></td>
<td valign=top width=600 bgcolor=#ffffff>
<table width=600px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<tr>
<?php
 $query = 'SELECT * FROM build WHERE build_id='.$_GET["obj"];
 $a = mysql_query ($query,$i);
 if ($a) $uy = mysql_fetch_row ($a);
 if ($uy[4]) 
 for ($ent=1;$ent<=$uy[4];$ent++)
	{ 
	 print '<tr><td valign=top colspan=2><img src="charts/barplots1.php?ent='.$ent.'&obj='.$_GET["obj"].'&source=6" width=600 height=250></td></tr>';
	}
 for ($ent=1;$ent<=$uy[4];$ent++)
	{ 
	 print '<tr><td valign=top colspan=2><img src="charts/barplots1.php?ent='.$ent.'&obj='.$_GET["obj"].'&source=8" width=600 height=250></td></tr>';
	}
 print '<tr><td valign=top align=center colspan=2 bgcolor=#ffcf68><font class=tablz3>Распределение потребления по месяцам</font></td></tr>';
 print '<tr><td valign=top align=center bgcolor=#ffcf68><font class=tablz3>ХВС</font></td><td bgcolor=#ffcf68 valign=top align=center><font class=tablz3>ГВС</font></td></tr>';
 print '<tr><td valign=top><img src="charts/pieplot2.php?source=6&';
 for ($cn=6;$cn>0;$cn--) print 'dat'.$cn.'='.$dat[$cn].'&n'.$cn.'='.$hnum[$cn].'&';
 print '" width=300 height=250></td>';
 print '<td valign=top><img src="charts/pieplot2.php?source=8&';
 for ($cn=6;$cn>0;$cn--) print 'dat'.$cn.'='.$dat[$cn].'&n'.$cn.'='.$gnum[$cn].'&';
 print '"width=300 height=250></td></tr>';
 print '<tr><td valign=top align=center bgcolor=#ffcf68><font class=tablz3>Top10 ХВС</font></td><td valign=top align=center bgcolor=#ffcf68><font class=tablz3>Top10 ГВС</font></td></tr>';
 print '<tr><td valign=top><table width=300px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>';
 for ($yy=1;$yy<=10;$yy++)
	{
	 print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>'.$yy.'</font></td><td bgcolor=#eeeeee><font class=top2>['.$fl1[$yy].'] '.$name[$fl1[$yy]].'</font></td><td bgcolor=#ffcf68><font class=tablz>'.$datas1[$yy].'</font></td></tr>';
	} 
 print '</table></td><td valign=top><table width=300px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>';
 for ($yy=1;$yy<=10;$yy++)
	{
	 print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>'.$yy.'</font></td><td bgcolor=#eeeeee><font class=top2>['.$fl2[$yy].'] '.$name[$fl2[$yy]].'</font></td><td bgcolor=#ffcf68><font class=tablz>'.$datas2[$yy].'</font></td></tr>';
	} 
 print '</table></td></tr>'; 

 if ($is_tekon)
	{
	 print '<tr><td colspan=2 valign=top bgcolor=#ffcf68 align=center><font class=tablz3>Общедомовое потребление воды</font></td></tr>';
	 print '<tr><td colspan=2 valign=top>';
	 print '<table width=600px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>';
	 print '<tr><td valign=top><table width=150px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center>
	 <td bgcolor=#ffcf68 align=center><font class=tablz>дата</font></td> <td bgcolor=#ffcf68 align=center><font class=tablz>общ</font></td>
	 <td bgcolor=#ffcf68 align=center><font class=tablz>ХВС</font></td> <td bgcolor=#ffcf68 align=center><font class=tablz>ГВС</font></td></tr>';
	 $today=getdate();
	 if ($_GET["year"]=='') $ye=$today["year"]; else $ye=$_GET["year"];
	 if ($_GET["month"]=='') $mn=$today["mon"]; else $mn=$_GET["month"];
	 if ($mn>2) $ms=$mn-2; else $ms=1;
	 $x=0;
	 $dy=$today["mday"]-1; $fn=1;
	 for ($tn=$mn; $tn>=$ms; $tn--)
	 for ($tm=$dy; $tm>=$fn; $tm--)
	    {
	     $date1=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	     $dat[$x]=sprintf ("%02d-%02d-%d",$tm,$mn,$ye);
	     $query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND date='.$date1;
		$a = mysql_query ($query,$i);
		if ($a) $uy = mysql_fetch_row ($a);
		$data0=$data1='-';
		while ($uy)
		      {          
		       if ($uy[8]==12 && $uy[6]==6) $data10=number_format($uy[3],2);
		       if ($uy[8]==12 && $uy[6]==5) $data11=number_format($uy[3],2);
		       $uy = mysql_fetch_row ($a);	     
		      }
		if ($_GET["obj"]==1) $data00=$data10-$data11;
		else { $data00=$data10; $data10=$data10+$data11; }
		if ($data10!='')
			{
		        print '<tr><td align=center bgcolor=#ffcf68><font class=top2>'.$dat[$x].'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data10.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data00.'</font></td>';
			print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data11.'</font></td></tr>';
			}
	        if ($tm==$fn) $fn=$today["mday"];
		$x++; 
	        if ($tm==1)
		   {
			$mn--;
				$dy=31;
			if (!checkdate ($mn,31,$ye)) { $dy=30; }
			if (!checkdate ($mn,30,$ye)) { $dy=29; }
			if (!checkdate ($mn,29,$ye)) { $dy=28; }
		    }
	    }
	 print '</table></td>';                                                   
	 print '<td valign=top><img src="charts/barplots3.php"><br><img src="charts/xyplot7.php?obj='.$_GET["obj"].'&type=5&size=450" width=450 height=220><br>
	 <img src="charts/mix4.php?type=1&size=450&obj='.$_GET["obj"].'" width=450 height=220><br><img src="charts/mix4.php?type=2&size=450&obj='.$_GET["obj"].'" width=450 height=220></td></tr>'; 
	 print '</table></td></tr>';
	}
?>
</table>
</td></tr>
</table>
</td>
</tr></table>
