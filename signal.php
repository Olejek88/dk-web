<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Система учета индивидуального потребления энергоресурсов :: Область видимости ЛК, на основе данных о уровне сигналов беспрводных датчиков</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=900px cellpadding=1 cellspacing=1 align=center>
<tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Область видимости ЛК, на основе данных о уровне сигналов беспрводных датчиков </font></td></tr>

<?php
if ($_GET["obj"]==1)
   {
    print '<tr><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=0&obj='.$_GET["obj"].'"></td><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=1&obj='.$_GET["obj"].'"></td></tr>';
    print '<tr><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=2&obj='.$_GET["obj"].'"></td><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=3&obj='.$_GET["obj"].'"></td></tr>';
   }
?>
<?php
if ($_GET["obj"]==2)
   {
    print '<tr><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=10&obj='.$_GET["obj"].'"></td><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=11&obj='.$_GET["obj"].'"></td></tr>';
    print '<tr><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=12&obj='.$_GET["obj"].'"></td><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=13&obj='.$_GET["obj"].'"></td></tr>';
    print '<tr><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=14&obj='.$_GET["obj"].'"></td><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=15&obj='.$_GET["obj"].'"></td></tr>';
    print '<tr><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=16&obj='.$_GET["obj"].'"></td><td width=450 valign=top><img width=450 height=450 src="charts/polar.php?type=17&obj='.$_GET["obj"].'"></td></tr>';
   }
?>
<?php
if ($_GET["obj"]==6)
   {
    print '<tr><td width=450 valign=top><img width=450 src="charts/polar.php?type=61&obj='.$_GET["obj"].'"></td><td width=450 valign=top><img width=450 src="charts/polar.php?type=62&obj='.$_GET["obj"].'"></td></tr>';
    print '<tr><td width=450 valign=top><img width=450 src="charts/polar.php?type=63&obj='.$_GET["obj"].'"></td><td width=450 valign=top><img width=450 src="charts/polar.php?type=64&obj='.$_GET["obj"].'"></td></tr>';
    print '<tr><td width=450 valign=top><img width=450 src="charts/polar.php?type=65&obj='.$_GET["obj"].'"></td><td width=450 valign=top><img width=450 src="charts/polar.php?type=66&obj='.$_GET["obj"].'"></td></tr>';
   }
?>
</table>
