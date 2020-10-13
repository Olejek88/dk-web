<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = 'SELECT * FROM field WHERE type=1';
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     $query = 'SELECT strut_number FROM dev_bit WHERE device='.$ui[4].' OR device='.$ui[5];
     $r = mysql_query ($query,$i);
     if ($r) $uo = mysql_fetch_row ($r); 
     $query = 'UPDATE field SET strut=\''.$uo[0].'\' WHERE id='.$ui[0];
     echo $query.'<br>';
     //$r = mysql_query ($query,$i);  
     $ui = mysql_fetch_row ($e);
    }
?>
</td></tr>
</table>
</body>
</html>
