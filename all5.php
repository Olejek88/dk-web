<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ показаний по электроэнергии, ХВС, ГВС и тепловой энергии по всем квартирам</title>
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

 if ($_GET["date"]=='') $month=$today["mon"];
 else $month=$_GET["date"];
 if ($_GET["year"]!='') $today["year"]=$_GET["year"];

 include("time.inc"); 
 if ($_GET["date"]=='') 
	{ 
	 $st=sprintf ("%d%02d01000000",$today["year"],$today["mon"]-1);
	 $fn=sprintf ("%d%02d01000000",$today["year"],$today["mon"]);
	 $month=$today["mon"]-1;
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

 $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
      {
       $dev2ip[$uy[10]]=$uy[1];
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
	$nab[$count]=$uy[10]; $count++;
       $uy = mysql_fetch_row ($a);
      }


 $query = 'SELECT * FROM prdata WHERE type=2 AND (prm=2 OR prm=6 OR prm=8 OR prm=13) AND date<'.$st.' AND value>0 ORDER BY date DESC LIMIT 10000';
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
      {
	if ($ui[2]==6) 
	for ($ll=1;$ll<=$count;$ll++)
	if ($n2ipg[$ll]<=0 && $dev2ip[$ll]==$ui[1]) $n2ipg[$ll]=$ui[5];
	if ($ui[2]==8) 
	for ($ll=1;$ll<=$count;$ll++)
	if ($n2iph[$ll]<=0 && $dev2ip[$ll]==$ui[1]) $n2iph[$ll]=$ui[5];
	if ($ui[2]==2) 
	for ($ll=1;$ll<=$count;$ll++)
	if ($nmee[$ll]<=0 && $devmee[$ll]==$ui[1]) $nmee[$ll]=$ui[5];
        $ui = mysql_fetch_row ($e);
      } 
 $query = 'SELECT * FROM prdata WHERE type=2 AND (prm=2 OR prm=6 OR prm=8 OR prm=13) AND date>'.$st.' AND date<'.$fn.' AND value>0 ORDER BY date DESC LIMIT 10000';
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
      {
	if ($ui[2]==6) 
	for ($ll=1;$ll<=$count;$ll++)
	if ($k2ipg[$ll]<=0 && $dev2ip[$ll]==$ui[1]) $k2ipg[$ll]=$ui[5];
	if ($ui[2]==8) 
	for ($ll=1;$ll<=$count;$ll++)
	if ($k2iph[$ll]<=0 && $dev2ip[$ll]==$ui[1]) $k2iph[$ll]=$ui[5];
	if ($ui[2]==2) 
	for ($ll=1;$ll<=$count;$ll++)
	if ($kmee[$ll]<=0 && $devmee[$ll]==$ui[1]) $kmee[$ll]=$ui[5];
        $ui = mysql_fetch_row ($e);
      } 

 print '<table width=1200px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center><tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Распределение и анализ потребления всех энергоресурсов по объекту ул.'.$build.' за '.$month.' '.$today["year"].'</td><td>';

 $today=getdate();
 $tm=$today["mon"];
 for ($pm=1; $pm<=9; $pm++)
    {	 
     $tod=31;
     if (!checkdate ($tm,31,$today["year"])) { $tod=30; }
     if (!checkdate ($tm,30,$today["year"])) { $tod=29; }
     if (!checkdate ($tm,29,$today["year"])) { $tod=28; }
     if ($tm==1) $dat='Январь';
     if ($tm==2) $dat='Февраль';
     if ($tm==3) $dat='Март';
     if ($tm==4) $dat='Апрель';
     if ($tm==5) $dat='Май';
     if ($tm==6) $dat='Июнь';
     if ($tm==7) $dat='Июль';
     if ($tm==8) $dat='Август';
     if ($tm==9) $dat='Сентябрь';
     if ($tm==10) $dat='Октябрь'; if ($tm==11) $dat='Ноябрь'; if ($tm==12) $dat='Декабрь';     
     $sts=sprintf("%d%02d00000000",$today["year"],$tm); $fns=sprintf("%d%02d00000000",$today["year"],$tm+1);
     print '<td align=center><a href="index.php?sel=all5&obj='.$_GET["obj"].'&st='.$sts.'&fn='.$fns.'&date='.$tm.'&year='.$today["year"].'"><font class=tablz3>'.$dat.'</font></td>';

     if ($tm>1) $tm--;
     else { $tm=12; $today["year"]--; }
     $uy = mysql_fetch_row ($a);
    }
 print '</td></tr></table>';

?>

<table width=1190px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td valign=top>
<table width=940px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center><tr>
<?php
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N[K]</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Ресурс</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N[K]</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Ресурс</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N[K]</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Ресурс</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N[K]</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Ресурс</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N[K]</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Ресурс</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '</tr>'; 
?>
</tr>

<?php
 $cm=0;
 for ($flat=1;$flat<$count;$flat++)
         {
	  $sum0=$sum1=$sum2=0;
	  if ($cm==0)
		{
		  $cold=number_format($nab[$flat]*5.4*$k,2); $cold0+=$cold;
		  if ($k2iph[$flat]>$n2iph[$flat]) $sum0=$k2iph[$flat]-$n2iph[$flat];
		  //echo $k2iph[$flat].' '.$n2iph[$flat].'<br>';
		  //else $sum0=$k2iph[$flat];
		  if ($sum0<0) $sum0=0; $ssum0+=$sum0;
		}
	  if ($cm==1)
		{
		  $hot=number_format($nab[$flat]*3.6*$k,2);
		  $hot0+=$hot;
		  if ($k2ipg[$flat]>$n2ipg[$flat]) $sum1=$k2ipg[$flat]-$n2ipg[$flat];
		  //echo $k2ipg[$flat].' '.$n2ipg[$flat].'<br>';
		  //else $sum1=$k2ipg[$flat];
		  if ($sum1<0) $sum1=0; $ssum1+=$sum1;
		}
	  if ($cm==2)
		{
		  $ee=number_format($nab[$flat]*130*$k,2);
		  $ee0+=$ee;
		  if ($kmee[$flat]>$nmee[$flat]) $sum2=$kmee[$flat]-$nmee[$flat];
		  //else $sum2=$kmee[$flat];
		  if ($sum2<0) $sum2=0; $ssum2+=$sum2;
		}

	  if ($flat%5==1) print '<tr bgcolor=#e8e8e8>';

          if ($cm==0) print '<td align=center bgcolor=#eeeeee rowspan=3><font class=top2>'.$flat.'['.$nab[$flat].']</font></td>';
	  if ($cm==0)
		{
		 if ($nab[$flat]==0 && $sum0>1) { $h1++; print '<td  align=left bgcolor=#ee80ee><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ХВС</font></td>'; }
		 else if ($sum0>($cold+$cold)) { $h2++; print '<td  align=left bgcolor=#ee5544><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ХВС</font></td>'; }
		 else if ($sum0>$cold) { $h3++; print '<td  align=left bgcolor=#eeee33><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ХВС</font></td>'; }
		 else if ($nab>0 && $sum0<0.1) { $h4++; print '<td  align=left bgcolor=#775577><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ХВС</font></td>'; }
		 else { $h0++; print '<td  align=left bgcolor=#eeeeee><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ХВС</font></td>'; }
		}	 
	  if ($cm==0) print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum0,2).'</font></td>';
	  if ($cm==0) print '<td align=center align=left bgcolor=#eeeeee><font class=top2>'.$cold.'</font></td>';

	  if ($cm==1)
		{
		 if ($nab[$flat]==0 && $sum1>1) { $g1++; print '<td  align=left bgcolor=#ee80ee><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ГВС</font></td>'; }
		 else if ($sum1>($hot+$hot)) { $g2++; print '<td  align=left bgcolor=#ee5544><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ГВС</font></td>'; }
		 else if ($sum1>$hot) { $g3++; print '<td  align=left bgcolor=#eeee33><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ГВС</font></td>'; }
		 else if ($nab>0 && $sum1<0.1) { $g4++; print '<td  align=left bgcolor=#775577><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ГВС</font></td>'; }
		 else { $g0++; print '<td  align=left bgcolor=#eeeeee><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ГВС</font></td>'; } 
		}	 
	  if ($cm==1) print '<td  align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum1,2).'</font></td>';
	  if ($cm==1) print '<td  align=center align=left bgcolor=#eeeeee><font class=top2>'.$hot.'</font></td>';

	  if ($cm==2)
		{
		 if ($nab[$flat]==0 && $sum2>1) { $n1++; print '<td  align=left bgcolor=#ee80ee><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ЭЭ</font></td>'; }
		 else if ($sum2>($ee+$ee)) { $n2++; print '<td  align=left bgcolor=#ee5544><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ЭЭ</font></td>'; }
		 else if ($sum2>$ee) { $n3++; print '<td  align=left bgcolor=#eeee33><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ЭЭ</font></td>'; }
		 else if ($nab>0 && $sum2<1) { $n4++; print '<td  align=left bgcolor=#775577><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ЭЭ</font></td>'; }
		 else { $n0++; print '<td  align=left bgcolor=#eeeeee><a href="index.php?sel=flat2&flat='.$flat.'"><font class=top2>ЭЭ</font></td>'; } 
		}	 
	  if ($cm==2) print '<td  align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum2,2).'</font></td>';
	  if ($cm==2) print '<td  align=center align=left bgcolor=#eeeeee><font class=top2>'.$ee.'</font></td>';

	  if ($flat%5==0) { print '</tr>'; $cm++; if ($cm==3) $cm=0; else $flat=$flat-5; }
          if (($cm==0 || $cm==1) && $flat==$count-1) { $flat=$flat-$flat%5; $cm++; print '<td colspan=21 bgcolor=#eeeeee>'; }
	}
 $cm=$count;
 $pr0=number_format($n0*100/$cm,2);
 $pr1=number_format($n1*100/$cm,2);
 $pr2=number_format($n2*100/$cm,2);
 $pr3=number_format($n3*100/$cm,2);
 $pr4=number_format($n4*100/$cm,2);
 $pr00=number_format(100*($ee0-$ssum2)/$ee0,2);
 $prg0=number_format($g0*100/$cm,2);
 $prg1=number_format($g1*100/$cm,2);
 $prg2=number_format($g2*100/$cm,2);
 $prg3=number_format($g3*100/$cm,2);
 $prg4=number_format($g4*100/$cm,2);
 $prg00=number_format(100*($hot0-$ssum1)/$hot0,2);
 $prh0=number_format($h0*100/$cm,2);
 $prh1=number_format($h1*100/$cm,2);
 $prh2=number_format($h2*100/$cm,2);
 $prh3=number_format($h3*100/$cm,2);
 $prh4=number_format($h4*100/$cm,2);
 $prh00=number_format(100*($cold0-$ssum0)/$cold0,2);

 print '<td colspan=21 bgcolor=#e8e8e8></tr>'; 
 print '<tr><td colspan=2 bgcolor=#ffcf68 align=center><font class=tablz>Итого</font></td>
 <td bgcolor=#ffcf68 colspan=32><font class=tablz>ХВС: '.number_format($ssum0,2).'/'.$cold0.' ('.$prh00.'%) | ГВС: '.number_format($ssum1,2).'/'.$hot0.' ('.$prg00.'%) | ЭЭ: '.number_format($ssum2,2).'/'.$ee0.' ('.$pr00.'%)</font></td></tr>'; 
