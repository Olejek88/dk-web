<ul id="main-menu">
	<li class="root-item"><a class="root-item" href=""><strong>Главная</strong></a></li>
	<li onmouseout="fo('about');" onmouseover="fr('about');" class="root-item"><a class="root-item" href="index.php?sel=about2">Введение в Систему</a>
	<ul id="about"><li class=""><a class="" href="index.php?sel=strukt">Описание</a></li>
	<li class=""><a class="" href="index.php?sel=about2">Структура</a></li>
	<li onmouseout="fo('objj');" onmouseover="fr('objj');" class=""><a class="parent" href="index.php">Автоматизированные объекты</a>
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
		 print '<li onmouseout="fo(\'news\');" onmouseover="fr(\'news\');" class="root-item"><a class="root-item" href="index.php?sel=rz1&obj='.$_GET["obj"].'">Абонентам</a>
			<ul id="news">';
		 print '<li class=""><a class="" href="index.php?sel=flat&id=1&obj='.$_GET["obj"].'">Индивидуальный листок потребления</a></li>';
		 if ($is_tekon) print '<li class=""><a class="" href="index.php?sel=trend4&obj='.$_GET["obj"].'">Температура горячей воды и тепловая энергия на ее подготовку</a></li>';
		 if ($is_tekon) print '<li class=""><a class="" href="index.php?sel=trend5&obj='.$_GET["obj"].'">Качественный анализ поставляемого тепла</a></li>';
		 print '</ul></li>';
		}
	?>

	<li onmouseout="fo('products');" onmouseover="fr('products');" class="root-item"><a class="root-item" href="">Техническому персоналу</a>
		<ul id="products">
			<li onmouseout="fo('p-1120723474');" onmouseover="fr('p-1120723474');" class=""><a class="parent" href="index.php?sel=current&type=1<?php print '&obj='.$_GET["obj"]; ?>">Датчики энтальпии</a>
			<ul id="p-1120723474">
				<li class=""><a class="" href="index.php?sel=current&type=1<?php print '&obj='.$_GET["obj"]; ?>">Текущие значения датчиков</a></li>
			</ul></li>
			<?php
			if ($is_2ip)
				print '<li onmouseout="fo(\'p-1161849688\');" onmouseover="fr(\'p-1161849688\');" class=""><a class="parent" href="index.php?sel=current&type=2&obj='.$_GET["obj"].'">Датчики расхода воды</a>
				<ul id="p-1161849688">
					<li class=""><a class="" href="index.php?sel=current&type=2&obj='.$_GET["obj"].'">Текущие значения датчиков</a></li>
					<li class=""><a class="" href="index.php?sel=lk1&obj='.$_GET["obj"].'">Статистика работы 2ИП</a></li>
					<li class=""><a class="" href="index.php?sel=lk&obj='.$_GET["obj"].'">Список всех водосчетчиков и последние значения</a></li>
					<li class=""><a class="" href="index.php?sel=lk3&obj='.$_GET["obj"].'">Суточные архивы по воде за последнее время по всем квартирам</a></li>
				</ul></li>';
			if ($is_mee)
				print '<li onmouseout="fo(\'p-1120552476\');" onmouseover="fr(\'p-1120552476\');" class=""><a class="parent" href="index.php?sel=current&type=4&obj='.$_GET["obj"].'">Мониторы электроэнергии</a>
					<ul id="p-1120552476">
					<li class=""><a class="" href="index.php?sel=current&type=4&obj='.$_GET["obj"].'">Текущие значения МЭЭ</a></li>
					<li class=""><a class="" href="index.php?sel=mee&obj='.$_GET["obj"].'">Список всех мониторов ЭЭ и последние значения</a></li>
					<li class=""><a class="" href="index.php?sel=mee3&obj='.$_GET["obj"].'">Суточные архивы по электричеству за последнее время по всем квартирам</a></li>
				</ul></li>';
			?>
			<li onmouseout="fo('p-1120723543');" onmouseover="fr('p-1120723543');" class=""><a class="parent" href="index.php?sel=irp2<?php print '&obj='.$_GET["obj"]; ?>">Стояковые тепловычислители</a>
			<ul id="p-1120723543">
				<li class=""><a class="" href="index.php?sel=current&type=5<?php print '&obj='.$_GET["obj"]; ?>">Текущие значения ИРП</a></li>
				<?php
				if (!$mini && $_GET["obj"]<=5) print '<li class=""><a class="" href="index.php?sel=irp3&obj='.$_GET["obj"].'">Статистика работы ИРП</a></li>';
				print '<li class=""><a class="" href="index.php?sel=irp2&obj='.$_GET["obj"].'">Срез по температуре на текущий момент и значения</a></li>';
				if (!$mini && $_GET["obj"]<=5) print '<li class=""><a class="" href="index.php?sel=irp4&obj='.$_GET["obj"].'">Суточные архивы всех параметров</a></li>';
				?>
			</ul>
			</li>
			<?php
			if (!$mini && $is_2ip && $is_tekon)
				{
				 print '<li onmouseout="fo(\'p-1120723574\');" onmouseover="fr(\'p-1120723574\');" class=""><a class="parent" href="index.php?sel=balans&obj='.$_GET["obj"].'">Сведение балансов</a>
					<ul id="p-1120723574">
						<li class=""><a class="" href="index.php?sel=balans&obj='.$_GET["obj"].'">Сведение суточного баланса за апрель</a></li>
						<li class=""><a class="" href="index.php?sel=balans&month=4&obj=1&obj='.$_GET["obj"].'">Сведение суточного баланса за март</a></li>
					</ul></li>';
				}
			if (!$mini && $_GET["obj"]<3) print '<li class=""><a class="parent" href="mnem.php?obj='.$_GET["obj"].'">Мнемосхема дома с текущими показаниями датчиков и авариями</a></li>';
			if ($_GET["obj"]<3) print '<li class=""><a class="parent" href="index.php?sel=signal&obj='.$_GET["obj"].'">Зона видимости ЛК, построенная на уровнях сигналов</a></li>';
			print '<li class=""><a class="parent" href="index.php?sel=tech4&obj='.$_GET["obj"].'">Списки неотвечающих датчиков по категориям</a></li>';
			if ($is_tekon) print '<li class=""><a class="parent" href="index.php?sel=trend3&obj='.$_GET["obj"].'">Тренды по входным значениям ИТП по часам</a></li>';
			if ($is_bit) print '<li class=""><a class="parent" href="index.php?sel=bit10&obj='.$_GET["obj"].'">Потребление тепловой энергии, вычисленное по различным алгоритмам</a></li>';
			if (!$mini && $is_bit && $_GET["obj"]==1) print '<li class=""><a class="parent" href="index.php?sel=bit11&obj='.$_GET["obj"].'">Примерное распредерение тепловой энергии по квартирам-стоякам</a></li>';
			if ($is_tekon) print '<li class=""><a class="parent" href="index.php?sel=trend2&obj='.$_GET["obj"].'">Архивы по коммерческому узлу учета</a></li>';
			?>
			</ul></li>
			<li onmouseout="fo('catalogue');" onmouseover="fr('catalogue');" class="root-item"><a class="root-item" href="">Управляющим компаниям</a>
			<ul id="catalogue">
			<?php
			if ($is_tekon) print '<li class=""><a class="" href="index.php?sel=all2&obj='.$_GET["obj"].'">Анализ энергоэффективности Системы</a></li>';
			if ($_GET["obj"]<=3) print '<li class=""><a class="" href="index.php?sel=all5&obj='.$_GET["obj"].'">Распределение и анализ потребления всех энергоресурсов</a></li>';
			else print '<li class=""><a class="" href="index.php?sel=all51&obj='.$_GET["obj"].'">Распределение и анализ потребления всех энергоресурсов</a></li>';
			if ($is_tekon) print '<li class=""><a class="" href="index.php?sel=analis1&obj='.$_GET["obj"].'">Анализ теплопотерь дома от температуры наружного воздуха</a></li>';
			if ($is_2ip && $_GET["obj"]<=5) print '<li class=""><a class="" href="index.php?sel=analis2&obj='.$_GET["obj"].'">Анализ потребления воды по времени суток</a></li>';
			if ($_GET["obj"]==1) print '<li class=""><a class="" href="index.php?sel=termo&obj='.$_GET["obj"].'">Термографические фотографии дома</a></li>';
			if ($is_2ip) print '<li class=""><a class="" href="index.php?sel=all6&obj='.$_GET["obj"].'">Распределение и анализ потребления холодной и горячей воды</a></li>';
			if ($is_2ip) print '<li class=""><a class="" href="index.php?sel=lk56&obj='.$_GET["obj"].'">Потребление питьевой воды абонентами и анализ</a></li>';
			if ($is_2ip && $_GET["obj"]<6) print '<li class=""><a class="" href="index.php?sel=lk6&obj='.$_GET["obj"].'">Потребление питьевой воды абонентами (только графики)</a></li>';
			if ($is_bit) print '<li class=""><a class="" href="index.php?sel=bit5&obj='.$_GET["obj"].'">Потребление тепловой энергии абонентами и анализ</a></li>';
			if (!$mini && $is_bit && $_GET["obj"]==1) print '<li class=""><a class="" href="index.php?sel=bit9&date=20120202&obj='.$_GET["obj"].'">Расчет тепловой энергии по квартирам</a></li>';
			if ($is_mee) print '<li class=""><a class="" href="index.php?sel=mee5&obj='.$_GET["obj"].'">Потребление электроэнергии абонентами и анализ</a></li>';
			if ($is_mee) print '<li class=""><a class="" href="index.php?sel=mee6&obj='.$_GET["obj"].'">Потребление электроэнергии абонентами (только графики)</a></li>';
			if ($is_bit && $_GET["obj"]<=2) print '<li class=""><a class="" href="mnem2.php?obj='.$_GET["obj"].'">Распределение удельного потребления в зависимости от расположения квартиры</a></li>';
			if (!$mini && $is_tekon) print '<li class=""><a class="" href="index.php?sel=all&obj='.$_GET["obj"].'">Сравнение потребления дома с нормативными показателями по месяцам</a></li>';
			if (!$mini && $is_tekon) print '<li class=""><a class="" href="index.php?sel=analis4&obj='.$_GET["obj"].'">Анализ качества поставляемых коммунальных услуг</a></li>';
			?>
			</ul></li>
			<?php
			if ($_GET["obj"]<=3) print '<li onmouseout="fo(\'support\');" onmouseover="fr(\'support\');" class="root-item"><a class="root-item" href="index.php?sel=rz4&obj='.$_GET["obj"].'">Поставщикам энергоресурсов</a>';
			else print '<li onmouseout="fo(\'support\');" onmouseover="fr(\'support\');" class="root-item"><a class="root-item" href="">Поставщикам энергоресурсов</a>';
			?>
			<ul id="support">
			<?php
			if ($is_tekon && $_GET["obj"]<3) print '<li class=""><a class="" href="index.php?sel=reports">Отчеты в dbf и xls</a></li>';
			print '<li class=""><a class="" href="index.php?sel=reports2">Отчеты в csv</a></li>';
			if (!$mini && $is_2ip && $_GET["obj"]<6) print '<li class=""><a class="" href="index.php?sel=lk6&obj='.$_GET["obj"].'">Потребление питьевой воды абонентами (только графики)</a></li>';
			if ($is_mee) print '<li class=""><a class="" href="index.php?sel=mee6&obj='.$_GET["obj"].'">Потребление электроэнергии абонентами (только графики)</a></li>';
			if (!$mini) print '<li class=""><a class="" href="index.php?sel=all&obj='.$_GET["obj"].'">Сравнение потребления дома с нормативными показателями по месяцам</a></li>';
			if ($_GET["obj"]<=5) print '<li class=""><a class="" href="index.php?sel=all21&obj='.$_GET["obj"].'">Анализ энергоэффективности за все время работы</a></li>';
			else print '<li class=""><a class="" href="index.php?sel=all22&obj='.$_GET["obj"].'">Анализ энергоэффективности за все время работы</a></li>';
			if ($is_tekon) 
			    {
			     if ($_GET["obj"]==9) print '<li class=""><a class="" href="index.php?sel=trend3_el23&obj='.$_GET["obj"].'">Тренды по входным значениям ИТП по часам</a></li>';
			     else  print '<li class=""><a class="" href="index.php?sel=trend3&obj='.$_GET["obj"].'">Тренды по входным значениям ИТП по часам</a></li>';
			    }
			if ($is_tekon) 
			    {
			     if ($_GET["obj"]==9) print '<li class=""><a class="" href="index.php?sel=trend2_el23&obj='.$_GET["obj"].'">Архивы по коммерческому узлу учета</a></li>';
			     else if ($_GET["obj"]==13) print '<li class=""><a class="" href="index.php?sel=trend2_el17&obj='.$_GET["obj"].'">Архивы по коммерческому узлу учета</a></li>';
			     else print '<li class=""><a class="" href="index.php?sel=trend2&obj='.$_GET["obj"].'">Архивы по коммерческому узлу учета</a></li>';
			    }
			if ($is_tekon) print '<li class=""><a class="" href="index.php?sel=analis3&obj='.$_GET["obj"].'">Анализ общедомовых потерь от температуры внешнего воздуха</a></li>';
			if ($is_mee) print '<li class=""><a class="" href="index.php?sel=analis5&obj='.$_GET["obj"].'">Анализ распределения среднечасовых значений потребления электрической энергии по времени суток и дням недели</a></li>';
			if (!$mini && $is_tekon) print '<li class=""><a class="" href="index.php?sel=analis4&obj='.$_GET["obj"].'">Анализ качества поставляемых коммунальных услуг</a></li>';
			?>
			</ul></li>
</ul>