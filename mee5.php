<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ показаний по электроэнергии</title>
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

 if ($_GET["date"]=='') $month=3; else $month=$_GET["date"];

 include("time.inc"); 
 if ($_GET["date"]=='') 
	{ 
	 $st=''.$today["year"].'0100000000'; 
	 $fn=''.$today["year"].'0200000000';
	 if ($_GET["year"]=='') $_GET["year"]=$today["year"];
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

$query = 'SELECT * FROM flats ORDER BY flat';
$a = mysql_query ($query,$i); $cn=0;
if ($a) $uy = mysql_fetch_row ($a);
while ($uy)
    {
     $data01[$cn]=$data02[$cn]=0;
     $query = 'SELECT * FROM device WHERE type=4 AND flat='.$uy[1];
     $e = mysql_query ($query,$i);
     $ui = mysql_fetch_row ($e);
     if ($ui) 
	{
	 $device[$cn]=$ui[1]; 
	 $cn++;
	}
     $uy = mysql_fetch_row ($a);
    }
 $max=$cn-1; $cn=0; 
 for ($w=0;$w<=$max;$w++) $data01[$w]=$data02[$w]=$data03[$w]=-1;

// $query = 'SELECT * FROM prdata WHERE type=2 AND prm=2 AND date>='.$st.' AND date<'.$fn.' AND value>0 ORDER BY date';
// $query = 'SELECT * FROM prdata WHERE type=2 AND prm=14 AND date>=20090624000000 AND date<20100331000000 AND value>0 ORDER BY date';
//echo $query.'<br>';
// $e = mysql_query ($query,$i);
// if ($e) $ui = mysql_fetch_row ($e);
// while ($ui)
//    {
//     //if ($device[0]==$ui[1]) echo $ui[5].' ';
//     for ($w=0;$w<=$max;$w++)	
//     if ($device[$w]==$ui[1])
//	 { $data03[$w]+=$ui[5];  break; }
//     $ui = mysql_fetch_row ($e);    
//    }                                                

 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=2 AND date>='.$st.' AND date<'.$fn.' AND value>0 ORDER BY date';
//echo $query.'<br>';
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     //if ($device[0]==$ui[1]) echo $ui[5].' ';
     for ($w=0;$w<=$max;$w++)	
     if ($device[$w]==$ui[1])
	 if ($data01[$w]==-1)  { $data01[$w]=$ui[5];  break; }
     $ui = mysql_fetch_row ($e);    
    }                                                
 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=2 AND date>='.$st.' AND date<'.$fn.' ORDER BY date DESC';
//echo $query.'<br>';
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     //echo $ui[1].' '.$ui[4].' '.$ui[5].'<br>';
     for ($w=0;$w<=$max;$w++)	
     if ($device[$w]==$ui[1])
	 if ($data02[$w]==-1)  { $data02[$w]=$ui[5]; break; }
     $ui = mysql_fetch_row ($e);    
    }                                                

 $query = 'SELECT * FROM device WHERE type=4 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0;
 while ($uy)
         {
	  $query = 'SELECT calcoef FROM dev_mee WHERE device='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e); $calc=$ui[0];

	  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $flat=$ui[1]; $abn=$ui[5]; $cold=number_format($ui[10]*130*(31)/31,2);
	  $nab=$ui[10];
	  $cold0+=$cold;
	  $hot0+=$hot;
	  for ($w=0;$w<=$max;$w++)	
	  if ($device[$w]==$uy[1]) 
		{
		 //$flt[$flat]=$data03[$w];
		 //if ($_GET["abs"]==1) $flt[$flat]=$data02[$w]+$calc;
		 if ($_GET["abs"]==1) $flt[$flat]=$calc;
		 else $flt[$flat]=$data02[$w]-$data01[$w];	  
		 //echo $device[$w].' '.$data02[$w].'-'.$data01[$w].'<br>';	  

	        if ($data02[$w]<$data01[$w]) 
		//if (0)
			{
		 	 $query = 'SELECT MAX(value) FROM prdata WHERE (type=2 OR type=1) AND prm=2 AND date<'.$fn.' AND date>'.$st.' AND value>0 AND device='.$uy[1];
		 	 $e = mysql_query ($query,$i);
	         	 if ($e) $ui = mysql_fetch_row ($e);
	         	 if ($ui) $flt[$flat]+=$ui[0];
			}
		}


	  $sum0=$flt[$flat];	 
	  if ($sum0<0) $sum0=0; $ssum0+=$sum0;
	  while (1)
		{
		 if ($nab==0 && $sum0>1) { $n1++; break; }
		 if ($sum0>($cold+$cold)) { $n2++; break; }
		 if ($sum0>$cold) { $n3++; break; }
		 if ($nab>0 && $sum0<1) { $n4++; break; }
		 $n0++; break;
		}
	 $cm++;	 
	 $uy = mysql_fetch_row ($a);
	}
 $pr0=number_format($n0*100/$cm,2);
 $pr1=number_format($n1*100/$cm,2);
 $pr2=number_format($n2*100/$cm,2);
 $pr3=number_format($n3*100/$cm,2);
 $pr4=number_format($n4*100/$cm,2);
 $pr00=number_format(100*($cold0-$ssum0)/$cold0,2);

 print '<table width=1200px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center><tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Распределение и анализ потребления электрической энергии по объекту ул.'.$build.' за '.$month.' '.$today["year"].'</td><td>';
 $today=getdate();
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
     print '<td align=center><a href="index.php?sel=mee5&obj='.$_GET["obj"].'&st='.$sts.'&fn='.$fns.'&date='.$tm.'&year='.$today["year"].'"><font class=tablz3>'.$dat.'</font></td>';

     if ($tm==1) { $tm=12; $today["year"]--; }
     else $tm--;
     $cn--;
     $uy = mysql_fetch_row ($a);
    }
 print '</td></tr></table>';

