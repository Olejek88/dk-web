<?php include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $today=getdate();
 include("time.inc"); 
 $query = 'SELECT MAX(ent),MAX(rasp) FROM flats';
 $a = mysql_query ($query,$i);
 if ($a) $uy = mysql_fetch_row ($a);
 $maxent=$uy[0]; $maxrasp=$uy[1];

 if ($_GET["date"]=='') 
	{ 
         $st=sprintf ("%d%02d00000000",$today["year"],$today["mon"]);
         $fn=sprintf ("%d%02d00000000",$today["year"],$today["mon"]+1);
	 $k=1; 
	}
 else 
	{ 
	 if ($_GET["date"]!=$today["mon"]) $k=1;
	 else $k=$today["mday"]/31;
         $st=sprintf ("%d%02d00000000",$today["year"],$_GET["date"]);
         $fn=sprintf ("%d%02d00000000",$today["year"],$_GET["date"]+1);
	}

if ($_GET["date"]=='') $tm=$today["mon"];
else $tm=$_GET["date"];

if ($_GET["year"]=='') $_GET["year"]=$today["year"];

     if ($tm==1) $dat='Январь '.$today["year"];
     if ($tm==2) $dat='Февраль '.$today["year"];
     if ($tm==3) $dat='Март '.$today["year"];
     if ($tm==4) $dat='Апрель '.$today["year"];
     if ($tm==5) $dat='Май '.$today["year"];
     if ($tm==6) $dat='Июнь '.$today["year"];
     if ($tm==7) $dat='Июль '.$today["year"];
if ($_GET["obj"]==1) $yy=0;
if ($_GET["obj"]==2) $yy=190;
?>

<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Система учета индивидуального потребления энергоресурсов :: Распределение теплопотребления</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>


<div style="position:absolute;top:5;left:400;width:340;height:300;z-index:10;visibility:visible;">
<font class=tablz3>Относительное удельное теплопотребление квартир, усредненное по этажам. Показан процент по отношению к квартире с наименьшим удельным теплопотреблением. Диаграмма за 
<?php 
 print $dat.'<br>Другие месяцы: '; 
 for ($tm=1; $tm<=12; $tm++)
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

     print '<a href="mnem2.php?obj='.$_GET["obj"].'&date='.$tm.'"><font class=tablz3>'.$dat.'</a> ';
     $uy = mysql_fetch_row ($a);
    }
 ?>
</font>
</div>

<div style="position:absolute;top:<?php print $yy; ?>;left:0;width:1200;height:628;z-index:0;visibility:visible;"><img src="files/hs<?php print $_GET["obj"]; ?>.jpg"></div>
<div style="position:absolute;top:630;left:0;width:1200;height:200;">
<?php
 $query = 'SELECT * FROM dev_irp ORDER BY adr';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); 
 while ($uy)
        {
	 $query = 'SELECT SUM(value) FROM prdata WHERE type=2 AND prm=13 AND device='.$uy[1].' AND date<'.$fn.' AND date>'.$st;	
	 //echo $query;
	 $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
	 $irpdata[$uy[2]]=$ui[0]; $sums+=$irpdata[$uy[2]];
	 $uy = mysql_fetch_row ($a); 
	}

 $query = 'SELECT SUM(value) FROM data WHERE flat=0 AND type=2 AND prm=13 AND source=2 AND date<'.$fn.' AND date>'.$st;	
// echo $query;
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 $sum=$ui[0]; 

 $query = 'SELECT SUM(square),SUM(rnum) FROM flats';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $kk=$uy[0]; $kk1=$uy[1];

 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=1; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $flat=$ui[1]; $abn=$ui[5]; $square=$ui[8]; $cold=number_format($ui[8]*0.0322*(59)/31,2);
	  $nab=$ui[10];
	  $cold0+=$cold;

	  $query = 'SELECT * FROM dev_bit WHERE flat_number='.$uy[1];
	  $b = mysql_query ($query,$i);
	  $ut = mysql_fetch_row ($b); $data01[$cm]=$data02[$cm]=0;
	  while ($ut)
	         {
		  $query = 'SELECT * FROM dev_irp WHERE strut='.$ut[9];
		  $e = mysql_query ($query,$i);
        	  if ($e) $ui = mysql_fetch_row ($e);
		  
		  if ($ui[2]==39) { $data01[$cm]+=$irpdata[29]/(9*4190); }
		  else $data01[$cm]+=$irpdata[$ui[2]]/(9*4190);

		  //$data01+=$irpdata[$ui[2]]/(9*4190);
	 	  //echo $query.' '.$irpdata[$ui[1]];	
		  $ut = mysql_fetch_row ($b); 
		 }
          $data02[$cm]=(($sum-$sums/4190))*($square/$kk);	  
 	  //echo $sum.' '.number_format($sums/4190,2).'<br>';
	  $data01[$cm]+=(($sum-$sums/4190))*($square/$kk);
	  $sum0=$data01[$cm];
	  $ssum0+=$sum0;

	  while (1)
		{
		 if ($sum0>($cold+$cold)) { $n1++; break; }
		 if ($sum0>$cold) { $n2++; break; }
		 $n0++; break;
		}
	 $cm++;	 
	 $uy = mysql_fetch_row ($a);
	}
 $pr0=number_format($n0*100/$cm,2);
 $pr1=number_format($n1*100/$cm,2);
 $pr2=number_format($n2*100/$cm,2);
 $pr00=number_format(100*($ssum0-$cold0)/$cold0,2);
