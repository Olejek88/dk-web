<table cellpadding="0" cellspacing="1" border="0" style="width:1050px" align=left>
<tr>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=1"><img src="files/1p7.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<p><font class="har">Код объекта <a href="index.php?obj=1">1pa[1]</a><br>
	<strong>Характеристика объекта:</strong><br>
	панельный жилой дом по адресу ул. 1-й Пятилетки, 7<br>
	<strong> Количество этажей:</strong> 9<br>
	<strong> Количество жителей:</strong> 303 человека<br>
	<strong> Общая жилая площадь:</strong> 4720 м2<br>
	<strong> Квартиры / Подъезды:</strong> 141/2<br>
	<strong> Количество стояков:</strong> 42<br>
	<?php
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 print '<strong> Дата актуализации данных:</strong> '.$uy[0].'<br>';	  
	?>
        </td></tr>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=2"><img src="files/v53.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=2;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=2">v53[2]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Ворошилова,53<br>
	        <strong> Количество этажей:</strong> 9<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> '.$uy[1].' м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 208/4<br>
		<strong> Количество стояков:</strong> 76<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	  
	?>
        </td></tr>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=3"><img src="files/gt59.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=3;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=3">gt59[3]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Героев Танкограда,59<br>
	        <strong> Количество этажей:</strong> 9<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> '.$uy[1].' м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 231/4<br>
		<strong> Количество стояков:</strong> 96<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	
	?>
	</font></td></tr>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=4"><img src="files/ro2a.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=4;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=4">ro2[4]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу ул. Фабричная, 2а<br>
	        <strong> Количество этажей:</strong> 10<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> '.$uy[1].' м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 35/1<br>
		<strong> Количество стояков:</strong> 13<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	
	?>
	</font></p>
	</tbody></table>
</td>
</tr>
<tr>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=5"><img src="files/ch54.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=5;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=5">ch54[5]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу ул. Эльтонская,59<br>
	        <strong> Количество этажей:</strong> 10<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> '.$uy[1].' м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 36/1<br>
		<strong> Количество стояков:</strong> 13<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	  
	?>
	</font></p>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=6"><img src="files/myt14.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=6;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=6">mt14[6]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу г.Мытищи,мкр14-кор16<br>
	        <strong> Количество этажей:</strong> 22<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> '.$uy[1].' м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 496/6<br>
		<strong> Количество стояков:</strong> 72<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	
	?>
	</font></p>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=7"><img src="files/nd.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=7;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=7">rg1[7]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Рига<br>
	        <strong> Количество этажей:</strong> 10<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> '.$uy[1].' м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 35/1<br>
		<strong> Количество стояков:</strong> 12<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	
	?>
	</font></p>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=8"><img src="files/55gt9.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=8;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=8">gt9[8]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Габдуллы Туккая, 9<br>
	        <strong> Количество этажей:</strong> 10<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> '.$uy[1].' м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 60/1<br>
		<strong> Количество стояков:</strong> 10<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	
	?>
	</font></p>
	</tbody></table>
</td>
</tr>
<tr>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=9"><img src="files/est23.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=9;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=9">est23[9]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Челябинск, Электростальская, 23<br>
	        <strong> Количество этажей:</strong> 10<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> '.$uy[1].' м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 140/2<br>
		<strong> Количество стояков:</strong> 45<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	
	?>
	</font></p>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=10"><img src="files/mirk1.jpeg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=10;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=10">mirk1[10]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Москва, Мироновская, 1<br>
	        <strong> Количество этажей:</strong> 20/17<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> 9562 м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 140/2<br>
		<strong> Количество стояков:</strong> 45<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	
	?>
	</font></p>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=11"><img src="files/mytk22.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=11;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=11">myt22[11]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Московская обл., Мытищи, мкр. 16, корп. 22.<br>
	        <strong> Количество этажей:</strong> 25<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> 9999 м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 484/6<br>
		<strong> Количество стояков:</strong> 135<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	
	?>
	</font></p>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=12"><img src="files/mytk23.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=12;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=12">myt23[12]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Московская обл., Мытищи, мкр. 16, корп. 23.<br>
	        <strong> Количество этажей:</strong> 25<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> 10221 м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 520/6<br>
		<strong> Количество стояков:</strong> 154<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	
	?>
	</font></p>
	</tbody></table>
</td>
</tr>
<tr>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=13"><img src="files/sm22.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=13;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=13">sm17[13]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Челябинск, Электростальская, 17<br>
	        <strong> Количество этажей:</strong> 10<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> 4562 м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 135/4<br>
		<strong> Количество стояков:</strong> 45<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';
	?>
	</font></p>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=14"><img src="files/mirk1.jpeg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=14;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=14">mirk2[14]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Москва, Мироновская,2.<br>
	        <strong> Количество этажей:</strong> 24<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> 9999 м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 341/4<br>
		<strong> Количество стояков:</strong> 110<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';
	?>
	</font></p>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=15"><img src="files/rm22.png" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=15;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=15">rm22[15]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Когалым, Романтиков,22.<br>
	        <strong> Количество этажей:</strong> 3<br>';
	 print '<strong> Количество жителей:</strong>'.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> 1768.5 м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 33/3<br>
		<strong> Количество стояков:</strong> 24<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';
	?>
	</font></p>
	</tbody></table>
</td>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=16"><img src="files/rm24.png" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=16;
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?obj=16">rm24[16]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'панельный жилой дом по адресу Когалым, Романтиков,24.<br>
	        <strong> Количество этажей:</strong> 3<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>
		<strong> Общая жилая площадь:</strong> 1858.5 м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> 33/3<br>
		<strong> Количество стояков:</strong> 25<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';
	?>
	</font></p>
	</tbody></table>
</td>
</tr>
<tr>
<td id="ccol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="nav"><td><div class="anounce">
	<div class="photobox"><table><tbody><tr><td><a href="index.php?sel=main3"><img src="files/ufa_kot.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>
	</div>
	</td></tr>
	<tr><td style="padding-left:10px">
	<?php
	 $_GET["obj"]=51;
	 include("config/local4.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT MAX(date) FROM hours';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);

	 print '<p><font class="har">Код объекта <a href="index.php?sel=main3">ufa[51]</a><br>
		<strong>Характеристика объекта:</strong><br>';
	 print 'котельная по адресу Верхний Уфалей, Спартак<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';
	?>
	</font></p>
	</tbody></table>
</td>
</tr>
</table>