<title>Система учета индивидуального потребления энергоресурсов :: Анализ показаний по тепловой энергии</title>
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

 if ($_GET["date"]=='') $month=$today["mon"]-1;
 else $month=$_GET["date"];
 if ($month==0) $month=1;
 include("time.inc"); 

 if ($_GET["date"]=='') 
	{ 
	 $st=sprintf("%d%02d01000000",$today["year"],$today["mon"]);
	 $fn=sprintf("%d%02d01000000",$today["year"],$today["mon"]+1);
	 $_GET["date"]=$today["mon"];
	 $k=1; 
	}
 else 
	{ 
	 if ($_GET["year"]!='') $today["year"]=$_GET["year"];
	 if ($_GET["date"]!=$today["mon"]) $k=1;
	 else $k=$today["mday"]/31;
	 if ($_GET["st"]=='') $st=sprintf("%d%02d01000000",$today["year"],$month); else $st=$_GET["st"];
	 if ($_GET["fn"]=='') $fn=sprintf("%d%02d01000000",$today["year"],$month+1); else $fn=$_GET["fn"];
	}

 $query = 'SELECT * FROM dev_irp ORDER BY adr';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); 
 while ($uy)
        {
	 $query = 'SELECT SUM(value),AVG(value),COUNT(id) FROM prdata WHERE type=2 AND prm=13 AND value>20 AND device='.$uy[1].' AND date<'.$fn.' AND date>'.$st;
	 $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
	 //echo $uy[2].' '.$ui[2].' '.$ui[1].'<br>';
	 $irpdata[$uy[3]]=$ui[0]+(30-$ui[2])*$ui[1]; 
	 $sums+=$irpdata[$uy[3]];
	 $uy = mysql_fetch_row ($a); 
	}

 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE flat=0 AND type=2 AND prm=13 AND source=2 AND date<'.$fn.' AND date>'.$st;	
 //echo $query;
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 $sum=$ui[0]; $nday=$ui[1];
 if ($sum==0)
    {
     $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE flat=0 AND type=4 AND prm=13 AND date<'.$fn.' AND date>'.$st;	
     $e = mysql_query ($query,$i);
     if ($e) $ui = mysql_fetch_row ($e);
	{
	 $sum=$ui[0];
	}
    }
    
 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE flat=0 AND type=2 AND prm=13 AND source=3 AND date<'.$fn.' AND date>'.$st;	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 $sum4=$ui[0]; $qgvs=$sum4-$sum;
