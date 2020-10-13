<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
 include("config/local3.php");
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
 date_default_timezone_set("Europe/London");
// phpinfo();
// print_r(get_loaded_extensions()); 
?>

<html><head>
<title>Конвертируем из SQL Lite (QDK) в MySQL (DK)</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1251">
<meta http-equiv="Pragma" content="no-cashe">
<link rel="stylesheet" href="files/structure_collage_ektron.css" type="text/css">
<link rel="stylesheet" href="files/default.css" title="default" type="text/css">
<link rel="alternate stylesheet" href="files/default_larger.css" title="big" type="text/css">
<link rel="stylesheet" type="text/css" href="files/niftyCorners.css">
<link rel="stylesheet" type="text/css" href="files/quotetabs.css">
</head>
<body>

<?php
 //$user = '';
 //$password = '';
 //$crdate=mktime(0, 0, 0, 11, 8, 2013);
 //echo $crdate.'<br>';
 $today=getdate();
 $crdate=mktime(0, 0, 0, $today["mon"], $today["mday"], $today["year"]);
 $crdate-=3600*12*24;
 $crdate8=$crdate+3600*20*24;

 echo $crdate.'<br>';

 $stage0=1;
 $stage1=1;
 $stage2=1;
 $stage3=1;
 $stage4=1;

if ($_GET["stage0"]=='0')  $stage0=0;
if ($_GET["stage1"]=='0')  $stage1=0;
if ($_GET["stage2"]=='0')  $stage2=0;
if ($_GET["stage3"]=='0')  $stage3=0;
if ($_GET["stage4"]=='0')  $stage4=0;

 $section_num=1;

print '<table cellpadding=2 cellspacing=1 bgcolor=#82cc7f align=center>
<tr bgcolor="#476a94">
<td align="center"><font color="white">factory</font></td>
<td align="center"><font color="white">link</font></td>
<td align="center"><font color="white">rf_interact</font></td>
<td align="center"><font color="white">measure</font></td>
<td align="center"><font color="white">integral_measure</font></td>
<td align="center"><font color="white">level</font></td>
<td align="center"><font color="white">flat_number</font></td>
<td align="center"><font color="white">strut_number</font></td>
<td align="center"><font color="white">rf_power</font></td></tr>';

//phpinfo();
try {
$dbh = new PDO ($dsn, $user, $password);
echo $dsn;
}
 catch (PDOException $e) {  
         //re-execute same code as within the try clause?
echo "hui".$e;

                     }
//echo $dbh;
//----------------------------------------------------------------------------------------------------------------------------
function StoreData ($i,$date,$prm,$source,$type,$value)
{
 $query = 'SELECT * FROM data WHERE flat=0 AND prm='.$prm.' AND type='.$type.' AND source='.$source.' AND date='.$date;
 if ($a = mysql_query ($query,$i))
 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO data SET flat=0,prm='.$prm.',source='.$source.',type='.$type.',value='.$value.',date='.$date;
 else	 $query = 'UPDATE data SET value='.$value.',date='.$date.' WHERE flat=0 AND prm='.$prm.' AND type='.$type.' AND source='.$source.' AND date='.$date;
 echo $query.'<br>'; $a = mysql_query ($query,$i);
}
//----------------------------------------------------------------------------------------------------------------------------
print '<table cellpadding=2 cellspacing=1 bgcolor=#82cc7f align=center>
<tr bgcolor="#476a94">
<td align="center"><font color="white">factory</font></td>
<td align="center"><font color="white">date</font></td>
<td align="center"><font color="white">E1E2</font></td>
<td align="center"><font color="white">M1</font></td>
<td align="center"><font color="white">M2</font></td>
<td align="center"><font color="white">InA</font></td>
<td align="center"><font color="white">InB</font></td> 
<td align="center"><font color="white">P1</font></td>          
<td align="center"><font color="white">P2</font></td>
<td align="center"><font color="white">T1</font></td>
<td align="center"><font color="white">T3</font></td>
<td align="center"><font color="white">T2</font></td>
<td align="center"><font color="white">InfoD</font></td></tr>';	

// $query = 'DELETE FROM data WHERE type=2 AND flat=0'; echo $query.'<br>';
// $a = mysql_query ($query,$i);         
//  $sql = 'SELECT * FROM sqlite_master WHERE type="table"';
// $sql = 'PRAGMA table_info(\'multical66_day_archive\')';
// echo $sql.'<br>';
// foreach ($dbh->query($sql) as $row) 
//	{
//       print $row["name"].'<br>';
//	}
// $sql = 'SELECT * FROM vist_archive ORDER BY date DESC';
 $sql = 'SELECT * FROM multical66_day_archive ORDER BY date DESC';
 echo $sql.'<br>';
 if ($stage0)
 foreach ($dbh->query($sql) as $row) 
	{
         print '<tr bgcolor="#ffffff">';
         print '<td align="center">'.$row["factory"].'</td>';
         print '<td align="center">'.$row["date"].'</td>';
         print '<td align="center">'.$row["E1E2"].'</td>';
         print '<td align="center">'.$row["Mass1"].'</td>';
         print '<td align="center">'.$row["Mass2"].'</td>';
         print '<td align="center">'.$row["InA"].'</td>';
         print '<td align="center">'.$row["InB"].'</td>';
         print '<td align="center">'.$row["P1mid"].'</td>';
         print '<td align="center">'.$row["P2mid"].'</td>';
         print '<td align="center">'.$row["T1mid"].'</td>';
         print '<td align="center">'.$row["T3mid"].'</td>';
         print '<td align="center">'.$row["T2mid"].'</td>';
         print '<td align="center">'.$row["InfoD"].'</td>';
         print '</tr>';

	 $tarr = localtime($row["date"]-3600*24,TRUE);
	 $date2=sprintf ("%d%02d%02d000000",1900+$tarr['tm_year'],$tarr['tm_mon']+1,$tarr['tm_mday'],$tarr['tm_hour']);
	 //01 1a 10000002 - гвс нежилой части
 	 if ($row["factory"]=="01 1b 00000000")
 	    {
	 	$query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND prm=4 AND source=0 AND date='.$date2; echo $query.'<br>';
		$a = mysql_query ($query,$i);
		$uy = mysql_fetch_row ($a);
		if (!$uy)
	 		{
	       	     	 $query = 'INSERT INTO data SET flat=0,prm=4,source=0,date='.$date2.',type=2,value=\''.$row["T1mid"].'\''; echo $query.'<br>';
			 $a = mysql_query ($query,$i);
		         $query = 'INSERT INTO data SET flat=0,prm=4,source=1,date='.$date2.',type=2,value=\''.$row["T2mid"].'\''; echo $query.'<br>';
			 $a = mysql_query ($query,$i);
		       	 $query = 'INSERT INTO data SET flat=0,prm=12,source=0,date='.$date2.',type=2,value=\''.$row["Mass1"].'\''; echo $query.'<br>';
			 $a = mysql_query ($query,$i);
	       		 $query = 'INSERT INTO data SET flat=0,prm=13,source=0,date='.$date2.',type=2,value=\''.($row["E1E2"]/1.163).'\''; echo $query.'<br>';
			 $a = mysql_query ($query,$i);
		    	}
		}

	}

