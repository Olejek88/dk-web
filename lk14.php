<?php print '<title>Значения всех датчиков по возрастанию</title>'; ?>
<table width=990px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td><table width=990px cellpadding=0 cellspacing=0 bgcolor=#eeedd8 align=center>
<tr><td width=990px valign=top><table width=990px cellpadding=0 cellspacing=0 bgcolor=#eeedd8 align=center>
<tr><td valign=top>
<?php
 include("config/local.php");
 if ($_POST["id"]=='' || $_POST["id"]<1 || $_POST["id"]>210) $_POST["id"]=$_GET["id"];
 else $_GET["id"]=$_POST["id"];
 if ($_GET["type"]=='') $_GET["type"]=2;
 $max=300;
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $today=getdate(); 
 if ($_GET["year"]=='') $ye=$today["year"];
 else $ye=$_GET["year"];
 if ($_GET["month"]=='') $mn=$today["mon"];
 else $mn=$_GET["month"];
 $x=0; 
 if ($today["mday"]>2) $tm=$dy=$today["mday"]-1;
 else $tm=$dy=$today["mday"];

 for ($tn=1; $tn<=$max; $tn++)
	{		
	 $date1[$x]=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $dat[$x]=sprintf ("%02d-%02d-%02d 00:00:00",$ye,$mn,$tm);
	 $dats[$x]=sprintf ("%02d-%02d-%02d",$ye,$mn,$tm);
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
 if ($_GET["type"]==1) $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 if ($_GET["type"]==2) $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 if ($_GET["type"]==3) $query = 'SELECT * FROM device WHERE type=4 ORDER BY flat';
 if ($_GET["type"]==4) $query = 'SELECT * FROM device WHERE type=1 ORDER BY flat';

 $e = mysql_query ($query,$i); $ct=0;
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
         {
	  $device[$ct]=$ui[1];
	  $flat[$ct]=$ui[10];
	  $ust[$ct]=$ui[21];
	// echo $flat[$ct].' '.$device[$ct].'<br>';
	  $ct++;
	  $ui = mysql_fetch_row ($e); 
	 }
 $dev_num=$ct;
 
 if ($_GET["type"]==1) $prm=8;
 if ($_GET["type"]==2) $prm=6;
 if ($_GET["type"]==3) $prm=2;
 if ($_GET["type"]==4) $prm=1;

 $query = 'SELECT COUNT(id) FROM prdata WHERE type=2 AND prm='.$prm.' ORDER BY date DESC';
 $a = mysql_query ($query,$i); $x=$max+1; $yy=$dev_num+1;
 if ($a) $uy = mysql_fetch_row ($a);
 $query = 'SELECT * FROM prdata WHERE type=2 AND prm='.$prm.' ORDER BY date DESC';
 $a = mysql_query ($query,$i); $x=$max+1; $yy=$dev_num+1;
 if ($a) $uy = mysql_fetch_row ($a);
 while ($uy)
      {	
	for ($tn=0; $tn<$max; $tn++) 
	if ($uy[4]==$dat[$tn]) { $x=$tn; break; }

	for ($tm=0; $tm<$dev_num; $tm++) 
	if ($uy[1]==$device[$tm]) { $yy=$tm; break; }

        $data[$yy][$x]=number_format($uy[5],1);
//echo 'data['.$yy.']['.$x.']<br>';
       $uy = mysql_fetch_row ($a);
      }

 print '<table width=1190px cellpadding=1 cellspacing=1 bgcolor=#ffcf68 align=center valign=top>';
 print '<tr><td><a href="index.php?sel=lk14&type=1&obj='.$_GET["obj"].'"><font class="tablz">ХВС</font></a></td>';
 print '<td><a href="index.php?sel=lk14&type=2&obj='.$_GET["obj"].'"><font class="tablz">ГВС</font></a></td>';
 print '<td><a href="index.php?sel=lk14&type=3&obj='.$_GET["obj"].'"><font class="tablz">МЭЭ</font></a></td>';
 print '<td><a href="index.php?sel=lk14&type=4&obj='.$_GET["obj"].'"><font class="tablz">БИТ</font></a></td>';
 print '</tr></table></td></tr>';
 print '<tr><td><table width=1190px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center>
	<tr><td bgcolor=#eeedd8 align=center width=100px><font class=tablz>Дата</font></td>';
 for ($dv=0;$dv<$dev_num;$dv++)
	print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$flat[$dv].'</font></td>';
 print '</tr>';

 for ($tn=0; $tn<$max; $tn++) 
	{
	 print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>'.$dats[$tn].'</font></td>';
	 for ($dv=0;$dv<$dev_num;$dv++)
		{
		 if ($ust[21]=='0') print '<td bgcolor=#ffffff align=center><font class=top5>'.$data[$dv][$tn].'</font></td>'; 
		 if ($ust[21]=='1') print '<td bgcolor=#e8e8e8 align=center><font class=top5>'.$data[$dv][$tn].'</font></td>'; 
		}
	 print '</tr>';
	}
 ?>
</td></tr>
</table>
</td></tr>
</table>

</body>
</html>