?>

<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>

<?php
 print '<tr><td bgcolor=#ffcf68 align=center width="20px"><font class=tablz>Абоненты</font></td>'; 
 for ($ent=1;$ent<=$maxent;$ent++)
 for ($rs=1;$rs<=$maxrasp;$rs++)
     { 
      $query = 'SELECT * FROM flats WHERE ent='.$ent.' AND rasp='.$rs.' ORDER BY flat';
      $a = mysql_query ($query,$i);
      $uy = mysql_fetch_row ($a);
      print '<td bgcolor=#ffcf68 align=left valign=top>';
      while ($uy)
         {
          print '<font class="tablz">['.$uy[1].'] </font>';
          $uy = mysql_fetch_row ($a);
	 }
      print '</td>';
     }
 print '</tr>'; 

 print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>Sкв</font></td>';
 for ($ent=1;$ent<=$maxent;$ent++)
 for ($rs=1;$rs<=$maxrasp;$rs++)
     { 
      $query = 'SELECT * FROM flats WHERE ent='.$ent.' AND rasp='.$rs.' ORDER BY flat';
      $a = mysql_query ($query,$i);
      $uy = mysql_fetch_row ($a);
      while ($uy)
         {
          $s=$uy[8];
          $uy = mysql_fetch_row ($a);
	 }
      print '<td bgcolor=#eeeeee align=center><font class=top2>'.$s.'</font></td>';
     }
 print '</tr>'; 
 print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>ГКал (общ)</font></td>';
 for ($ent=1;$ent<=$maxent;$ent++)
 for ($rs=1;$rs<=$maxrasp;$rs++)
     { 
      $query = 'SELECT * FROM flats WHERE ent='.$ent.' AND rasp='.$rs.' ORDER BY flat';
      $a = mysql_query ($query,$i);
      $uy = mysql_fetch_row ($a); $s=$n=$s2=0;
      while ($uy)
         {
          $s+=$data01[$uy[1]]; $s2+=$data02[$uy[1]]; $n++;	   
          $uy = mysql_fetch_row ($a);
	 }
      if ($n>0) print '<td bgcolor=#eeeeee align=center><font class=top2>'.number_format($s/$n,2).' ('.number_format($s2/$n,2).')</font></td>';
      else print '<td bgcolor=#eeeeee align=center><font class=top2>- (н/д)</font></td>';
     }
 print '</tr>'; 
 print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>Руб/кв.м.</font></td>';
 $min=1000;

 for ($ent=1;$ent<=$maxent;$ent++)
 for ($rs=1;$rs<=$maxrasp;$rs++)
     { 
      $query = 'SELECT * FROM flats WHERE ent='.$ent.' AND rasp='.$rs.' ORDER BY flat';
      $a = mysql_query ($query,$i);
      $uy = mysql_fetch_row ($a); $s=$n=0;
      while ($uy)
         {
          $s+=$data01[$uy[1]]; $n++;
	  $sq=$uy[8];
          $uy = mysql_fetch_row ($a);
	 }
      if ($sq>0 && $n>0)      
	 {
	  if ((537/$sq*($s/$n))<$min) $min=537/$sq*($s/$n);
          print '<td bgcolor=#eeeeee align=center><font class=top2>'.number_format(537/$sq*($s/$n),2).'</font></td>';
	 }
      else print '<td bgcolor=#eeeeee align=center><font class=top2>- (н/д)</font></td>';
     }
 print '</tr>'; 
 print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>%отклонения</font></td>';
 $cm=0;
 for ($ent=1;$ent<=$maxent;$ent++)
 for ($rs=1;$rs<=$maxrasp;$rs++)
     { 	 
      $query = 'SELECT * FROM flats WHERE ent='.$ent.' AND rasp='.$rs.' ORDER BY flat';
      $a = mysql_query ($query,$i);
      $uy = mysql_fetch_row ($a); $s=$n=0;
      while ($uy)
         {
          $s+=$data01[$uy[1]]; $sq=$uy[8]; $n++;
          $uy = mysql_fetch_row ($a);
	 }
      if ($n>0 && $min>0) 
	{
	 print '<td bgcolor=#eeeeee align=center><font class=top2>'.number_format(((537/$sq*($s/$n))*100/$min)-100,2).'</font></td>';
      	 $pr[$cm]=number_format((537/$sq*($s/$n))/$min,2);
	}
      else print '<td bgcolor=#eeeeee align=center><font class=top2>-</font></td>';
      $cm++;
     }
 print '</tr>'; 
