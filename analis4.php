<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ качества поставляемых коммунальных услуг</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<?php
 include("config/local.php");
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

 $today=getdate();
 if ($_GET["date"]=='') $month=5;
 else $month=$_GET["date"];
 $_GET["month"]=$_GET["date"];
 include("time.inc"); 
?>
<table width=1200px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center><tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Анализ качества поставляемых коммунальных услуг</td></tr></table>
<table width=1200px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<tr>
<td width=1200 valign=top><table width=1200 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr>
<td bgcolor=#ffcf68 align=center rowspan=2><font class=tablz>месяц/год</font></td>
<td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>Бесперебойность ХВС</font></td>
<td bgcolor=#ffcf68 align=center colspan=3><font class=tablz>Давление ХВС (0.03-0.6 МПа)</font></td>
<td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>Бесперебойность ГВС</font></td>
<td bgcolor=#ffcf68 align=center colspan=4><font class=tablz>Температура ГВС (60-75 С)</font></td>
<td bgcolor=#ffcf68 align=center colspan=3><font class=tablz>Давление ГВС (0.03-0.45 МПа)</font></td>
<td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>Бесп-ость электро-ния</font></td>
<td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>Бесп-ость тепло-ния</font></td>
<td bgcolor=#ffcf68 align=center rowspan=2><font class=tablz>Всего часов</font></td>
<td bgcolor=#ffcf68 align=center rowspan=2><font class=tablz>Тепло</font></td>
<td bgcolor=#ffcf68 align=center rowspan=2><font class=tablz>Изм.</font></td>
<td bgcolor=#ffcf68 align=center rowspan=2><font class=tablz>ГВС</font></td>
<td bgcolor=#ffcf68 align=center rowspan=2><font class=tablz>Изм.</font></td>
<td bgcolor=#ffcf68 align=center rowspan=2><font class=tablz>ХВС</font></td>
<td bgcolor=#ffcf68 align=center rowspan=2><font class=tablz>Изм.</font></td>
<td bgcolor=#ffcf68 align=center rowspan=2><font class=tablz>ЭЭ</font></td>
<td bgcolor=#ffcf68 align=center rowspan=2><font class=tablz>Изм</font></td>
<td bgcolor=#ffcf68 align=center rowspan=2><font class=tablz>Итого</font></td>
</tr>
<tr>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>часов</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>% сн.</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>часов</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz><25% ч.</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>>25% ч.</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>часов</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>% сн.</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>ночь/ч.</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>% сн.</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>день/ч.</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>% сн.</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>часов</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz><25% ч.</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>>25% ч.</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>часов</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>% сн.</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>часов</font></td>
<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>% сн.</font></td>
</tr>

