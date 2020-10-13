<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
 include("config/local3.php");
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
?>

<html><head>
<title>Конвертируем из SQL Lite (QDK) в MySQL (DK)</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Pragma" content="no-cashe">
<link rel="stylesheet" href="files/structure_collage_ektron.css" type="text/css">
<link rel="stylesheet" href="files/default.css" title="default" type="text/css">
<link rel="alternate stylesheet" href="files/default_larger.css" title="big" type="text/css">
<link rel="stylesheet" type="text/css" href="files/niftyCorners.css">
<link rel="stylesheet" type="text/css" href="files/quotetabs.css">
</head>
<body>

<?php
 $host='d:\riga.db';
 $dsn = 'sqlite:d:\riga.db';
 $user = '';
 $password = '';
 $crdate=mktime(0, 0, 0, 3, 12, 2013);
 $crdate2=mktime(0, 0, 0, 6, 3, 2013);

 echo $crdate.' '.$crdate2.'<br>'; 
 //1357862400
 //1348128000
 //01 01 000015dc
 //1345128600
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

$dbh = new PDO($dsn, $user, $password); 
 //----------------------------------------------------------------------------------------------------------------------------
 $sql = 'SELECT * FROM BIT_Config_Structure';
 if (0)
 foreach ($dbh->query($sql) as $row) 
	{
	 $sql = 'SELECT * FROM Qbit WHERE factory=\''.$row["factory"].'\'';
	 foreach ($dbh->query($sql) as $row2) 
		{
		 $strut=$row2["strut"];
		}
	 $sql = 'SELECT * FROM system_config WHERE factory=\''.$row["factory"].'\'';
	 foreach ($dbh->query($sql) as $row2) 
		{
		 $flat_n=$row2["flat"];
		 $floor=$row2["floor"];
		}

         print '<tr bgcolor="#ffffff">';
         print '<td align="center">'.$row["factory"].'</td>';
         print '<td align="center">'.$row["link_factory"].'</td>';
         print '<td align="center">'.$row["rf_interact_interval"].'</td>';
         print '<td align="center">'.$row["measure_interval"].'</td>';
         print '<td align="center">'.$row["integral_measure_count"].'</td>';
         print '<td align="center">'.$floor.'</td>';
         print '<td align="center">'.$flat_n.'</td>';
         print '<td align="center">'.$strut.'</td>';
         print '<td align="center">'.$row["rf_power"].'</td>';
         print '</tr>';
	 //01 01 000016c9
	 $factory=hexdec (substr ($row["factory"],6,8));	 
	 $factory_link=hexdec (substr ($row["link_factory"],6,8));	 
	 $idd=16842753+$factory;

        }
print '</table>';	
//----------------------------------------------------------------------------------------------------------------------------
print '<table cellpadding=2 cellspacing=1 bgcolor=#82cc7f align=center>
<tr bgcolor="#476a94">
<td align="center"><font color="white">id</font></td>
<td align="center"><font color="white">factory</font></td>
<td align="center"><font color="white">link</font></td>
<td align="center"><font color="white">rf_interact</font></td>
<td align="center"><font color="white">measure</font></td>
<td align="center"><font color="white">integral_measure</font></td>
<td align="center"><font color="white">flat_number</font></td>
<td align="center"><font color="white">rf_power</font></td></tr>';	

 $sql = 'SELECT * FROM IRP_DataFrom_Structure';
 if (0)
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

	 $factory=hexdec (substr ($row["factory"],6,8));
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
 if (0)
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
	 $factory=hexdec (substr ($row["factory"],6,8));
	 $idd=33882112+$factory;

	 $tarr = localtime($row["date"],TRUE);
	 //$tarr = localtime(1361318400);
	 $date2=sprintf ("%d%02d%02d000000",1900+$tarr[tm_year],$tarr[tm_mon]+1,$tarr[tm_mday],$tarr[tm_hour]);

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
 echo $sql;
 if (0)
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
	 $date2=sprintf ("%d%02d%02d000000",1900+$tarr[tm_year],$tarr[tm_mon]+1,$tarr[tm_mday],$tarr[tm_hour]);

	 $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$idd.' AND date='.$date2.' AND prm=13 AND pipe=0'; echo $query.'<br>';	 
	 if ($a = mysql_query ($query,$i))	 
	 if (!$uy = mysql_fetch_row ($a))
		{
		 $value=$row["Q"];
        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=13,date='.$date2.',type=2,value=\''.$value.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 
	        }
	 $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$idd.' AND date='.$date2.' AND prm=11 AND pipe=0'; echo $query.'<br>';	 
	 if (0)
	 if ($a = mysql_query ($query,$i))	 
	 if (!$uy = mysql_fetch_row ($a))
		{
		 $value=$row["V"];
        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=11,date='.$date2.',type=2,value=\''.$value.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 
	        }
        }