?>
</tr></table></div>

<?php
 if ($_GET["obj"]==1)
 for ($fl=0;$fl<=15;$fl++)
     {
      $col='#cc3333';
      if ($pr[$fl]<1.6) $col='#ff5555';
      if ($pr[$fl]<1.4) $col='#666699';
      if ($pr[$fl]<1.25) $col='#339933';
      if ($pr[$fl]<1.10) $col='#eeeeee';
      if ($fl==0) print '<div style="position:absolute;top:250;left:120;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==1) print '<div style="position:absolute;top:250;left:20;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==2) print '<div style="position:absolute;top:120;left:80;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==3) print '<div style="position:absolute;top:40;left:230;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      

      if ($fl==4) print '<div style="position:absolute;top:200;left:426;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==5) print '<div style="position:absolute;top:200;left:512;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==6) print '<div style="position:absolute;top:350;left:450;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==7) print '<div style="position:absolute;top:350;left:290;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      

      if ($fl==8) print '<div style="position:absolute;top:350;left:723;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==9) print '<div style="position:absolute;top:350;left:615;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==10) print '<div style="position:absolute;top:200;left:670;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==11) print '<div style="position:absolute;top:200;left:800;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      

      if ($fl==12) print '<div style="position:absolute;top:350;left:970;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==13) print '<div style="position:absolute;top:350;left:1110;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==14) print '<div style="position:absolute;top:480;left:1040;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==15) print '<div style="position:absolute;top:480;left:900;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
     }

 if ($_GET["obj"]==2)
 for ($fl=0;$fl<=23;$fl++)
     {
      $col='#cc3333';
      if ($pr[$fl]<1.6) $col='#ff5555';
      if ($pr[$fl]<1.4) $col='#666699';
      if ($pr[$fl]<1.25) $col='#339933';
      if ($pr[$fl]<1.10) $col='#eeeeee';
      if ($fl==1) print '<div style="position:absolute;top:372;left:12;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==4) print '<div style="position:absolute;top:372;left:248;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';
      if ($fl==7) print '<div style="position:absolute;top:372;left:320;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==10) print '<div style="position:absolute;top:372;left:558;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==13) print '<div style="position:absolute;top:372;left:630;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==16) print '<div style="position:absolute;top:372;left:870;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==19) print '<div style="position:absolute;top:372;left:940;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==22) print '<div style="position:absolute;top:372;left:1180;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      

      if ($fl==0) print '<div style="position:absolute;top:510;left:85;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==5) print '<div style="position:absolute;top:510;left:178;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==6) print '<div style="position:absolute;top:510;left:392;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==11) print '<div style="position:absolute;top:510;left:490;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==12) print '<div style="position:absolute;top:510;left:700;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==17) print '<div style="position:absolute;top:510;left:797;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==18) print '<div style="position:absolute;top:510;left:1018;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==23) print '<div style="position:absolute;top:510;left:1110;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      

      if ($fl==2) print '<div style="position:absolute;top:250;left:45;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==3) print '<div style="position:absolute;top:250;left:212;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==8) print '<div style="position:absolute;top:250;left:357;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==9) print '<div style="position:absolute;top:250;left:522;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==14) print '<div style="position:absolute;top:250;left:667;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==15) print '<div style="position:absolute;top:250;left:832;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==20) print '<div style="position:absolute;top:250;left:980;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
      if ($fl==21) print '<div style="position:absolute;top:250;left:1145;width:60;height:20;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><font class=zagl2>'.$pr[$fl].'</font></div>';      
     }
?>
<div style="position:absolute;top:0;left:1000;width:200;height:200;margin-left:0;padding-left:0;visibility:visible;z-index:15;background-color:'.$col.';text-align:center;vertical-align:center"><img src="files/comp.jpg"></div>
</body>
</html>                                                                                 