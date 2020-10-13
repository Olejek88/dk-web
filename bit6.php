<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Технологические параметры теплоснабжения индивидуальных жилых помешений</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1200px cellpadding=1 cellspacing=1 align=center>
<tr>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 print '<td width=1200 valign=top><table width=1200 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
 <thead><font class=tablz>Технологические параметры теплоснабжения индивидуальных жилых помешений</font></thead>
 <tr><td bgcolor=#ffcf68 align=center><font class=tablz>Время, час</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Показания счетчика на входе, Гкал</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Показания счетчика на входе, Гкал</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>№ этажа</font></td>';
 print '<td bgcolor=#ffcf68 align=center colspan=21><font class=tablz>Расход теплоносителя по стоякам, м3/час; температура по стоякам и этажам</font></td>';
 print '</tr>';
 $today=getdate(); $today["hours"]=$today["hours"]-2;
 print '<tr><td bgcolor=#e8e8e8 align=center><font class=tablz>'.$today["hours"].':00</font></td>';
 print '<td bgcolor=#e8e8e8 align=center></td>';
 print '<td bgcolor=#e8e8e8 align=center></td>';
 print '<td bgcolor=#e8e8e8 align=center><font class=tablz>номер стояка</font></td>';
 $query = 'SELECT * FROM dev_irp ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
	  if ($cn<22) print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$uy[3].'</font></td>';
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }
 print '</tr>';
 print '<tr><td bgcolor=#e8e8e8 align=center></td>';
 $query = 'SELECT * FROM data WHERE flat=0 AND prm=13 AND type=1 AND source=1 ORDER BY date DESC LIMIT 3';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	{
	 if ($uy[3]>0) { print '<td bgcolor=#eeeeee align=center><font class=top5>'.$uy[3].'</font></td>'; break; }
	 $uy = mysql_fetch_row ($a);
	}
 $query = 'SELECT * FROM data WHERE flat=0 AND prm=13 AND type=1 AND source=3 ORDER BY date DESC LIMIT 3';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	{
	 if ($uy[3]>0) { print '<td bgcolor=#eeeeee align=center><font class=top5>'.$uy[3].'</font></td>'; break; }
	 $uy = mysql_fetch_row ($a);
	}
 print '<td bgcolor=#e8e8e8 align=center><font class=top5>Расход м3/ч</font></td>';

 $query = 'SELECT * FROM dev_irp WHERE strut<22 ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
	  $query = 'SELECT * FROM prdata WHERE (type=0 OR type=2) AND device='.$uy[1].' AND prm=12 ORDER BY date DESC';
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  while ($ui)
         	{
		  $irp=number_format($ui[5],2);		  
		  if ($ui[5]>0)  {print '<td bgcolor=#eeeeee align=center><font class=top5>'.$irp.'</font></td>'; break; }
		  $ui = mysql_fetch_row ($e);			
		}
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }
 for ($lv=10;$lv>=0;$lv--)
	{
	  print '<tr><td bgcolor=#eeedd8 align=center></td>';
	  print '<td bgcolor=#eeedd8 align=center></td>';
	  print '<td bgcolor=#eeedd8 align=center></td>';
	  print '<td bgcolor=#eeedd8 align=center>'.$lv.'</td>';
	  if ($lv==10 || $lv==0)
		{
 	  	 for ($str=1;$str<22;$str++)
			{
			  $query = 'SELECT * FROM dev_irp WHERE strut='.$str;
			  $a = mysql_query ($query,$i);
			  $uy = mysql_fetch_row ($a);
			  while ($uy)
				{
				 if ($lv==10) $query = 'SELECT * FROM prdata WHERE prm=4 AND type=0 AND pipe=1 AND device='.$uy[1];
			         else $query = 'SELECT * FROM prdata WHERE prm=4 AND type=0 AND pipe=0 AND device='.$uy[1];
			  	     $e = mysql_query ($query,$i);
			  	     $ui = mysql_fetch_row ($e);
				     $irp=number_format($ui[5],2);
				     print '<td bgcolor=#e8e8e8 align=center><font class=top5>'.$irp.'</font></td>';			
				 $uy = mysql_fetch_row ($a);
				}
			}
		}
	  else
	  for ($str=1;$str<22;$str++)
		{
		  $query = 'SELECT * FROM dev_bit WHERE strut_number='.$str.' ORDER BY flat_number';
		  $a = mysql_query ($query,$i);
		  $uy = mysql_fetch_row ($a); $cn=0;
		  while ($uy)
			{
                  	 $query = 'SELECT * FROM flats WHERE flat='.$uy[8];
			 $e = mysql_query ($query,$i);
			 $ui = mysql_fetch_row ($e);
			 if ($ui && $ui[2]==$lv)
			    {
			     $query = 'SELECT * FROM prdata WHERE prm=4 AND type=0 AND device='.$uy[1];
		  	     $e = mysql_query ($query,$i);
		  	     $ui = mysql_fetch_row ($e);
			     $irp=number_format($ui[5],2); $cn=1;		  
			     print '<td bgcolor=#e8e8e8 align=center><font class=top5>'.$irp.'</font></td>';
			    }			 
			 $uy = mysql_fetch_row ($a);
			}
		 if ($cn==0) print '<td bgcolor=#e8e8e8 align=center></td>';
		}
	  print '</tr>';	  	 
	}

 print '<tr><td bgcolor=#e8e8e8 align=center><font class=tablz>'.$today["hours"].':00</font></td>';
 print '<td bgcolor=#e8e8e8 align=center></td>';
 print '<td bgcolor=#e8e8e8 align=center></td>';
 print '<td bgcolor=#e8e8e8 align=center><font class=tablz>номер стояка</font></td>';
 $query = 'SELECT * FROM dev_irp ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
	  if ($cn>21) print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$cn.'</font></td>';
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }
 print '</tr>';
 print '<tr><td bgcolor=#e8e8e8 align=center></td>';
 $query = 'SELECT * FROM data WHERE flat=0 AND prm=13 AND type=1 AND source=1 ORDER BY date DESC LIMIT 3';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	{
	 if ($uy[3]>0) { print '<td bgcolor=#eeeeee align=center><font class=top5>'.$uy[3].'</font></td>'; break; }
	 $uy = mysql_fetch_row ($a);
	}
 $query = 'SELECT * FROM data WHERE flat=0 AND prm=13 AND type=1 AND source=3 ORDER BY date DESC LIMIT 3';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	{
	 if ($uy[3]>0) { print '<td bgcolor=#eeeeee align=center><font class=top5>'.$uy[3].'</font></td>'; break; }
	 $uy = mysql_fetch_row ($a);
	}
 print '<td bgcolor=#e8e8e8 align=center><font class=top5>Расход м3/ч</font></td>';

 $query = 'SELECT * FROM dev_irp WHERE strut>21 ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
	  $query = 'SELECT * FROM prdata WHERE (type=0 OR type=2) AND device='.$uy[1].' AND prm=12 ORDER BY date DESC';
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  while ($ui)
         	{
		  $irp=number_format($ui[5],2);		  
		  if ($ui[5]>0)  {print '<td bgcolor=#eeeeee align=center><font class=top5>'.$irp.'</font></td>'; break; }
		  $ui = mysql_fetch_row ($e);			
		}
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }
 for ($lv=10;$lv>=0;$lv--)
	{
	  print '<tr><td bgcolor=#eeedd8 align=center></td>';
	  print '<td bgcolor=#eeedd8 align=center></td>';
	  print '<td bgcolor=#eeedd8 align=center></td>';
	  print '<td bgcolor=#eeedd8 align=center>'.$lv.'</td>';
	  if ($lv==10 || $lv==0)
		{
 	  	 for ($str=22;$str<43;$str++)
			{
			  $query = 'SELECT * FROM dev_irp WHERE strut='.$str;
			  $a = mysql_query ($query,$i);
			  $uy = mysql_fetch_row ($a);
			  while ($uy)
				{
				 if ($lv==10) $query = 'SELECT * FROM prdata WHERE prm=4 AND type=0 AND pipe=1 AND device='.$uy[1];
			         else $query = 'SELECT * FROM prdata WHERE prm=4 AND type=0 AND pipe=0 AND device='.$uy[1];
			  	     $e = mysql_query ($query,$i);
			  	     $ui = mysql_fetch_row ($e);
				     $irp=number_format($ui[5],2);		  
				     print '<td bgcolor=#e8e8e8 align=center><font class=top5>'.$irp.'</font></td>';			
				 $uy = mysql_fetch_row ($a);
				}
			}
		}
	  else
	  for ($str=22;$str<43;$str++)
		{
		  $query = 'SELECT * FROM dev_bit WHERE strut_number='.$str.' ORDER BY flat_number';
		  $a = mysql_query ($query,$i);
		  $uy = mysql_fetch_row ($a); $cn=0;
		  while ($uy)
			{
                  	 $query = 'SELECT * FROM flats WHERE flat='.$uy[8];
			 $e = mysql_query ($query,$i);
			 $ui = mysql_fetch_row ($e);
			 if ($ui && $ui[2]==$lv)
			    {
			     $query = 'SELECT * FROM prdata WHERE prm=4 AND type=0 AND device='.$uy[1];
		  	     $e = mysql_query ($query,$i);
		  	     $ui = mysql_fetch_row ($e);
			     $irp=number_format($ui[5],2); $cn=1;		  
			     print '<td bgcolor=#e8e8e8 align=center><font class=top5>'.$irp.'</font></td>';
			    }			 
			 $uy = mysql_fetch_row ($a);
			}
		 if ($cn==0) print '<td bgcolor=#e8e8e8 align=center></td>';
		}
	  print '</tr>';	  	 
	}
?>
</table></td></tr></table></td>

</tr>
</table>
</body>
</html>