print '</table>';	
//----------------------------------------------------------------------------------------------------------------------------
print '<table cellpadding=2 cellspacing=1 bgcolor=#82cc7f align=center>
<tr bgcolor="#476a94">
<td align="center"><font color="white">factory</font></td>
<td align="center"><font color="white">link</font></td>
<td align="center"><font color="white">rf_interact</font></td>
<td align="center"><font color="white">measure</font></td>
<td align="center"><font color="white">integral_measure</font></td>
<td align="center"><font color="white">flat_number</font></td>
<td align="center"><font color="white">rf_power</font></td></tr>';	

 $sql = 'SELECT * FROM I2CH_Config_Structure';
 if (0)
 foreach ($dbh->query($sql) as $row) 
	{
         print '<tr bgcolor="#ffffff">';
         print '<td align="center">'.$row["factory"].'</td>';
         print '<td align="center">'.$row["link_factory"].'</td>';
         print '<td align="center">'.$row["rf_interact_interval"].'</td>';
         print '<td align="center">'.$row["measure_interval"].'</td>';
         print '<td align="center">'.$row["integral_measure_count"].'</td>';
         print '<td align="center">'.$row["flat_number"].'</td>';
         print '<td align="center">'.$row["rf_power"].'</td>';
         print '</tr>';
	 //01 01 000016c9
	 $factory=hexdec (substr ($row["factory"],6,8));	 
	 $factory_link=hexdec (substr ($row["link_factory"],6,8));	 
	 $idd=16910000+$factory;

	 $query = 'SELECT * FROM device WHERE type=2 AND adr='.$factory;
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if (0)
	 if (!$uy)
		{
		 $query = 'INSERT INTO device SET idd='.$idd.',SV=1,interface=3,protocol=4,port=0,speed=0,adr='.$factory.',type=2,flat='.$row["flat_number"].',akt=1,source=1,name="2IP (flat='.$row["flat_number"].')", ust=0';
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		}
	 $query = 'SELECT * FROM dev_2ip WHERE ids_module='.$factory;
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if (0)
	 if (!$uy)
		{
		 $query = 'INSERT INTO dev_2ip SET device='.$idd.',rf_int_interval='.$row["rf_interact_interval"].',ids_lk='.$factory_link.',ids_module='.$factory.',meas_interval='.$row["measure_interval"].',flat_number='.$row["flat_number"];
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		}
        }
print '</table>';	

