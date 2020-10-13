<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>abonet report for day/month</title>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $today=getdate ();
 $cn=3; $tep=$tep1=$gvs=$gvs1=$hvs=$hvs1=$ee=$ee1=$sum1=0;
 if ($_GET["id"]=='') $_GET["id"]=1;
 while ($cn)
       {
	if ($today["mon"]<10)  $today["mon"]='0'.$today["mon"];
	$sum=0; $month=$today["mon"];
	$tim=$today["year"].$today["mon"].'01000000';
	$mon=$today["mon"]+1;
	if ($mon<10) $tim2=$today["year"].'0'.$mon.'01000000';
	else $tim2=$today["year"].$mon.'01000000';

	if ($today[mon]>1) $today[mon]--;
	else { $today[year]--; $today[mon]=12; }

	// HVS
	$query = 'SELECT * FROM dev_2ip';
	$r = mysql_query ($query,$i);
	if ($r) $ur = mysql_fetch_row ($r);
	while ($ur)
		{
		 $data02=$data01=0;
		 $query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=6 AND date<'.$tim.' AND device='.$ur[1].' ORDER BY date DESC LIMIT 1';	
	 	 $e = mysql_query ($query,$i);
	    	 if ($e) $ui = mysql_fetch_row ($e);
	     	 if ($ui) $data01=$ui[5];
		 $query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=6 AND date<'.$tim2.' AND device='.$ur[1].' ORDER BY date DESC LIMIT 1';	
		 $e = mysql_query ($query,$i);
		 if ($e) $ui = mysql_fetch_row ($e);
		 if ($ui)  $data02=$ui[5];
		 $rt1=$data02-$data01;

		 $query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=8 AND date<'.$tim.' AND device='.$ur[1].' ORDER BY date DESC LIMIT 1';	
	 	 $e = mysql_query ($query,$i);
	    	 if ($e) $ui = mysql_fetch_row ($e);
	     	 if ($ui) $data01=$ui[5];
		 $query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=8 AND date<'.$tim2.' AND device='.$ur[1].' ORDER BY date DESC LIMIT 1';
		 $e = mysql_query ($query,$i);
		 if ($e) $ui = mysql_fetch_row ($e);
		 if ($ui)  $data02=$ui[5];
		 $rt2=$data02-$data01;
		 if ($rt1<0) $rt1=0;
		 if ($rt2<0) $rt2=0;
		 // select input HVS
		 $query = 'SELECT * FROM data WHERE type=4 AND date='.$tim.' AND flat='.$ur[6].' AND prm=11 AND source=5';
		 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);		    
                 if ($uy)
		    {
		     $query = 'UPDATE data SET date='.$tim.',value='.$rt1.' WHERE type=4 AND date='.$tim.' AND flat='.$ur[6].' AND prm=11 AND source=5';
		     echo $query.'<br>';
		     $a = mysql_query ($query,$i);		    
		    }
		 else
		    {
		     $query = 'INSERT INTO data(type,date,value,flat,source,prm) VALUES (4,'.$tim.','.$rt1.','.$ur[6].',5,11)';
		     echo $query.'<br>';
		     $a = mysql_query ($query,$i);
		    }

		 $query = 'SELECT * FROM data WHERE type=4 AND date='.$tim.' AND flat='.$ur[6].' AND prm=11 AND source=6';
		 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);		    
                 if ($uy)
		    {
		     $query = 'UPDATE data SET date='.$tim.',value='.$rt2.' WHERE type=4 AND date='.$tim.' AND flat='.$ur[6].' AND prm=11 AND source=6';
		     echo $query.'<br>';
		     $a = mysql_query ($query,$i);		    
		    }
		 else
		    {
		     $query = 'INSERT INTO data(type,date,value,flat,source,prm) VALUES (4,'.$tim.','.$rt2.','.$ur[6].',6,11)';
		     echo $query.'<br>';
		     $a = mysql_query ($query,$i);
		    }
		 $ur = mysql_fetch_row ($r);
		}

	$query = 'SELECT * FROM device WHERE type=4';
	$r = mysql_query ($query,$i);
	if ($r) $ur = mysql_fetch_row ($r);
	while ($ur)
		{
		 $data02=$data01=0;
		 $query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=2 AND date<'.$tim.' AND device='.$ur[1].' ORDER BY date DESC LIMIT 1';	
	 	 $e = mysql_query ($query,$i);
	    	 if ($e) $ui = mysql_fetch_row ($e);
	     	 if ($ui) $data01=$ui[5];
		 $query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=2 AND date<'.$tim2.' AND device='.$ur[1].' ORDER BY date DESC LIMIT 1';
		 $e = mysql_query ($query,$i);
		 if ($e) $ui = mysql_fetch_row ($e);
		 if ($ui)  $data02=$ui[5];
		 $rt2=$data02-$data01;
		 if ($rt2<0) $rt2=0;
		 // select input HVS
		 $query = 'SELECT * FROM data WHERE type=4 AND date='.$tim.' AND flat='.$ur[10].' AND prm=2 AND source=0';
		 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);		    
                 if ($uy)
		    {
		     $query = 'UPDATE data SET date='.$tim.',value='.$rt2.' WHERE type=4 AND date='.$tim.' AND flat='.$ur[10].' AND prm=2 AND source=0';
		     echo $query.'<br>';
		     $a = mysql_query ($query,$i);		    
		    }
		 else
		    {
		     $query = 'INSERT INTO data(type,date,value,flat,source,prm) VALUES (4,'.$tim.','.$rt2.','.$ur[10].',0,2)';
		     echo $query.'<br>';
		     $a = mysql_query ($query,$i);
		    }
       		 $ur = mysql_fetch_row ($r);
		}
	 $cn--;
	}	
 ?>

</td></tr>
</table>
</body>
</html>
