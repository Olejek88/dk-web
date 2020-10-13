<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ показаний по холодной и горячей воде</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $_GET["abs"]=1;
 $today=getdate(); $begintime=time();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
 $query = 'SELECT * FROM build WHERE build_id='.$_GET["obj"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $build=$uy[1];

 $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 if ($_GET["date"]=='') $month=1;
 else $month=$_GET["date"];
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
	 if ($_GET["fn"]=='') $fn=sprintf("%d%02d15000000",$today["year"],$month+1); else $fn=$_GET["fn"];
	}

// for ($w=0;$w<=$max;$w++)       echo $data01[$w].' '.$data02[$w].' '.$data11[$w].' '.$data12[$w].'<br>';

 $query = 'SELECT * FROM flats ORDER BY flat'; $cm=0;
 if ($e = mysql_query ($query,$i))
 while ($ui = mysql_fetch_row ($e))
         {
	  $today["mday"]=31;
	  $cm=$ui[1];
	  $flat[$cm]=$ui[1]; $abn[$cm]=$ui[16]; $cold[$cm]=number_format($ui[10]*5.4*$k,2); $hot[$cm]=number_format($ui[10]*3.6*$k,2);
	  $nab[$cm]=$ui[10];
	  $cold0+=$cold[$cm];
	  $hot0+=$hot[$cm]; 
	}
 $max=$cm-1;

 $query = 'SELECT * FROM data WHERE date>='.$st.' AND date<'.$fn.' AND type=2 AND (prm=12 OR prm=11)';
 if ($a = mysql_query ($query,$i))
 while ($uy = mysql_fetch_row ($a)) 
	{	
	 for ($w=0;$w<=$max;$w++) 
	 if ($uy[4]==$flat[$w])
		{
		 if ($uy[6]==6) $hvs[$w]+=$uy[3];
		 if ($uy[6]==5) $gvs[$w]+=$uy[3];		 
		 break;
		}	
	}

 $query = 'SELECT * FROM flats ORDER BY flat'; $cm=0;
 if ($e = mysql_query ($query,$i))
 while ($ui = mysql_fetch_row ($e))
         {
	  //echo $hvs[$cm].' '.$gvs[$cm].'<br>';
	  $sum0[$cm]+=$hvs[$cm];  if ($sum0[$cm]<0) $sum0[$cm]=0; $ssum0+=$hvs[$cm];
	  $sum1[$cm]+=$gvs[$cm];  if ($sum1[$cm]<0) $sum1[$cm]=0; $ssum1+=$gvs[$cm];

	  //if ($_GET["abs"]==1) { $sum1[$cm]=$data12[$cm]; $sum0[$cm]=$data11[$cm]; }

	  while (1)
		{
		 if (($nab[$cm]==0 && $sum0[$cm]>1) || ($nab[$cm]==0 && $sum1[$cm]>1)) 
			{ 
			 $n1++; 
			 if ($sum0[$cm]>1) $snab0+=$sum0[$cm];  
			 if ($sum1[$cm]>1) $snab1+=$sum1[$cm];  
			 break; 
			}
		 if (($sum0[$cm]>($cold[$cm]+$cold[$cm])) || ($sum1[$cm]>($hot[$cm]+$hot[$cm]))) 
			{ 
			 $n2++; 
			 if ($sum0[$cm]>1) $spr0+=($sum0[$cm]-$cold[$cm]);  
			 if ($sum1[$cm]>1) $spr1+=($sum1[$cm]-$hot[$cm]);  
			 break; 
			}
		 if ($sum0[$cm]>$cold[$cm] || $sum1[$cm]>$hot[$cm]) 
			{ 
			 $n3++; 
			 if ($sum0[$cm]>1) $spr0+=$sum0[$cm]-$cold[$cm];  
			 if ($sum1[$cm]>1) $spr1+=$sum1[$cm]-$hot[$cm];  
			 break; 
			}
		 if ($nab[$cm]>0 && ($sum0[$cm]<0.1 || $sum1[$cm]<0.1)) if ($uy[21]==0) { $n4++; break; }
		 $n0++; break;

		 //print '<td align=center bgcolor=#eeeeee><font class=top2>'.$flat[$cm].'</font></td>'; 
		 //print '<td align=left bgcolor=#eeeeee><a href="lk_hour.php?flat='.$flat[].'&device='.$uy[1].'&n1='.$n1.'&st='.$st.'&fn='.$fn.'"><font class=top2>'.$abn.'</font></td>';
		 $n1=0;
		 break;
		}
	 $cm++;	 
	}
 $pr0=number_format($n0*100/$cm,2);
 $pr1=number_format($n1*100/$cm,2);
 $pr2=number_format($n2*100/$cm,2);
 $pr3=number_format($n3*100/$cm,2);
 $pr4=number_format($n4*100/$cm,2);
 $pr00=number_format(100*($cold0-$ssum0)/$cold0,2);
 $pr01=number_format(100*($hot0-$ssum1)/$hot0,2);
 $today=getdate();
 print '<table width=1200px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center><tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Распределение и анализ потребления холодной и горячей воды по объекту ул.'.$build.' за '.$month.' '.$today["year"].'</td>';

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

     $sts=sprintf ("%d%02d01000000",$today["year"],$tm);
     $fns=sprintf ("%d%02d01000000",$today["year"],$tm+1);
     print '<td align=center><a href="index.php?sel=lk56&obj='.$_GET["obj"].'&st='.$sts.'&fn='.$fns.'&date='.$tm.'&year='.$today["year"].'"><font class=tablz3>'.$dat.'</font></td>';

     if ($tm==1) { $tm=12; $today["year"]--; }
     else $tm--;
     $cn--;
     $uy = mysql_fetch_row ($a);
    }
 print '</tr></table>';