// echo $sum4.' '.$sum;

 $query = 'SELECT SUM(square),SUM(rnum) FROM flats';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $kk=$uy[0]; $kk1=$uy[1];

 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 while ($uy)
         {
	  $flat[$cm]=$uy[1]; $abn[$cm]=$uy[5]; $square[$cm]=$uy[8]; $cold=number_format($uy[8]*0.0322*$nday/31,2);
	  $nab=$uy[10]; $cold0+=$cold;

	  $query = 'SELECT * FROM dev_bit WHERE flat_number='.$uy[1];
	  $b = mysql_query ($query,$i);
	  $ut = mysql_fetch_row ($b); 
	  while ($ut)
	         {
		  $query = 'SELECT * FROM dev_irp WHERE strut='.$ut[9];
		  $e = mysql_query ($query,$i);
        	  if ($e) $ui = mysql_fetch_row ($e);
		  $data01[$cm]+=$irpdata[$ui[2]]/(9*4186);
		  $ut = mysql_fetch_row ($b); 
		 }	
	  if ($sum-($sums/4186)<0) $sums=$sum*4186;
	  $data001[$cm]=(($sum-$sums/4186))*($square[$cm]/$kk);
	  $data01[$cm]+=$data001[$cm];
	  $data00[$cm]=($sum)*($square[$cm]/$kk);

	  $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND (source=0 OR source=1) AND flat='.$uy[1].' AND date<'.$fn.' AND date>'.$st;	
//echo $query;
	  $e = mysql_query ($query,$i);
	  if ($e) $ui = mysql_fetch_row ($e);
	  $data02[$cm]=$ui[0]/4186; 

	  $query = 'SELECT SUM(value) FROM data WHERE value<4 AND type=2 AND prm=11 AND source=5 AND flat='.$uy[1].' AND date<'.$fn.' AND date>'.$st;	
	  $e = mysql_query ($query,$i);
	  if ($e) $ui = mysql_fetch_row ($e);
	  $data04[$cm]=$ui[0]; 

	  if ($data04[$cm]==0) $data04[$cm]=3.6*$uy[10]*$nday/30;
	  if ($data04[$cm]>50) $data04[$cm]=50;
	
	  $data03[$cm]=$cold; 
	  //echo $data00[$cm].' '.$data01[$cm].' '.$data02[$cm].' '.$data03[$cm].'<br>';
	  $data0+=$data00[$cm];
	  $data1+=$data01[$cm]; 
	  $data2+=$data02[$cm];
	  $data3+=$data03[$cm];
	  $data4+=$data04[$cm];
	  while (1)
		{
		 if ($data03[$cm]>($cold+$cold)) { $n1++; break; }
		 if ($data03[$cm]>$cold) { $n2++; break; }
		 $n0++; break;
		}
	  $sum0=$data03[$cm];
	  $cm++;	 
	  $datass[$uy[9]].='&s'.$cm.'='.number_format($data00[$cm-1],2).'&d'.$cm.'='.number_format($data01[$cm-1],2).'&n'.$cm.'='.number_format($data02[$cm-1],2);
	  $uy = mysql_fetch_row ($a);
	 }

 $pr0=number_format($n0*100/$cm,2);
 $pr1=number_format($n1*100/$cm,2);
 $pr2=number_format($n2*100/$cm,2);
 if ($cold0) $pr00=number_format(100*($cold0-$sum)/$cold0,2);
 else $pr00=0;
 print '<table width=1200px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center><tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Распределение и анализ потребления тепловой энергии по объекту ул.'.$build.' за '.$month.' '.$today["year"].'</td>';
 print '<td>';
 $tm=$today["mon"];
 $cn=8;
 while ($cn)
    {		 
     if ($tm==1) $dat='Январь';
     if ($tm==2) $dat='Февраль';
     if ($tm==3) $dat='Март';
     if ($tm==4) $dat='Апрель';
     if ($tm==5) $dat='Май';
     if ($tm==6) $dat='Июнь';
     if ($tm==7) $dat='Июль';
     if ($tm==8) $dat='Август';
     if ($tm==9) $dat='Сентябрь';
     if ($tm==10) $dat='Октябрь';
     if ($tm==11) $dat='Ноябрь';
     if ($tm==12) $dat='Декабрь';

     $sts=sprintf ("%d%02d00000000",$today["year"],$tm);
     $fns=sprintf ("%d%02d00000000",$today["year"],$tm+1);
     print '<td align=center><a href="index.php?sel=bit5&obj='.$_GET["obj"].'&st='.$sts.'&fn='.$fns.'&date='.$tm.'&year='.$today["year"].'"><font class=tablz3>'.$dat.'</font></td>';

     if ($tm==1) { $tm=12; $today["year"]--; }
     else $tm--;
     $cn--;
     $uy = mysql_fetch_row ($a);
    }
 print '</td></tr></table>';
 print '</tr></table>';
?>

<table width=600px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td valign=top>
<table width=300px cellpadding=2 cellspacing=1 bgcolor=#664466 align=right>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>цвет</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>причины</font></td></tr>
<tr><td bgcolor=#ee5544 align=center><font class=top5>критично</font></td><td bgcolor=#e8e8e8><font class=top5>- перерасход больше норматива на 50%</font></td></tr>
<tr><td bgcolor=#eeee33 align=center><font class=top5>внимание</font></td><td bgcolor=#e8e8e8><font class=top5>- больше норматива</font></td></tr>
<tr><td bgcolor=green align=center><font class=top5>нормально</font></td><td bgcolor=#e8e8e8><font class=top5>- показания корректны</font></td></tr>
</table>
</td><td valign=top>
<table width=300px cellpadding=2 cellspacing=1 bgcolor=#664466 align=left>
<?php
 $today=getdate();
 print '<tr><td bgcolor=#ffcf68 align=center><font class=top5>Дата</font></td><td bgcolor=#ffcf68><font class=tablz>'.$month.' '.$_GET["year"].'</font></td></tr>';