?>

<table width=600px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td valign=top>
<table width=300px cellpadding=2 cellspacing=1 bgcolor=#664466 align=right>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>цвет</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>причины</font></td></tr>
<tr><td bgcolor=#ee5544 align=center><font class=top5>критично</font></td><td bgcolor=#e8e8e8><font class=top5>- перерасход больше норматива на 50%</font></td></tr>
<tr><td bgcolor=#eeee33 align=center><font class=top5>внимание</font></td><td bgcolor=#e8e8e8><font class=top5>- больше норматива</font></td></tr>
<tr><td bgcolor=#ee80ee align=center><font class=top5>непорядок</font></td><td bgcolor=#e8e8e8><font class=top5>- расход, но никто не прописан</font></td></tr>
<tr><td bgcolor=#775577 align=center><font class=top5>неисправность</font></td><td bgcolor=#e8e8e8><font class=top5>- отсутствуют показания / не установлен</font></td></tr>
<tr><td bgcolor=green align=center><font class=top5>нормально</font></td><td bgcolor=#e8e8e8><font class=top5>- показания корректны</font></td></tr>
</table>
</td><td valign=top>
<table width=300px cellpadding=2 cellspacing=1 bgcolor=#664466 align=left>
<?php
 $today=getdate();
 print '<tr><td bgcolor=#ffcf68 align=center><font class=top5>Дата</font></td><td bgcolor=#ffcf68><font class=tablz>'.$month.' '.$_GET["year"].'</font></td></tr>';
?>
<tr><td bgcolor=#eeeeee align=center><font class=top5>Норматив потребления электроэнергии</font></td><td bgcolor=#e8e8e8><font class=top5>130 кВт/ч в месяц на человека</font></td></tr>
<?php
 $query = 'SELECT SUM(square),SUM(rnum) FROM flats';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $kk=$uy[1]; $kk1=$uy[0];
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Жилая площадь дома</font></td><td bgcolor=#e8e8e8><font class=top5>'.$kk1.' м3</font></td></tr>'; 
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Общее число жителей</font></td><td bgcolor=#e8e8e8><font class=top5>'.$kk.' человек</font></td></tr>';
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Сумма потребления по дому</font></td><td bgcolor=#e8e8e8><font class=tablz>'.number_format($ssum0,2).' кВт</font></td>';
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Нормативное потребление</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$cold0.' кВт</font></td>';
 print '<tr><td bgcolor=#eeeeee align=center><font class=top5>Экономия</font></td><td bgcolor=#e8e8e8><font class=tablz>'.$pr00.' %</font></td>';