//----------------------------------------------------------------------------------------------------------------------------
print '<table cellpadding=2 cellspacing=1 bgcolor=#82cc7f align=center>
<tr bgcolor="#476a94">
<td align="center"><font color="white">factory</font></td>
<td align="center"><font color="white">parent</font></td>
<td align="center"><font color="white">name</font></td>
<td align="center"><font color="white">status</font></td>
<td align="center"><font color="white">floor</font></td>
<td align="center"><font color="white">flat</font></td>
<td align="center"><font color="white">section</font></td>
</tr>';	
 $sql = 'SELECT * FROM system_config';

 if (0)
 foreach ($dbh->query($sql) as $row) 
	{
         print '<tr bgcolor="#ffffff">';
         print '<td align="center">'.$row["factory"].'</td>';
         print '<td align="center">'.$row["parent_factory"].'</td>';
         print '<td align="center">'.$row["name"].'</td>';
         print '<td align="center">'.$row["status"].'</td>';
         print '<td align="center">'.$row["floor"].'</td>';
         print '<td align="center">'.$row["flat"].'</td>';
         print '<td align="center">'.$row["section"].'</td>';
         print '</tr>';
	 $factory_link=hexdec (substr ($row["factory"],6,8));	 

	 $query = 'SELECT * FROM dev_lk WHERE adr='.$factory_link;
	 echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if ($uy)
		{
		 $idd=17170451+$factory_link;
		 $query = 'UPDATE dev_lk SET napr='.$row["section"].' WHERE device='.$idd.' AND adr='.$factory_link;
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 if ($row["section"]==6 || $row["section"]==5) $query = 'UPDATE device SET port=0 WHERE idd='.$idd;
		 if ($row["section"]==4 || $row["section"]==3) $query = 'UPDATE device SET port=1 WHERE idd='.$idd;
		 if ($row["section"]==2 || $row["section"]==1) $query = 'UPDATE device SET port=2 WHERE idd='.$idd;
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
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
 if (0)
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
	 $vdd=$row["vdd"]/100;

	 $idd=16842753+$factory;

	 $tarr = localtime($row["time"],TRUE);
	 $date2=sprintf ("%d%02d%02d000000",1900+$tarr[tm_year],$tarr[tm_mon]+1,$tarr[tm_mday],$tarr[tm_hour]);

	 $query = 'UPDATE device SET lastdate=NULL,devtim='.$date2.' WHERE idd='.$idd;
	 $a = mysql_query ($query,$i);

	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=1 AND type=0 AND pipe=0'; //echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a))
		{
		 $query = 'INSERT INTO prdata SET prm=33,type=0,value='.$vdd.',pipe=0,device='.$idd; echo $query.'<br>';
		 $a = mysql_query ($query,$i);		 
		 $query = 'INSERT INTO prdata SET prm=32,type=0,value='.$rssi.',pipe=0,device='.$idd; echo $query.'<br>';
		 $a = mysql_query ($query,$i);		 
		 $query = 'INSERT INTO prdata SET prm=1,type=0,value='.$value.',pipe=0,device='.$idd; echo $query.'<br>';
		 $a = mysql_query ($query,$i);		 
		 $query = 'INSERT INTO prdata SET prm=4,type=0,value='.$temp.',pipe=0,device='.$idd; echo $query.'<br>';
		 $a = mysql_query ($query,$i);		 
		}
	 else	{
		 $query = 'UPDATE prdata SET prm=33,type=0,value='.$vdd.',pipe=0 WHERE device='.$idd.' AND prm=33 AND type=0 AND pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'UPDATE prdata SET prm=32,type=0,value='.$rssi.',pipe=0 WHERE device='.$idd.' AND prm=32 AND type=0 AND pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'UPDATE prdata SET prm=4,type=0,value='.$temp.',pipe=0 WHERE device='.$idd.' AND prm=4 AND type=0 AND pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'UPDATE prdata SET prm=1,type=0,value='.$value.',pipe=0 WHERE device='.$idd.' AND prm=1 AND type=0 AND pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);

		}
	}