//----------------------------------------------------------------------------------------------------------------------------
print '<table cellpadding=2 cellspacing=1 bgcolor=#82cc7f align=center>
<tr bgcolor="#476a94">
<td align="center"><font color="white">id</font></td>
<td align="center"><font color="white">factory</font></td>
<td align="center"><font color="white">t_front</font></td>
<td align="center"><font color="white">t_back</font></td>
<td align="center"><font color="white">t_delta</font></td>
<td align="center"><font color="white">h_front</font></td>
<td align="center"><font color="white">h_delta</font></td>
<td align="center"><font color="white">v</font></td></tr>';	

 $sql = 'SELECT * FROM IRP_DataFrom_Structure';
 if ($stage1)
 foreach ($dbh->query($sql) as $row) 
	{
         print '<tr bgcolor="#ffffff">';
         print '<td align="center">'.$row["rowid"].'</td>';
         print '<td align="center">'.$row["factory"].'</td>';
         print '<td align="center">'.$row["t_front"].'</td>';
         print '<td align="center">'.$row["t_back"].'</td>';
         print '<td align="center">'.$row["t_delta"].'</td>';
         print '<td align="center">'.$row["h_front"].'</td>';
         print '<td align="center">'.$row["h_delta"].'</td>';
         print '<td align="center">'.$row["v_per_h_front"].'</td>';
         print '</tr>';

	 $sql = 'SELECT * FROM QIRP WHERE factory=\''.$row["factory"].'\'';
	 foreach ($dbh->query($sql) as $row2) 
		{
		 $addr=$row2["address"];
		 $strut=$row2["strut"];
		}

	 $factory=hexdec (substr ($row2["factory"],6,8));
	 $idd=33882112+$factory;
 
	 $query = 'SELECT * FROM prdata WHERE type=0 AND device='.$idd; echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if (!$uy)
	 	{
		 $query = 'DELETE FROM prdata WHERE device='.$idd.' AND type=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=1,type=0,value=\''.$row["h_front"].'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=1,type=0,value=\''.$row["h_back"].'\',pipe=1'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=4,type=0,value=\''.$row["t_front"].'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=4,type=0,value=\''.$row["t_back"].'\',pipe=1'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=11,type=0,value=\''.$row["v_per_h_front"].'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=11,type=0,value=\''.$row["v_per_h_front"].'\',pipe=1'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=12,type=0,value=\''.$row["m_per_h_front"].'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=12,type=0,value=\''.$row["m_per_h_front"].'\',pipe=1'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=13,type=0,value=\''.$row["q_per_h"].'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		}
	 $query = 'UPDATE prdata SET value=\''.$row["h_front"].'\' WHERE device='.$idd.' AND prm=1 AND type=0 AND pipe=0'; echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $query = 'UPDATE prdata SET value=\''.$row["h_back"].'\' WHERE device='.$idd.' AND prm=1 AND type=0 AND pipe=1'; echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $query = 'UPDATE prdata SET value=\''.$row["t_front"].'\' WHERE device='.$idd.' AND prm=4 AND type=0 AND pipe=0'; echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $query = 'UPDATE prdata SET value=\''.$row["t_back"].'\' WHERE device='.$idd.' AND prm=4 AND type=0 AND pipe=1'; echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $query = 'UPDATE prdata SET value=\''.$row["v_per_h_front"].'\' WHERE device='.$idd.' AND prm=11 AND type=0 AND pipe=0'; echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $query = 'UPDATE prdata SET value=\''.$row["v_per_h_front"].'\' WHERE device='.$idd.' AND prm=11 AND type=0 AND pipe=1'; echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $query = 'UPDATE prdata SET value=\''.$row["m_per_h_front"].'\' WHERE device='.$idd.' AND prm=12 AND type=0 AND pipe=0'; echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $query = 'UPDATE prdata SET value=\''.$row["m_per_h_front"].'\' WHERE device='.$idd.' AND prm=12 AND type=0 AND pipe=1'; echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $query = 'UPDATE prdata SET value=\''.$row["q_per_h"].'\' WHERE device='.$idd.' AND prm=13 AND type=0 AND pipe=0'; echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	}
//----------------------------------------------------------------------------------------------------------------------------
print '<table cellpadding=2 cellspacing=1 bgcolor=#82cc7f align=center>
<tr bgcolor="#476a94">
<td align="center"><font color="white">id</font></td>
<td align="center"><font color="white">factory</font></td>
<td align="center"><font color="white">date</font></td>
<td align="center"><font color="white">P1</font></td>
<td align="center"><font color="white">P2</font></td></tr>';	

 $sql = 'SELECT * FROM irp_tech_archive WHERE P1>100 AND date > '.$crdate;
 echo $sql;
 if ($stage1)
 foreach ($dbh->query($sql) as $row) 
	{
         print '<tr bgcolor="#ffffff">';
         print '<td align="center">'.$row["rowid"].'</td>';
         print '<td align="center">'.$row["factory"].'</td>';
         print '<td align="center">'.$row["date"].'</td>';
         print '<td align="center">'.$row["P1"].'</td>';
         print '<td align="center">'.$row["P2"].'</td>';
         print '</tr>';
	 $sql = 'SELECT * FROM QIRP WHERE factory=\''.$row["factory"].'\'';
	 foreach ($dbh->query($sql) as $row2) 
		{
		 $addr=$row2["address"];
		 $strut=$row2["strut"];
		}
	 $factory=hexdec (substr ($row2["factory"],6,8));
	 $idd=33882112+$factory;

	 $tarr = localtime($row["date"],TRUE);
	 //$tarr = localtime(1361318400);
	 $date2=sprintf ("%d%02d%02d000000",1900+$tarr['tm_year'],$tarr['tm_mon']+1,$tarr['tm_mday'],$tarr['tm_hour']);

	 $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$idd.' AND date='.$date2.' AND prm=1 AND pipe=0';
	 echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if (!$uy)
		{
		 $value=$row["P1"]/24;
        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=1,date='.$date2.',type=2,value=\''.$value.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 
	        }
	 $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$idd.' AND date='.$date2.' AND prm=11 AND pipe=0';
	 echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if (!$uy)
		{
		 $value=$row["P2"];
        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=11,date='.$date2.',type=2,value=\''.$value.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 
	        }
        }
print '</table>';	
//----------------------------------------------------------------------------------------------------------------------------
print '<table cellpadding=2 cellspacing=1 bgcolor=#82cc7f align=center>
<tr bgcolor="#476a94">
<td align="center"><font color="white">id</font></td>
<td align="center"><font color="white">factory</font></td>
<td align="center"><font color="white">date</font></td>
<td align="center"><font color="white">Q</font></td>
<td align="center"><font color="white">M</font></td>
<td align="center"><font color="white">V</font></td></tr>';	

 $sql = 'SELECT * FROM irp_day_archive WHERE date > '.$crdate;
 if ($stage1)
 foreach ($dbh->query($sql) as $row) 
	{
         print '<tr bgcolor="#ffffff">';
         print '<td align="center">'.$row["rowid"].'</td>';
         print '<td align="center">'.$row["factory"].'</td>';
         print '<td align="center">'.$row["date"].'</td>';
         print '<td align="center">'.$row["Q"].'</td>';
         print '<td align="center">'.$row["M"].'</td>';
         print '<td align="center">'.$row["V"].'</td>';
         print '</tr>';
	 $sql = 'SELECT * FROM QIRP WHERE factory=\''.$row["factory"].'\'';
	 foreach ($dbh->query($sql) as $row2) 
		{
		 $addr=$row2["address"];
		 $strut=$row2["strut"];
		}
	 $factory=hexdec (substr ($row["factory"],6,8));
	 $idd=33882112+$factory;

	 $tarr = localtime($row["date"],TRUE);
	 //$tarr = localtime(1361318400);
	 $date2=sprintf ("%d%02d%02d000000",1900+$tarr['tm_year'],$tarr['tm_mon']+1,$tarr['tm_mday'],$tarr['tm_hour']);

	 $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$idd.' AND date='.$date2.' AND prm=13 AND pipe=0'; echo $query.'<br>';	 
	 if ($a = mysql_query ($query,$i))	 
	 if (!$uy = mysql_fetch_row ($a))
		{
		 $value=$row["Q"];
        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=13,date='.$date2.',type=2,value=\''.$value.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 
	        }
	 $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$idd.' AND date='.$date2.' AND prm=11 AND pipe=0'; echo $query.'<br>';	 
	 if ($a = mysql_query ($query,$i))	 
	 if (!$uy = mysql_fetch_row ($a))
		{
		 $value=$row["V"];
        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=11,date='.$date2.',type=2,value=\''.$value.'\',pipe=0'; echo $query.'<br>';
		 //$a = mysql_query ($query,$i);	 
	        }
        }
print '</table>';	
//----------------------------------------------------------------------------------------------------------------------------
print '<table cellpadding=2 cellspacing=1 bgcolor=#82cc7f align=center>
<tr bgcolor="#476a94">
<td align="center"><font color="white">factory</font></td>
<td align="center"><font color="white">time</font></td>
<td align="center"><font color="white">integral</font></td>
<td align="center"><font color="white">summ</font></td>
<td align="center"><font color="white">Taverage</font></td>
<td align="center"><font color="white">Tlast</font></td>
</tr>';	

  $sql = 'SELECT * FROM BIT_DataFrom_Structure';
 if ($stage2)
 foreach ($dbh->query($sql) as $row) 
	{
         print '<tr bgcolor="#ffffff">';
         print '<td align="center">'.$row["factory"].'</td>';
         print '<td align="center">'.$row["time"].'</td>';
         print '<td align="center">'.$row["integral_entalpy"].'</td>';
         print '<td align="center">'.$row["summ_entalpy"].'</td>';
         print '<td align="center">'.$row["average_temperature"].'</td>';
         print '<td align="center">'.$row["last_temperature"].'</td>';
         print '</tr>';

	 $factory=hexdec (substr ($row["factory"],6,8));
	 $value=$row["integral_entalpy"]/(3600*24);
	 $sum=$row["summ_entalpy"]/(3600*24);
	 $temp=$row["average_temperature"]/100;
	 $rssi=intval ($row["last_rssi"]);

	 $idd=16842753+$factory;

	 $tarr = localtime($row["time"],TRUE);
	 $date2=sprintf ("%d%02d%02d000000",1900+$tarr[tm_year],$tarr[tm_mon]+1,$tarr[tm_mday],$tarr[tm_hour]);

	 $query = 'UPDATE device SET lastdate=NULL,devtim='.$date2.' WHERE idd='.$idd;
	 $a = mysql_query ($query,$i);

	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=32 AND type=0 AND pipe=0'; echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a))
		{
		 $query = 'INSERT INTO prdata SET prm=32,type=0,value='.$rssi.',pipe=0,device='.$idd; echo $query.'<br>';
		 $a = mysql_query ($query,$i);		 
		 $query = 'INSERT INTO prdata SET prm=1,type=0,value='.$value.',pipe=0,device='.$idd; echo $query.'<br>';
		 $a = mysql_query ($query,$i);		 
		 $query = 'INSERT INTO prdata SET prm=4,type=0,value='.$temp.',pipe=0,device='.$idd; echo $query.'<br>';
		 $a = mysql_query ($query,$i);		 
		 $query = 'INSERT INTO prdata SET prm=31,type=0,value='.$sum.',pipe=0,device='.$idd; echo $query.'<br>';
		 $a = mysql_query ($query,$i);		 
		}
	 else	{
		 $query = 'UPDATE prdata SET prm=32,type=0,value='.$rssi.',pipe=0 WHERE device='.$idd.' AND prm=32 AND type=0 AND pipe=0';	
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'UPDATE prdata SET prm=1,type=0,value='.$value.',pipe=0 WHERE device='.$idd.' AND prm=1 AND type=0 AND pipe=0';	
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'UPDATE prdata SET prm=4,type=0,value='.$temp.',pipe=0 WHERE device='.$idd.' AND prm=4 AND type=0 AND pipe=0';	
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'UPDATE prdata SET prm=31,type=0,value='.$sum.',pipe=0 WHERE device='.$idd.' AND prm=31 AND type=0 AND pipe=0';	
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		}
/*
	 $query = 'UPDATE prdata SET prm=1,type=0,value='.$value.',pipe=0 WHERE device='.$idd.' AND prm=1 AND type=0 AND pipe=0';
	 echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $query = 'UPDATE prdata SET prm=4,type=0,value='.$temp.',pipe=0 WHERE device='.$idd.' AND prm=4 AND type=0 AND pipe=0';
	 echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $query = 'UPDATE prdata SET prm=31,type=0,value='.$sum.',pipe=0 WHERE device='.$idd.' AND prm=31 AND type=0 AND pipe=0';
	 echo $query.'<br>';
	 $a = mysql_query ($query,$i);

	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=1 AND type=2 AND pipe=0 AND date=\''.$date2.'\'';
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a))
		{
        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=1,date='.$date2.',type=2,value=\''.$value.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 		 
		}
	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=4 AND type=2 AND pipe=0 AND date=\''.$date2.'\'';
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a))
		{
        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=4,date='.$date2.',type=2,value=\''.$temp.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 		 
		}
	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=31 AND type=2 AND pipe=0 AND date=\''.$date2.'\'';
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a))
		{
        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=31,date='.$date2.',type=2,value=\''.$sum.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 		 
		}
		*/
	}
//----------------------------------------------------------------------------------------------------------------------------
 $sql = 'SELECT * FROM I2CH_DataFrom_Structure';
 if ($stage2)
 foreach ($dbh->query($sql) as $row) 
	{
	 $factory=hexdec (substr ($row["factory"],6,8));
	 $value=$row["consumtion_value1"];
	 $value2=$row["consumtion_value2"];
	 $expvalue=$row["expense_value1"];
	 $expvalue2=$row["expense_value2"];
	 $rssi=intval ($row["last_rssi"]);
	 $idd=16910000+$factory;

	 $tarr = localtime($row["time"],TRUE);
	 $date2=sprintf ("%d%02d%02d000000",1900+$tarr[tm_year],$tarr[tm_mon]+1,$tarr[tm_mday],$tarr[tm_hour]);

	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=32 AND type=0 AND pipe=0';
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a))
		{
		 $query = 'INSERT INTO prdata SET prm=32,type=0,value='.$rssi.',pipe=0,device='.$idd;	
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);		 
		}
	 else	{
		 $query = 'UPDATE prdata SET prm=32,type=0,value='.$rssi.',pipe=0 WHERE device='.$idd.' AND prm=32 AND type=0 AND pipe=0';	
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		}

	 $query = 'UPDATE device SET lastdate=NULL,devtim='.$date2.' WHERE idd='.$idd;
	 $a = mysql_query ($query,$i);

	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=5 AND type=0 AND pipe=0';
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) 
		$query = 'INSERT INTO prdata SET device='.$idd.',prm=5,type=0,value='.$expvalue.',pipe=0';
	 else	 $query = 'UPDATE prdata SET value='.$expvalue.' WHERE device='.$idd.' AND prm=5 AND type=0 AND pipe=0';
	 echo $query.'<br>'; $a = mysql_query ($query,$i);

	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=6 AND type=0 AND pipe=0';
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO prdata SET device='.$idd.',prm=6,type=0,value='.$value.',pipe=0';
	 else	 $query = 'UPDATE prdata SET value='.$value.' WHERE device='.$idd.' AND prm=6 AND type=0 AND pipe=0';
	 echo $query.'<br>'; $a = mysql_query ($query,$i);

	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=7 AND type=0 AND pipe=0';
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO prdata SET device='.$idd.',prm=7,type=0,value='.$expvalue2.',pipe=0';
	 else	 $query = 'UPDATE prdata SET value='.$expvalue2.' WHERE device='.$idd.' AND prm=7 AND type=0 AND pipe=0';
	 echo $query.'<br>'; $a = mysql_query ($query,$i);

	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=8 AND type=0 AND pipe=0';
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO prdata SET device='.$idd.',prm=8,type=0,value='.$value.',pipe=0';
	 else	 $query = 'UPDATE prdata SET value='.$value2.' WHERE device='.$idd.' AND prm=8 AND type=0 AND pipe=0';
	 echo $query.'<br>'; $a = mysql_query ($query,$i);
	}