<?php
 $ye=$today["year"]; $cn=0;
 for ($tn=$today["year"]-1; $tn<=$today["year"]; $tn++)
     {
      if ($tn==$today["year"]) { $mmn=1; $mmx=$today["mon"]; }
      else { $mmn=4; $mmx=12; }
      for ($tm=$mmn; $tm<=$mmx; $tm++)
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
	     $sts=sprintf("%d%02d00000000",$tn,$tm); 
	     $fns=sprintf("%d%02d00000000",$tn,$tm+1); 
	     //-----------------------------------------------------------------------------------
	     $query = 'SELECT SUM(value) FROM data WHERE type=2 AND flat=0 AND prm=12 AND source=5 AND date>'.$sts.' AND date<'.$fns;
	     //echo $query;
	     $r = mysql_query ($query,$i); 
	     if ($r) $ur = mysql_fetch_row ($r); $vhgvs=0;
	     while ($ur)	{ $vhgvs=$ur[0]; $ur = mysql_fetch_row ($r);	}
	     //------------------------------------------------------------------------------------
	     $query = 'SELECT SUM(value) FROM data WHERE type=2 AND flat=0 AND prm=12 AND source=6 AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); 
	     if ($r) $ur = mysql_fetch_row ($r); $vhhvs=0;
	     while ($ur)	{ $vhhvs=$ur[0]; $ur = mysql_fetch_row ($r);	}
	     $vhhvs-=$vhgvs;
	     //------------------------------------------------------------------------------------
	     $query = 'SELECT SUM(value) FROM data WHERE type=2 AND flat=0 AND prm=14 AND source=0 AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); 
	     if ($r) $ur = mysql_fetch_row ($r); $vhee=0;
	     while ($ur)	{ $vhee=$ur[0]; $ur = mysql_fetch_row ($r);	}
	     //------------------------------------------------------------------------------------
	     $query = 'SELECT SUM(value) FROM data WHERE type=2 AND flat=0 AND prm=13 AND source=2 AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); 
	     if ($r) $ur = mysql_fetch_row ($r); $vhtp=0;
	     while ($ur)	{ $vhtp=$ur[0]; $ur = mysql_fetch_row ($r);	}
	     //------------------------------------------------------------------------------------
             $query = 'SELECT COUNT(id) FROM data WHERE type=1 AND prm=12 AND source=6 AND value=0 AND date>'.$sts.' AND date<'.$fns;
	     //echo $query;
	     $r = mysql_query ($query,$i); 
	     if ($r) $ur = mysql_fetch_row ($r); $qhvs=0;
	     while ($ur)	{ $qhvs=number_format($ur[0],0); $ur = mysql_fetch_row ($r);	}	     
	     $hvspr=0.15*($qhvs-0); if ($hvspr<0) $hvspr=0; $shvs+=$hvspr;
	     //------------------------------------------------------------------------------------
             $query = 'SELECT COUNT(id) FROM data WHERE type=1 AND prm=12 AND source=5 AND value=0 AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); 
	     if ($r) $ur = mysql_fetch_row ($r); $qgvs=0;
	     while ($ur)	{ $qgvs=number_format($ur[0],0); $ur = mysql_fetch_row ($r);	}
	     $gvspr=0.15*($qgvs-0); if ($gvspr<0) $gvspr=0; $sgvs+=$gvspr;
	     //------------------------------------------------------------------------------------
             $query = 'SELECT COUNT(id) FROM data WHERE type=1 AND prm=16 AND source=6 AND (value<0.0225 OR value>0.525) AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); 
	     if ($r) $ur = mysql_fetch_row ($r); $phvs=0;
	     while ($ur)	{ $phvs=number_format($ur[0],0); $ur = mysql_fetch_row ($r);	}
	     $phvspr=0.15*$phvs; $sphvs+=$phvspr;
	     //------------------------------------------------------------------------------------
             $query = 'SELECT COUNT(id) FROM data WHERE type=1 AND prm=16 AND source=6 AND (value<0.03 OR value>0.45) AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); 
	     if ($r) $ur = mysql_fetch_row ($r); $phvs1=0;
	     while ($ur)	{ $phvs1=number_format($ur[0],0); $ur = mysql_fetch_row ($r);	}
	     $phvspr1=0.15*($phvs1-$phvs); $sphvs1+=$phvspr1;
	     //------------------------------------------------------------------------------------
             $query = 'SELECT COUNT(id) FROM data WHERE type=1 AND prm=16 AND source=5 AND (value<0.0225 OR value>0.525) AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); 
	     if ($r) $ur = mysql_fetch_row ($r); $pgvs=0;
	     while ($ur)	{ $pgvs=number_format($ur[0],0); $ur = mysql_fetch_row ($r);	}
	     $pgvspr=0.15*$pgvs; $spgvs+=$pgvspr;
	     //------------------------------------------------------------------------------------
             $query = 'SELECT COUNT(id) FROM data WHERE type=1 AND prm=16 AND source=5 AND (value<0.03 OR value>0.6) AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); 
	     if ($r) $ur = mysql_fetch_row ($r); $pgvs=0;
	     while ($ur)	{ $pgvs1=number_format($ur[0],0); $ur = mysql_fetch_row ($r);	}
	     $pgvspr1=0.15*($pgvs1-$pgvs); $spgvs1+=$pgvspr1;
	     //------------------------------------------------------------------------------------
             $query = 'SELECT COUNT(id) FROM data WHERE type=1 AND prm=4 AND source=5 AND (value<57 OR value>78) AND (date LIKE \'%23:00%\' OR date LIKE \'%00:00:00%\' OR date LIKE \'%01:00%\' OR date LIKE \'%02:00%\' OR date LIKE \'%03:00%\' OR date LIKE \'%04:00%\' OR date LIKE \'%05:00%\' OR date LIKE \'%06:00%\') AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); 
	     if ($r) $ur = mysql_fetch_row ($r); $tgvs1=0;
	     while ($ur)	{ $tgvs1=number_format($ur[0],0); $ur = mysql_fetch_row ($r);	}
	     $tgvspr1=0.15*($tgvs1); $stgvspr1+=$tgvspr1;
	     //------------------------------------------------------------------------------------
             $query = 'SELECT COUNT(id) FROM data WHERE type=1 AND prm=4 AND source=5 AND (value<55 OR value>80) AND (date LIKE \'%07:00%\' OR date LIKE \'%08:00%\' OR date LIKE \'%09:00%\' OR date LIKE \'%10:00%\' OR date LIKE \'%11:00%\' OR date LIKE \'%12:00%\' OR date LIKE \'%13:00%\' OR date LIKE \'%14:00%\' OR date LIKE \'%15:00%\' OR date LIKE \'%16:00%\' OR date LIKE \'%17:00%\' OR date LIKE \'%18:00%\' OR date LIKE \'%19:00%\' OR date LIKE \'%20:00%\' OR date LIKE \'%21:00%\' OR date LIKE \'%22:00%\') AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); if ($r) $ur = mysql_fetch_row ($r); $tgvs2=0;
	     while ($ur)	{ $tgvs2=number_format($ur[0],0); $ur = mysql_fetch_row ($r);	}
	     $tgvspr2=0.15*($tgvs2); $stgvspr2+=$tgvspr2;
	     //------------------------------------------------------------------------------------
             $query = 'SELECT COUNT(id) FROM data WHERE type=1 AND prm=14 AND source=0 AND value=0 AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); if ($r) $ur = mysql_fetch_row ($r); $ee=0;
	     while ($ur)	{ $ee=number_format($ur[0],0); $ur = mysql_fetch_row ($r);	}
		if ($ee>150) $ee=0;
	     $eepr=0.15*($ee); $seepr+=$eepr;
	     //------------------------------------------------------------------------------------
             $query = 'SELECT COUNT(id) FROM data WHERE type=1 AND prm=13 AND source=2 AND value=0 AND date>'.$sts.' AND date<'.$fns;
	     $r = mysql_query ($query,$i); if ($r) $ur = mysql_fetch_row ($r); $qtep=0;
	     while ($ur)	{ $qtep=number_format($ur[0]/2,0); $ur = mysql_fetch_row ($r);	}
	     if ($qtep>50) $qtep=0;
	     $teppr=0.15*($qtep-0); if ($teppr<0) $teppr=0; $steppr+=$teppr;	     
	     print '<tr><td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>'.$dat.'/'.$tn.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$qhvs.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$hvspr.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$phvs1.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$phvspr.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$phvspr1.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$qgvs.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$gvspr.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$tgvs1.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$tgvspr1.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$tgvs2.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$tgvspr2.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$pgvs1.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$pgvspr.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$pgvspr1.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$ee.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$eepr.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$qtep.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.$teppr.'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.number_format($qhvs+$qgvs+$phvs1+$tgvs1+$tgvs2+$pgvs1+$ee+$qtep,0).'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.number_format($vhtp,2).'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.number_format($vhtp*$teppr/100,2).'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.number_format($vhgvs,2).'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.number_format($vhgvs*($tgvspr1+$tgvspr2+$pgvspr1+$pgvspr)/100,2).'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.number_format($vhhvs,2).'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.number_format($vhhvs*($hvspr+$phvspr+$phvspr1)/100,2).'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.number_format($vhee,2).'</font></td>';
	     print '<td bgcolor=#ffffff align=center colspan=1><font class=top5>'.number_format($vhee*$eepr/100,0).'</font></td>';
	     $itogo=$vhtp*$teppr*537/100+$vhgvs*($tgvspr1+$tgvspr2+$pgvspr1+$pgvspr)*12.41/100+$vhhvs*($hvspr+$phvspr+$phvspr1)*12.41/100+$vhee*$eepr*1.68/100;
	     //print $vhtp.' '.$teppr.' | '.$vhgvs.' '.$tgvspr1.' '.$tgvspr2.' '.$pgvspr1.' '.$pgvspr.' | '.$vhhvs.' '.$hvspr.' '.$phvspr.' '.$phvspr.' | '.$vhee.' '.$eepr.'<br>';
	     $sitogo+=$itogo;
	     print '<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>'.number_format($itogo,2).'</font></td></tr>';
	     $svhtp+=$vhtp; $steppr+=($vhtp*$teppr)/100; $svhgvs+=$vhgvs; $sgvspr+=$vhgvs*($tgvspr1+$tgvspr2+pgvspr1+$pgvspr)/100;
	     $svhee+=$vhee; $sseepr+=($vhee*$eepr)/100; $svhhvs+=$vhhvs; $shvspr+=$vhhvs*($hvspr+$phvspr+$phvspr1)/100;

	     $phvspr+=$phvspr1; $tgvspr=$tgvspr1+$tgvspr2;
	     $get.='x'.$cn.'n='.$dat.'&x'.$cn.'-1-1='.$phvspr.'&x'.$cn.'-1-2='.$hvspr.'&x'.$cn.'-1-3=0'.
					'&x'.$cn.'-2-1='.$pgvspr.'&x'.$cn.'-2-2='.$gvspr.'&x'.$cn.'-2-3='.$tgvspr.
					'&x'.$cn.'-3-1=0&x'.$cn.'-3-2='.$teppr.'&x'.$cn.'-3-3=0'.
					'&x'.$cn.'-4-1=0&x'.$cn.'-4-2='.$eepr.'&x'.$cn.'-4-3=0'.
					'&x'.$cn.'-vh1='.$vhtp.'&x'.$cn.'-vh2='.$vhgvs.'&x'.$cn.'-vh3='.$vhhvs.'&x'.$cn.'-vh4='.$vhee.'&';
	     $cn++;
	   }
    }

     print '<tr><td bgcolor=#ffcf68 align=center colspan=20><font class=tablz></font></td>';
     print '<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>'.number_format($svhtp,1).'</font></td>';
     print '<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>'.number_format($steppr,1).'</font></td>';
     print '<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>'.number_format($svhgvs,1).'</font></td>';
     print '<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>'.number_format($sgvspr,1).'</font></td>';
     print '<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>'.number_format($svhhvs,1).'</font></td>';
     print '<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>'.number_format($shvspr,1).'</font></td>';
     print '<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>'.number_format($svhee,1).'</font></td>';
     print '<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>'.number_format($sseepr,1).'</font></td>';
     print '<td bgcolor=#ffcf68 align=center colspan=1><font class=tablz>'.number_format($sitogo,1).'</font></td></tr>';
 //------------------------------------------------------------------------------------------------
?>
</table>
<table width=1200px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<tr valign=top>
<td align=center bgcolor=#ffcf68><font class=tablz3>Переплата за непредоставленные услуги</td>
<td align=center bgcolor=#ffcf68><font class=tablz3>Респределение по ресурсам</td>
<td align=center bgcolor=#ffcf68><font class=tablz3>Возврат жителям</td>
</tr>
<tr>
<?php
print '<td><img src="charts/barplots23.php?'.$get.'" width=600 height=250></td>';
print '<td><img src="charts/pieplot23.php?'.$get.'" width=200 height=250></td>';
print '<td><img src="charts/xyplot23.php?'.$get.'" width=400 height=250></td>';
?>
</tr>
</table>
</table>
</body>
</html>