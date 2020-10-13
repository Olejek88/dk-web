<td id="lcol">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr><td colspan="2" valign="top" width="278"><img src="files/infos.gif" height="30" width="278"></td></tr>
	<tr class="nav"><td><div class="anounce">
	<?php
	 include("config/local.php");
	 $arr = get_defined_vars();
	 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	 $query = 'SELECT COUNT(id) FROM dev_irp';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a); $irp=$uy[0];
	 $query = 'SELECT MAX(lastdate) FROM device';
	 $a = mysql_query ($query,$i);
	 $ur = mysql_fetch_row ($a);
	 $query = 'SELECT SUM(rnum),SUM(square),COUNT(id) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);

	
	 if ($_GET["obj"]=='1') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=1"><img src="files/1p7.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='2') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=2"><img src="files/v53.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='3') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=3"><img src="files/gt59.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='4') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=4"><img src="files/ro2a.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='5') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=5"><img src="files/ch54.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='6') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=6"><img src="files/myt14.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='7') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=7"><img src="files/nd.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='8') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=8"><img src="files/55gt9.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='9') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=9"><img src="files/sm22.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='10') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=10"><img src="files/mirk1.jpeg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='11') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=11"><img src="files/mytk22.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='12') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=12"><img src="files/mytk23.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='13') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=13"><img src="files/sm22.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='14') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=14"><img src="files/mirk1.jpeg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='15') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=15"><img src="files/rm22.png" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';
 	 if ($_GET["obj"]=='16') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=16"><img src="files/rm24.png" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';

 	 if ($_GET["obj"]=='50') print '<div class="photobox"><table><tbody><tr><td><a href="index.php?obj=50"><img src="files/nd.jpg" align="center" style="border:2px solid #CCC;" width="250"></a></td></tr></tbody></table></div>';

	 print '<div class="separator"></div></div></td></tr><tr><td style="padding-left:10px"><p>';

	 if ($_GET["obj"]=='1') print '<font class="har">Код объекта <a href="index.php?obj=1">1pa[1]</a><br>';
	 if ($_GET["obj"]=='2') print '<font class="har">Код объекта <a href="index.php?obj=2">v53[2]</a><br>';
	 if ($_GET["obj"]=='3') print '<font class="har">Код объекта <a href="index.php?obj=3">gt59[3]</a><br>';
	 if ($_GET["obj"]=='4') print '<font class="har">Код объекта <a href="index.php?obj=4">ro2a[4]</a><br>';
	 if ($_GET["obj"]=='5') print '<font class="har">Код объекта <a href="index.php?obj=5">ch54[5]</a><br>';
	 if ($_GET["obj"]=='6') print '<font class="har">Код объекта <a href="index.php?obj=6">mt14[6]</a><br>';
	 if ($_GET["obj"]=='7') print '<font class="har">Код объекта <a href="index.php?obj=7">riga1[7]</a><br>';
	 if ($_GET["obj"]=='8') print '<font class="har">Код объекта <a href="index.php?obj=8">gt9[8]</a><br>';
	 if ($_GET["obj"]=='9') print '<font class="har">Код объекта <a href="index.php?obj=9">sm22[9]</a><br>';
	 if ($_GET["obj"]=='10') print '<font class="har">Код объекта <a href="index.php?obj=10">mirk1[10]</a><br>';
	 if ($_GET["obj"]=='11') print '<font class="har">Код объекта <a href="index.php?obj=11">mytk22[11]</a><br>';
	 if ($_GET["obj"]=='12') print '<font class="har">Код объекта <a href="index.php?obj=12">mytk23[12]</a><br>';
	 if ($_GET["obj"]=='13') print '<font class="har">Код объекта <a href="index.php?obj=13">sm17[13]</a><br>';
	 if ($_GET["obj"]=='14') print '<font class="har">Код объекта <a href="index.php?obj=14">mirk2[14]</a><br>';
	 if ($_GET["obj"]=='15') print '<font class="har">Код объекта <a href="index.php?obj=15">rm22[15]</a><br>';
	 if ($_GET["obj"]=='16') print '<font class="har">Код объекта <a href="index.php?obj=16">rm24[16]</a><br>';

	 if ($_GET["obj"]=='50') print '<font class="har">Код объекта <a href="index.php?obj=50">mal[50]</a><br>';

    	 $query = 'SELECT * FROM build WHERE id='.$_GET["obj"];
       	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e);

	 print '<strong>Характеристика объекта:</strong><br> панельный жилой дом по адресу '.$ui[1].'<br>';
	 print '<strong> Количество этажей:</strong> '.$ui[6].'<br>';
	 print '<strong> Количество жителей:</strong> '.$uy[0].' человек<br>';
	 print '<strong> Общая жилая площадь:</strong> '.number_format($uy[1],2).' м2<br>';
	 print '<strong> Квартиры / Подъезды:</strong> '.$ui[3].'/'.$ui[4].'<br>';
	 print '<strong> Количество стояков:</strong> '.$irp.'<br>';
	 print '<strong> Дата актуализации данных:</strong> '.$ur[0].'<br>';	  
	?>

	</font></p>
	<tr class="nav"><td>
	<div class="separator"></div>
	</td></tr>
	</tbody></table>
</td>