?>
<table width=600px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td valign=top>
<table width=250px cellpadding=2 cellspacing=1 bgcolor=#664466 align=right>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>цвет</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>причины</font></td></tr>
<tr><td bgcolor=#ee5544 align=center><font class=top5>критично</font></td><td bgcolor=#e8e8e8><font class=top5>- перерасход больше норматива на 50%</font></td></tr>
<tr><td bgcolor=#eeee33 align=center><font class=top5>внимание</font></td><td bgcolor=#e8e8e8><font class=top5>- больше норматива</font></td></tr>
<tr><td bgcolor=#ee80ee align=center><font class=top5>непорядок</font></td><td bgcolor=#e8e8e8><font class=top5>- расход, но никто не прописан</font></td></tr>
<tr><td bgcolor=#775577 align=center><font class=top5>неисправность</font></td><td bgcolor=#e8e8e8><font class=top5>- отсутствуют показания / не установлен</font></td></tr>
</table>
</td><td valign=top>
<table width=270px cellpadding=2 cellspacing=1 bgcolor=#664466 align=left>
<?php
 $today=getdate();                                            	
 //print '<tr><td bgcolor=#ffcf68 align=center><font class=top5>Дата</font></td><td bgcolor=#ffcf68><font class=tablz>'.$month.' '.$today["year"].'</font></td></tr>';
?>
<tr><td bgcolor=#eeeeee align=center><font class=top5>Норматив потребления ХВ</font></td><td bgcolor=#e8e8e8><font class=top5>5.4 м3 в месяц</font></td></tr>
<tr><td bgcolor=#eeeeee align=center><font class=top5>Норматив потребления ГВ</font></td><td bgcolor=#e8e8e8><font class=top5>3.6 м3 в месяц</font></td></tr>
<?php
 $query = 'SELECT SUM(square),SUM(rnum) FROM flats';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $kk=$uy[1]; $kk1=$uy[0];
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Сумма потребления ХВС</font></td><td bgcolor=#e8e8e8><font class=tablz>'.number_format($ssum0,2).' м3</font></td>';
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Нормативное потребление ХВС</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$cold0.' м3</font></td>';
 print '<tr><td bgcolor=#ffcf68 align=center><font class=top5>Экономия</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$pr00.' %</font></td>';

 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Сумма потребления ГВС</font></td><td bgcolor=#e8e8e8><font class=tablz>'.number_format($ssum1,2).' м3</font></td>';
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Нормативное потребление ГВС</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$hot0.' м3</font></td>';
 print '<tr><td bgcolor=#ffcf68 align=center><font class=top5>Экономия</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$pr01.' %</font></td>';

?>

