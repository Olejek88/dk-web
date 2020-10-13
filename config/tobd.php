<?php include("config/local.php"); ?>
<?php
$shapka_err = '<html><head><style>
	 a:link  {font:8pt/11pt verdana; color:red}
	 a:visited {font:8pt/11pt verdana; color:#4e4e4e}
	 </style><meta HTTP-EQUIV="Content-Type" Content="text-html; charset=koi8r">
	 <title>Error!</title></head>
	 <body bgcolor="white" onload="initPage()">
	 <table width="400" cellpadding="3" cellspacing="5"><tr><td valign="top" align="left">
	 <img id="pagerrorImg" SRC="files/pagerror.gif" width="25" height="33"></td>
	 <td id="tableProps2" align="left" valign="middle" width="360"><h1 id="textSection1" style="COLOR: black; FONT: 13pt/15pt verdana">
	 <span id="errorText">Error in form.</span></h1>
	 </td></tr><tr><td id="tablePropsWidth" width="400" colspan="2"><font style="COLOR: black; FONT: 8pt/11pt verdana">
	 </font></td></tr><tr>
	 <td id="tablePropsWidth" width="400" colspan="2"><font style="COLOR: black; FONT: 8pt/11pt verdana"><hr color="#C0C0C0" noshade><p>Информация об ошибке:</p>';
	 $konec_err = '<li>оБЦНЙФЕ <a href="javascript:history.back(1)"><img valign=bottom border=0 src="files/back.gif"> Back</a> ДМС ТЕДБЛФЙТПЧБОЙС ОЕФПЮОПУФЙ.</li>
    	 </ul><p><br></p><h2 style="font:8pt/11pt verdana; color:black">оЕЧПЪНПЦОП ПУХЭЕУФЧЙФШ ДПВБЧМЕОЙЕ/ПВОПЧМЕОЙЕ ДБООЩИ</h2></font>';
$konec2_err = '</td></tr></table></body></html>'; $error=""; $err = 0;
$direct = "pikt/";
$name_form = $HTTP_POST_VARS [frm];
//-------------------------------------------------------------------------
$errr[0] = "<li>[0] Не заполнено поле названия. </li>";
$errr[1] = "<li>[1] Не указан идентификатор. </li>";
$errr[2] = "<li>[2] Не заполнено поле заголовка.</li>";
$errr[3] = "<li>[3] Не указан один или несколько параметров. </li>";
$errr[4] = "<li>[4] Не указана цена. </li>";
$errr[5] = "<li>[5] Ошибка запроса БД.</li>";
$errr[6] = "<li>[6] Не заполнено поле текста. </li>";
//-------------------------------------------------------------------------
$today = getdate(); $month = $today[month]; $mday = $today[mday]; $year = $today[year];
$minutes = $today[minutes]; $hours = $today[hours];
if ($minutes<10) $minutes = "0" . $minutes;
//-------------------------------------------------------------------
if ($_POST["frm"]=='1')
{
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
if ($err==0)
{
$id=$_POST["ID"]+$_POST["type"]*0x10000+$_POST["manf"]*0x1000000;
$query = 'INSERT INTO device(idd,SV,interface,protocol,port,speed,adr,type,flat,chng,name) 
VALUES ('.'\''.$id.'\',\''.$_POST["SV"].'\',\''.$_POST["interface"].'\',\''.$_POST["protocol"].'\',\''.$_POST["port"].'\',\''.$_POST["speed"].'\',\''.$_POST["adr"].'\',\''.$_POST["type"].'\',\''.$_POST["flat"].'\',\'1\',\''.$_POST["name"].'\')';
echo $query;
$e = mysql_query ($query,$i);
if ($_POST["type"]==1)
    {
     $query = 'INSERT INTO dev_bit(device,rf_int_interval,ids_lk,ids_module,meas_interval,integ_meas_cnt,pi,flat_number,strut_number,low_error_temp,high_error_temp,low_warn_temp,high_warn_temp,imitate_tem,pa_table) 
     VALUES ('.'\''.$id.'\',\''.$_POST["rf_int_interval"].'\',\''.$_POST["adr"].'\',\''.$_POST["ids_module"].'\',\''.$_POST["meas_inteval"].'\',\''.$_POST["integ_meas_cnt"].'\',\''.$_POST["pi"].'\',\''.$_POST["flat"].'\',\''.$_POST["strut_number"].'\',\''.$_POST["low_error_temp"].'\',\''.$_POST["low_error_temp"].'\',\''.$_POST["high_error_temp"].'\',\''.$_POST["low_warn_temp"].'\',\''.$_POST["high_warn_temp"].'\',\''.$_POST["imitate_tem"].'\',\''.$_POST["pa_table"].'\')';
     echo $query;
     $e = mysql_query ($query,$i);     
    }

if ($e==0)    {     $err++;  $arr[5] = 1;    }
}
//if ($err==0)    print '<script> window.close(); </script>';
}
//-------------------------------------------------------------------
if ($_POST["frm"]=='2')
{
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
if ($err==0)
    {
     $query = 'INSERT INTO edizm(name,knt) VALUES (\''.$_POST["name"].'\',\''.$_POST["knt"].'\')';
     echo $query;
     //$e = mysql_query ($query,$i);
     if ($e==0)    {     $err++;  $arr[5] = 1;    }
    }
//if ($err==0)    print '<script> window.close(); </script>';
}
//-------------------------------------------------------------------
if ($_POST["frm"]=='6')
{
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
if ($err==0)
    {
     $query = 'INSERT INTO var(dt,descr) VALUES (\''.$_POST["dt"].'\',\''.$_POST["descr"].'\')';
     echo $query;
     //$e = mysql_query ($query,$i);
     if ($e==0)    {     $err++;  $arr[5] = 1;    }
    }
//if ($err==0)    print '<script> window.close(); </script>';
}
//-------------------------------------------------------------------
if ($_POST["frm"]=='7')
{
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
if ($err==0)
    {
     $query = 'INSERT INTO flats(flat,level,rooms,nstrut,name) VALUES (\''.$_POST["flat"].'\',\''.$_POST["level"].'\',\''.$_POST["rooms"].'\',\''.$_POST["nstrut"].'\',\''.$_POST["name"].'\')';
     echo $query;
     //$e = mysql_query ($query,$i);
     if ($e==0)    {     $err++;  $arr[5] = 1;    }
    }
//if ($err==0)    print '<script> window.close(); </script>';
}
//-------------------------------------------------------------------
if ($_POST["frm"]=='8')
{
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
if ($err==0)
    {
     $num_lk=1;
     $num_mee=1;
     $num_2ip=1;
     $num_bit=1;
     $num_irp=1;
     
     for ($lv=1;$lv<=$_POST["levels"];$lv++)
        {
         // LK
         $idd=$num_lk+6*0x10000+1*0x1000000;
         $query = 'INSERT INTO device(idd,interface,protocol,port,speed,adr,type,flat,source,name) 
         VALUES ('.$idd.',2,1,1,57600,'.$num_lk.',6,8,123,\'local concentrator (ent=1,lev='.$lv.')\')';
         echo $query.'<br>';
	 $e = mysql_query ($query,$i);
         $query = 'INSERT INTO dev_lk(device,adr,level,flats) VALUES ('.$idd.','.$lv.','.$lv.','.$_POST["flats"].')';
         echo $query.'<br>';	     
	 //$e = mysql_query ($query,$i);	 	     	 
         $num_lk++;

	 for ($fl=1;$fl<=$_POST["flats"];$fl++)
	    {
	     $flt=$fl+($lv-1)*$_POST["flats"];
	    
	     $idd=$num_mee+4*0x10000+3*0x1000000;
	     $adr=1+($num_mee-1)%8;
	     $query = 'INSERT INTO device(idd,interface,protocol,port,speed,adr,type,flat,source,name) 
	     VALUES ('.$idd.',2,1,0,19200,'.$adr.',4,'.$flt.',4,\'MEE (flat='.$flt.')\')';
    	     echo $query.'<br>';
    	     $e = mysql_query ($query,$i);	 	     	 
	     $query = 'INSERT INTO dev_mee(device,adr) VALUES ('.$idd.','.$adr.')';
    	     echo $query.'<br>';	     	     
	     //$e = mysql_query ($query,$i);	 	     	 
	     $num_mee++;
	     $idd=$num_2ip+2*0x10000+1*0x1000000;
	     $adr=20+$num_2ip%8;
	     $query = 'INSERT INTO device(idd,interface,protocol,port,speed,adr,type,flat,source,name) 
	     VALUES ('.$idd.',3,2,0,0,'.$adr.',2,'.$flt.',23,\'2IP (flat='.$flt.')\')';
    	     echo $query.'<br>';
	     $e = mysql_query ($query,$i);	 	     	 

	     $query = 'INSERT INTO dev_2ip(device,ids_lk,ids_module,flat_number) VALUES ('.$idd.','.$lv.','.$adr.','.$flt.')';
    	     echo $query.'<br>';
	     //$e = mysql_query ($query,$i);	 	     	 
	     
	     $num_2ip++;	     
	    }
         for ($st=1;$st<=$_POST["struts"];$st++)
	    {
	     $idd=$num_bit+1*0x10000+1*0x1000000;
	     $adr=$num_bit%20;
	     if ($st<5) $fl=1+($lv-1)*$_POST["flats"];
	     if ($st>16) $fl=8+($lv-1)*$_POST["flats"];
	     if ($st>4 && $st<17) $fl=2+floor(($st-5)/2)+($lv-1)*$_POST["flats"];
	     $query = 'INSERT INTO device(idd,interface,protocol,port,speed,adr,type,flat,source,name) 
	     VALUES ('.$idd.',3,2,0,0,'.$st.',1,'.$fl.',1,\'BIT (flat='.$fl.',str='.$st.')\')';
    	     echo $query.'<br>';
	     $e = mysql_query ($query,$i);	 	     	 

	     $query = 'INSERT INTO dev_bit(device,ids_lk,ids_module,flat_number,strut_number) 
	     VALUES ('.$idd.','.$lv.','.$st.','.$fl.','.$st.')';
    	     echo $query.'<br>';
	     $e = mysql_query ($query,$i);	 	     	 

	     $num_bit++;
	    }
	}

     for ($st=1;$st<=$_POST["struts"];$st++)
        {
         $idd=$num_irp+5*0x10000+2*0x1000000;
         $query = 'INSERT INTO device(idd,interface,protocol,port,speed,adr,type,flat,source,name) 
         VALUES ('.$idd.',2,2,2,9600,'.$st.',5,'.$st.',12,\'IRP (str='.$st.')\')';
         echo $query.'<br>';
         $e = mysql_query ($query,$i);	 	     	 

         $query = 'INSERT INTO dev_irp(device,adr,strut) VALUES ('.$idd.','.$st.','.$st.')';
	 echo $query.'<br>';
         //$e = mysql_query ($query,$i);	 	     	 

	 $num_irp++;
	}
	
     if ($e==0)    {     $err++;  $arr[5] = 1;    }
    }
//if ($err==0)    print '<script> window.close(); </script>';
}
//-------------------------------------------------------------------
if ($_POST["frm"]=='11')
{
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
if ($err==0)
{
$id=$_POST["ID"]; //+$_POST["type"]*0x10000+$_POST["manf"]*0x1000000;
$query = 'UPDATE device SET idd=\''.$id.'\',SV=\''.$_POST["SV"].'\',
	  interface=\''.$_POST["interface"].'\',protocol=\''.$_POST["protocol"].'\',
	  port=\''.$_POST["port"].'\',speed=\''.$_POST["speed"].'\',
	  adr=\''.$_POST["adr"].'\',type=\''.$_POST["type"].'\',
	  flat=\''.$_POST["flat"].'\',chng=1,name=\''.$_POST["name"].'\' WHERE id='.$_POST["id"];
echo $query;
if ($_POST["type"]==1)
    {
     $query = 'UPDATE dev_bit SET device=\''.$id.'\',rf_int_interval=\''.$_POST["rf_int_interval"].'\',
     ids_lk=\''.$_POST["adr"].'\',ids_module=\''.$_POST["ids_module"].'\',
     meas_interval=\''.$_POST["meas_inteval"].'\',integ_meas_cnt=\''.$_POST["integ_meas_cnt"].'\',
     pi=\''.$_POST["pi"].'\',flat_number=\''.$_POST["flat"].'\',
     strut_number=\''.$_POST["strut_number"].'\',low_error_temp=\''.$_POST["low_error_temp"].'\',
     high_error_temp=\''.$_POST["high_error_temp"].'\',low_warn_temp=\''.$_POST["low_warn_temp"].'\',
     high_warn_temp=\''.$_POST["high_warn_temp"].'\',imitate_tem=\''.$_POST["imitate_tem"].'\',pa_table=\''.$_POST["pa_table"].'\' WHERE id='.$_POST["id2"];
     echo $query;
     $e = mysql_query ($query,$i);     
    }
$e = mysql_query ($query,$i);
if ($e==0)    {     $err++;  $arr[5] = 1;    }
}
if ($err==0)    print '<script> window.close(); </script>';
}
//-------------------------------------------------------------------
if ($_POST["frm"]=='12')
{
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
if ($err==0)
    {
     $query = 'UPDATE edizm SET name=\''.$_POST["name"].'\',knt=\''.$_POST["knt"].'\' WHERE id='.$_POST["id"];
     echo $query;
     //$e = mysql_query ($query,$i);
     if ($e==0)    {     $err++;  $arr[5] = 1;    }
    }
//if ($err==0)    print '<script> window.close(); </script>';
}
//-------------------------------------------------------------------
if ($_POST["frm"]=='16')
{
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
if ($err==0)
    {
     $query = 'UPDATE var SET dt=\''.$_POST["dt"].'\',descr=\''.$_POST["descr"].'\'';
     echo $query;
     //$e = mysql_query ($query,$i);
     if ($e==0)    {     $err++;  $arr[5] = 1;    }
    }
//if ($err==0)    print '<script> window.close(); </script>';
}
//-------------------------------------------------------------------
if ($_POST["frm"]=='17')
{
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
if ($err==0)
    {
     $query = 'UPDATE flats SET flat=\''.$_POST["flat"].'\',level=\''.$_POST["level"].'\',
     rooms=\''.$_POST["rooms"].'\',nstrut=\''.$_POST["nstrut"].'\',name=\''.$_POST["name"].'\' WHERE id='.$_POST["id"];
     echo $query;
     //$e = mysql_query ($query,$i);
     if ($e==0)    {     $err++;  $arr[5] = 1;    }
    }
//if ($err==0)    print '<script> window.close(); </script>';
}
//-------------------------------------------------------------------
if ($err>0)
	{
	if ($arr[0]==1)	{ $error = $error . $errr[0]; }
	if ($arr[1]==1)	{ $error = $error . $errr[1]; }
	if ($arr[2]==1)	{ $error = $error . $errr[2]; }
	if ($arr[3]==1)	{ $error = $error . $errr[3]; }
	if ($arr[4]==1)	{ $error = $error . $errr[4]; }
	if ($arr[5]==1)	{ $error = $error . $errr[5]; }
	if ($arr[6]==1)	{ $error = $error . $errr[6]; }
	print $shapka_err;
	print $error;
	print $konec_err;
	print '<font style="font:8pt/11pt verdana; color:black">чУЕЗП ПЫЙВПЛ:';
	print $err;
	print '</font>';
	print $konec2_err;
	}
?>