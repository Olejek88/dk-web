 print '<form name="reda" method=post action="tobd.php">';
 print '<tr><td><font class="main">хУФТПКУФЧБ УЙУФЕНЩ</td><td><select class=log id="iddev" name="iddev" style="height:18">';
 for ($z=1;$z<=120;$z++)
     {
      $query = 'SELECT * FROM devices';
      $e = mysql_query ($query,$i); 
      $ui = mysql_fetch_row ($e);
      if ($ui == true)
         {
          print '<option value="'; print $z; print '">'; print $ui[5];
         }
     }
 if ($_GET["sd"]!='')
    {
      $query = 'SELECT * FROM devices WHERE id='.$_GET["sd"];
      $e = mysql_query ($query,$i); 
      $ui = mysql_fetch_row ($e);
      if ($ui == true)
         {
	  print '<tr><td><font class="down">Название устройства </font></td><td><input name="name" size=10 class=log style="height:18px" value="'.$ui[5].'"></td><td></td></tr>';
	  print '<tr><td><font class="main">Тип устройства</font></td><td><select class=log name="type" style="height:18">';
	  print '<option value="0" '; if ($ui[1]==0) print 'selected'; print '>Встроенные платы';
	  print '<option value="1" '; if ($ui[1]==1) print 'selected'; print '>Каскад-Э';
	  print '<option value="2" '; if ($ui[1]==2) print 'selected'; print '>Hart-модем';
	  print '<option value="3" '; if ($ui[1]==3) print 'selected'; print '>Логика';
	  print '<option value="4" '; if ($ui[1]==4) print 'selected'; print '>Q.Sonic';
	  print '<option value="5" '; if ($ui[1]==5) print 'selected'; print '>ADAM-4017';
	  print '<option value="6" '; if ($ui[1]==6) print 'selected'; print '>ADAM-4015';
	  print '<option value="7" '; if ($ui[1]==7) print 'selected'; print '>DK-8072';
	  print '<option value="8" '; if ($ui[1]==8) print 'selected'; print '>Posiflex-7000';
	  print '<option value="9" '; if ($ui[1]==9) print 'selected'; print '>GSM-модем';
	  print '</select></td></tr>';
	  print '<tr><td><font class="down">Адрес </font></td><td><input name="device" size=10 class=log style="height:18px" value="'.$ui[6].'"></td><td></td></tr>';
	  print '<tr><td><font class="main">Скорость</font></td><td><select class=log name="speed" style="height:18">';
	  print '<option value="300" '; if ($ui[3]==300) print 'selected'; print '>300';
	  print '<option value="600" '; if ($ui[3]==600) print 'selected'; print '>600';
	  print '<option value="1200" '; if ($ui[3]==1200) print 'selected'; print '>1200';
	  print '<option value="2400" '; if ($ui[3]==2400) print 'selected'; print '>2400';
	  print '<option value="4800" '; if ($ui[3]==4800) print 'selected'; print '>4800';
	  print '<option value="9600" '; if ($ui[3]==9600) print 'selected'; print '>9600';
	  print '<option value="19200" '; if ($ui[3]==19200) print 'selected'; print '>19200';
	  print '<option value="38400" '; if ($ui[3]==38400) print 'selected'; print '>38400';
	  print '<option value="57600" '; if ($ui[3]==57600) print 'selected'; print '>57600';
	  print '<option value="115200" '; if ($ui[3]==115200) print 'selected'; print '>115200';
	  print '</select></td></tr>';
	  print '<tr><td><font class="main">Порт</font></td><td><select class=log name="com" style="height:18">';
	  print '<option value="1" '; if ($ui[2]==1) print 'selected'; print '>com1';
	  print '<option value="2" '; if ($ui[2]==2) print 'selected'; print '>com2';
	  print '<option value="3" '; if ($ui[2]==3) print 'selected'; print '>com3';
	  print '<option value="4" '; if ($ui[2]==4) print 'selected'; print '>com4';
	  print '<option value="5" '; if ($ui[2]==5) print 'selected'; print '>com5';
	  print '<option value="6" '; if ($ui[2]==6) print 'selected'; print '>com6';
	  print '<option value="7" '; if ($ui[2]==7) print 'selected'; print '>com7';
	  print '<option value="8" '; if ($ui[2]==8) print 'selected'; print '>com8';
	  print '<option value="9" '; if ($ui[2]==9) print 'selected'; print '>com9';
	  print '<option value="10" '; if ($ui[2]==10) print 'selected'; print '>com10';
	  print '</select></td></tr>';
	  print '<tr><td align=right><font class="dd">изменить</font></td><td><input alt="сохранить изменения" border=0 align=left src="files/forward.gif" type=image></td><td><input name="frm" size=1 style="height:1;width:1;visibility:hidden" value="ch"><input name="id" size=1 style="height:1;width:1;visibility:hidden" value="'.$ui[0].'"></td></tr></form>';
	}
    }
 print '<tr><td colspan=3><br></td></tr>';  
	  print '<tr><td><font class="down">Название устройства </font></td><td><input name="name" size=10 class=log style="height:18px"></td><td></td></tr>';
	  print '<tr><td><font class="main">Тип устройства</font></td><td><select class=log name="type" style="height:18">';
	  print '<option value="0">Встроенные платы';
	  print '<option value="1">Каскад-Э';
	  print '<option value="2">Hart-модем';
	  print '<option value="3">Логика';
	  print '<option value="4">Q.Sonic';
	  print '<option value="5">ADAM-4017';
	  print '<option value="6">ADAM-4015';
	  print '<option value="7">DK-8072';
	  print '<option value="8">Posiflex-7000';
	  print '<option value="9">GSM-модем';
	  print '</select></td></tr>';
	  print '<tr><td><font class="down">Адрес </font></td><td><input name="device" size=10 class=log style="height:18px"></td><td></td></tr>';
	  print '<tr><td><font class="main">Скорость</font></td><td><select class=log name="speed" style="height:18">';
	  print '<option value="300">300';
	  print '<option value="600">600';
	  print '<option value="1200">1200';
	  print '<option value="2400">2400';
	  print '<option value="4800">4800';
	  print '<option value="9600">9600';
	  print '<option value="19200">19200';
	  print '<option value="38400">38400';
	  print '<option value="57600">57600';
	  print '<option value="115200">115200';
	  print '</select></td></tr>';
	  print '<tr><td><font class="main">Порт</font></td><td><select class=log name="com" style="height:18">';
	  print '<option value="1">com1';
	  print '<option value="2">com2';
	  print '<option value="3">com3';
	  print '<option value="4">com4';
	  print '<option value="5">com5';
	  print '<option value="6">com6';
	  print '<option value="7">com7';
	  print '<option value="8">com8';
	  print '<option value="9">com9';
	  print '<option value="10">com10';
	  print '</select></td></tr>';
	  print '<tr><td align=right><font class="dd">изменить</font></td><td><input alt="сохранить изменения" border=0 align=left src="files/forward.gif" type=image></td><td><input name="frm" size=1 style="height:1;width:1;visibility:hidden" value="ch"><input name="id" size=1 style="height:1;width:1;visibility:hidden" value="'.$ui[0].'"></td></tr></form>';
	  print '<tr><td align=right><font class="dd">добавить</font></td><td><input alt="добавить устройство" border=0 align=left src="files/forward.gif" type=image></td><td><input name="frm" size=1 style="height:1;width:1;visibility:hidden" value="ad"></td></tr></form>';