</table>
</td>
<?php
print '<td valign=top><img src="charts/pieplot5.php?obj='.$_GET["obj"].'&n1='.$n1.'&n2='.$n2.'&n3='.$n3.'&n4='.$n0.'&n5='.$n4.'" width=200 height=140></td>';
?>
<td valign=top>
<table width=180px cellpadding=2 cellspacing=1 bgcolor=#664466 align=right>
<?php
print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>цвет</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>количество</font></td></tr>
<tr><td bgcolor=#ee5544 align=center><font class=top5>критично</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$n2.' ('.$pr2.'%)</font></td></tr>
<tr><td bgcolor=#eeee33 align=center><font class=top5>внимание</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$n3.' ('.$pr3.'%)</font></td></tr>
<tr><td bgcolor=#ee80ee align=center><font class=top5>непорядок</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$n1.' ('.$pr1.'%)</font></td></tr>
<tr><td bgcolor=#775577 align=center><font class=top5>неисправность</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$n4.' ('.$pr4.'%)</font></td></tr>
<tr><td bgcolor=green align=center><font class=top5>нормально</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$n0.' ('.$pr0.'%)</font></td></tr>';
?>
</table>
</td>

<td valign=top>
<table width=280px cellpadding=2 cellspacing=1 bgcolor=#664466 align=left>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>показатель</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>индикатор</font></td></tr>
<?php
$tarif2=12.41;
$tarif3=0.0467*537;
print '<tr><td bgcolor=#eeeeee align=center><font class=tablz>Потребление ХВС, где не прописаны</font></td><td bgcolor=#e8e8e8><font class=top5>'.number_format($snab0,2).' м3</font></td></tr>';
print '<tr><td bgcolor=#eeeeee align=center><font class=tablz>Потребление ГВС, где не прописаны</font></td><td bgcolor=#e8e8e8><font class=top5>'.number_format($snab1,2).' м3</font></td></tr>';
print '<tr><td bgcolor=#eeeeee align=center><font class=tablz>Потребление сверх нормы ХВС абонентами</font></td><td bgcolor=#e8e8e8><font class=top5>'.number_format($spr0,2).' м3</font></td></tr>';
print '<tr><td bgcolor=#eeeeee align=center><font class=tablz>Потребление сверх нормы ГВС абонентами</font></td><td bgcolor=#e8e8e8><font class=top5>'.number_format($spr1,2).' м3</font></td></tr>';
?>

</table>
</td>
</tr></table>

<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>К</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Vхвс</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Vгвс</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>К</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Vхвс</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Vгвс</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>К</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Vхвс</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Vгвс</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>К</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Vхвс</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Vгвс</font></td></tr>'; 

 print '<tr><td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '</tr>'; 

?>
</tr>

