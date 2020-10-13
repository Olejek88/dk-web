<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Баланс суточный по энергоресурсам</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1200px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<tr>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
 print '<td width=1200 valign=top><table width=1200 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr>
 <td bgcolor=#ffcf68 align=center colspan=3><font class=tablz>Баланс показаний</font></td>';
 for ($fl=1; $fl<43;$fl++) $df[$fl]=0; 

 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
	  if ($cn<30) print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$uy[1].'</font></td>';
	  $rnum[$cn]=$uy[10];
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }

 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Всего</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Небаланс</font></td></tr>';
 $today["mday"]=30; //$today["mday"]-2;
 $today["mon"]='04';
 //------------------------------------------------------------------------------------------------
 for ($tm=1; $tm<32;$tm++)
	{
	 if ($today["mday"]<10) $today["mday"]='0'.$today["mday"];
	 $date3[$tm]=$today["year"].'-'.$today["mon"].'-'.$today["mday"].' 00:00:00';
	 if ($today["mday"]>1) $today["mday"]--; else break;
	}

 $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $max=0;
 while ($uy)
	{
	 $df[$uy[10]]=$uy[1];
	 $ust[$uy[10]]=$uy[21];
	 $max++;
	 $uy = mysql_fetch_row ($a);
	}

 $query = 'SELECT * FROM data WHERE prm=11 AND source=6 AND type=2 AND flat>0 ORDER BY date DESC';
 $r = mysql_query ($query,$i);                        
 $ur = mysql_fetch_row ($r);
 while ($ur)
	{
	 for ($tm=1; $tm<32;$tm++)
	 if ($date3[$tm]==$ur[2]) 
	 for ($fl=1; $fl<$max; $fl++)
	 if ($fl==$ur[4])
	 if (!$data1[$fl][$tm])
		$data1[$fl][$tm]=number_format($ur[3],2); 
		  //echo $ur[2].' '.$fl.' '.$data1[$fl][$tm].'<br>'; }
	 $ur = mysql_fetch_row ($r); 		
	}

 
 $today=getdate();
 $today["mday"]=30;
 $today["mon"]=4;
 if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];

 for ($tm=1; $tm<32;$tm++)
	{
	 $all=0;
	 if ($tm==1) print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>ХВС</font></td>';
	 else print '<tr><td bgcolor=#e8e8e8 align=center><font class=tablz></font></td>';

	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$today["mday"].'/'.$today["mon"].'/'.$today["year"].'</font></td>';
	 if ($today["mday"]<10) $today["mday"]='0'.$today["mday"];

	 $date1=$today["year"].$today["mon"].$today["mday"].'000000'; $tf=$today["mday"]+1;
	 if ($tf<10) $tf='0'.$tf;
	 $date2=$today["year"].$today["mon"].$tf.'000000'; 

	 $query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND prm=12 AND source=6 AND date='.$date1;
	 //echo $query; 
	 $r = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($r); $vh=0;
	 while ($ur)
		{
		 $vh=number_format($ur[3],2);
		 $ur = mysql_fetch_row ($r);
		}
	
	 print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$vh.'</font></td>'; 
	 for ($fl=1; $fl<$max;$fl++)
		{		 
		 $all=$all+$data1[$fl][$tm];
		 //echo $tm.' '.$data1[$fl][$tm],' = '.$all.'<br>';
		 if ($fl<30) 
		    {	
		     if ($ust[$fl]==0) print '<td bgcolor=#e8e8e8 align=center><font class=top5>'.$data1[$fl][$tm].'</font></td>';
		     else 
			{
			 $norm=number_format($rnum[$fl]*5.4/31,2);
			 $all=$all+$norm;
			 print '<td bgcolor=#5555ee align=center><font class=top5>'.number_format($norm,2).'</font></td>';
			}
		    }	
		 else		 
	         if ($ust[$fl]==1)
			{
			 $norm=number_format($rnum[$fl]*5.4/31,2);
			 $all=$all+$norm;
			}	 
		}
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$all.'</font></td>';
	 if ($vh>0) 
		{
		 $pr=($vh-$all)*100/$vh; 
		 $pr=number_format($pr,2);
		 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$pr.'%</font></td></tr>';
		}
	 else print '<td bgcolor=#ffcf68 align=center><font class=tablz>н/д</font></td></tr>';
	 if ($today["mday"]>1) $today["mday"]--; else break;
	}

 for ($fl=1; $fl<43;$fl++) $df[$fl]=0;
 //------------------------------------------------------------------------------------------------
 for ($fl=1; $fl<143;$fl++) for ($tm=1; $tm<32;$tm++) $data1[$fl][$tm]=0;

 $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $max=0;
 while ($uy)
	{
	 $df[$uy[10]]=$uy[1];
	 $max++;
	 $uy = mysql_fetch_row ($a);
	}

 $query = 'SELECT * FROM data WHERE prm=11 AND source=6 AND type=2 AND flat>0 ORDER BY date DESC';
 $r = mysql_query ($query,$i);
 $ur = mysql_fetch_row ($r);
 while ($ur)
	{
	 for ($tm=1; $tm<32;$tm++)
	 if ($date3[$tm]==$ur[2]) 
	 for ($fl=1; $fl<$max; $fl++)
	 if ($fl==$ur[4])
	 if (!$data1[$fl][$tm])
		$data1[$fl][$tm]=number_format($ur[3],2);
	 $ur = mysql_fetch_row ($r); 		
	}
 
 $today=getdate();
 $today["mday"]=30;
 $today["mon"]=4;
 if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];

 for ($tm=1; $tm<32;$tm++)
	{
	 $all=0;
	 if ($tm==1) print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>ГВС</font></td>';
	 else print '<tr><td bgcolor=#e8e8e8 align=center><font class=tablz></font></td>';

	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$today["mday"].'/'.$today["mon"].'/'.$today["year"].'</font></td>';
	 if ($today["mday"]<10) $today["mday"]='0'.$today["mday"];

	 $date1=$today["year"].$today["mon"].$today["mday"].'000000';

	 $query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND prm=12 AND source=6 AND date='.$date1;
	 //echo $query; 
	 $r = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($r); $vh=0;
	 while ($ur)
		{
		 $vh=number_format($ur[3],2);
		 $ur = mysql_fetch_row ($r);
		}
	
	 print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$vh.'</font></td>'; 
	 for ($fl=1; $fl<$max;$fl++)
		{		 
		 $all=$all+$data1[$fl][$tm];
		 if ($fl<30) 
		    {	
		     if ($ust[$fl]==0) print '<td bgcolor=#e8e8e8 align=center><font class=top5>'.$data1[$fl][$tm].'</font></td>';
		     else 
			{
			 $norm=number_format($rnum[$fl]*3.6/31,2);
			 $all=$all+$norm;
			 print '<td bgcolor=#5555ee align=center><font class=top5>'.number_format($norm,2).'</font></td>';
			}
		    }
		 else		 
	         if ($ust[$fl]==1)
			{
			 $norm=number_format($rnum[$fl]*3.6/31,2);
			 $all=$all+$norm;
			}
		}
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$all.'</font></td>';
	 if ($vh>0) 
		{
		 $pr=($vh-$all)*100/$vh; 
		 $pr=number_format($pr,2);
		 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$pr.'%</font></td></tr>';
		}
	 else print '<td bgcolor=#ffcf68 align=center><font class=tablz>н/д</font></td></tr>';
	 if ($today["mday"]>1) $today["mday"]--; else break;
	}
 //------------------------------------------------------------------------------------------------
 for ($fl=1; $fl<143;$fl++) for ($tm=1; $tm<32;$tm++) $data1[$fl][$tm]=0;

 for ($fl=1; $fl<43;$fl++) $df[$fl]=0;
 $query = 'SELECT * FROM device WHERE type=4 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $max=0;
 while ($uy)
	{
	 $df[$uy[10]]=$uy[1];
	 $max++;
	 $uy = mysql_fetch_row ($a);
	}

 $query = 'SELECT * FROM prdata WHERE prm=14 AND type=2 ORDER BY date DESC';
 //echo $query;
 $r = mysql_query ($query,$i);
 $ur = mysql_fetch_row ($r);
 while ($ur)
	{
	 for ($tm=1; $tm<32;$tm++) 
	 if ($date3[$tm]==$ur[4]) 
	 for ($fl=1; $fl<$max;$fl++)
	 if ($df[$fl]==$ur[1])
		 $data1[$fl][$tm]=number_format($ur[5],2);
	 $ur = mysql_fetch_row ($r); 
	}
 
 $today=getdate();
 $today["mday"]=29;
 $today["mon"]=4;
 if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];

 for ($tm=1; $tm<5;$tm++)
	{
	 $all=0;
	 if ($tm==1) print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>ЭЭ</font></td>';
	 else print '<tr><td bgcolor=#e8e8e8 align=center><font class=tablz></font></td>';

	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$today["mday"].'/'.$today["mon"].'/'.$today["year"].'</font></td>';
	 if ($today["mday"]<10) $today["mday"]='0'.$today["mday"];

	 $date1=$today["year"].$today["mon"].$today["mday"].'000000';

	 $query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND prm=14 AND source=0 AND date='.$date1;
	 //echo $query; 
	 $r = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($r); $vh=0;
	 while ($ur)
		{
		 $vh=number_format($ur[3],2);
		 $ur = mysql_fetch_row ($r);
		}
	
	 print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$vh.'</font></td>'; 
	 for ($fl=1; $fl<$max;$fl++)
		{		 
		 $all=$all+$data1[$fl][$tm];
		 if ($fl<30) print '<td bgcolor=#e8e8e8 align=center><font class=top5>'.$data1[$fl][$tm].'</font></td>'; 
		}
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$all.'</font></td>';
	 if ($vh>0) 
		{
		 $pr=($vh-$all)*100/$vh; 
		 $pr=number_format($pr,2);
		 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$pr.'%</font></td></tr>';
		}
	 else print '<td bgcolor=#ffcf68 align=center><font class=tablz>н/д</font></td></tr>';
	 if ($today["mday"]>1) $today["mday"]--; else break;
	}
 print '</table></td></tr>';
 print '<tr><td><img width=1200 height=200 src="barplots12.php?n1=1"></td></tr>';  
 print '<tr><td><img width=1200 height=200 src="barplots12.php?n1=2"></td></tr>';  
 print '<tr><td><img width=1200 height=200 src="barplots12.php?n1=3"></td></tr>';  
 print '<tr><td width=1200 valign=top><table width=1200 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr>
 <td bgcolor=#ffcf68 align=center colspan=3><font class=tablz>Баланс показаний</font></td>';

 for ($fl=1; $fl<43;$fl++) $df[$fl]=0;

 for ($fl=1; $fl<142;$fl++)
 for ($tm=1; $tm<32;$tm++) $data1[$fl][$tm]=0;

 $query = 'SELECT * FROM dev_irp ORDER BY adr';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
	  print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$uy[2].'</font></td>';
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Всего</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Небаланс</font></td></tr>';


 $query = 'SELECT * FROM device WHERE type=5 ORDER BY adr';

 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $max=0;
 while ($uy)
	{
	 $df[$uy[7]]=$uy[1];
	 $max++;
	 $uy = mysql_fetch_row ($a);
	}

 $query = 'SELECT * FROM prdata WHERE (prm=13 OR prm=11) AND value>20 AND type=2 ORDER BY date DESC';
 $r = mysql_query ($query,$i);
 $ur = mysql_fetch_row ($r);

 while ($ur)
	{
	 for ($tm=1; $tm<32;$tm++)
		{ 
		 //echo $date3[$tm].' '.$ur[4].'<br>';
		 if ($date3[$tm]==$ur[4]) 
		 for ($fl=1; $fl<43;$fl++)
		 if ($df[$fl]==$ur[1])
			 $data1[$fl][$tm]=number_format($ur[5]/4190,2);
		}
	 $ur = mysql_fetch_row ($r); 
	}
 for ($tm=1;$tm<32;$tm++) for ($fl=1;$fl<43;$fl++) if ($data1[$fl][$tm]) { $cntr[$tm]++; $avg[$tm]+=$data1[$fl][$tm]; }

 $today=getdate();
 $today["mday"]=30;
 $today["mon"]=4;
 if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];

 for ($tm=1; $tm<32;$tm++)
	{
 	 $all=0;
	 if ($tm==1) print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>ИРП</font></td>';
	 else print '<tr><td bgcolor=#e8e8e8 align=center><font class=tablz></font></td>';

	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$today["mday"].'/'.$today["mon"].'</font></td>';
	 if ($today["mday"]<10) $today["mday"]='0'.$today["mday"];

	 $date1=$today["year"].$today["mon"].$today["mday"].'000000';

	 $query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND prm=13 AND source=2 AND date='.$date1;
	 //echo $query; 
	 $r = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($r); $vh=0;
	 while ($ur)
		{
		 $vh=number_format($ur[3],2);
		 $ur = mysql_fetch_row ($r);
		}
	
	 print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$vh.'</font></td>'; 
	 for ($fl=1; $fl<43;$fl++)
		{		 
		 $all=$all+$data1[$fl][$tm];		 
		 if ($data1[$fl][$tm]) 
			print '<td bgcolor=#e8e8e8 align=center><font class=top5>'.$data1[$fl][$tm].'</font></td>'; 
		 else
			{
			 if ($data1[$fl][$tm-1]) $data1[$fl][$tm]=$data1[$fl][$tm-1]; 
			 else $data1[$fl][$tm]=$avg[$tm]/$cntr[$tm]; 
			 $all=$all+$data1[$fl][$tm];
			 print '<td bgcolor=#5555e8 align=center><font class=top5>'.$data1[$fl][$tm].'</font></td>'; 
			}
		}
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$all.'</font></td>';
	 if ($vh>0) 
		{
		 $pr=($vh-$all)*100/$vh; 
		 $pr=number_format($pr,2);
		 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$pr.'%	</font></td></tr>';
		}
	 else print '<td bgcolor=#ffcf68 align=center><font class=tablz>н/д</font></td></tr>';
	 if ($today["mday"]>1) $today["mday"]--; else break;
	}
 print '</table></td></tr>';
 print '<tr><td><img width=1200 height=200 src="charts/barplots12.php?n1=4"></td></tr>';    
?>

</table>
</body>
</html>