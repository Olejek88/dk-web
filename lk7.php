<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Абсолютные показания по холодной и горячей воде</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
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
 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i); $cn=0;
 if ($a) $uy = mysql_fetch_row ($a);
 while ($uy)
    {
     $data01[$cn]=$data02[$cn]=$data11[$cn]=$data12[$cn]=0;
     $query = 'SELECT * FROM device WHERE type=2 AND flat='.$uy[1];
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

 $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=8 AND date<'.$fn.' AND date>='.$st.' ORDER BY date';	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     for ($w=0;$w<=$max;$w++) if ($device[$w]==$ui[1])
     if ($data01[$w]==0)  $data01[$w]=$ui[5]; 
     $ui = mysql_fetch_row ($e);    
    }                                                
 $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=6 AND date<'.$fn.' AND date>='.$st.' ORDER BY date';	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     for ($w=0;$w<=$max;$w++) if ($device[$w]==$ui[1])
     if ($data02[$w]==0)  $data02[$w]=$ui[5]; 
     $ui = mysql_fetch_row ($e);    
    }                                                

 $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=8 AND date<='.$fn.' ORDER BY date DESC LIMIT 10000';
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     for ($w=0;$w<=$max;$w++) if ($device[$w]==$ui[1])
     if ($data11[$w]==0)  $data11[$w]=$ui[5]; 
     $ui = mysql_fetch_row ($e);    
    }                                                
 $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=6 AND date<='.$fn.' ORDER BY date DESC LIMIT 10000';
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     for ($w=0;$w<=$max;$w++) if ($device[$w]==$ui[1])
     if ($data12[$w]==0)  $data12[$w]=$ui[5]; 
     $ui = mysql_fetch_row ($e);    
    }                                                
 $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $a = mysql_query ($query,$i); $cm=0;
 if ($a) $uy = mysql_fetch_row ($a);
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $today["mday"]=31;
	  $flat[$cm]=$ui[1]; $abn[$cm]=$ui[5]; $cold[$cm]=number_format($ui[10]*5.4*$k,2); $hot[$cm]=number_format($ui[10]*3.6*$k,2);
	  $nab[$cm]=$ui[10]; $ust[$cm]=$uy[21];
	  $cold0+=$cold[$cm];
	  $hot0+=$hot[$cm]; 

	  $query = 'SELECT * FROM dev_2ip WHERE flat_number='.$ui[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  if ($ui) { $hvs[$flat[$cm]]=$ui[14]; $gvs[$flat[$cm]]=$ui[15]; }
	  $sum11[$cm]=$data11[$cm]+$hvs[$flat[$cm]];//-$data01[$cm];  if ($sum0[$cm]<0) $sum0[$cm]=0; $ssum0+=$sum0[$cm];
	  $sum12[$cm]=$data12[$cm]+$gvs[$flat[$cm]];//-$data02[$cm];  if ($sum1[$cm]<0) $sum1[$cm]=0; $ssum1+=$sum1[$cm];

	  $sum01[$cm]=$data01[$cm]+$hvs[$flat[$cm]];//-$data01[$cm];  if ($sum0[$cm]<0) $sum0[$cm]=0; $ssum0+=$sum0[$cm];
	  $sum02[$cm]=$data02[$cm]+$gvs[$flat[$cm]];//-$data02[$cm];  if ($sum1[$cm]<0) $sum1[$cm]=0; $ssum1+=$sum1[$cm];

	 $cm++;	 
	 $uy = mysql_fetch_row ($a);
	}
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

     $sts=sprintf ("%d%02d00000000",$today["year"],$tm);
     $fns=sprintf ("%d%02d00000000",$today["year"],$tm+1);
     print '<td align=center style="background-color:pink"><a href="index.php?sel=lk7&obj='.$_GET["obj"].'&st='.$sts.'&fn='.$fns.'&date='.$tm.'&year='.$today["year"].'"><font class=tablz3>'.$dat.'</font></td>';

     if ($tm==1) { $tm=12; $today["year"]--; }
     else $tm--;
     $cn--;
     $uy = mysql_fetch_row ($a);
    }
 print '</tr></table>';
?>

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
 print '<td bgcolor=#ffcf68 colspan=3 align=center><font class=tablz>ХВС</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=3 align=center><font class=tablz>ГВС</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=3 align=center><font class=tablz>ХВС</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=3 align=center><font class=tablz>ГВС</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=3 align=center><font class=tablz>ХВС</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=3 align=center><font class=tablz>ГВС</font></td></tr>'; 

 print '<tr><td bgcolor=#ffcf68 align=center width="20px"></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нач</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>кон</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>расход</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нач</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>кон</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>расход</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нач</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>кон</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>расход</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нач</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>кон</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>расход</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нач</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>кон</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>расход</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>нач</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>кон</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>расход</font></td>'; 
 print '</tr>'; 

?>
</tr>

<?php
 $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 while ($uy)
         {

	 if ($flat[$cm]%3==1) print '<tr bgcolor=#e8e8e8>';
	 while (1)
		{
		 if ($sum11[$cm]-$sum01[$cm]==0) if ($ust[$cm]==0) { $n1=2; print '<td align=center bgcolor=#ee5544><font class=top2>'.$flat[$cm].'</font></td>'; break; }
		 if ($sum12[$cm]-$sum02[$cm]==0) if ($ust[$cm]==0) { $n1=2; print '<td align=center bgcolor=#ee5544><font class=top2>'.$flat[$cm].'</font></td>'; break; }
		 if ($sum11[$cm]-$sum01[$cm]<0) if ($ust[$cm]==0) { $n1=3; print '<td align=center bgcolor=#eeee33><font class=top2>'.$flat[$cm].'</font></td>'; break; }
		 if ($sum12[$cm]-$sum02[$cm]<0) if ($ust[$cm]==0) { $n1=3; print '<td align=center bgcolor=#eeee33><font class=top2>'.$flat[$cm].'</font></td>'; break; }
		 print '<td align=center bgcolor=#eeeeee><font class=top2>'.$flat[$cm].'</font></td>'; 
		 break;
		}	 
	if ($ust[$cm]==0)
		{	
		 print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum01[$cm],2).'</font></td>';
		 print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum11[$cm],2).'</font></td>';
		 print '<td align=center align=left bgcolor=#ffcf68><font class=top2>'.number_format($sum11[$cm]-$sum01[$cm],2).'</font></td>';
		 print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum02[$cm],2).'</font></td>';
		 print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum12[$cm],2).'</font></td>';
		 print '<td align=center align=left bgcolor=#ffcf68><font class=top2>'.number_format($sum12[$cm]-$sum02[$cm],2).'</font></td>';
		}
	 else
		{
		 print '<td colspan=6 align=center align=left bgcolor=#ffffff><font class=top2>н.у.</font></td>';
		}
	 if ($flat[$cm]%3==0) print '</tr>';
	 $cm++;
	 $uy = mysql_fetch_row ($a);
	}
 print '<td colspan=21 bgcolor=#e8e8e8></tr>'; 
?>
</table>
</body>
</html>