//----------------------------------------------------------------------------------------------------------------------------
 $sql = 'SELECT * FROM I2CH_DataFrom_Structure';
 if (0)
 foreach ($dbh->query($sql) as $row) 
	{
	 $factory=hexdec (substr ($row["factory"],6,8));
	 $value=$row["consumtion_value1"];
	 $value2=$row["consumtion_value2"];
	 $expvalue=$row["expense_value1"];
	 $expvalue2=$row["expense_value2"];
	 $rssi=intval ($row["last_rssi"]);
	 $vdd=$row["vdd"]/100;
	 $idd=16910000+$factory;

	 $tarr = localtime($row["time"],TRUE);
	 $date2=sprintf ("%d%02d%02d000000",1900+$tarr[tm_year],$tarr[tm_mon]+1,$tarr[tm_mday],$tarr[tm_hour]);

	 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=32 AND type=0 AND pipe=0';
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a))
		{
		 $query = 'INSERT INTO prdata SET prm=32,type=0,value='.$rssi.',pipe=0,device='.$idd;	
		 echo $query.'<br>'; $a = mysql_query ($query,$i);		 
		 $query = 'INSERT INTO prdata SET prm=33,type=0,value='.$vdd.',pipe=0,device='.$idd;	
		 echo $query.'<br>'; $a = mysql_query ($query,$i);		 
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=5,type=0,value='.$expvalue.',pipe=0';
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=6,type=0,value='.$value.',pipe=0';
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=7,type=0,value='.$expvalue2.',pipe=0';
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=8,type=0,value='.$value2.',pipe=0';
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		}
	 else	{
		 $query = 'UPDATE prdata SET prm=32,type=0,value='.$rssi.',pipe=0 WHERE device='.$idd.' AND prm=32 AND type=0 AND pipe=0';	
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		 $query = 'UPDATE prdata SET prm=33,type=0,value='.$vdd.',pipe=0 WHERE device='.$idd.' AND prm=33 AND type=0 AND pipe=0';	
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
	 	 $query = 'UPDATE prdata SET value='.$expvalue.' WHERE device='.$idd.' AND prm=5 AND type=0 AND pipe=0';
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		 $query = 'UPDATE prdata SET value='.$value.' WHERE device='.$value.' AND prm=6 AND type=0 AND pipe=0';
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
	 	 $query = 'UPDATE prdata SET value='.$expvalue2.' WHERE device='.$idd.' AND prm=7 AND type=0 AND pipe=0';
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
	 	 $query = 'UPDATE prdata SET value='.$value2.' WHERE device='.$idd.' AND prm=8 AND type=0 AND pipe=0';
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		}

	 $query = 'UPDATE device SET lastdate=NULL,devtim='.$date2.' WHERE idd='.$idd;
	 $a = mysql_query ($query,$i);

	 if (0)
		{	
		 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=5 AND type=2 AND pipe=0 AND date='.$date2;
		 echo $query.'<br>';
		 if ($a = mysql_query ($query,$i))
		 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO prdata SET device='.$idd.',prm=5,type=2,value='.$expvalue.',pipe=0,date='.$date2;
		 //else	 $query = 'UPDATE prdata SET value='.$expvalue.' WHERE device='.$idd.' AND prm=5 AND type=2 AND pipe=0 AND date='.$date2;
		 echo $query.'<br>'; $a = mysql_query ($query,$i);

		 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=6 AND type=2 AND pipe=0 AND date='.$date2;
		 echo $query.'<br>';
		 if ($a = mysql_query ($query,$i))
		 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO prdata SET device='.$idd.',prm=6,type=2,value='.$value2.',pipe=0,date='.$date2;
		 //else	 $query = 'UPDATE prdata SET value='.$value2.' WHERE device='.$idd.' AND prm=6 AND type=2 AND pipe=0 AND date='.$date2;
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
	                                                  
		 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=7 AND type=2 AND pipe=0 AND date='.$date2;
		 echo $query.'<br>';
		 if ($a = mysql_query ($query,$i))
		 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO prdata SET device='.$idd.',prm=7,type=2,value='.$expvalue2.',pipe=0,date='.$date2;
		 //else	 $query = 'UPDATE prdata SET value='.$expvalue2.' WHERE device='.$idd.' AND prm=7 AND type=2 AND pipe=0 AND date='.$date2;
		 echo $query.'<br>'; $a = mysql_query ($query,$i);

		 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=8 AND type=2 AND pipe=0 AND date='.$date2;
		 echo $query.'<br>';
		 if ($a = mysql_query ($query,$i))
		 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO prdata SET device='.$idd.',prm=8,type=2,value='.$value2.',pipe=0,date='.$date2;
		 //else	 $query = 'UPDATE prdata SET value='.$value.' WHERE device='.$value2.' AND prm=8 AND type=2 AND pipe=0 AND date='.$date2;
		 echo $query.'<br>'; $a = mysql_query ($query,$i);
		}
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

