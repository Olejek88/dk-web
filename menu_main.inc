<ul id="main-menu">
	<li class="root-item"><a class="root-item" href="http://rpk-su.info/"><strong>�������</strong></a></li>
	<li onmouseout="fo('about');" onmouseover="fr('about');" class="root-item"><a class="root-item" href="http://rpk-su.info/index.php?sel=about2">�������� � �������</a>
	<ul id="about"><li class=""><a class="" href="http://rpk-su.info/index.php?sel=strukt">��������</a></li>
	<li class=""><a class="" href="http://rpk-su.info/index.php?sel=about2">���������</a></li>
	</ul></li>
	<li onmouseout="fo('objj');" onmouseover="fr('objj');" class="root-item"><a class="root-item" href="http://rpk-su.info/index.php">������������������ �������</a>
	<ul id="objj">
		<?php
		  include("config/local.php");
		  $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
		  $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
		  $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
		  $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
	     	  $query = 'SELECT * FROM build';
		  $e = mysql_query ($query,$i);
		  $ui = mysql_fetch_row ($e);
		  while ($ui) 
			{
			 print '<li class=""><a class="" href="http://rpk-su.info/index.php?obj='.$ui[0].'">'.$ui[1].'</a></li>';
			 $ui = mysql_fetch_row ($e);
			}
		?>
	</ul></li>
	<li onmouseout="fo('contacts');" onmouseover="fr('contacts');" class="root-item"><a class="root-item" href="http://rpk-su.info/">��������</a>
	<ul id="contacts">
		<li class=""><a class="" href="http://rpk-su.info/index.php?sel=kont">��������</a></li>
		<li class=""><a class="" href="http://rpk-su.info/index.php?sel=kart">����� �������</a></li>
	</ul></li>
</ul>