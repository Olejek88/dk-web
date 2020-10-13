<title>Система учета индивидуального потребления энергоресурсов :: Полный отчет о потреблении электроэнергии</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>Полный отчет о потреблении электроэнергии (часовые значения)</font></td></tr>
<tr><td style="width:1190px" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr>
<td style="width:500px" valign=top>
    <table width=500px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
	<tr><td bgcolor=#ffcf68 align=center width=70px><font class=tablz>дата</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Ввод</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>Лифт</font></td>
	<?php  
	include("config/local.php");
	$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
	$query = 'SELECT * FROM flats ORDER BY flat';
	$a = mysql_query ($query,$i); $cn=0;
	if ($a) $uy = mysql_fetch_row ($a);
	while ($uy)
	    {
	     print '<td bgcolor=#ffcf68 align=center><font class=tablz>кв.'.$uy[1].'</font></td>'; 
	     $uy = mysql_fetch_row ($a);
	    }
	?>
	</tr>
	<?php  
		$query = 'SELECT * FROM flats ORDER BY flat';
		$a = mysql_query ($query,$i); $cn=0;
		if ($a) $uy = mysql_fetch_row ($a);
		while ($uy)
		    {
		     $data01[$cn]=$data02[$cn]=0;
		     $query = 'SELECT * FROM device WHERE type=4 AND flat='.$uy[1];
		     $e = mysql_query ($query,$i);
		     $ui = mysql_fetch_row ($e);
		     if ($ui) 
			{
			 $device[$cn]=$ui[1]; 
			 $cn++;
			}
		     $uy = mysql_fetch_row ($a);
		    }
		$max=$cn-1;

			$today=getdate();
			if ($_GET["year"]=='') $ye=$today["year"];
			else $ye=$_GET["year"];
			if ($_GET["month"]=='') $mn=$today["mon"];
			else $mn=$_GET["month"];
			$mn=4;

			$x=0; $nn=1; $ts=1;
			$tm=$dy=1;
			
			for ($tn=0; $tn<=728; $tn++)
				{		
				 $date1[$tn]=sprintf ("%d%02d%02d%02d0000",$ye,$mn,$tm,$ts);
				 $dat[$tn]=sprintf ("%d-%02d-%02d %02d:00:00",$ye,$mn,$tm,$ts);
				 //if ($tm>10) $dat2[$tn]=sprintf ("%d-%02d-%02d %02d:00:00",$ye,$mn,$tm-10,$ts);
				 //else $dat2[$tn]=sprintf ("%d-%02d-%02d %02d:00:00",$ye,$mn,24,$ts);

				 $data0[$tn]=$data1[$tn]=$data2[$tn]=$data3[$tn]=$data4[$tn]=$data5[$tn]=$data6[$tn]=$data7[$tn]=$data8[$tn]=$data9[$tn]=$data10[$tn]=$data11[$tn]=$data12[$tn]='-';
				 $ts++;
				 if ($ts==24) 
					{ 
					 $ts=0; $tm++;
					 $dy=31;
					 if (!checkdate ($mn,31,$ye)) { $dy=30; }
					 if (!checkdate ($mn,30,$ye)) { $dy=29; }
					 if (!checkdate ($mn,29,$ye)) { $dy=28; }
					 if ($tm>$dy)
						{ 
						 $mn++;
						 $tm=1;
						}
				        }
				}
	
			 $query = 'SELECT * FROM data WHERE type=1 AND flat=0 AND prm=14 ORDER BY date DESC LIMIT 10000';
			 $a = mysql_query ($query,$i);
			 if ($a) $uy = mysql_fetch_row ($a);			 
			 while ($uy)
			      	{
				 $x=729;
				 for ($tn=0; $tn<=728; $tn++) 
				 if ($uy[2]==$dat[$tn]) $x=$tn;
					
			       	 if ($uy[8]==14 && $uy[6]==0) $data0[$x]=number_format($uy[3],2);
			       	 if ($uy[8]==14 && $uy[6]==0) $data1[$x]=number_format($uy[3],2);

			       	 $uy = mysql_fetch_row ($a);	     
			      	}

			 $query = 'SELECT * FROM prdata WHERE type=1 AND prm=14 ORDER BY date';
			 $a = mysql_query ($query,$i);
			 if ($a) $uy = mysql_fetch_row ($a);			 
			 while ($uy)
			      	{
				 $x=729; $x1=729;
				 for ($tn=0; $tn<=728; $tn++)
					{
					 if ($uy[4]==$dat[$tn]) $x=$tn;
					 if ($uy[4]==$dat2[$tn]) $x1=$tn;
					}

				 for ($w=0;$w<=$max;$w++)
				 if ($device[$w]==$uy[1])
					{ $data[$w][$x]=$uy[5]; $sts[$w][$x]=$uy[6]; break; }

			       	 $uy = mysql_fetch_row ($a);	     
			      	}

			 for ($tn=0; $tn<=728; $tn++) 
				{
		        	 print '<tr><td align=center bgcolor=#ffcf68><font class=top2>'.$dat[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data0[$tn].'</font></td>';
				 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data1[$tn].'</font></td>';
				 for ($w=0;$w<=$max;$w++)
				 if ($data[$w][$tn]) 
					{
					 if ($sts[$w][$tn]==0) print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data[$w][$tn],4).'</font></td>';
					 else print '<td align=center bgcolor=#e8e8e8><font class=top2>0</font></td>';
//print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data[$w][$tn],4).'</font></td>';
					}
				 //else	if ($data2[$w][$tn]) print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data2[$w][$tn],4).'</font></td>';
				 else	print '<td align=center bgcolor=#e8e8e8><font class=top2>0.0000</font></td>';
				 print '</tr>';
			       }
		?>
	</table>
    </td>
</tr>

</table>
</td></tr></table>

