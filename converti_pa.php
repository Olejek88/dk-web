<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
 include("config/local3.php");
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
// $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
// $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
// $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
 $query = "set character_set_client='utf8'"; mysql_query ($query,$i);
 $query = "set character_set_results='utf8'"; mysql_query ($query,$i);
 $query = "set collation_connection='utf8_general_ci'"; mysql_query ($query,$i);
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
 $dbh = new PDO($dsn, $user, $password);

 print '<table cellpadding=2 cellspacing=1 bgcolor=#82cc7f align=center>
	<tr bgcolor="#476a94">
	<td align="center"><font color="white">factory</font></td>
	<td align="center"><font color="white">address</font></td>
	<td align="center"><font color="white">strut</font></td></tr>';	
 //----------------------------------------------------------------------------------------------------------------------------
 $sql = 'SELECT * FROM BIT_Config_Structure';
 if (1)
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
		 //$strut=$row2["location"];
		 $section=$row2["section"]=1;
		}

         print '<tr bgcolor="#ffffff">';
         print '<td align="center">'.$row["factory"].'</td>';
         print '<td align="center">'.$row["link_factory"].'</td>';
         print '<td align="center">'.$row["rf_interact_interval"].'</td>';
         print '<td align="center">'.$row["measure_interval"].'</td>';
         print '<td align="center">'.$row["integral_measure_count"].'</td>';
         print '<td align="center">'.$row["pi"].'</td>';
         print '<td align="center">'.$flat_n.'</td>';
         print '<td align="center">'.$strut.'</td>';
         print '<td align="center">'.$floor.'</td>';
         print '<td align="center">'.$row["rf_power"].'</td>';
         print '</tr>';
	 //01 01 000016c9
	 $factory=hexdec (substr ($row["factory"],6,8));	 
	 $factory_link=hexdec (substr ($row["link_factory"],6,8));	 
	 $idd=16842753+$factory;

	 $strut_n=$strut;
	 //GetStrut2($i,0,$strut);
	 //if ($strut_n==0) $strut_n=$strut;

	 $query = 'SELECT * FROM device WHERE type=1 AND adr='.$factory;
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if (0)
	 if (!$uy)
		{
		 $query = 'INSERT INTO device SET idd='.$idd.',SV=1,interface=3,protocol=4,port=0,speed=0,adr='.$factory.',type=1,flat='.$row["flat_number"].',akt=1,source=1,name="BIT (flat='.$row["flat_number"].', str='.$strut_n.')", ust=0';
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		}
	 else   {
		 $query = 'UPDATE device SET adr='.$factory.',flat='.$flat_n.',name="BIT (flat='.$flat_n.', str='.$strut_n.')", ust=0 WHERE idd='.$idd;
		 //echo $query.'<br>';
		 //$a = mysql_query ($query,$i);		
		}

	 $query = 'SELECT * FROM dev_bit WHERE ids_module='.$factory;
	 echo $query.'<br>';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if (!$uy)
		{
		 $query = 'INSERT INTO dev_bit SET device='.$idd.',rf_int_interval='.$row["rf_interact_interval"].',ids_lk='.$factory_link.',ids_module='.$factory.',meas_interval='.$row["measure_interval"].',integ_meas_cnt='.$row["integral_measure_count"].',pi='.$row["pi"].',flat_number='.$row["flat_number"].',strut_number=\''.$strut_n.'\',low_warn_temp='.$row["low_warning_temperature"].',high_warn_temp='.$row["high_warning_temperature"].',low_error_temp='.$row["low_error_temperature"].',high_error_temp='.$row["high_error_temperature"].',imitate_tem='.$row["imitate_temperatue"];
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		}
	 else	{
		 //print $idd.' '.$flat_n.' '.$strut.'<br>';		 
		 $query = 'UPDATE dev_bit SET flat_number='.$flat_n.', strut_number="'.$strut.'",imitate_tem='.$section.',pa_table='.$floor.' WHERE device='.$idd;
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		 $query = 'UPDATE device SET flat='.$flat_n.',name="BIT (flat='.$flat_n.',str='.$strut_n.')" WHERE idd='.$idd;
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		}

	 $query = 'SELECT * FROM device WHERE type=6 AND adr='.$factory_link;
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if (0)
	 if (!$uy)
		{
		 $idd=17170451+$factory_link;
		 $query = 'INSERT INTO device SET idd='.$idd.',SV=3,interface=2,protocol=4,port=2,speed=115200,adr='.$factory_link.',type=6,flat=0,akt=1,source=123,name="LK ('.$row["link_factory"].')", ust=0';
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		}
	
	 $query = 'SELECT * FROM dev_lk WHERE adr='.$factory_link;
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if (0)
	 if (!$uy)
		{
		 $idd=17170451+$factory_link;
		 $query = 'INSERT INTO dev_lk SET device='.$idd.',adr='.$factory_link;
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		}
	 else	{
		 $idd=17170451+$factory_link;
		 $query = 'UPDATE dev_lk SET level='.$floor.' WHERE device='.$idd;
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);		 
		}

	 $query = 'SELECT * FROM flats WHERE flat='.$row["flat_number"];
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if (0)
	 if (!$uy)
		{
		 $query = 'INSERT INTO flats SET flat='.$row["flat_number"].',level=1,rooms=2,nstrut=2,name="Flat ('.$row["flat_number"].')",fname="Flat ('.$row["flat_number"].')"';
		 echo $query.'<br>';
		 $a = mysql_query ($query,$i);
		}
        }
 print '</table>';	

 //----------------------------------------------------------------------------------------------------------------------------

 function GetFlat($flat) 
	{
	 if (strstr ($flat," 1")) return 500;
	 if (strstr ($flat," 2")) return 501;
	 if (strstr ($flat," 3")) return 502;
	 if (strstr ($flat," 4")) return 503;
	 if (strstr ($flat," 5")) return 504;
	 if (strstr ($flat," 6")) return 505;
	 return 0;
	}

 function GetStrut2($i, $factory,$str) 
	{
	 $query = 'SELECT * FROM strut_names WHERE name=\''.$str.'\'';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if (!$uy)
		{
	 	 $query = 'SELECT MAX(strut)+1 FROM strut_names';
	 	 $a2 = mysql_query ($query,$i);
	 	 $ui = mysql_fetch_row ($a2);
		 if (!$ui || $ui[0]<1) $ui[0]=1;
		 //echo 'a='.$ui[0];
		 $query = 'INSERT INTO strut_names SET name=\''.$str.'\',strut='.$ui[0];
		 echo $query.'<br>';
		 mysql_query ($query,$i);
		 return $ui[0];
		}
	 else return $uy[2];	 
	}
?>
