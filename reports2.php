<title>Система индивидуального учета энергоресурсов :: Ежемесячные отчеты</title>
<table cellpadding="2" cellspacing="1" border="0" style="width:900px" align=center>
<tr>
<td bgcolor=#ffcf68 align=center><font class="zagl">Объект</font></td>
<?php
$today=getdate();
$tm=$today["mon"]-1;
for ($pm=1; $pm<=12; $pm++)
    {	 
     $tod=31;
     if (!checkdate ($tm,31,$today["year"])) { $tod=30; }
     if (!checkdate ($tm,30,$today["year"])) { $tod=29; }
     if (!checkdate ($tm,29,$today["year"])) { $tod=28; }
     $sts=sprintf("%d%02d01000000",$today["year"],$tm); 
     $fns=sprintf("%d%02d01000000",$today["year"],$tm+1);
     $month=$tm; include("time.inc");
     print '<td bgcolor=#ffcf68 align=center><font class="zagl">'.$month.', '.$today["year"].'</font></td>';

     if ($tm>1) $tm--;
     else { $tm=12; $today["year"]--; }
    }
print '</tr>';

for ($obj=1; $obj<=14; $obj++)
    {
     $_GET["obj"]=$obj;
     include("config/local.php");
     $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
     $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
     $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
     $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

     $query = 'SELECT * FROM build WHERE id='.$_GET["obj"];
     $e = mysql_query ($query,$i);
     $ui = mysql_fetch_row ($e);

     print '<tr><td bgcolor=#ffcf68 align=center><font class="zagl">'.$ui[1].'</font></td>';

	$today=getdate();
	$tm=$today["mon"]-1;
	for ($pm=1; $pm<=12; $pm++)
	    {	 
	     $tod=31;  $sumt=0;
	     if (!checkdate ($tm,31,$today["year"])) { $tod=30; }
	     if (!checkdate ($tm,30,$today["year"])) { $tod=29; }
	     if (!checkdate ($tm,29,$today["year"])) { $tod=28; }
	     $sts=sprintf("%d%02d01000000",$today["year"],$tm); 
	     $fns=sprintf("%d%02d01000000",$today["year"],$tm+1);
	     $month=$tm; include("time.inc");


  	     $query = 'SELECT COUNT(id) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND prm=13 AND flat>0';
	     if ($e = mysql_query ($query,$i))
	     if ($ui = mysql_fetch_row ($e)) $sumt=$ui[0]; 

	     if ($sumt)
		 {
		  $ffile=sprintf("reports2/%02d-%d%02d.csv",$_GET["obj"],$today["year"],$tm);
		  if (!file_exists($ffile))
		      {
		       $fp=fopen($ffile,"w");
		       $prt='№;Квартира;Тепло,ГКал;ХВС,м3;ГВС,м3'.PHP_EOL; fwrite ($fp,$prt);
		       $query = 'SELECT * FROM flats ORDER BY flat';
		       if ($a = mysql_query ($query,$i))
		       while ($uy = mysql_fetch_row ($a))
				{
				 $hvs[$uy[1]]=$gvs[$uy[1]]=$teplo[$uy[1]]=0;
				 $query = 'SELECT SUM(value)/4186,COUNT(id) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND prm=13 AND flat='.$uy[1];
				 if ($e = mysql_query ($query,$i))
				 if ($ui = mysql_fetch_row ($e)) $teplo[$uy[1]]=$ui[0]; 
				 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND (prm=12 OR prm=11) AND source=6 AND flat='.$uy[1];
				 if ($e = mysql_query ($query,$i))
				 if ($ui = mysql_fetch_row ($e)) $hvs[$uy[1]]=$ui[0];
				 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND (prm=12 OR prm=11) AND source=5 AND flat='.$uy[1];
				 if ($e = mysql_query ($query,$i))
				 if ($ui = mysql_fetch_row ($e)) $gvs[$uy[1]]=$ui[0];
			         $prt=$uy[1].';'.$uy[5].';'.number_format($teplo[$uy[1]],5).';'.$hvs[$uy[1]].';'.$gvs[$uy[1]].PHP_EOL; fwrite ($fp,$prt);
				}
		        fclose($fp);
		       }
		  print '<td bgcolor=#e3eaf3 align=center><font class="top2"><a href="'.$ffile.'">'.$ffile.' (скачать)</a></font></td>';
		 }
	     else print '<td bgcolor=#ffffff align=center><font class="top2">-</font></td>';

	     if ($tm>1) $tm--;
	     else { $tm=12; $today["year"]--; }
	     $cn++;
	    }
     print '</tr>';      
  }
?>
</table>
