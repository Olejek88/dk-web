<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ показаний по потребленной тепловой энергии, вычисленные по различным алгоритмам</title>
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
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 include("time.inc"); 

 if ($_GET["date"]=='') 
	{ 
	 $st=''.$today["year"].'0100000000'; 
	 $fn=''.$today["year"].'0200000000';
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

 $max=$cn-1; $cn=0; 
 $query = 'SELECT * FROM dev_irp ORDER BY adr';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); 
 while ($uy)
        {
	 $query = 'SELECT SUM(value),AVG(value),COUNT(id) FROM prdata WHERE type=2 AND prm=13 AND value>10 AND device='.$uy[1].' AND date<'.$fn.' AND date>'.$st;
	 //echo $query;
	 $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
	 //echo $uy[2].' '.$ui[2].' '.$ui[1].'<br>';
	 $irpdata[$uy[2]]=$ui[0]; 
	 $sums+=$irpdata[$uy[2]];
	 $uy = mysql_fetch_row ($a); 
	}

 if ($is_tekon)
	{
	 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE flat=0 AND type=2 AND prm=13 AND source=0 AND date<'.$fn.' AND date>'.$st;	
	 //echo $query;
	 $e = mysql_query ($query,$i);
	 if ($e) $ui = mysql_fetch_row ($e);
	 $sum=$ui[0]; $nday=$ui[1];

	 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE flat=0 AND type=2 AND prm=13 AND source=4 AND date<'.$fn.' AND date>'.$st;	
	 //echo $query;
	 $e = mysql_query ($query,$i);
	 if ($e) $ui = mysql_fetch_row ($e);
	 $sum6=$ui[0];
	}
else { $sum=0; $nday=31; }	
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

	  $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND (source=0) AND flat='.$uy[1].' AND date<'.$fn.' AND date>'.$st;	
	  $e = mysql_query ($query,$i);
	  if ($e) $ui = mysql_fetch_row ($e);
	  $data02[$cm]=$ui[0]/4186; 
	  $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND (source=1) AND flat='.$uy[1].' AND date<'.$fn.' AND date>'.$st;	
	  $e = mysql_query ($query,$i);
	  if ($e) $ui = mysql_fetch_row ($e);
	  $data22[$cm]=$ui[0]/4186; 
	  $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND (source=2) AND flat='.$uy[1].' AND date<'.$fn.' AND date>'.$st;	
	  $e = mysql_query ($query,$i);
	  if ($e) $ui = mysql_fetch_row ($e);
	  $data23[$cm]=$ui[0]/4186; 

	  $query = 'SELECT SUM(value) FROM data WHERE value<4 AND type=2 AND prm=11 AND source=5 AND flat='.$uy[1].' AND date<'.$fn.' AND date>'.$st;	
	  $e = mysql_query ($query,$i);
	  if ($e) $ui = mysql_fetch_row ($e);
	  $data04[$cm]=$ui[0]; 
	  if ($data04[$cm]==0) $data04[$cm]=3.6*$uy[10]*$nday/30;
	  if ($data04[$cm]>50) $data04[$cm]=50;
	
	  $data03[$cm]=$cold; 
	  //echo $data00[$cm].' '.$data01[$cm].' '.$data02[$cm].' '.$data03[$cm].'<br>';
	  $data0+=$data00[$cm];
	  if ($is_tekon) $data1+=$data01[$cm];
	  else if ($flat[$cm]>496 && $_GET["obj"]==6) $data1+=$data01[$cm];
	  $data2+=$data02[$cm]+$data22[$cm];
	  $data3+=$data03[$cm];
	  $data4+=$data04[$cm];
	  $cm++;	 
	  $datass[$uy[9]].='&s'.$cm.'='.number_format($data00[$cm-1],2).'&d'.$cm.'='.number_format($data01[$cm-1],2).'&n'.$cm.'='.number_format($data02[$cm-1],2);
	  $uy = mysql_fetch_row ($a);
	 }

 print '<table width=1200px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center><tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Потребление тепловой энергии, вычисленное по различным алгоритмам по объекту ул.'.$build.' за '.$month.' '.$today["year"].'</td>';
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
     print '<td align=center><a href="index.php?sel=bit10&obj='.$_GET["obj"].'&st='.$sts.'&fn='.$fns.'&date='.$tm.'&year='.$today["year"].'"><font class=tablz3>'.$dat.'</font></td>';

     if ($tm==1) { $tm=12; $today["year"]--; }
     else $tm--;
     $cn--;
     $uy = mysql_fetch_row ($a);
    }
 print '</tr></table>';