// $query = 'DELETE FROM prdata WHERE type=2 AND pipe=0 AND device>16840000 AND device<16900000';
// mysql_query ($query,$i);
// $sql = 'DELETE FROM bit WHERE time < '.$crdate;
// echo $sql.'<br>';
// $dbh->query($sql);

 $sql = 'SELECT * FROM bit WHERE time >= '.$crdate.' GROUP BY factory,time ORDER BY factory DESC';
 echo $sql.'<br>';
 if (0)
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
	 if (0)
		{
	       	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=1,date='.$date2.',type=2,value=\''.$value.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 		 
	       	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=4,date='.$date2.',type=2,value=\''.$temp.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 		 
	       	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=31,date='.$date2.',type=2,value=\''.$sum.'\',pipe=0'; echo $query.'<br>';
		 $a = mysql_query ($query,$i);	 		 
		}  
	 //if ($idd>16849831)
	 if (1)
		{
		 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=1 AND type=2 AND pipe=0 AND date=\''.$date2.'\'';
		 //echo $query.'<br>';		 
		 if ($a = mysql_query ($query,$i))
		 if (!$uy = mysql_fetch_row ($a))
			{
	        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=1,date='.$date2.',type=2,value=\''.$value.'\',pipe=0'; echo $query.'<br>';
			 $a = mysql_query ($query,$i);	 		 
	        	 $query = 'INSERT INTO prdata SET device='.$idd.',prm=4,date='.$date2.',type=2,value=\''.$temp.'\',pipe=0'; echo $query.'<br>';
			 $a = mysql_query ($query,$i);	 		 
        		 $query = 'INSERT INTO prdata SET device='.$idd.',prm=31,date='.$date2.',type=2,value=\''.$sum.'\',pipe=0'; echo $query.'<br>';
			 $a = mysql_query ($query,$i);	 		 
			}
		}
	}
