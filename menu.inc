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
		  if ($e = mysql_query ($query,$i))
		  while ($ui = mysql_fetch_row ($e))
			{
			 print '<li class=""><a class="" href="index.php?obj='.$ui[0].'">'.$ui[1].'</a></li>';
			}
		?>
	</ul></li>
	</ul></li>
	<?php
	//if ($_GET["obj"]!=7)
	$mini=1;
	if (1)
		{
		 print '<li onmouseout="fo(\'news\');" onmouseover="fr(\'news\');" class="root-item"><a class="root-item" href="index.php?sel=rz1&obj='.$_GET["obj"].'">���������</a>
			<ul id="news">';
		 print '<li class=""><a class="" href="index.php?sel=flat&id=1&obj='.$_GET["obj"].'">�������������� ������ �����������</a></li>';
		 if ($is_tekon) print '<li class=""><a class="" href="index.php?sel=trend4&obj='.$_GET["obj"].'">����������� ������� ���� � �������� ������� �� �� ����������</a></li>';
		 if ($is_tekon) print '<li class=""><a class="" href="index.php?sel=trend5&obj='.$_GET["obj"].'">������������ ������ ������������� �����</a></li>';
		 print '</ul></li>';
		}
	?>

	<li onmouseout="fo('products');" onmouseover="fr('products');" class="root-item"><a class="root-item" href="">������������ ���������</a>
		<ul id="products">
			<li onmouseout="fo('p-1120723474');" onmouseover="fr('p-1120723474');" class=""><a class="parent" href="index.php?sel=current&type=1<?php print '&obj='.$_GET["obj"]; ?>">������� ���������</a>
			<ul id="p-1120723474">
				<li class=""><a class="" href="index.php?sel=current&type=1<?php print '&obj='.$_GET["obj"]; ?>">������� �������� ��������</a></li>
			</ul></li>
			<?php
			if ($is_2ip)
				print '<li onmouseout="fo(\'p-1161849688\');" onmouseover="fr(\'p-1161849688\');" class=""><a class="parent" href="index.php?sel=current&type=2&obj='.$_GET["obj"].'">������� ������� ����</a>
				<ul id="p-1161849688">
					<li class=""><a class="" href="index.php?sel=current&type=2&obj='.$_GET["obj"].'">������� �������� ��������</a></li>
					<li class=""><a class="" href="index.php?sel=lk1&obj='.$_GET["obj"].'">���������� ������ 2��</a></li>
					<li class=""><a class="" href="index.php?sel=lk&obj='.$_GET["obj"].'">������ ���� ������������� � ��������� ��������</a></li>
					<li class=""><a class="" href="index.php?sel=lk3&obj='.$_GET["obj"].'">�������� ������ �� ���� �� ��������� ����� �� ���� ���������</a></li>
				</ul></li>';
			if ($is_mee)
				print '<li onmouseout="fo(\'p-1120552476\');" onmouseover="fr(\'p-1120552476\');" class=""><a class="parent" href="index.php?sel=current&type=4&obj='.$_GET["obj"].'">�������� ��������������</a>
					<ul id="p-1120552476">
					<li class=""><a class="" href="index.php?sel=current&type=4&obj='.$_GET["obj"].'">������� �������� ���</a></li>
					<li class=""><a class="" href="index.php?sel=mee&obj='.$_GET["obj"].'">������ ���� ��������� �� � ��������� ��������</a></li>
					<li class=""><a class="" href="index.php?sel=mee3&obj='.$_GET["obj"].'">�������� ������ �� ������������� �� ��������� ����� �� ���� ���������</a></li>
				</ul></li>';
			?>
			<li onmouseout="fo('p-1120723543');" onmouseover="fr('p-1120723543');" class=""><a class="parent" href="index.php?sel=irp2<?php print '&obj='.$_GET["obj"]; ?>">��������� ����������������</a>
			<ul id="p-1120723543">
				<li class=""><a class="" href="index.php?sel=current&type=5<?php print '&obj='.$_GET["obj"]; ?>">������� �������� ���</a></li>
				<?php
				if (!$mini && $_GET["obj"]<=5) print '<li class=""><a class="" href="index.php?sel=irp3&obj='.$_GET["obj"].'">���������� ������ ���</a></li>';
				print '<li class=""><a class="" href="index.php?sel=irp2&obj='.$_GET["obj"].'">���� �� ����������� �� ������� ������ � ��������</a></li>';
				if (!$mini && $_GET["obj"]<=5) print '<li class=""><a class="" href="index.php?sel=irp4&obj='.$_GET["obj"].'">�������� ������ ���� ����������</a></li>';
				?>
			</ul>
			</li>
			<?php
			if (!$mini && $is_2ip && $is_tekon)
				{
				 print '<li onmouseout="fo(\'p-1120723574\');" onmouseover="fr(\'p-1120723574\');" class=""><a class="parent" href="index.php?sel=balans&obj='.$_GET["obj"].'">�������� ��������</a>
					<ul id="p-1120723574">
						<li class=""><a class="" href="index.php?sel=balans&obj='.$_GET["obj"].'">�������� ��������� ������� �� ������</a></li>
						<li class=""><a class="" href="index.php?sel=balans&month=4&obj=1&obj='.$_GET["obj"].'">�������� ��������� ������� �� ����</a></li>
					</ul></li>';
				}
			if (!$mini && $_GET["obj"]<3) print '<li class=""><a class="parent" href="mnem.php?obj='.$_GET["obj"].'">���������� ���� � �������� ����������� �������� � ��������</a></li>';
			if ($_GET["obj"]<3) print '<li class=""><a class="parent" href="index.php?sel=signal&obj='.$_GET["obj"].'">���� ��������� ��, ����������� �� ������� ��������</a></li>';
			print '<li class=""><a class="parent" href="index.php?sel=tech4&obj='.$_GET["obj"].'">������ ������������ �������� �� ����������</a></li>';
			if ($is_tekon) print '<li class=""><a class="parent" href="index.php?sel=trend3&obj='.$_GET["obj"].'">������ �� ������� ��������� ��� �� �����</a></li>';
			if ($is_bit) print '<li class=""><a class="parent" href="index.php?sel=bit10&obj='.$_GET["obj"].'">����������� �������� �������, ����������� �� ��������� ����������</a></li>';
			if (!$mini && $is_bit && $_GET["obj"]==1) print '<li class=""><a class="parent" href="index.php?sel=bit11&obj='.$_GET["obj"].'">��������� ������������� �������� ������� �� ���������-�������</a></li>';
			if ($is_tekon) print '<li class=""><a class="parent" href="index.php?sel=trend2&obj='.$_GET["obj"].'">������ �� ������������� ���� �����</a></li>';
			?>
			</ul></li>
			<li onmouseout="fo('catalogue');" onmouseover="fr('catalogue');" class="root-item"><a class="root-item" href="">����������� ���������</a>
			<ul id="catalogue">
			<?php
			if ($is_tekon) print '<li class=""><a class="" href="index.php?sel=all2&obj='.$_GET["obj"].'">������ ������������������� �������</a></li>';
			if ($_GET["obj"]<=3) print '<li class=""><a class="" href="index.php?sel=all5&obj='.$_GET["obj"].'">������������� � ������ ����������� ���� ��������������</a></li>';
			else print '<li class=""><a class="" href="index.php?sel=all51&obj='.$_GET["obj"].'">������������� � ������ ����������� ���� ��������������</a></li>';
			if ($is_tekon) print '<li class=""><a class="" href="index.php?sel=analis1&obj='.$_GET["obj"].'">������ ����������� ���� �� ����������� ��������� �������</a></li>';
			if ($is_2ip && $_GET["obj"]<=5) print '<li class=""><a class="" href="index.php?sel=analis2&obj='.$_GET["obj"].'">������ ����������� ���� �� ������� �����</a></li>';
			if ($_GET["obj"]==1) print '<li class=""><a class="" href="index.php?sel=termo&obj='.$_GET["obj"].'">���������������� ���������� ����</a></li>';
			if ($is_2ip) print '<li class=""><a class="" href="index.php?sel=all6&obj='.$_GET["obj"].'">������������� � ������ ����������� �������� � ������� ����</a></li>';
			if ($is_2ip) print '<li class=""><a class="" href="index.php?sel=lk56&obj='.$_GET["obj"].'">����������� �������� ���� ���������� � ������</a></li>';
			if ($is_2ip && $_GET["obj"]<6) print '<li class=""><a class="" href="index.php?sel=lk6&obj='.$_GET["obj"].'">����������� �������� ���� ���������� (������ �������)</a></li>';
			if ($is_bit) print '<li class=""><a class="" href="index.php?sel=bit5&obj='.$_GET["obj"].'">����������� �������� ������� ���������� � ������</a></li>';
			if (!$mini && $is_bit && $_GET["obj"]==1) print '<li class=""><a class="" href="index.php?sel=bit9&date=20120202&obj='.$_GET["obj"].'">������ �������� ������� �� ���������</a></li>';
			if ($is_mee) print '<li class=""><a class="" href="index.php?sel=mee5&obj='.$_GET["obj"].'">����������� �������������� ���������� � ������</a></li>';
			if ($is_mee) print '<li class=""><a class="" href="index.php?sel=mee6&obj='.$_GET["obj"].'">����������� �������������� ���������� (������ �������)</a></li>';
			if ($is_bit && $_GET["obj"]<=2) print '<li class=""><a class="" href="mnem2.php?obj='.$_GET["obj"].'">������������� ��������� ����������� � ����������� �� ������������ ��������</a></li>';
			if (!$mini && $is_tekon) print '<li class=""><a class="" href="index.php?sel=all&obj='.$_GET["obj"].'">��������� ����������� ���� � ������������ ������������ �� �������</a></li>';
			if (!$mini && $is_tekon) print '<li class=""><a class="" href="index.php?sel=analis4&obj='.$_GET["obj"].'">������ �������� ������������ ������������ �����</a></li>';
			?>
			</ul></li>
			<?php
			if ($_GET["obj"]<=3) print '<li onmouseout="fo(\'support\');" onmouseover="fr(\'support\');" class="root-item"><a class="root-item" href="index.php?sel=rz4&obj='.$_GET["obj"].'">����������� ��������������</a>';
			else print '<li onmouseout="fo(\'support\');" onmouseover="fr(\'support\');" class="root-item"><a class="root-item" href="">����������� ��������������</a>';
			?>
			<ul id="support">
			<?php
			if ($is_tekon && $_GET["obj"]<3) print '<li class=""><a class="" href="index.php?sel=reports">������ � dbf � xls</a></li>';
			print '<li class=""><a class="" href="index.php?sel=reports2">������ � csv</a></li>';
			if (!$mini && $is_2ip && $_GET["obj"]<6) print '<li class=""><a class="" href="index.php?sel=lk6&obj='.$_GET["obj"].'">����������� �������� ���� ���������� (������ �������)</a></li>';
			if ($is_mee) print '<li class=""><a class="" href="index.php?sel=mee6&obj='.$_GET["obj"].'">����������� �������������� ���������� (������ �������)</a></li>';
			if (!$mini) print '<li class=""><a class="" href="index.php?sel=all&obj='.$_GET["obj"].'">��������� ����������� ���� � ������������ ������������ �� �������</a></li>';
			if ($_GET["obj"]<=5) print '<li class=""><a class="" href="index.php?sel=all21&obj='.$_GET["obj"].'">������ ������������������� �� ��� ����� ������</a></li>';
			else print '<li class=""><a class="" href="index.php?sel=all22&obj='.$_GET["obj"].'">������ ������������������� �� ��� ����� ������</a></li>';
			if ($is_tekon) 
			    {
			     if ($_GET["obj"]==9) print '<li class=""><a class="" href="index.php?sel=trend3_el23&obj='.$_GET["obj"].'">������ �� ������� ��������� ��� �� �����</a></li>';
			     else  print '<li class=""><a class="" href="index.php?sel=trend3&obj='.$_GET["obj"].'">������ �� ������� ��������� ��� �� �����</a></li>';
			    }
			if ($is_tekon) 
			    {
			     if ($_GET["obj"]==9) print '<li class=""><a class="" href="index.php?sel=trend2_el23&obj='.$_GET["obj"].'">������ �� ������������� ���� �����</a></li>';
			     else if ($_GET["obj"]==13) print '<li class=""><a class="" href="index.php?sel=trend2_el17&obj='.$_GET["obj"].'">������ �� ������������� ���� �����</a></li>';
			     else print '<li class=""><a class="" href="index.php?sel=trend2&obj='.$_GET["obj"].'">������ �� ������������� ���� �����</a></li>';
			    }
			if ($is_tekon) print '<li class=""><a class="" href="index.php?sel=analis3&obj='.$_GET["obj"].'">������ ����������� ������ �� ����������� �������� �������</a></li>';
			if ($is_mee) print '<li class=""><a class="" href="index.php?sel=analis5&obj='.$_GET["obj"].'">������ ������������� ������������� �������� ����������� ������������� ������� �� ������� ����� � ���� ������</a></li>';
			if (!$mini && $is_tekon) print '<li class=""><a class="" href="index.php?sel=analis4&obj='.$_GET["obj"].'">������ �������� ������������ ������������ �����</a></li>';
			?>
			</ul></li>
</ul>