?>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<?php
 if ($is_tekon) print '<tr><td colspan=32 bgcolor=#ffcf68><font  class=tablz>Q вход = '.$sum.', Q на жилую часть = '.$sum6.', Q индивидуальные = '.$data2.', Q по нормативу = '.$data3.'</font></td></tr>';
 else print '<tr><td colspan=32 bgcolor=#ffcf68><font  class=tablz>Q теплового пункта = '.$data0.', Q общедомовые = '.$data1.', Q индивидуальные = '.$data2.', Q по нормативу = '.$data3.'</font></td></tr>'; 
?>
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
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>S</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qпр</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qодн</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нор</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qсум</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>S</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qпр</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qодн</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>норм.</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qсум</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>S</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qпр</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qодн</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>норм.</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qсум</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>S</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qпр</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qодн</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>норм.</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qсум</font></td></tr>'; 
?>
</tr>

<?php
// $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $query = 'SELECT * FROM flats';
 $a = mysql_query ($query,$i);
 $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0; $prflat=0; $alr=0;
 while ($uy = mysql_fetch_row ($a))
         {
	 if (($cm%4==0 && !$alr)) { print '</tr><tr bgcolor=#e8e8e8>'; $alr++; }
	 if ($cm%4!=0) $alr=0;
	 if ($prflat!=$uy[1])
		{
		 print '<td align=center bgcolor=#eeeeee><font class=top2>'.$flat[$cm].'</font></td>'; 
		 print '<td align=left bgcolor=#eeeeee><a href="lk_hour4.php?obj='.$_GET["obj"].'&flat='.$flat[$cm].'&device='.$uy[1].'&n1='.$n1.'&st='.$st.'&fn='.$fn.'"><font class=top2>'.$abn[$cm].'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.$square[$cm].'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data02[$cm]+$data22[$cm]/2,3).'</font></td>';
		 print '<td align=center bgcolor=#eeeeee><font class=top2>'.number_format($data22[$cm]-$data22[$cm]/2,3).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data23[$cm],3).'</font></td>';
		 if ($_GET["date"]>10 || $_GET["date"]<5) print '<td align=center bgcolor=#eeeeee><font class=top2>'.number_format($square[$cm]*0.0366,3).'</font></td>';
		 if ($_GET["date"]==5) print '<td align=center bgcolor=#eeeeee><font class=top2>'.number_format($square[$cm]*0.0122,3).'</font></td>';
		 if ($_GET["date"]==10) print '<td align=center bgcolor=#eeeeee><font class=top2>'.number_format($square[$cm]*0.0322,3).'</font></td>';
		 if ($_GET["date"]>5 && $_GET["date"]<10) print '<td align=center bgcolor=#eeeeee><font class=top2>'.number_format(0,3).'</font></td>';
		 print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data23[$cm]+$data22[$cm]+$data02[$cm],3).'</font></td>';
		}
	 if ($prflat!=$uy[1]) { $prflat=$uy[1]; $cm++; }	 
	}
 print '<td colspan=24 bgcolor=#e8e8e8></tr>';
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
	 print '<tr><td><img width=1200 height=350 src="charts/barplots30.php?type=1&obj='.$_GET["obj"].'&n1='.$ent.'&'.$datass[$ent].'"></td></tr>';
	}
?>
</table>
