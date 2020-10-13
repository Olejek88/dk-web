<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Система учета индивидуального потребления энергоресурсов :: Анализ показаний по тепловой энергии на подготовку ГВС</title>
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

 if ($_GET["date"]=='') $month=5;
 else $month=$_GET["date"];
 include("time.inc"); 

 if ($_GET["date"]=='') 
	{ 
	 $st='20090300000000'; 
	 $fn='20090400000000';
	 $k=1; 
	}
 else 
	{ 
	 if ($_GET["date"]!=$today["mon"]) $k=1;
	 else $k=$today["mday"]/31;
	 $st=sprintf ("%d%02d00000000",$today["year"],$_GET["date"]);
	 $fn=sprintf ("%d%02d00000000",$today["year"],$_GET["date"]+1);
	}

 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND source=2 AND date<'.$fn.' AND date>'.$st;	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 $sum=$ui[0]; 

 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND source=3 AND date<'.$fn.' AND date>'.$st;	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 $sum12=$ui[0]; 
 $sum=$sum12-$sum;


 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $flat=$ui[1]; $abn=$ui[5]; $square=$ui[8]; $cold=0.046*31;
	  $nab=$ui[10];  $cold0+=$cold;

	  $query = 'SELECT * FROM dev_2ip WHERE flat_number='.$uy[1];
	  $b = mysql_query ($query,$i);
	  $ut = mysql_fetch_row ($b); $data01=$data02=0;
	  while ($ut)
	         {
		  $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=8 AND date<'.$fn.' AND date>'.$st.' AND device='.$ut[1].' ORDER BY date LIMIT 1';
		  $e = mysql_query ($query,$i);
        	  if ($e) $ui = mysql_fetch_row ($e);
	          if ($ui) $data02=$ui[5];

	 	  $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=8 AND date<'.$fn.' AND date>'.$st.' AND device='.$ut[1].' ORDER BY date DESC LIMIT 1';
	          $e = mysql_query ($query,$i);
	          if ($e) $ui = mysql_fetch_row ($e);
	          if ($ui) $data12=$ui[5];  
	 	  $sum1[$uy[1]]=$data12-$data02;  $ssum1+=$sum1[$uy[1]];
		  $ut = mysql_fetch_row ($b); 
		 }
	 $uy = mysql_fetch_row ($a);
	}
 print '<table width=1100px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center><tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Распределение и анализ потребления тепловой энергии на подготовку ГВС по объекту ул.'.$build.' за '.$month.' '.$today["year"].'</td>';
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
     print '<tr><td bgcolor=#eeeeee align=center><a href="index.php?sel=bit51&obj='.$_GET["obj"].'&st='.$sts.'&fn='.$fns.'&date='.$tm.'"><font class=tablz3>'.$dat.'</font></td></tr>';
     if ($tm==1) { $tm=12; $today["year"]--; }
     else $tm--;
     $cn--;
     $uy = mysql_fetch_row ($a);
    }
 print '</td></tr></table>';
 print '</tr></table>';
?>

</td>
</tr></table>

<br>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr>

<?php
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>тепло</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>тепло</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>тепло</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>тепло</font></td></tr>'; 

 print '<tr><td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>гвс</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>гвс</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>гвс</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>гвс</font></td>'; 
 print '</tr>'; 

?>
</tr>

<?php
 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0;
 while ($uy)
        {
	 $flat=$uy[1]; 
	  print '<td align=center bgcolor=#eeeeee><font class=top2>'.$uy[1].'</font></td>'; 
 	  print '<td align=left bgcolor=#eeeeee><font class=top2>'.$abn.'</font></td>';
   	  print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum*($sum1[$uy[1]]/$ssum1),3).'</font></td>';
	  print '<td align=center align=left bgcolor=#eeeeee><font class=top2>'.number_format($sum1[$uy[1]],2).'</font></td>';
	 if ($flat%4==0) print '</tr>';
	 $uy = mysql_fetch_row ($a);
	}
 print '<td colspan=21 bgcolor=#e8e8e8></tr>'; 
 //print '<tr><td colspan=2 bgcolor=#ffcf68 align=center><font class=tablz>Итого</font></td><td bgcolor=#ffcf68 colspan=32><font class=tablz>'.number_format($ssum1,2).'/'.$cold0.' ('.$pr0.'%)</font></td></tr>'; 
?>
</table>
<br>
<table width=1100px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<?php
 print '<tr><td><img width=1100 height=350 src="charts/barplots151.php?type=1&n1=1&st='.$st.'&fn='.$fn.'&month='.$_GET["date"].'&obj='.$_GET["obj"].'"></td></tr>';
 print '<tr><td><img width=1100 height=350 src="charts/barplots151.php?type=1&n1=2&st='.$st.'&fn='.$fn.'&month='.$_GET["date"].'&obj='.$_GET["obj"].'"></td></tr>';
?>
</table>

</body>
</html>                                                        .,