?>
</table>
</td>
<?php
print '<td valign=top><img src="charts/pieplot5.php?obj='.$_GET["obj"].'&n1='.$n1.'&n2='.$n2.'&n3='.$n3.'&n4='.$n0.'&n5='.$n4.'" width=200 height=140></td>';
?>
<td valign=top>
<table width=200px cellpadding=2 cellspacing=1 bgcolor=#664466 align=right>
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
</tr></table>

<br>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr>

<?php
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>К</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>ЭЭ</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>К</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>ЭЭ</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>К</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>ЭЭ</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>К</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>ЭЭ</font></td></tr>'; 

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
 $query = 'SELECT * FROM device WHERE type=4 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $flat=$ui[1]; $abn=$ui[5]; $cold=number_format($ui[10]*130*(31)/31,2);
	  $nab=$ui[10];
	  $cold0+=$cold;
	  $hot0+=$hot;

	 $sum0=$flt[$flat];
	 if ($sum0<0) $sum0=0; $ssum0+=$sum0;
	 if ($flat%4==1) print '<tr bgcolor=#e8e8e8>';
	 while (1)
		{
		 if ($nab==0 && $sum0>1) { $n1=1; print '<td align=center bgcolor=#ee80ee><font class=top2>'.$flat.'</font></td>'; 
					   print '<td align=left bgcolor=#ee80ee><a href="lk_hour2.php?flat='.$flat.'&device='.$uy[1].'&n1='.$n1.'&obj='.$_GET["obj"].'"><font class=top2>'.$abn.'</font></td>';break; }
		 if ($sum0>($cold+$cold)) { $n1=3; print '<td align=center bgcolor=#ee5544><font class=top2>'.$flat.'</font></td>'; 
					   print '<td align=left bgcolor=#ee5544><a href="lk_hour2.php?flat='.$flat.'&device='.$uy[1].'&n1='.$n1.'&obj='.$_GET["obj"].'"><font class=top2>'.$abn.'</font></td>';break; }
		 if ($sum0>$cold) { $n1=5; print '<td align=center bgcolor=#eeee33><font class=top2>'.$flat.'</font></td>'; 
					   print '<td align=left bgcolor=#eeee33><a href="lk_hour2.php?flat='.$flat.'&device='.$uy[1].'&n1='.$n1.'&obj='.$_GET["obj"].'"><font class=top2>'.$abn.'</font></td>';break; }
		 if ($nab>0 && $sum0<1) { $n1=7; print '<td align=center bgcolor=#775577><font class=top2>'.$flat.'</font></td>'; 
					   print '<td align=left bgcolor=#775577><a href="lk_hour2.php?flat='.$flat.'&device='.$uy[1].'&n1='.$n1.'&obj='.$_GET["obj"].'"><font class=top2>'.$abn.'</font></td>';break; }
		 print '<td align=center bgcolor=#eeeeee><font class=top2>'.$flat.'</font></td>'; 
		 print '<td align=left bgcolor=#eeeeee><a href="lk_hour2.php?flat='.$flat.'&device='.$uy[1].'&n1='.$n1.'&obj='.$_GET["obj"].'"><font class=top2>'.$abn.'</font></td>';
		 $n1=0;
		 break;
		}	 
	 print '<td align=center bgcolor=#ffffff><font class=top2>'.$nab.'</font></td>';
	 print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum0,0).'</font></td>';
	 print '<td align=center align=left bgcolor=#eeeeee><font class=top2>'.$cold.'</font></td>';
	 if ($flat%4==0) print '</tr>';
	 $uy = mysql_fetch_row ($a);
	}
 print '<td colspan=21 bgcolor=#e8e8e8></tr>'; 
 $pr0=number_format(100*($ssum0-$cold0)/$cold0,2);
 print '<tr><td colspan=2 bgcolor=#ffcf68 align=center><font class=tablz>Итого</font></td><td bgcolor=#ffcf68 colspan=32><font class=tablz>'.number_format($ssum0,2).'/'.$cold0.' ('.$pr0.'%)</font></td></tr>'; 
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
	 print '<tr><td><img width=1200 height=350 src="charts/barplots10.php?type=1&obj='.$_GET["obj"].'&n1='.$ent.'&st='.$st.'&fn='.$fn.'&month='.$_GET["date"].'"></td></tr>';
	}
?>

</table>
</body>
</html>