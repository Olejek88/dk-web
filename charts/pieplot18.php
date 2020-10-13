<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_pie.php");
include ("../jpgraph/jpgraph_pie3d.php");
include("../config/local.php");
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

if ($_GET["type"]=='') $_GET["type"]='1';
$x=0;
if ($_GET["type"]=='1')
for ($hr=0;$hr<=23;$hr++)
 {
  if ($hr<10) $date1='%0'.$hr.':00:00%'; else $date1='%'.$hr.':00:00%';
  $query = 'SELECT SUM(value) FROM hours WHERE type=1 AND prm=14 AND date>20090305000000 AND date LIKE \''.$date1.'\'';
  //echo $query.'<br>';
  $a = mysql_query ($query,$i);
  if ($a) $uy = mysql_fetch_row ($a);
  $data[$x]=$uy[0];
  if ($data[$x]==0)
	{
	  $query = 'SELECT SUM(value) FROM data WHERE type=1 AND prm=14 AND date>20090305000000 AND date LIKE \''.$date1.'\'';
	  //echo $query.'<br>';
	  $a = mysql_query ($query,$i);
	  if ($a) $uy = mysql_fetch_row ($a);
	  $data[$x]=$uy[0];
	}

  if ($hr>=0 && $hr<=4) $dat[$x]='ночь (00:00-05:00)';
  if ($hr>=5 && $hr<=8) $dat[$x]='утро (05:00-08:00)';
  if ($hr>=9 && $hr<=13) $dat[$x]='до обеда (09:00-13:00)';
  if ($hr>=14 && $hr<=18) $dat[$x]='после обеда (14:00-18:00)';
  if ($hr>=19 && $hr<=23) $dat[$x]='вечер (19:00-24:00)';
  if ($hr==4 || $hr==8 || $hr==13 || $hr==18) $x++;

 }

if ($_GET["type"]=='2')
for ($hr=0;$hr<=6;$hr++)
 {
  if ($hr<10) $date1='%0'.$hr.':00:00%'; else $date1='%'.$hr.':00:00%';
  $query = 'SELECT SUM(value),COUNT(id) FROM prdata WHERE type=2 AND prm=14 AND value<50 AND date>20090301000000 AND WEEKDAY(date)='.$hr;
  //echo $query.'<br>';
  $a = mysql_query ($query,$i);
  if ($a) $uy = mysql_fetch_row ($a);
  $data[$x]=$uy[0]/$uy[1];
  if ($hr==0) $dat[$x]='понедельник';
  if ($hr==1) $dat[$x]='вторник';
  if ($hr==2) $dat[$x]='среда';
  if ($hr==3) $dat[$x]='четверг';
  if ($hr==4) $dat[$x]='пятница';
  if ($hr==5) $dat[$x]='суббота';
  if ($hr==6) $dat[$x]='воскресенье';
  $x++;
 }

// Create the Pie Graph 
$graph = new PieGraph(300,300,"auto");
$graph->SetShadow();

// Set A title for the plot
$graph->title->SetFont(FF_ARIAL,FS_BOLD,7);

// Create
$p1 = new PiePlot3D($data);
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,9);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->title->SetColor("darkblue");
$graph->img->SetMargin(0,0,0,0);

$p1->SetAngle(50);
$p1->SetSliceColors(array('#111111','#e8e8e8','#55d055','#5555d0','#555555','#8855d0','#558855'));
$p1->SetCenter(0.5,0.65);
$p1->SetSize(142);
$p1->SetStartAngle(20); 
//$name='Отчет '.$month.','.$today["year"];
//$graph->title->Set($name);
$p1->value->SetColor("darkred");
$p1->SetLabelPos(0.5);
$graph->legend->SetAbsPos(10,10,'right','top');
$p1->SetLegends($dat);

//$p1->SetAngle(0);
//$p1->SetGuideLines ();
//$p1->ExplodeSlice(1);
//$p1->ExplodeAll(10);

$graph->Add($p1);
$graph->Stroke();
?>