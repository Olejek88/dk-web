<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Стояковые</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

 $query = 'SELECT * FROM dev_irp ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=0;
 print '<td bgcolor=#ffcf68 align=center width="100px"><font class=tablz><a href="irp.php?pr=1">Q</a>|<a href="irp.php?pr=2">V</a>|<a href="irp.php?pr=3">M</a>|<a href="irp.php?pr=4">H1</a>|<a href="irp.php?pr=5">H2</a></font></td>';
 while ($uy)
         {
	  print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$uy[2].'</font></td>';
	  $irp[$cn]=$uy[1];
	  $cn++;
	  $uy = mysql_fetch_row ($a);
         }
?>
</tr>

<?php
 $today=getdate();
 $ye=$today["year"];
 $mm=$today["mon"];
 $mx=$today["hours"]-4;

 $mn=1; $nx=6; $nn=1;
 $today["mday"]=$today["mday"]-2;
 $x=$today["hours"]+48;
 $max=$x;
 $month=''.$month;
 //echo $mx.'<br>';
 if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];
 if ($today["mday"]<10) $today["mday"]='0'.$today["mday"];
 echo $nx.' '.$nn.'|'.$mx.' '.$mn;

 for ($tn=0; $tn<=550; $tn++)
    {
     $data0[$x]=0; $data1[$x]=0; $dtt=-1;
     $date1=sprintf ("%d%02d%02d%02d0000",$today["year"],$today["mon"],$today["mday"],$ts);
     $dat[$x]=sprintf ("%02d %02d:00",$today["mday"],$ts);

     if ($_GET["pr"]=='' || $_GET["pr"]=='1') $query = 'SELECT * FROM prdata WHERE type=1 AND prm=13 AND pipe=0 AND date='.$date1;
     if ($_GET["pr"]=='2') $query = 'SELECT * FROM prdata WHERE type=1 AND prm=11 AND pipe=0 AND date='.$date1;
     if ($_GET["pr"]=='3') $query = 'SELECT * FROM prdata WHERE type=1 AND prm=12 AND pipe=0 AND date='.$date1;
     if ($_GET["pr"]=='4') $query = 'SELECT * FROM prdata WHERE type=1 AND prm=1 AND pipe=0 AND date='.$date1;
     if ($_GET["pr"]=='5') $query = 'SELECT * FROM prdata WHERE type=1 AND prm=1 AND pipe=1 AND date='.$date1;
     
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     while ($uy)
         {	  
	  for ($y=0;$y<$cn;$y++) 
		if ($irp[$y]==$uy[1]) $data[$x][$y]=$uy[5];
	  $uy = mysql_fetch_row ($a);
         }
     if ($tm==1 && $ts==0)
	{
	 $mn--; $ts=24;					
	 $dy=31;
	 if (!checkdate ($mn,31,$ye)) { $dy=30; }
	 if (!checkdate ($mn,30,$ye)) { $dy=29; }
	 if (!checkdate ($mn,29,$ye)) { $dy=28; }
	 $tm=$dy;
        }
     if ($ts==0) { $ts=24; $tm--; }
     $ts--;
    }

//echo $max.' '.$x;
for ($y=$max;$y>$x;$y--)
{
 print '<tr><td align=center bgcolor=#ffcf68 width=100><font class=top2>'.$dat[$y].'</font></td>';
 for ($u=0;$u<$cn;$u++)
     {
      print '<td align=center bgcolor=#ffffff><font class=top5>';
      if (!$data[$y][$u]) $data[$y][$u]=$data[$y+1][$u];
      printf ("%.1f",$data[$y][$u]);
      print '</font></td>';
     }
 print '</tr>';
}
?>

</table>
</body>
</html>