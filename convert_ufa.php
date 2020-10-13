<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
 include("config/local4.php");
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
 $i2 = mysql_connect ($mysql_host2,$mysql_user2,$mysql_password2); $e2=mysql_select_db ($mysql_db_name2);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i2);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i2);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i2);
?>

<html><head>
<title>Get data from Ufaley</title>
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
 $date_last_day="";
 $date_last="";
 $query = 'SELECT * FROM hours WHERE type=1 ORDER BY date DESC LIMIT 1';
 echo $query.'<br>';
 if ($a = mysql_query ($query,$i))
 if ($uy = mysql_fetch_row ($a)) 
    $date_last=$uy[4];

 $query = 'SELECT * FROM prdata WHERE type=2 ORDER BY date DESC LIMIT 1';
 echo $query.'<br>';
 if ($a = mysql_query ($query,$i))
 if ($uy = mysql_fetch_row ($a)) 
 $date_last_day=$uy[2];

 $date=sprintf ("%s%s%s%s%s%s%s%s000000",$date_last[0],$date_last[1],$date_last[2],$date_last[3],$date_last[5],$date_last[6],$date_last[8],$date_last[9]);
 $date2=sprintf ("%s%s%s%s%s%s%s%s000000",$date_last_day[0],$date_last_day[1],$date_last_day[2],$date_last_day[3],$date_last_day[5],$date_last_day[6],$date_last_day[8],$date_last_day[9]);
 echo $date.' '.$date2.'<br>';
 
 $query = 'SELECT * FROM hours WHERE type=1';
 echo $query.'<br>';
 if ($a = mysql_query ($query,$i2))
 while ($uy = mysql_fetch_row ($a)) 
    {
     $query = 'SELECT * FROM hours WHERE date="'.$uy[4].'"  AND type="'.$uy[3].'" AND channel="'.$uy[8].'"';
     //echo $query.'<br>';
     if ($a2 = mysql_query ($query,$i))
     if (!($uy2 = mysql_fetch_row ($a2))) 
        {
         $query = 'INSERT INTO hours SET device="'.$uy[1].'",prm="'.$uy[2].'",type="'.$uy[3].'",date="'.$uy[4].'",value="'.$uy[5].'",status="'.$uy[6].'",pipe="'.$uy[7].'",channel="'.$uy[8].'"';
	 echo $query.'<br>';
	 mysql_query ($query,$i);
	}
    }

 $query = 'SELECT * FROM prdata WHERE date>='.$date2;
 echo $query.'<br>';
 if ($a = mysql_query ($query,$i2))
 while ($uy = mysql_fetch_row ($a)) 
    {
     $query = 'SELECT * FROM prdata WHERE date="'.$uy[4].'"  AND type="'.$uy[3].'" AND channel="'.$uy[8].'"';
     if ($a2 = mysql_query ($query,$i))
     if (!($uy2 = mysql_fetch_row ($a2))) 
        {
         $query = 'INSERT INTO prdata SET device="'.$uy[1].'",prm="'.$uy[2].'",type="'.$uy[3].'",date="'.$uy[4].'",value="'.$uy[5].'",status="'.$uy[6].'",pipe="'.$uy[7].'",channel="'.$uy[8].'"';
         echo $query.'<br>';
	 mysql_query ($query,$i);
	}
    }
    
?>
</body>
</html>