//----------------------------------------------------------------------------------------------------------------------------
print '<table cellpadding=2 cellspacing=1 bgcolor=#82cc7f align=center>
<tr bgcolor="#476a94">
<td align="center"><font color="white">factory</font></td>
<td align="center"><font color="white">time</font></td>
<td align="center"><font color="white">integral</font></td>
<td align="center"><font color="white">summ</font></td>
<td align="center"><font color="white">Taverage</font></td>
<td align="center"><font color="white">Tlast</font></td>
</tr>';	

 if ($stage3)
 for ($cnt=0; $cnt<30; $cnt++)
	{
	 $today=getdate();
	 $crdate2=mktime(0, 0, 0, $today["mon"], $today["mday"], $today["year"]);
	 $crdate2-=3600*$cnt*24;
	 $crdate3=$crdate2+3600*1*24;

	 $tarr = localtime($crdate2,TRUE);
	 $date3=sprintf ("%d%02d%02d000000",1900+$tarr[tm_year],$tarr[tm_mon]+1,$tarr[tm_mday],$tarr[tm_hour]);
	 $est=0;

	 $query = 'SELECT COUNT(id) FROM prdata WHERE device<30000000 AND prm=1 AND type=2 AND pipe=0 AND date='.$date3;
	 echo $query.'<br>';		 
	 if ($a = mysql_query ($query,$i))
	 if ($uy = mysql_fetch_row ($a)) $est=$uy[0];

	 $sql = 'SELECT * FROM bit WHERE time>='.$crdate2.' AND time<'.$crdate3;    
	 echo $est.' | '.$sql.'<br>';

	 if ($est<10)	 
	 foreach ($dbh->query($sql) as $row) 
		{
	         print '<tr bgcolor="#ffffff">';
        	 print '<td align="center">'.$row["factory"].'</td>';
	         print '<td align="center">'.$row["time"].'</td>';
	         print '<td align="center">'.$row["integral_entalpy"].'</td>';
        	 print '<td align="center">'.$row["summ_entalpy"].'</td>';
	         print '<td align="center">'.$row["average_temperature"].'</td>';
        	 print '<td align="center">'.$row["last_temperature"].'</td>';
	         print '</tr>';

		 $factory=hexdec (substr ($row["factory"],6,8));
		 $value=$row["integral_entalpy"]/(3600*24);
		 $sum=$row["summ_entalpy"]/(3600*24);
		 $temp=$row["average_temperature"]/100;
		 $rssi=intval ($row["last_rssi"]);

		 $idd=16842753+$factory;

		 $tarr = localtime($row["time"],TRUE);
		 $date2=sprintf ("%d%02d%02d000000",1900+$tarr[tm_year],$tarr[tm_mon]+1,$tarr[tm_mday],$tarr[tm_hour]);

        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=1,date='.$date2.',type=2,value=\''.$value.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 		 
        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=4,date='.$date2.',type=2,value=\''.$temp.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 		 
       		 //$query = 'INSERT INTO prdata SET device='.$idd.',prm=31,date='.$date2.',type=2,value=\''.$sum.'\',pipe=0'; echo $query.'<br>';
		 //$a = mysql_query ($query,$i);	 		 
		}
	}
