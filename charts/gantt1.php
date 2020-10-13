<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_bar.php");
require_once ("../jpgraph/jpgraph_gantt.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

$today=getdate();
if ($_GET["year"]=='') $ye=$today["year"];
else $ye=$_GET["year"];
if ($_GET["month"]=='') $mn=$today["mon"];
else $mn=$_GET["month"];
$x=0; $tm=$dy=$today["mday"]-1;
for ($tn=1; $tn<=70; $tn++)
	{		
	 $date1=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $dat[69-$x]=sprintf ("%02d-%02d-%d",$tm,$mn,$ye);
	 $dats[69-$x]=sprintf ("%d-%02d-%02d",$ye,$mn,$tm);
         $x++; $tm--;
         if ($tm==0)
		{
		 $mn--;
		 if ($mn==0) { $mn=12; $ye--; }
		 $dy=31;
		 if (!checkdate ($mn,31,$ye)) { $dy=30; }
		 if (!checkdate ($mn,30,$ye)) { $dy=29; }
		 if (!checkdate ($mn,29,$ye)) { $dy=28; }
		 $tm=$dy;
	        }
        }

$query = 'SELECT * FROM dev_irp ORDER BY strut';
$b = mysql_query ($query,$i);
$ui = mysql_fetch_row ($b); $cn=0; $max=0;
while ($ui)
         {
	  $dev[$cn]=$ui[1];
	  $query = 'SELECT COUNT(id),MAX(date) FROM answers WHERE device='.$dev[$cn];
	  $a = mysql_query ($query,$i);
	  if ($a) $uy = mysql_fetch_row ($a);
	  $count[$cn]=$uy[0]; $last[$cn]=$uy[1];
	  if ($count[$cn]>$max) $max=$count[$cn];
	  $cn++;
	  $ui = mysql_fetch_row ($b);
	 }

for ($tn=0; $tn<$x; $tn++)
{
 $query = 'SELECT * FROM answers WHERE date LIKE \'%'.$dats[$tn].'%\'';
 $a = mysql_query ($query,$i);
 if ($a) $uy = mysql_fetch_row ($a);
 while ($uy)
    {   
     for ($y=0; $y<$cn; $y++)
	if ($dev[$y]==$uy[4])
	     $otv[$y][$tn]=1;

     $uy = mysql_fetch_row ($a);
    }
}

$graph = new GanttGraph(1200);
$graph->SetShadow();
 
// Add title and subtitle
$graph->title->Set("Статистика работы стояковых вычислителей - периоды передачи нормальных данных");
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
 
// Show day, week and month scale
$graph->ShowHeaders(GANTT_HDAY | GANTT_HWEEK | GANTT_HMONTH);
 
// Instead of week number show the date for the first day in the week
// on the week scale
$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY);
 
// Make the week scale font smaller than the default
$graph->scale->week->SetFont(FF_FONT0);
 
// Use the short name of the month together with a 2 digit year
// on the month scale
$graph->scale->month->SetStyle(MONTHSTYLE_SHORTNAMEYEAR4);
$graph->scale->month->SetFontColor("white");
$graph->scale->month->SetBackgroundColor("#FFCF68");
 
// 0 % vertical label margin
$graph->SetLabelVMarginFactor(1); // 1=default value

// Setup some "very" nonstandard colors
$graph->SetMarginColor('lightgreen@0.8');
$graph->SetBox(true,'yellow:0.6',2);
$graph->SetFrame(true,'darkgreen',4);
$graph->scale->divider->SetColor('yellow:0.6');
$graph->scale->dividerh->SetColor('yellow:0.6');
 

// Setup activity info
// For the titles we also add a minimum width of 100 pixels for the Task name column
$graph->scale->actinfo->SetColTitles(array('N','Last Answer','Stat','%'),array(20,115,55));
$graph->scale->actinfo->SetBackgroundColor('#FFCF68');
$graph->scale->actinfo->SetFont(FF_ARIAL,FS_NORMAL,10);
$graph->scale->actinfo->vgrid->SetStyle('solid');
$graph->scale->actinfo->vgrid->SetColor('gray');

for ($y=0; $y<$cn; $y++)
 {
  $irp=sprintf ("D%d",$y+1);
  $tn=0;
  while (!$otv[$y][$tn] && $tn<70) $tn++;
  if ($tn==70) $begin=$dats[0];
	else $begin=$dats[$tn];
  while ($tn<70)
	{
	  while ($otv[$y][$tn] && $tn<70)
		{
		 //printf ("%2s ",$otv[$y][$tn]);
		 $tn++;
		}
	  if ($tn==70) $end=$dats[69];
	  else $end=$dats[$tn];
	  // Format the bar for the first activity
	  // ($row,$title,$startdate,$enddate)
      	  //if ($y==2) echo 	$y.' '.$irp.' b='.$begin.', e='.$end.'<br>';
	  $pr=number_format($count[$y]*100/$max,2);
	  $ans=$count[$y].'/'.$max;
	  $activity1 = new GanttBar($y,array($irp,$last[$y],$ans,$pr),$begin,$end,"",10);
	  // Yellow diagonal line pattern on a red background
	  $activity1->SetPattern(BAND_RDIAG,"yellow");
	  $activity1->SetFillColor("red");
	  // Set absolute height of activity
	  $activity1->SetHeight(10);
	  $graph->Add($activity1);
	  while (!$otv[$y][$tn] && $tn<70) $tn++;
	  $begin=$dats[$tn];
	}
 }
$graph->SetVMarginFactor(0.30); 
// ... and display it
$graph->Stroke();

?>