<?php
 $query = 'SELECT * FROM device WHERE type=2 GROUP BY flat ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $cm=$ui[1];

 	  if ($flat[$cm]%4==1) print '<tr bgcolor=#e8e8e8>';
	  while (1)
	  if ($uy[21]==0)
		{
		 if ($nab[$cm]==0 && $sum0[$cm]>1) { $n1=1; print '<td align=center bgcolor=#ee80ee><font class=top2>'.$flat[$cm].'</font></td>'; 
					   print '<td align=left bgcolor=#ee80ee><a href="lk_hour.php?flat='.$flat[$cm].'&obj='.$_GET["obj"].'&device='.$uy[1].'&n1='.$n1.'&st='.$st.'&fn='.$fn.'"><font class=top2>'.$abn[$cm].'</font></td>';break; }
		 if ($nab[$cm]==0 && $sum1[$cm]>1) { $n1=2; print '<td align=center bgcolor=#ee80ee><font class=top2>'.$flat[$cm].'</font></td>'; 
					   print '<td align=left bgcolor=#ee80ee><a href="lk_hour.php?flat='.$flat[$cm].'&obj='.$_GET["obj"].'&device='.$uy[1].'&n1='.$n1.'&st='.$st.'&fn='.$fn.'"><font class=top2>'.$abn[$cm].'</font></td>';break; }
		 if ($sum0[$cm]>($cold[$cm]+$cold[$cm])) { $n1=3; print '<td align=center bgcolor=#ee5544><font class=top2>'.$flat[$cm].'</font></td>'; 
					   print '<td align=left bgcolor=#ee5544><a href="lk_hour.php?flat='.$flat[$cm].'&obj='.$_GET["obj"].'&device='.$uy[1].'&n1='.$n1.'&st='.$st.'&fn='.$fn.'"><font class=top2>'.$abn[$cm].'</font></td>';break; }
		 if ($sum1[$cm]>($hot[$cm]+$hot[$cm])) { $n1=4; print '<td align=center bgcolor=#ee5544><font class=top2>'.$flat[$cm].'</font></td>'; 
					   print '<td align=left bgcolor=#ee5544><a href="lk_hour.php?flat='.$flat[$cm].'&obj='.$_GET["obj"].'&device='.$uy[1].'&n1='.$n1.'&st='.$st.'&fn='.$fn.'"><font class=top2>'.$abn[$cm].'</font></td>';break; }

		 if ($sum0[$cm]>$cold[$cm]) { $n1=5; print '<td align=center bgcolor=#eeee33><font class=top2>'.$flat[$cm].'</font></td>'; 
					   print '<td align=left bgcolor=#eeee33><a href="lk_hour.php?flat='.$flat[$cm].'&obj='.$_GET["obj"].'&device='.$uy[1].'&n1='.$n1.'&st='.$st.'&fn='.$fn.'"><font class=top2>'.$abn[$cm].'</font></td>';break; }
		 if ($sum1[$cm]>$hot[$cm]) { $n1=6; print '<td align=center bgcolor=#eeee33><font class=top2>'.$flat[$cm].'</font></td>'; 
					   print '<td align=left bgcolor=#eeee33><a href="lk_hour.php?flat='.$flat[$cm].'&obj='.$_GET["obj"].'&device='.$uy[1].'&n1='.$n1.'&st='.$st.'&fn='.$fn.'"><font class=top2>'.$abn[$cm].'</font></td>';break; }
 		 if ($nab[$cm]>0 && $sum0[$cm]<0.1)
		 if ($uy[21]==0) { $n1=7; print '<td align=center bgcolor=#775577><font class=top2>'.$flat[$cm].'</font></td>'; 
				   print '<td align=left bgcolor=#775577><a href="lk_hour.php?flat='.$flat[$cm].'&obj='.$_GET["obj"].'&device='.$uy[1].'&n1='.$n1.'&st='.$st.'&fn='.$fn.'"><font class=top2>'.$abn[$cm].'</font></td>';break; }
		 if ($nab[$cm]>0 && $sum1[$cm]<0.1) 
		 if ($uy[21]==0) { $n1=8; print '<td align=center bgcolor=#775577><font class=top2>'.$flat[$cm].'</font></td>'; 
				   print '<td align=left bgcolor=#775577><a href="lk_hour.php?flat='.$flat[$cm].'&obj='.$_GET["obj"].'&device='.$uy[1].'&n1='.$n1.'&st='.$st.'&fn='.$fn.'"><font class=top2>'.$abn[$cm].'</font></td>';break; }
		
		 print '<td align=center bgcolor=#eeeeee><font class=top2>'.$flat[$cm].'</font></td>'; 
		 print '<td align=left bgcolor=#eeeeee><a href="lk_hour.php?flat='.$flat[$cm].'&obj='.$_GET["obj"].'&device='.$uy[1].'&n1='.$n1.'&st='.$st.'&fn='.$fn.'"><font class=top2>'.$abn[$cm].'</font></td>';
		 $n1=0;
		 break;
		}
	 else   {
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.$flat[$cm].'</font></td>'; 
		 print '<td align=left bgcolor=#ffffff>н/у</font></td>';
		 break;
		}	 
	 print '<td align=center bgcolor=#ffffff><font class=top2>'.$nab[$cm].'</font></td>';
	 print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum0[$cm],2).'</font></td>';
	 print '<td align=center align=left bgcolor=#eeeeee><font class=top2>'.$cold[$cm].'</font></td>';
	 //print '</tr><tr><td></td><td></td><td></td>';
	 print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum1[$cm],2).'</font></td>';
	 print '<td align=center align=left bgcolor=#eeeeee><font class=top2>'.$hot[$cm].'</font></td>';
	 if ($flat[$cm]%4==0) print '</tr>';
	 $cm++;
	 $uy = mysql_fetch_row ($a);
	}
 print '<td colspan=21 bgcolor=#e8e8e8></tr>'; 
?>
</table>
<br>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<?php
 $query = 'SELECT * FROM build WHERE build_id='.$_GET["obj"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 if ($uy[4]) 
 for ($ent=1;$ent<=$uy[4];$ent++)
	{ 
//	 print '<tr><td><img width=1200 height=350 src="charts/barplots9.php?type=1&obj='.$_GET["obj"].'&n1='.$ent.'&st='.$st.'&fn='.$fn.'"></td></tr>';
	}
?>
</table>
</body>
</html>