//----------------------------------------------------------------------------------------------------------------------------
 $sql = 'SELECT * FROM i2ch WHERE time > '.$crdate.' GROUP BY factory,time ORDER BY time';
 if (0)
 foreach ($dbh->query($sql) as $row) 
	{
	 $factory=hexdec (substr ($row["factory"],6,8));
	 $value=$row["consumtion_value1"];
	 $value2=$row["consumtion_value2"];
	 $expvalue=$row["expense_value1"];
	 $expvalue2=$row["expense_value2"];
	 $rssi=intval ($row["last_rssi"]);
	 $idd=16910000+$factory;

         echo $idd.' | '.$value.' | '.$value2.' | '.$expvalue.' '.$expvalue2.'<br>';

	 $tarr = localtime($row["time"],TRUE);
	 $date2=sprintf ("%d%02d%02d000000",1900+$tarr[tm_year],$tarr[tm_mon]+1,$tarr[tm_mday],$tarr[tm_hour]);

	 if (0)
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
	 if (1)
		{
		 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=6 AND type=2 AND pipe=0 AND date='.$date2;
		 //echo $query.'<br>';
		 if ($a = mysql_query ($query,$i))
		 if (!$uy = mysql_fetch_row ($a)) 
			{
			 $query = 'INSERT INTO prdata SET device='.$idd.',prm=6,type=2,value='.$value.',pipe=0,date='.$date2;
			 echo $query.'<br>'; $a = mysql_query ($query,$i);
			 $query = 'INSERT INTO prdata SET device='.$idd.',prm=8,type=2,value='.$value2.',pipe=0,date='.$date2;
			 echo $query.'<br>'; $a = mysql_query ($query,$i);
			}
		}
	 if (0)
		{
		 $query = 'SELECT * FROM prdata WHERE device='.$idd.' AND prm=5 AND type=2 AND pipe=0 AND date='.$date2;
		 echo $query.'<br>';
		 if ($a = mysql_query ($query,$i))
		 if (!$uy = mysql_fetch_row ($a)) 
			{
			 $query = 'INSERT INTO prdata SET device='.$idd.',prm=5,type=2,value='.$expvalue.',pipe=0,date='.$date2;
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
		}
	}
//----------------------------------------------------------------------------------------------------------------------------
if (0)
{
 $query = 'SELECT * FROM dev_2ip';
 echo $query.'<br>'; $cn=0;
 if ($a = mysql_query ($query,$i))
 while ($uy = mysql_fetch_row ($a)) 
	{
	 $dev[$cn]=$uy[1]; $flt[$cn]=$uy[6];	 
	 $cn++;
	}
 $flats=$cn; 

 $today=getdate();
 $ye=$today["year"];
 $mn=$today["mon"];
 $tm=$today["mday"]=2;
 for ($tn=1; $tn<=100; $tn++) 
	{		
	 $date1[$tn]=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $query = 'SELECT * FROM prdata WHERE (prm=6 OR prm=8) AND type=2 AND date='.$date1[$tn];
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{		 
		 for ($rr=0;$rr<$flats;$rr++) if ($dev[$rr]==$uy[1]) break;
		 if ($uy[2]==6) $tgvs[$flt[$rr]][$tn]+=$uy[5];
		 if ($uy[2]==8) $thvs[$flt[$rr]][$tn]+=$uy[5];
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
 for ($tn=2; $tn<=100; $tn++) 
 for ($rr=0;$rr<$flats;$rr++)
	{			 
	 if ($tgvs[$flt[$rr]][$tn]==0 || $tgvs[$flt[$rr]][$tn]=='') $tgvs[$flt[$rr]][$tn]=$tgvs[$flt[$rr]][$tn-1];
	 if ($thvs[$flt[$rr]][$tn]==0 || $thvs[$flt[$rr]][$tn]=='') $thvs[$flt[$rr]][$tn]=$thvs[$flt[$rr]][$tn-1];
	}

 for ($rr=0;$rr<$flats;$rr++)
 for ($tn=1; $tn<=100; $tn++) 
	{		
  	 if ($tgvs[$flt[$rr]][$tn]>0 && $tgvs[$flt[$rr]][$tn+1]>0 && $tgvs[$flt[$rr]][$tn]>=$tgvs[$flt[$rr]][$tn+1])
		if ($tgvs[$flt[$rr]][$tn]-$tgvs[$flt[$rr]][$tn+1]<10) $gvs[$flt[$rr]][$tn]=$tgvs[$flt[$rr]][$tn]-$tgvs[$flt[$rr]][$tn+1];
		else $gvs[$flt[$rr]][$tn]=0;
  	 if ($thvs[$flt[$rr]][$tn]>0 && $thvs[$flt[$rr]][$tn+1]>0 && $thvs[$flt[$rr]][$tn]>=$thvs[$flt[$rr]][$tn+1])
		if ($thvs[$flt[$rr]][$tn]-$thvs[$flt[$rr]][$tn+1]<10) $hvs[$flt[$rr]][$tn]=$thvs[$flt[$rr]][$tn]-$thvs[$flt[$rr]][$tn+1];
		else $hvs[$flt[$rr]][$tn]=0;
	}

 for ($tn=1; $tn<=100; $tn++) 
 for ($cn=0; $cn<$flats; $cn++) 
 if ($gvs[$flt[$cn]][$tn]>=0 || $hvs[$flt[$cn]][$tn]>=0)
	{		
	 $query = 'SELECT * FROM data WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=5 AND date='.$date1[$tn];
	 //echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO data SET flat='.$flt[$cn].',prm=12,source=5,type=2,value='.$hvs[$flt[$cn]][$tn].',date='.$date1[$tn];
	 else	 $query = 'UPDATE data SET value='.$hvs[$flt[$cn]][$tn].',date='.$date1[$tn].' WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=5 AND date='.$date1[$tn];
	 echo $flt[$cn].' '.$thvs[$flt[$cn]][$tn].' | '.$thvs[$flt[$cn]][$tn+1].' '.$query.'<br>'; $a = mysql_query ($query,$i);

	 $query = 'SELECT * FROM data WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=6 AND date='.$date1[$tn];
	 //echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO data SET flat='.$flt[$cn].',prm=12,source=6,type=2,value='.$gvs[$flt[$cn]][$tn].',date='.$date1[$tn];
	 else	 $query = 'UPDATE data SET value='.$gvs[$flt[$cn]][$tn].',date='.$date1[$tn].' WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=6 AND date='.$date1[$tn];
	 echo $flt[$cn].' '.$tgvs[$flt[$cn]][$tn].' | '.$tgvs[$flt[$cn]][$tn+1].' '.$query.'<br>'; $a = mysql_query ($query,$i);
	}
}
//----------------------------------------------------------------------------------------------------------------------------
if (1)
{
 for ($sec=1;$sec<=1;$sec++)
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
 echo 'devices='.$cn.'<br>';

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
 $tm=$today["mday"]=2;
 for ($tn=1; $tn<=100; $tn++) 
	{		
	 for ($rr=0;$rr<=$flats;$rr++)  $Qfl[$rr]=0;

	 $date11[$tn]=sprintf ("%d%02d01000000",$ye,$mn);
	 $date12[$tn]=sprintf ("%d%02d01000000",$ye,$mn+1);

	 $query = 'SELECT value FROM data WHERE flat=0 AND prm=13 AND type=2 AND source=0 AND date='.$date11[$tn];
	 if ($a2 = mysql_query ($query,$i))
	 if ($uy2 = mysql_fetch_row ($a2)) 
		{
		 $input[$tn]=$uy2[0];
		}

	 $query = 'SELECT SUM(value) FROM data WHERE flat>0 AND prm=13 AND type=2 AND source=0 AND date>='.$date11[$tn].' AND date<'.$date12[$tn];
	 //echo $query.'<br>';
	 if ($a2 = mysql_query ($query,$i))
	 if ($uy2 = mysql_fetch_row ($a2)) 
		{
		 $sumdata[$tn]=$uy2[0];
		}
	 if ($sumdata[$tn]) $knt[$tn]=$input[$tn]/$sumdata[$tn];
	 else $knt[$tn]=1;
	 
	 echo 'knt='.$knt[$tn].'<br>';

	 $date1[$tn]=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
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
	 $query = 'SELECT * FROM prdata WHERE prm=11 AND date='.$date1[$tn]; echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 for ($rr=0;$rr<$devs;$rr++) 
		 if ($dev[$rr]==$uy[1])
			{
			 $Q[$sect[$rr]][$str[$rr]]=$uy[5];
			 echo '['.$dev[$rr].'] V['.$sect[$rr].']['.$str[$rr].']='.$Q[$sect[$rr]][$str[$rr]].'<br>';
			 $sumq+=$uy[5];
	    		 $qq++;
	    		 break;
			}
		}

	 for ($sec=1;$sec<=1;$sec++)
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
			 //if (1)
				{
				 $dh[$strut][$level]=$h2-$h1;
				 $sdh[$sec][$strut]+=($h2-$h1);
				}
			 else $dh[$strut][$level]=0;
			 if (($h2-$h1)<=0 || ($h2-$h1)>($h2/10)) echo '---['.$date1[$tn].'] ['.$sec.'/'.$strut.'/'.$level.'] ('.$uy[4].'='.$h2.')('.$uy[5].'='.$h1.') dh='.$dh[$strut][$level].' ['.$sdh[$sec][$strut].']<br>';
			 else echo '['.$date1[$tn].'] ['.$strut.'/'.$level.'] ('.$uy[4].'='.$h2.')('.$uy[5].'='.$h1.') dh='.$dh[$strut][$level].' ['.$sdh[$sec][$strut].']<br>';
			}

		 for ($st=0;$st<=$strut_n[$sec];$st++) 
			{
			 $strn=$strt[$sec][$st]; // strut
			 $sdh[$sec][$strn]=0;
			 $sdh_ok[$sec][$strn]=0;
	    		 if ($qq>0 && $Q[$sec][$strn]==0) $Q[$sec][$strn]=$sumq/$qq;
	     
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
				 if ($sdh_ok[$sec][$strn]>0) $dh[$strut][$level]=$sdh[$sec][$strut]/$sdh_ok[$sec][$strut];
				 else $dh[$strut][$level]=$sdh[$sec][$strut]/$levels;
				}					 
			 $Qfl[$flat]+=$Q[$sec][$strut]*$dh[$strut][$level]; // /$sdh[$strut];
			 //echo '['.$date1[$tn].'] ('.$flat.'/'.$strut.') '.$Q[$sec][$strut].'*'.$dh[$strut][$level].'/'.$sdh[$sec][$strut].'='.($Q[$strut]*$dh[$strut][$level]/$sdh[$sec][$strut]).' ['.$Qfl[$flat].']<br>';
			 echo '['.$date1[$tn].'] ('.$sec.'/'.$flat.'/'.$strut.') '.$Q[$sec][$strut].'*'.$dh[$strut][$level].'='.($Q[$sec][$strut]*$dh[$strut][$level]).' ['.$Qfl[$flat].']<br>';
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

		 $query = 'SELECT * FROM data WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=2 AND date='.$date1[$tn];
		 //echo $query.'<br>';
		 if ($a2 = mysql_query ($query,$i))
		 if (!$uy2 = mysql_fetch_row ($a2)) $query = 'INSERT INTO data SET flat='.$flat.',prm=13,source=0,type=2,value='.($Qfl[$flat]*($knt[$tn]-1)).',date='.$date1[$tn];
		 else	 $query = 'UPDATE data SET value='.($Qfl[$flat]*($knt[$tn]-1)).',date='.$date1[$tn].' WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=0 AND date='.$date1[$tn];
		 echo $query.'<br>'; 
		 //$a2 = mysql_query ($query,$i);	
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

 $today=getdate();
 $ye=$today["year"];
 $mn=$today["mon"]-1;
 for ($tn=1; $tn<=12; $tn++)
	{	 
	 $date11[$tn]=sprintf ("%d%02d01000000",$ye,$mn);
	 $date12[$tn]=sprintf ("%d%02d01000000",$ye,$mn+1);

	 $query = 'SELECT value FROM data WHERE flat=0 AND prm=13 AND type=2 AND source=0 AND date='.$date11[$tn];
	 if ($a2 = mysql_query ($query,$i))
	 if ($uy2 = mysql_fetch_row ($a2)) 
		{
		 $input[$tn]=$uy2[0];
		}

	 $query = 'SELECT SUM(value) FROM data WHERE flat>0 AND prm=13 AND type=2 AND source=0 AND date>='.$date11[$tn].' AND date<'.$date12[$tn];
	 //echo $query.'<br>';
	 if ($a2 = mysql_query ($query,$i))
	 if ($uy2 = mysql_fetch_row ($a2)) 
		{
		 $sumdata[$tn]=$uy2[0];
		}
	 if ($sumdata[$tn]) $knt[$tn]=$input[$tn]/$sumdata[$tn];
	 else $knt[$tn]=1;
	 if ($mn==1) { $mn=12; $ye--; }
	 else $mn--;
	}

 if (0)
 for ($tn=1; $tn<=4; $tn++) 
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
