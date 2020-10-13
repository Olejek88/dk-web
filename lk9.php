<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Система учета индивидуального потребления энергоресурсов :: Посуточный отчет по всем квартирам</title>
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
     $query = 'SELECT * FROM device WHERE type=2 AND flat='.$uy[1];
     $e = mysql_query ($query,$i);
     $ui = mysql_fetch_row ($e);
     if ($ui) 
	{
	 $query = 'SELECT * FROM dev_2ip WHERE device='.$ui[1];
	 $e2 = mysql_query ($query,$i);
	 if ($e2) $uo = mysql_fetch_row ($e2);
	 $device[$cn]=$ui[1]; 
	 $cn++;
	}
     $uy = mysql_fetch_row ($a);
    }
 $max=$cn-1; $cn=0; 
 for ($w=0;$w<=$max;$w++) $data01[$w]=$data02[$w]=$data03[$w]=-1;

 $deep=70;

 $today=getdate();
 if ($_GET["year"]=='') $ye=$today["year"];
 else $ye=$_GET["year"];
 if ($_GET["month"]=='') $mn=$today["mon"];
 else $mn=$_GET["month"];
 $x=0; $tm=$dy=$today["mday"]-1;
 for ($tn=1; $tn<=$deep; $tn++)
	{		
	 $date[$x]=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $dat[$x]=sprintf ("%d-%02d-%02d 00:00:00",$ye,$mn,$tm);
	 $dt[$x]=sprintf ("%02d-%02d",$mn,$tm);
         $x++; $tm--;
         if ($tm==0)
		{
		 $mn--;
		 if ($mn==0) { $mn=12; $ye--; }
		 $dy=31;
		 if (!checkdate ($mn,31,$ye)) { $dy=30; }
		 if (!checkdate ($mn,30,$ye)) { $dy=29; }
		 if (!checkdate ($mn,29,$ye)) { $dy=28; }
		 $tm=$dy;
		}
	}

 $query = 'SELECT * FROM prdata WHERE type=2 AND (prm=6 OR prm=8) AND date>20100801000000 ORDER BY date DESC';
// echo $query;
 $a = mysql_query ($query,$i);
 if ($a) $uy = mysql_fetch_row ($a);
 while ($uy)
      {          
       for ($x=0; $x<$deep; $x++)
       for ($w=0;$w<=$max;$w++)	
	  {
	  // echo $device[$w].' '.$uy[1].' '.$uy[4].' '.$dat[$x].'<br>'; 
	   if ($device[$w]==$uy[1] && $uy[4]==$dat[$x] && $uy[2]==8) { $data[$x][$w]=$uy[5]; break; }
	   if ($device[$w]==$uy[1] && $uy[4]==$dat[$x] && $uy[2]==6) { $data2[$x][$w]=$uy[5]; break; }
	  }
       $uy = mysql_fetch_row ($a);
      }
?>

<br>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>Изменение потребления воды по дням</font></td></tr>
<tr><td style="width:1190px" valign=top>
<table width="1190px" cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr>
<?php
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="140px"><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Тип</font></td>';
 for ($x=$deep; $x>=0; $x--)
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$dt[$x].'</font></td>';
 print '</tr>'; 
?>

<?php
 $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $w=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $flat=$ui[1]; $abn=$ui[5]; $nab=$ui[10];
	  $sum0=$flt[$flat];
	  if ($sum0<0) $sum0=0; $ssum0+=$sum0;

	  print '<tr><td align=center bgcolor=#ffcf68 rowspan="2"><font class=top2>'.$flat.'</font></td>'; 
	  print '<td align=left bgcolor=#ffcf68 rowspan="2"><font class=top2>'.$abn.'</font></td>';
	  print '<td align=left bgcolor=#ffcf68><font class=top2>хвс</font></td>';
	  for ($x=$deep;$x>=0;$x--) 
		{
		 if ($data[$x][$w]>0) print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($data[$x][$w],2).'</font></td>';
		 else  print '<td align=center align=left bgcolor=#ffffff><font class=top2>-</font></td>';
		}
	  print '</tr>'; 
	  print '<tr><td align=left bgcolor=#ffcf68><font class=top2>гвс</font></td>';
	  for ($x=$deep;$x>=0;$x--) 
		{
		 if ($data2[$x][$w]>0) print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($data2[$x][$w],2).'</font></td>';
		 else  print '<td align=center align=left bgcolor=#ffffff><font class=top2>-</font></td>';
		}
	  print '</tr>'; 
	  $w++;
	  $uy = mysql_fetch_row ($a);
	}
?>
</table></td></tr></table>
</body>
</html>