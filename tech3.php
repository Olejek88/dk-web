<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Матрица расчетов разницы энтальпий по стоякам и этажам</title>
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
 print '<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center><tr bgcolor=#ffcf68><td><font class=tablz3>ЭТ/СТ</font></td>';
 $query = 'SELECT * FROM dev_irp';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); 
 while ($uy)
    {
     print '<td align=center><font class=tablz3>'.$uy[2].'</font></td>';
     $uy = mysql_fetch_row ($a);  		 
    }
 print '</tr>';
 $query = 'SELECT * FROM dev_bit';
 $a = mysql_query ($query,$i); $cou=0;
 if ($a) $uy = mysql_fetch_row ($a); 
 while ($uy) 
	{
	 $dev[$cou]=$uy[1];
	 $cou++;
	 $uy = mysql_fetch_row ($a); 
	}

 $query = 'SELECT device,value FROM prdata WHERE prm=1 AND type=2 ORDER BY date DESC LIMIT 50000';
 $b = mysql_query ($query,$i);
 if ($b) $ut = mysql_fetch_row ($b);
 while ($ut)
	{
	 for ($rr=0;$rr<=$cou;$rr++)
	 if ($h[$rr]==0)
	 if ($dev[$rr]==$ut[0])  { $h[$rr]=$ut[1]; break; }

         $ut = mysql_fetch_row ($b);
	}

 for ($tt=9;$tt>=1;$tt--)
  {
   print '<tr bgcolor=#ffcf68><td bgcolor=#ffcf68 align=center><font class=tablz3>'.$tt.'</font></td>';
   $query = 'SELECT * FROM dev_irp';

   $a = mysql_query ($query,$i);
   $uy = mysql_fetch_row ($a); 
   while ($uy)
     {
      print '<td bgcolor=#ffffff valign=top><table cellpadding=1 cellspacing=1 bgcolor=#664466>';
      $query = 'SELECT * FROM field WHERE type=1 AND strut='.$uy[2].' ORDER BY flat DESC'; 
      $e = mysql_query ($query,$i);
      $ui = mysql_fetch_row ($e);
      while ($ui)                
	{
	 $query = 'SELECT * FROM flats WHERE level='.$tt.' AND flat='.$ui[6].' ORDER BY flat DESC'; 
	 $t = mysql_query ($query,$i);
	 $ut = mysql_fetch_row ($t); 
	 if ($ut)
		{
		 $b1=$b2=0;
		 print '<tr>';
		 for ($rr=0;$rr<=$cou;$rr++)
			{
			 //echo $dev[$rr].' '.$ui[4].'<br>';
			 if ($dev[$rr]==$ui[4])  $b1=$h[$rr];
			 if ($dev[$rr]==$ui[5])  $b2=$h[$rr];
			} 
		 //$query = 'SELECT * FROM prdata WHERE type=2 AND device='.$ui[4].' AND prm=1 ORDER BY date DESC LIMIT 1';
		 //$t = mysql_query ($query,$i);
		 //$ut = mysql_fetch_row ($t); if ($ut) $b1=$ut[5];
		 //$query = 'SELECT * FROM prdata WHERE type=2 AND device='.$ui[5].' AND prm=1 ORDER BY date DESC LIMIT 1';
		 //$t = mysql_query ($query,$i);
		 //$ut = mysql_fetch_row ($t); if ($ut) $b2=$ut[5];
		 if ($b1>$b2) 
			{
			 print '<td bgcolor=#ffffff><font class=top5>'.number_format($b1,2).' '.$ui[4].'</font></td>';
			 print '<td bgcolor=#ffffff><font class=top5>'.number_format($b2,2).' '.$ui[5].'</font></td>';
			}
		 else   {
			 print '<td bgcolor=#dd9999><font class=top5>'.number_format($b1,2).' '.$ui[4].'</font></td>';
			 print '<td bgcolor=#dd9999><font class=top5>'.number_format($b2,2).' '.$ui[5].'</font></td>';
			}
		 print '</tr>';		 
		}
	 $ui = mysql_fetch_row ($e); 
	}
      print '</table></td>';
      $uy = mysql_fetch_row ($a);  		 
     }
  }
?>
</table>
</body>
</html>