//----------------------------------------------------------------------------------------------------------------------------
// $sql = 'SELECT * FROM i2ch WHERE time > '.$crdate.' AND time < '.$crdate8.' ORDER BY time DESC';
 $sql = 'SELECT * FROM i2ch WHERE id in(SELECT min(id) FROM i2ch WHERE time > '.$crdate.'  GROUP BY factory, time / (24*3600))';
// $sql = 'SELECT * FROM i2ch ORDER BY time DESC';
 echo $sql;
 echo date_default_timezone_get();

 if ($stage3)
 foreach ($dbh->query($sql) as $row) 
	{
	 $factory=hexdec (substr ($row["factory"],6,8));
	 $value=$row["consumtion_value1"];
	 $value2=$row["consumtion_value2"];
	 $expvalue=$row["expense_value1"];
	 $expvalue2=$row["expense_value2"];
	 $rssi=intval ($row["last_rssi"]);
	 $idd=16910000+$factory;

         //echo $row["factory"].' | '.$value.' | '.$value2.' | '.$expvalue.' '.$expvalue2.'<br>';

	 $tarr = localtime($row["time"],TRUE);
	 $date2=sprintf ("%d%02d%02d000000",1900+$tarr[tm_year],$tarr[tm_mon]+1,$tarr[tm_mday],$tarr[tm_hour]);

	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=5 AND type=2 AND pipe=0 AND date='.$date2;
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) 
		{
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=5,type=2,value='.$expvalue.',pipe=0,date='.$date2;
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=6,type=2,value='.$value.',pipe=0,date='.$date2;
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=7,type=2,value='.$expvalue2.',pipe=0,date='.$date2;
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=8,type=2,value='.$value2.',pipe=0,date='.$date2;
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		}
/*
	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=6 AND type=2 AND pipe=0 AND date='.$date2;
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) 
		{
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=6,type=2,value='.$value.',pipe=0,date='.$date2;
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		}
	                                                  
	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=7 AND type=2 AND pipe=0 AND date='.$date2;
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) 
		{
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=7,type=2,value='.$expvalue2.',pipe=0,date='.$date2;
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		}

	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=8 AND type=2 AND pipe=0 AND date='.$date2;
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) 
		{
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=8,type=2,value='.$value2.',pipe=0,date='.$date2;
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		}
*/
	}
