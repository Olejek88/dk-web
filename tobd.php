<?php include("config/local.php"); ?> 
<?php
$today = getdate(); 
//-------------------------------------------------------------------
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
phpinfo();
if ($_POST["frm"]=='1')
{
 $nnn='h1'; $nn=1;
 while ($_POST[$nnn]!='')
	{
	 $nnn='h'.$nn; $mmm='g'.$nn;
	 $query = 'UPDATE dev_2ip SET hvs=\''.$_POST[$nnn].'\',gvs=\''.$_POST[$mmm].'\' WHERE flat_number='.$nn;
	 echo $query.'<br>';
	 $e = mysql_query ($query,$i);
	 $nn++;
	}
// if ($e==0)    {     $err++;  $arr[5] = 1;    }
 print '<script> window.location.href="lk51.php?obj=1" </script>';
}
//---------------------------------------------------------------------------------------------------------------------------------
if ($_POST["frm"]=='2')
{
 $query = 'UPDATE device SET lastdate=lastdate,devtim=devtim,gvs=\''.$_POST["gvs"].'\',hvs=\''.$_POST["hvs"].'\' WHERE type=11';
 $e = mysql_query ($query,$i);
 if ($e==0)    {     $err++;  $arr[5] = 1;    }
 print '<script> window.location.href="lk51.php?obj=1" </script>';
}
//-------------------------------------------------------------------
if ($err>0)
	{
	 for ($p=0; $p<100; $p++)
  		if ($arr[$p]==1) { $error = $error . $errr[$p]; }
	print $shapka_err;
	print $error;
	print $konec_err;
	print '<font style="font:8pt/11pt verdana; color:black">Всего ошибок:';
	print $err;
	print '</font>';
	print $konec2_err;
	}
?>