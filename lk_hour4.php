<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Энтальпии по паре датчиков квартиры</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td width=300px valign=top>
<table width=300px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>дата</font></td>'; 

  $query = 'SELECT * FROM field WHERE type=1 AND flat='.$_GET["flat"];
  $e = mysql_query ($query,$i); $cn=0;
  if ($e) $ui = mysql_fetch_row ($e); 
  while ($ui) 
	{	 
	 $id1[$cn]=$ui[4]; $id2[$cn]=$ui[5];
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>H'.$ui[9].'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>H'.$ui[9].'</font></td>'; 
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>dH</font></td>'; 
	 $cn++;
	 $ui = mysql_fetch_row ($e); 
	}
 print '</tr>'; 

 $today=getdate();
 if ($_GET["year"]=='') $ye=$today["year"];
 else $ye=$_GET["year"];
 if ($_GET["month"]=='') $mn=$today["mon"];
 else $mn=$_GET["month"];
 $x=0; $tm=$dy=$today["mday"];
 for ($tn=0; $tn<=45; $tn++)
	{		
	 $date1=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $dat[$x]=sprintf ("%02d-%02d",$mn,$tm);
	 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=1 AND date='.$date1;
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);
	 for ($cm=0; $cm<$cn; $cm++) $data0[$cm]=$data1[$cm]='-';
	 while ($uy)
	      {          
	       for ($cm=0; $cm<$cn; $cm++)
		   {
		    if ($uy[1]==$id1[$cm]) $data0[$cm]=$uy[5];
		    if ($uy[1]==$id2[$cm]) $data1[$cm]=$uy[5];
		    //echo $uy[5].' '.$data0[$cm].' '.$data1[$cm].'<br>';
		   }
	       $uy = mysql_fetch_row ($a);	     
	      }	 
         print '<tr><td align=center bgcolor=#ffcf68 width=100><font class=top2>'.$dat[$x].'</font></td>';
         for ($cm=0; $cm<$cn; $cm++)
		   {		    
		    print '<td bgcolor=#e8e8e8><font class=top2>'.number_format($data0[$cm],1).'</font></td>';
		    print '<td bgcolor=#e8e8e8><font class=top2>'.number_format($data1[$cm],1).'</font></td>';
		    if ($data0[$cm]-$data1[$cm]>0 && $data0[$cm]-$data1[$cm]<500)
			{
			 $sdh[$cm]+=$data0[$cm]-$data1[$cm];
			 if ($data0[$cm]-$data1[$cm]>=0 && $data0[$cm]-$data1[$cm]<15)
				{
			 	print '<td bgcolor=#e8e8e8><font class=top2>'.number_format($data0[$cm]-$data1[$cm],3).'</font></td>';
			 	$hh1[$cm].='dat'.$tn.'='.$dat[$x].'&qe'.$tn.'='.number_format($data0[$cm]-$data1[$cm],3).'&';
				}
			 else 	{
			 	print '<td bgcolor=#e8e8e8><font class=top2>'.number_format(0,3).'</font></td>';
			 	$hh1[$cm].='dat'.$tn.'='.$dat[$x].'&qe'.$tn.'='.number_format(0,3).'&';
				}

			}
		    else
			{
			 print '<td bgcolor=#e8e8e8><font class=top2>-</font></td>';
			 $hh1[$cm].='dat'.$tn.'='.$dat[$x].'&qe'.$tn.'=0&';
			}
		   }
   	 $tm--;
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

print '<tr><td align=center bgcolor=#ffcf68 width=100><font class=top2></font></td>';
for ($cm=0; $cm<$cn; $cm++)
   {		    
    print '<td bgcolor=#ffcf68><font class=top2></font></td>';
    print '<td bgcolor=#ffcf68><font class=top2></font></td>';
    print '<td bgcolor=#ffcf68><font class=top2>'.number_format($sdh[$cm],3).'</font></td>';
   }
?>
</table></td>
<td width=800px>
<table width=800px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<?php 
        for ($cm=0; $cm<$cn; $cm++)
	    print '<tr><td><img width=800 height=280 src="charts/barplots29.php?type=1&'.$hh1[$cm].'"></td></tr>'; 
?>
</table>
</td></tr></table>
</body>                                                        
</html>