?>
<tr><td bgcolor=#eeeeee align=center><font class=top5>Норматив потребления тепловой энергии</font></td><td bgcolor=#e8e8e8><font class=top5>0.0322 ГКал в месяц на м3</font></td></tr>
<?php
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Жилая площадь дома</font></td><td bgcolor=#e8e8e8><font class=top5>'.$kk.' м3</font></td></tr>'; 
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Общее число жителей</font></td><td bgcolor=#e8e8e8><font class=top5>'.$kk1.' человека</font></td></tr>';
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Сумма потребления по дому</font></td><td bgcolor=#e8e8e8><font class=tablz>'.number_format($sum,2).'</font></td>';
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Нормативное потребление</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$cold0.'</font></td>';
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Экономия</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$pr00.'%</font></td>';
?>
</table>
</td>
<?php
print '<td valign=top><img src="charts/pieplot7.php?st='.$st.'&fn='.$fn.'" width=200 height=140></td>';
?>
<td valign=top>
<table width=150px cellpadding=2 cellspacing=1 bgcolor=#664466 align=right>
<?php
print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>цвет</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>количество</font></td></tr>
<tr><td bgcolor=#ee5544 align=center><font class=top5>критично</font></td><td bgcolor=#e8e8e8><font class=top5>'.$n1.' ('.$pr1.'%)</font></td></tr>
<tr><td bgcolor=#eeee33 align=center><font class=top5>внимание</font></td><td bgcolor=#e8e8e8><font class=top5>'.$n2.' ('.$pr2.'%)</font></td></tr>
<tr><td bgcolor=green align=center><font class=top5>нормально</font></td><td bgcolor=#e8e8e8><font class=top5>'.$n0.' ('.$pr0.'%)</font></td></tr>';
?>
</table>
</td>
</tr></table>

<br>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr>

<?php
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>S</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>тепло</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>S</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>тепло</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>S</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>тепло</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>S</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>тепло</font></td></tr>'; 

 print '<tr><td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '</tr>'; 

?>
</tr>

<?php
 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $flat=$ui[1]; $abn=$ui[5]; $square=$ui[8]; $cold=number_format($ui[8]*0.0322*(31)/31,2);
	  $nab=$ui[10]; $cold0+=$cold;
	  $sum0=$data02[$cm];
	 
	  if ($sum0<0) $sum0=0;
	  $ssum0+=$sum0;
	  if ($cm%4==0) print '<tr bgcolor=#e8e8e8>';

	  while (1)
		{
		 if ($sum0>($cold+$cold)) { $n1=1; print '<td align=center bgcolor=#ee5544><font class=top2>'.$flat.'</font></td>'; 
					   print '<td align=left bgcolor=#ee5544><font class=top2>'.$abn.'</font></td>';break; }
		 if ($sum0>$cold) { $n1=2; print '<td align=center bgcolor=#eeee33><font class=top2>'.$flat.'</font></td>'; 
					   print '<td align=left bgcolor=#eeee33><font class=top2>'.$abn.'</font></td>';break; }
		 print '<td align=center bgcolor=#eeeeee><font class=top2>'.$flat.'</font></td>'; 
		 print '<td align=left bgcolor=#eeeeee><font class=top2>'.$abn.'</font></td>';
		 $n1=0;
		 break;
		}
	 print '<td align=center bgcolor=#ffffff><font class=top2>'.$square.'</font></td>';
	 print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum0,4).'</font></td>';
	 print '<td align=center align=left bgcolor=#eeeeee><font class=top2>'.$cold.'</font></td>';
	 if ($cm%4==3) print '</tr>';
	 $cm++;
	 $uy = mysql_fetch_row ($a);
	}
 print '<td colspan=21 bgcolor=#e8e8e8></tr>'; 
 $pr0=number_format(100*($ssum0-$cold0)/$cold0,2);
 //print '<tr><td colspan=2 bgcolor=#ffcf68 align=center><font class=tablz>Итого</font></td><td bgcolor=#ffcf68 colspan=32><font class=tablz>'.number_format($ssum0,2).'/'.$cold0.' ('.$pr0.'%)</font></td></tr>'; 
?>
</table>
<br>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<?php
// print '<tr><td><img width=1200 height=350 src="charts/barplots15.php?type=1&n1=1&st='.$st.'&fn='.$fn.'&month='.$_GET["date"].'&obj='.$_GET["obj"].'"></td></tr>';
// print '<tr><td><img width=1200 height=350 src="charts/barplots15.php?type=1&n1=2&st='.$st.'&fn='.$fn.'&month='.$_GET["date"].'&obj='.$_GET["obj"].'"></td></tr>';
?>
</table>

</body>
</html>                                                        .,