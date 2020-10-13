<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Суточные показания стояковых тепловычислителей</title>
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
 print '<td bgcolor=#ffcf68 align=center width="100px"><font class=tablz><a href="index.php?sel=irp4&pr=1&obj='.$_GET["obj"].'">Q</a>|<a href="index.php?sel=irp4&pr=2&obj='.$_GET["obj"].'">V</a>|<a href="index.php?sel=irp4&pr=3&obj='.$_GET["obj"].'">M</a>|<a href="index.php?sel=irp4&pr=4&obj='.$_GET["obj"].'">H1</a>|<a href="index.php?sel=irp4&pr=5&obj='.$_GET["obj"].'">H2</a></font></td>';
 while ($uy)
         {
	  print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$uy[3].'/'.$uy[4].'</font></td>';
	  $irp[$cn]=$uy[1];
	  $cn++;
	  $uy = mysql_fetch_row ($a);
         }
?>
</tr>

<?php
 $today=getdate();
 $ye=$today["year"];
 $mm=$today["mon"]=1;
 $mx=$today["mday"]=2;
 $mn=1; $nx=15; $nn=1;
 $x=0;
 $month=''.$month;
 //echo $mx.'<br>';
 if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];
 if ($today["mday"]<10) $today["mday"]='0'.$today["mday"];

 for ($tn=$nx; $tn>=$nn; $tn--)
 for ($tm=$mx; $tm>=$mn; $tm--)
    {
     $data0[$x]=0; $data1[$x]=0; $dtt=-1;
     if ($tm<10)
	{
	 $date1=$today["year"].$today["mon"].'0'.$tm.'000000';
	 $dat[$x]=$tm.'-'.$today["mon"].'-'.$today["year"];
	}
     else
	{
	 $date1=$today["year"].$today["mon"].$tm.'000000';
	 $dat[$x]=$tm.'-'.$today["mon"].'-'.$today["year"];
	} 
     if ($_GET["pr"]=='' || $_GET["pr"]=='1') $query = 'SELECT * FROM prdata WHERE type=2 AND value>0 AND value<2000 AND prm=13 AND pipe=0 AND date='.$date1;
     if ($_GET["pr"]=='2') $query = 'SELECT * FROM prdata WHERE type=2 AND prm=11 AND value>0 AND value<2000 AND pipe=0 AND date='.$date1;
     if ($_GET["pr"]=='3') $query = 'SELECT * FROM prdata WHERE type=2 AND prm=12 AND value>0 AND value<2000 AND pipe=0 AND date='.$date1;
     if ($_GET["pr"]=='4') $query = 'SELECT * FROM prdata WHERE type=2 AND prm=1 AND pipe=0 AND date='.$date1;
     if ($_GET["pr"]=='5') $query = 'SELECT * FROM prdata WHERE type=2 AND prm=1 AND pipe=1 AND date='.$date1;
     //echo $query;
     
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     while ($uy)
         {	  
	  for ($y=0;$y<$cn;$y++) 
		if ($irp[$y]==$uy[1]) $data[$x][$y]=$uy[5];
	  $uy = mysql_fetch_row ($a);
         }     
     if ($tm==1)
	{
         if ($today["mon"]>1) $today["mon"]--;
         else { $today["mon"]=12; $today["year"]--; }
         if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];

	     $today["mday"]=31;
	     if (!checkdate ($today["mon"],31,$today["year"])) { $today["mday"]=30; }
	     if (!checkdate ($today["mon"],30,$today["year"])) { $today["mday"]=29; }
	     if (!checkdate ($today["mon"],29,$today["year"])) { $today["mday"]=28; }
	     $mx=$today["mday"];
	}
     $x++;
    }
 $max=$x;

//echo $max.' '.$x;
for ($y=0;$y<$max;$y++)
{
 print '<tr><td align=center bgcolor=#ffcf68 width=100><font class=tablz>'.$dat[$y].'</font></td>';
 for ($u=0;$u<$cn;$u++)
     {
      print '<td align=center bgcolor=#ffffff><font class=top5>';
      if (!$data[$y][$u]) $data[$y][$u]=$data[$y+1][$u];
      if ($data[$y][$u]) printf ("%.5f",$data[$y][$u]);
	else printf ("-");
      print '</font></td>';
     }
 print '</tr>';
}
?>

</table>
</body>
</html>