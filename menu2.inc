<ul id="main-menu">
	<li class="root-item"><a class="root-item" href=""><strong>�������</strong></a></li>
	<li onmouseout="fo('about');" onmouseover="fr('about');" class="root-item"><a class="root-item" href="index.php?sel=about2">�������� � �������</a>
	<ul id="about"><li class=""><a class="" href="index.php?sel=strukt">��������</a></li>
	<li class=""><a class="" href="index.php?sel=about2">���������</a></li>
	<li onmouseout="fo('objj');" onmouseover="fr('objj');" class=""><a class="parent" href="index.php">������������������ �������</a>
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
			 print '<li class=""><a class="" href="index.php?obj='.$ui[0].'">'.$ui[1].'</a></li>';
			 $ui = mysql_fetch_row ($e);
			}
		?>
	</ul></li>
	</ul></li>
	<li onmouseout="fo('products');" onmouseover="fr('products');" class="root-item"><a class="root-item" href="index.php?sel=rz2<?php print '&obj='.$_GET["obj"]; ?>">������������ ���������</a>
		<ul id="products">
			<li onmouseout="fo('p-1120723474');" onmouseover="fr('p-1120723474');" class=""><a class="parent" href="index.php?sel=bits<?php print '&obj='.$_GET["obj"]; ?>">������� ���������</a>
			<ul id="p-1120723474">
				<li class=""><a class="" href="index.php?sel=current&type=1<?php print '&obj='.$_GET["obj"]; ?>">������� �������� ��������</a></li>
				<li class=""><a class="" href="index.php?sel=bit<?php print '&obj='.$_GET["obj"]; ?>">������ ���� �������� ��������� � ��������� ��������</a></li>
				<li class=""><a class="" href="index.php?sel=bit4<?php print '&obj='.$_GET["obj"]; ?>">��������� ��������� �� �������</a></li>
			</ul></li>
			<li onmouseout="fo('p-1161849688');" onmouseover="fr('p-1161849688');" class=""><a class="parent" href="index.php?sel=lks<?php print '&obj='.$_GET["obj"]; ?>">������� ������� ����</a>
			<ul id="p-1161849688">
				<li class=""><a class="" href="index.php?sel=current&type=2<?php print '&obj='.$_GET["obj"]; ?>">������� �������� ��������</a></li>
				<li class=""><a class="" href="index.php?sel=lk<?php print '&obj='.$_GET["obj"]; ?>">������ ���� ������������� � ��������� ��������</a></li>
				<li class=""><a class="" href="index.php?sel=lk3<?php print '&obj='.$_GET["obj"]; ?>">�������� ������ �� ���� �� ��������� ����� �� ���� ���������</a></li>
				<li class=""><a class="" href="index.php?sel=lk4<?php print '&obj='.$_GET["obj"]; ?>">������ ��������������� ���������� �� ������� ��� � ���</a></li>
			</ul></li>
			<li onmouseout="fo('p-1120723543');" onmouseover="fr('p-1120723543');" class=""><a class="parent" href="index.php?sel=irps<?php print '&obj='.$_GET["obj"]; ?>">��������� ����������������</a>
			<ul id="p-1120723543">
				<li class=""><a class="" href="index.php?sel=current&type=5<?php print '&obj='.$_GET["obj"]; ?>">������� �������� ���</a></li>
				<li class=""><a class="" href="index.php?sel=irp3<?php print '&obj='.$_GET["obj"]; ?>">���������� ������ ���</a></li>
				<li class=""><a class="" href="index.php?sel=irp2<?php print '&obj='.$_GET["obj"]; ?>">���� �� ����������� �� ������� ������ � ��������</a></li>
				<li class=""><a class="" href="index.php?sel=irp4<?php print '&obj='.$_GET["obj"]; ?>">�������� ������ ���� ����������</a></li>
			</ul>
			</li>
			<li class=""><a class="parent" href="index.php?sel=tech4<?php print '&obj='.$_GET["obj"]; ?>">������ ������������ �������� �� ����������</a></li>
			<li class=""><a class="parent" href="index.php?sel=bit10<?php print '&obj='.$_GET["obj"]; ?>">����������� �������� �������, ����������� �� ��������� ����������</a></li>
			</ul></li>
			<li onmouseout="fo('catalogue');" onmouseover="fr('catalogue');" class="root-item"><a class="root-item" href="index.php?sel=rz3<?php print '&obj='.$_GET["obj"]; ?>">����������� ���������</a>
			<ul id="catalogue">
				<?php
				if ($_GET["obj"]<=5) print '<li class=""><a class="" href="index.php?sel=all21&obj='.$_GET["obj"].'">������ ������������������� �� ��� ����� ������</a></li>';
				else print '<li class=""><a class="" href="index.php?sel=all22&obj='.$_GET["obj"].'">������ ������������������� �� ��� ����� ������</a></li>';
				?>
				<li class=""><a class="" href="index.php?sel=all5<?php print '&obj='.$_GET["obj"]; ?>">������������� � ������ ����������� ���� ��������������</a></li>
				<li class=""><a class="" href="index.php?sel=analis2<?php print '&obj='.$_GET["obj"]; ?>">������ ����������� ���� �� ������� �����</a></li>
				<li class=""><a class="" href="index.php?sel=all6<?php print '&obj='.$_GET["obj"]; ?>">������������� � ������ ����������� �������� � ������� ����</a></li>
				<li class=""><a class="" href="index.php?sel=lk56<?php print '&obj='.$_GET["obj"]; ?>">����������� �������� ���� ���������� � ������</a></li>
				<li class=""><a class="" href="index.php?sel=bit5<?php print '&obj='.$_GET["obj"]; ?>">����������� �������� ������� ���������� � ������</a></li>
				<li class=""><a class="" href="index.php?sel=mee5<?php print '&obj='.$_GET["obj"]; ?>">����������� �������������� ���������� � ������</a></li>
				<li class=""><a class="" href="mnem2.php?<?php print 'obj='.$_GET["obj"]; ?>">������������� ��������� ����������� � ����������� �� ������������ ��������</a></li>
				<li class=""><a class="" href="index.php?sel=all<?php print '&obj='.$_GET["obj"]; ?>">��������� ����������� ���� � ������������ ������������ �� �������</a></li>
			</ul></li>
</ul>