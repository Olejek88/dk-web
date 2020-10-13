	<?php  
	include("config/local.php");
	$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
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
		 $dat2[$tn]=sprintf ("%d-%02d-%02d 00:00:00",$ye,$mn,$tm+1);
		 $dat3[$tn]=sprintf ("%d-%02d-%02d",$ye,$mn,$tm);
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
	
	 $query = 'SELECT * FROM prdata WHERE type=1 AND prm=14 ORDER BY date';
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);			 
	 while ($uy)
	      	{
		 $x=729;
		 for ($tn=0; $tn<=728; $tn++)
		 if ($uy[4]==$dat[$tn]) $x=$tn;

		 for ($w=0;$w<=$max;$w++)
		 if ($device[$w]==$uy[1])
			{ $data[$w][$x]=$uy[5]; break; }
	       	 $uy = mysql_fetch_row ($a);	     
	      	}

	 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=14 ORDER BY date';
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);			 
	 while ($uy)
	      	{
		 $x=729;
		 for ($tn=0; $tn<=728; $tn++)
		 if ($uy[4]==$dat[$tn]) $x=$tn;

		 for ($w=0;$w<=$max;$w++)
		 if ($device[$w]==$uy[1])
			{ $data[$w][$x]=$uy[5]; break; }
	       	 $uy = mysql_fetch_row ($a);	     
	      	}

	 for ($tn=0; $tn<=728; $tn++) 
		{
		 for ($w=0;$w<=$max;$w++)
		 if ($data[$w][$tn]) 
			print '<br><font class=top2>'.number_format($data[$w][$tn],4).'</font>';
				 //else	if ($data2[$w][$tn]) print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data2[$w][$tn],4).'</font></td>';
		 else	
			{
			 $val1=$val2=0;  $cnt=0;
			 $query = 'SELECT value FROM prdata WHERE type=2 AND prm=14 AND device='.$device[$w].' AND date='.$dat2[$tn];
			 $a = mysql_query ($query,$i);
			 if ($a) $uy = mysql_fetch_row ($a);			 
			 if ($uy) $val1=$uy[0];
			 $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM prdata WHERE type=1 AND prm=14 AND device='.$device[$w].' AND date LIKE \'%'.$dat3[$tn].'%\'';
			 $a = mysql_query ($query,$i);
			 if ($a) $uy = mysql_fetch_row ($a);			 
			 if ($uy) { $val2=$uy[0]; $cnt=24-$uy[1]; $avg=$uy[2]; }
			 if ($cnt>0) 
				{
				 if ($val1>0) $value=($val1-$val2)/$cnt;			 
				 else $value=$avg;
				 print '<br>'.$val1.' '.$val2.' '.$cnt.'='.$value; 
				 $query = 'INSERT INTO prdata (device,prm,type,date,value,status) VALUES (\''.$device[$w].'\',\'14\',\'1\',\''.$dat[$tn].'\',\''.$value.'\',\'1\')';
				 print $query.'<br>';
				 if ($value>0 && $value<2) $a = mysql_query ($query,$i);
				}
		       }
		}
?>