//----------------------------------------------------------------------------------------------------------------------------
if ($stage4)
{
 $query = 'SELECT * FROM dev_2ip';
 echo $query.'<br>'; $cn=0;
 if ($a = mysql_query ($query,$i))
 while ($uy = mysql_fetch_row ($a)) 
	{
	 $dev[$cn]=$uy[1]; $flt[$cn]=$uy[6]; $prd[$cn]=$uy[14];	 
	 $cn++;
	}
 $flats=$cn; 

 $today=getdate();
 $ye=$today["year"];
 $mn=$today["mon"];
 $tm=$today["mday"];
 for ($tn=1; $tn<=8; $tn++) 
	{		
	 $date1[$tn]=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $query = 'SELECT * FROM prdata WHERE (prm=6 OR prm=8) AND type=2 AND date='.$date1[$tn];
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{		 
		 for ($rr=0;$rr<$flats;$rr++) 
		 if ($dev[$rr]==$uy[1]) 
			{
			 //if ($uy[2]==6) $tgvs[$flt[$rr]][$tn]+=$uy[5];
			 //if ($uy[2]==8) $thvs[$flt[$rr]][$tn]+=$uy[5];
			 if ($uy[2]==6 && $prd[$rr]==0) $tgvs[$rr][$tn]=$uy[5];
			 if ($uy[2]==8 && $prd[$rr]==0) $thvs[$rr][$tn]=$uy[5];
			 if ($uy[2]==8 && $prd[$rr]==1) $tgvs[$rr][$tn]=$uy[5];
			 if ($uy[2]==6 && $prd[$rr]==1) $thvs[$rr][$tn]=$uy[5];
			}
		}

	 if ($tn>1)
	 for ($rr=0;$rr<$flats;$rr++) 
		{
		 if ($tgvs[$rr][$tn]<0.01) $tgvs[$rr][$tn]=$tgvs[$rr][$tn-1];
		 if ($thvs[$rr][$tn]<0.01) $thvs[$rr][$tn]=$thvs[$rr][$tn-1];
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

 for ($rr=0;$rr<$flats;$rr++)
 for ($tn=1; $tn<=8; $tn++) 
	{		
  	 if ($tgvs[$rr][$tn]>0 && $tgvs[$rr][$tn+1]>0 && $tgvs[$rr][$tn]>=$tgvs[$rr][$tn+1])
		if ($tgvs[$rr][$tn]-$tgvs[$rr][$tn+1]<1) $gvs[$flt[$rr]][$tn]+=$tgvs[$rr][$tn]-$tgvs[$rr][$tn+1];
		else $gvs[$flt[$rr]][$tn]=0;
  	 if ($thvs[$rr][$tn]>0 && $thvs[$rr][$tn+1]>0 && $thvs[$rr][$tn]>=$thvs[$rr][$tn+1])
		if ($thvs[$rr][$tn]-$thvs[$rr][$tn+1]<1) $hvs[$flt[$rr]][$tn]+=$thvs[$rr][$tn]-$thvs[$rr][$tn+1];
		else $hvs[$flt[$rr]][$tn]=0;
	}

 for ($tn=1; $tn<=8; $tn++) 
 for ($cn=1; $cn<=36; $cn++) 
	{		
	 if ($hvs[$cn][$tn]<3)
		{
		 $query = 'SELECT * FROM data WHERE flat='.$cn.' AND prm=12 AND type=2 AND source=6 AND date='.$date1[$tn];
		 echo $query.'<br>';
		 if ($a = mysql_query ($query,$i))
		 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO data SET flat='.$cn.',prm=12,source=6,type=2,value='.$hvs[$cn][$tn].',date='.$date1[$tn];
		 else $query = 'UPDATE data SET value='.$hvs[$cn][$tn].',date='.$date1[$tn].' WHERE flat='.$cn.' AND prm=12 AND type=2 AND source=6 AND date='.$date1[$tn];
		 echo '['.$thvs[$cn][$tn].' - '.$thvs[$cn][$tn+1].'] '.$query.'<br>';  $a = mysql_query ($query,$i);
		}
	 if ($gvs[$cn][$tn]<3)
		{       
		 $query = 'SELECT * FROM data WHERE flat='.$cn.' AND prm=12 AND type=2 AND source=5 AND date='.$date1[$tn];
		 echo $query.'<br>';
		 if ($a = mysql_query ($query,$i))
		 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO data SET flat='.$cn.',prm=12,source=5,type=2,value='.$gvs[$cn][$tn].',date='.$date1[$tn];
		 else	 $query = 'UPDATE data SET value='.$gvs[$cn][$tn].',date='.$date1[$tn].' WHERE flat='.$cn.' AND prm=12 AND type=2 AND source=5 AND date='.$date1[$tn];
		 echo '['.$tgvs[$cn][$tn].' - '.$tgvs[$cn][$tn+1].'] '.$query.'<br>'; $a = mysql_query ($query,$i);
		}
	}

}
//----------------------------------------------------------------------------------------------------------------------------
 $query = 'SELECT * FROM flats';
 if ($a=mysql_query ($query,$i))
 if (0)
 while ($uy = mysql_fetch_row ($a))
       	{
	 $query = 'UPDATE flats SET name="Квартира '.$uy[1].'",fname="Квартира '.$uy[1].'" WHERE id='.$uy[0]; echo $query.'<br>';	 
	 mysql_query ($query,$i);
	}
//----------------------------------------------------------------------------------------------------------------------------
if ($stage4)
{
 for ($sec=1;$sec<=$section_num;$sec++)
	{
	 $query = 'SELECT DISTINCT strut FROM field WHERE mnem='.$sec.' AND type=1'; echo $query.'<br>'; $cn=0;
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 $strt[$sec][$cn]=$uy[0]; 
		 //echo '['.$sec.'/'.$cn.'] '.$strt[$cn].'<br>';
		 $cn++;
		}
	 $strut_n[$sec]=$cn-1;
	}
 $strut_num=$cn-1;

 $query = 'SELECT MAX(level),MAX(flat) FROM field'; echo $query.'<br>';
 if ($a = mysql_query ($query,$i))
 if ($uy = mysql_fetch_row ($a))  { $levels=$uy[0]; $flats=$uy[1]; }

 $query = 'SELECT * FROM dev_bit'; echo $query.'<br>'; $cn=0;
 if ($a = mysql_query ($query,$i))
 while ($uy = mysql_fetch_row ($a)) 
	{
	 $dev[$cn]=$uy[1]; $flt[$cn]=$uy[8]; $str[$cn]=$uy[9]; $sect[$cn]=$uy[14]; $lvl[$cn]=$uy[15];
	 $device[$flt[$cn]][$str[$cn]]=$uy[1];
	 $devices[$sect[$cn]][$flt[$cn]][$str[$cn]]=$uy[1];
	 $cn++;
	}

 $query = 'SELECT flat,square FROM flats'; echo $query.'<br>';
 if ($a = mysql_query ($query,$i))
 while ($uy = mysql_fetch_row ($a))  
    {
     $squar[$uy[0]]=$uy[1];
     $ssquar+=$squar[$uy[0]];
    }

 $query = 'SELECT * FROM dev_irp'; echo $query.'<br>';
 if ($a = mysql_query ($query,$i))
 while ($uy = mysql_fetch_row ($a)) 
	{
	 $dev[$cn]=$uy[1]; $str[$cn]=$uy[3]; $sect[$cn]=$uy[4];
	 $cn++;
	}
 $devs=$cn; 
 echo 'devices='.$devs.'<br>';

 $today=getdate();
 $ye=$today["year"];
 $mn=$today["mon"];
 $tm=$today["mday"]-1;
 for ($tn=1; $tn<=10; $tn++) 
	{		
	 $date1[$tn]=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);

	 for ($rr=0;$rr<=$flats;$rr++) {  $Qfl[$rr]=0; $Qflo[$rr]=0; $Qflg[$rr]=0; }
	 $sumg=0;
	 $query = 'SELECT * FROM data WHERE prm=12 AND source=5 AND flat>0 AND date='.$date1[$tn]; echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 $dgvs[$uy[4]]=$uy[3];
		 $sumg+=$uy[3];
		}

	 $query = 'SELECT * FROM prdata WHERE prm=1 AND date='.$date1[$tn]; echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 for ($rr=0;$rr<$devs;$rr++) 
		 if ($dev[$rr]==$uy[1])
			{
			 //$data[$flt[$rr]][$str[$rr]]=$uy[5];
			 $data[$rr]=$uy[5];
			 break;
			}
		}
	 $sumq=$qq=0;
	 $query = 'SELECT * FROM prdata WHERE prm=11 AND date='.$date1[$tn]; echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 for ($rr=0;$rr<$devs;$rr++) 
		 if ($dev[$rr]==$uy[1])
			{
			 $Q[$sect[$rr]][$str[$rr]]=$uy[5];
			 echo '['.$dev[$rr].'] V['.$sect[$rr].']['.$str[$rr].'] se='.$sect[$rr].'='.$Q[$sect[$rr]][$str[$rr]].'<br>';
			 $sumq+=$uy[5];
			 $qq++;
			 break;
			}
		}

         $QSvh=0;
         $query = 'SELECT * FROM data WHERE prm=13 AND type=2 AND flat=0 AND date='.$date1[$tn]; echo $query.'<br>';
         if ($a = mysql_query ($query,$i))
         if ($uy = mysql_fetch_row ($a)) 
            	{
    		 $QSvh=$uy[3];
			echo 'Qvh='.$QSvh.'<br>';
		}

	 for ($sec=1;$sec<=$section_num;$sec++)
		{
		 $query = 'SELECT * FROM field WHERE type=1 AND mnem='.$sec.' ORDER BY strut,flat';
		 if ($a = mysql_query ($query,$i))
		 while ($uy = mysql_fetch_row ($a)) 
			{
			 $h2=$h1=0;
			 $flat=$uy[6]; $strut=$uy[9]; $level=$uy[11];
			 for ($rr=0;$rr<$devs;$rr++) 
				{
				 if ($dev[$rr]==$uy[4]) $h2=$data[$rr];
				 if ($dev[$rr]==$uy[5]) $h1=$data[$rr];
				}		

			 if ($h2 && $h1 && ($h2-$h1)<($h2/15) && ($h2-$h1)>0) 
	    			{
	    			 $dh[$strut][$level]=$h2-$h1;
	    			 $sdh[$sec][$strut]+=($h2-$h1);
	    			}
	    		 else if ($h2 && $h1 && ($h1-$h2)<($h2/15) && ($h1-$h2)>0) 
	    			{
	    			 $dh[$strut][$level]=$h1-$h2;
	    			 $sdh[$sec][$strut]+=($h1-$h2);
	    			 $querys[$quu] = 'UPDATE field SET id1='.$uy[5].',id2='.$uy[4].' WHERE id='.$uy[0];
	    			 //echo $querys[$quu];
	    			 //mysql_query ($querys[$quu],$i);
	    			 $iddd[$quu]=$h1.'-'.$h2;
	    			 $quu++;
	    			}
	    		 else $dh[$strut][$level]=0;
	    		 //if ($level==1) $dh[$strut][$level]=$dh[$strut][$level]/3;

			 if (($h2-$h1)<=0 || ($h2-$h1)>($h2/10)) echo '---['.$date1[$tn].'] ['.$sec.'/'.$strut.'/'.$level.'] ('.$uy[4].'='.$h2.')('.$uy[5].'='.$h1.') dh='.$dh[$strut][$level].' ['.$sdh[$sec][$strut].']<br>';
			 else echo '['.$date1[$tn].'] ['.$strut.'/'.$level.'] ('.$uy[4].'='.$h2.')('.$uy[5].'='.$h1.') dh='.$dh[$strut][$level].' ['.$sdh[$sec][$strut].']<br>';
			}

		 for ($st=0;$st<=$strut_n[$sec];$st++) 
			{
			 $strn=$strt[$sec][$st]; // strut
			 $sdh[$sec][$strn]=0;
			 $sdh_ok[$sec][$strn]=0;
			 for ($lv=1;$lv<=$levels;$lv++) 
				{
				 if ($dh[$strn][$lv]) //$dh[$strt[$st]][$lv]=$sdh[$strt[$st]]/$levels;
					{
					 $sdh[$sec][$strn]+=$dh[$strn][$lv];
					 $sdh_ok[$sec][$strn]++;
					}
				 //echo '['.$date1[$tn].'] ('.$lv.'/'.$strn.') dH='.$dh[$strn][$lv].' ['.$sdh[$sec][$strn].']<br>';
				}
			}		

		 $query = 'SELECT * FROM field WHERE type=1 AND mnem='.$sec.' ORDER BY flat,strut';
		 if ($a = mysql_query ($query,$i))
		 while ($uy = mysql_fetch_row ($a)) 
			{
			 $flat=$uy[6]; $strut=$uy[9]; $level=$uy[11];
			 if ($dh[$strut][$level]<=0) 
				{
				 //echo '>>>> '.$strut.'/'.$level.' '.$sdh[$sec][$strut].'/'.$sdh_ok[$sec][$strut];
				 if ($sdh_ok[$sec][$strn]>0) $dh[$strut][$level]=$sdh[$sec][$strut]/$sdh_ok[$sec][$strut];
				 else $dh[$strut][$level]=$sdh[$sec][$strut]/$levels;
				}
			 //else if ($level==2) $dh[$strut][$level]=$dh[$strut][$level]/3;
			 //if ($dh[$strut][$level]>4) $dh[$strut][$level]=$sdh[$sec][$strut]/25;
			 if ($qq>0 && $Q[$sec][$strut]==0) $Q[$sec][$strut]=$sumq/($qq*2.8);	 
			 //if ($Q[$sec][$strut]>30) $Q[$sec][$strut]/=2;
			 $Qfl[$flat]+=$Q[$sec][$strut]*$dh[$strut][$level]; // /$sdh[$strut];
			 //echo '['.$date1[$tn].'] ('.$flat.'/'.$strut.') '.$Q[$sec][$strut].'*'.$dh[$strut][$level].'/'.$sdh[$sec][$strut].'='.($Q[$strut]*$dh[$strut][$level]/$sdh[$sec][$strut]).' ['.$Qfl[$flat].']<br>';
			 echo '['.$date1[$tn].'] ('.$sec.'/'.$flat.'/'.$strut.') '.$Q[$sec][$strut].'*'.$dh[$strut][$level].'='.($Q[$sec][$strut]*$dh[$strut][$level]).' ['.$Qfl[$flat].']<br>';
			}
		}
     $QS=0;
     for ($rr=0;$rr<=$flats;$rr++)  $QS+=$Qfl[$rr];
     $QSvh*=4186;
     echo 'QSvh='.$QSvh.',QS='.$QS.' | S='.$ssquar.' V='.$sumq.' Vgv='.$sumg.'<br>';

     if ($QSvh>3000 && $sumq>10)
	{
	     if ($QSvh-($QS+0.4*4186)>0)
		{
		     for ($rr=0;$rr<=$flats;$rr++)  
			{
			 $Qflo[$rr]=($QSvh-$QS-0.4*4186)*$squar[$rr]/$ssquar;
			 if ($sumg) $Qflg[$rr]=(0.4*4186)*$dgvs[$rr]/$sumg;
			}
		}
   	     else
		{
		 if ($QSvh-$QS>0)
		 for ($rr=0;$rr<=$flats;$rr++)  
			{
			 //$Qflo[$rr]=($QSvh-$QS-0.4*4168)*$squar[$rr]/$ssquar;
			 if ($sumg) $Qflg[$rr]=($QSvh-$QS)*$dgvs[$rr]/$sumg;
			}
		}
	}
     else
	{
	     for ($rr=0;$rr<=$flats;$rr++) 
		{ 
 		 if ($sumg) $Qflg[$rr]=$QSvh*$dgvs[$rr]/$sumg;
                 $Qflo[$rr]=0;
                 $Qfl[$rr]=0;
		}
 	}
	 $query = 'SELECT DISTINCT flat FROM field WHERE type=1 ORDER BY flat';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a))
		{
		 $flat=$uy[0];
		 $query = 'SELECT * FROM data WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=0 AND date='.$date1[$tn];
		 //echo $query.'<br>';
		 if ($a2 = mysql_query ($query,$i))
		 if (!$uy2 = mysql_fetch_row ($a2)) $query = 'INSERT INTO data SET flat='.$flat.',prm=13,source=0,type=2,value='.$Qfl[$flat].',date='.$date1[$tn];
		 else	 $query = 'UPDATE data SET value='.$Qfl[$flat].',date='.$date1[$tn].' WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=0 AND date='.$date1[$tn];
		 echo $query.'<br>'; 
		 $a2 = mysql_query ($query,$i);	

		 $query = 'SELECT * FROM data WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=1 AND date='.$date1[$tn];
		 //echo $query.'<br>';
		 if ($a2 = mysql_query ($query,$i))
		 if (!$uy2 = mysql_fetch_row ($a2)) $query = 'INSERT INTO data SET flat='.$flat.',prm=13,source=1,type=2,value='.$Qflo[$flat].',date='.$date1[$tn];
		 else	 $query = 'UPDATE data SET value='.$Qflo[$flat].',date='.$date1[$tn].' WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=1 AND date='.$date1[$tn];
		 echo $query.'<br>'; 
		 $a2 = mysql_query ($query,$i);

		 $query = 'SELECT * FROM data WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=2 AND date='.$date1[$tn];
		 //echo $query.'<br>';
		 if ($a2 = mysql_query ($query,$i))
		 if (!$uy2 = mysql_fetch_row ($a2)) $query = 'INSERT INTO data SET flat='.$flat.',prm=13,source=2,type=2,value='.$Qflg[$flat].',date='.$date1[$tn];
		 else	 $query = 'UPDATE data SET value='.$Qflg[$flat].',date='.$date1[$tn].' WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=2 AND date='.$date1[$tn];
		 echo $query.'<br>'; 
		 $a2 = mysql_query ($query,$i);
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
 if (0) 
 for ($tn=1; $tn<=90; $tn++) 
 for ($cn=0; $cn<$flats; $cn++) 
	{		
	 $query = 'SELECT * FROM data WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=6 AND date='.$date1[$tn];
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO data SET flat='.$flt[$cn].',prm=12,source=6,type=2,value='.$hvs[$flt[$cn]][$tn].',date='.$date1[$tn];
	 else $query = 'UPDATE data SET value='.$hvs[$flt[$cn]][$tn].',date='.$date1[$tn].' WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=6 AND date='.$date1[$tn];
	 echo $query.'<br>'; $a = mysql_query ($query,$i);

	 $query = 'SELECT * FROM data WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=5 AND date='.$date1[$tn];
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO data SET flat='.$flt[$cn].',prm=12,source=5,type=2,value='.$hvs[$flt[$cn]][$tn].',date='.$date1[$tn];
	 else	 $query = 'UPDATE data SET value='.$hvs[$flt[$cn]][$tn].',date='.$date1[$tn].' WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=5 AND date='.$date1[$tn];
	 echo $query.'<br>'; $a = mysql_query ($query,$i);
	}
}

?>
                