?>
</table></td>
<td valign=top>
<table width=250px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td valign=top>
<table width=250px cellpadding=2 cellspacing=1 bgcolor=#664466 align=right>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>цвет</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>причины</font></td></tr>
<tr><td bgcolor=#ee5544 align=center><font class=top5>критично</font></td><td bgcolor=#e8e8e8><font class=top5>- перерасход больше норматива на 50%</font></td></tr>
<tr><td bgcolor=#eeee33 align=center><font class=top5>внимание</font></td><td bgcolor=#e8e8e8><font class=top5>- больше норматива</font></td></tr>
<tr><td bgcolor=#ee80ee align=center><font class=top5>непорядок</font></td><td bgcolor=#e8e8e8><font class=top5>- расход, но никто не прописан</font></td></tr>
<tr><td bgcolor=#775577 align=center><font class=top5>неисправность</font></td><td bgcolor=#e8e8e8><font class=top5>- отсутствуют показания / не установлен</font></td></tr>
<tr><td bgcolor=green align=center><font class=top5>нормально</font></td><td bgcolor=#e8e8e8><font class=top5>- показания корректны</font></td></tr>
</table>
</td></tr>
<tr bgcolor=#ffcf68 valign=top><td align=center><font class=tablz3>ХВС</td></tr>
<tr>
<?php
print '<td valign=top><img src="charts/pieplot9.php?source=6&st='.$st.'&fn='.$fn.'&month='.$_GET["date"].'&n0='.$h0.'&n1='.$h1.'&n2='.$h2.'&n3='.$h3.'&n4='.$h4.'" width=250 height=200></td>';
?>
</tr><tr>
<tr><td valign=top>
<table width=250px cellpadding=2 cellspacing=1 bgcolor=#664466 align=right>
<?php
print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>цвет</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>количество</font></td></tr>
<tr><td bgcolor=#ee5544 align=center><font class=top5>критично</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$h2.' ('.$prh2.'%)</font></td></tr>
<tr><td bgcolor=#eeee33 align=center><font class=top5>внимание</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$h3.' ('.$prh3.'%)</font></td></tr>
<tr><td bgcolor=#ee80ee align=center><font class=top5>непорядок</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$h1.' ('.$prh1.'%)</font></td></tr>
<tr><td bgcolor=#775577 align=center><font class=top5>неисправность</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$h4.' ('.$prh4.'%)</font></td></tr>
<tr><td bgcolor=green align=center><font class=top5>нормально</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$h0.' ('.$prh0.'%)</font></td></tr>';
?>
</table>
</td></tr>
<tr bgcolor=#ffcf68 valign=top><td align=center><font class=tablz3>ГВС</td></tr>
<tr>
<?php
print '<td valign=top><img src="charts/pieplot9.php?source=8&st='.$st.'&fn='.$fn.'&month='.$_GET["date"].'&n0='.$g0.'&n1='.$g1.'&n2='.$g2.'&n3='.$g3.'&n4='.$g4.'" width=250 height=200></td>';
?>
</tr><tr>
<tr><td valign=top>
<table width=250px cellpadding=2 cellspacing=1 bgcolor=#664466 align=right>
<?php
print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>цвет</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>количество</font></td></tr>
<tr><td bgcolor=#ee5544 align=center><font class=top5>критично</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$g2.' ('.$prg2.'%)</font></td></tr>
<tr><td bgcolor=#eeee33 align=center><font class=top5>внимание</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$g3.' ('.$prg3.'%)</font></td></tr>
<tr><td bgcolor=#ee80ee align=center><font class=top5>непорядок</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$g1.' ('.$prg1.'%)</font></td></tr>
<tr><td bgcolor=#775577 align=center><font class=top5>неисправность</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$g4.' ('.$prg4.'%)</font></td></tr>
<tr><td bgcolor=green align=center><font class=top5>нормально</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$g0.' ('.$prg0.'%)</font></td></tr>';
?>
</table>
</td></tr>
<tr bgcolor=#ffcf68 valign=top><td align=center><font class=tablz3>Электроэнергия</td></tr>
<tr>
<?php
print '<td valign=top><img src="charts/pieplot9.php?source=2&st='.$st.'&fn='.$fn.'&month='.$_GET["date"].'&n0='.$n0.'&n1='.$n1.'&n2='.$n2.'&n3='.$n3.'&n4='.$n4.'" width=250 height=200></td>';
?>
</tr><tr>
<tr><td valign=top>
<table width=250px cellpadding=2 cellspacing=1 bgcolor=#664466 align=right>
<?php
print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>цвет</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>количество</font></td></tr>
<tr><td bgcolor=#ee5544 align=center><font class=top5>критично</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$n2.' ('.$pr2.'%)</font></td></tr>
<tr><td bgcolor=#eeee33 align=center><font class=top5>внимание</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$n3.' ('.$pr3.'%)</font></td></tr>
<tr><td bgcolor=#ee80ee align=center><font class=top5>непорядок</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$n1.' ('.$pr1.'%)</font></td></tr>
<tr><td bgcolor=#775577 align=center><font class=top5>неисправность</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$n4.' ('.$pr4.'%)</font></td></tr>
<tr><td bgcolor=green align=center><font class=top5>нормально</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$n0.' ('.$pr0.'%)</font></td></tr>';
?>
</table>
</td></tr>
</table>
</td>
</tr></table>
<br>
</body>
</html>