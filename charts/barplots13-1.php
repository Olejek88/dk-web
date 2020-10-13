<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_bar.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
//------------------------------------------------------------------------
  $query = 'SELECT flat FROM device WHERE type=2 AND idd='.$_GET["id"];
  $e = mysql_query ($query,$i); $p=0;
  if ($e) $ui = mysql_fetch_row ($e);
  if ($ui) $flat=$ui[0];

  $query = 'SELECT * FROM prdata WHERE type='.$_GET["type"].' AND prm='.$_GET["prm"].' AND device='.$_GET["id"].' ORDER BY date DESC LIMIT 180';
  //echo $query;
  $data0[0]=0;
  $e = mysql_query ($query,$i); $p=0;
  if ($e) $ui = mysql_fetch_row ($e);
  while ($ui)
     {
      $data0[$p]=$ui[5];
      if ($_GET["type"]==2) $dat0[$p]=$ui[4][8].$ui[4][9].'/'.$ui[4][5].$ui[4][6];
      if ($_GET["type"]==2) $dats0[$p]=$ui[4][11].$ui[4][12].':00 '.$ui[4][8].$ui[4][9].'/'.$ui[4][5].$ui[4][6];	
      if ($_GET["type"]==1) $dat0[$p]=$ui[4][11].$ui[4][12];	
	//echo $data0[$p].'<br>';
      $p++;
      $ui = mysql_fetch_row ($e);
     }
$p--;
for ($tt=0;$tt<=$p;$tt++) { $data[$tt]=$data0[$p-$tt]; $dat[$tt]=$dat0[$p-$tt]; }


if ($_GET["type"]==1 || $_GET["type"]=='') $graph = new Graph(4000,250,"auto");
if ($_GET["type"]==2) $graph = new Graph(4000,250,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data);
$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
$lineplot->SetShadow();
$lineplot->value->Show();
$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 

if ($_GET["prm"]==8) $name='Потребление холодной воды с '.$dats0[$p-1].' по '.$dats0[0].' (м3)';
if ($_GET["prm"]==6) $name='Потребление горячей воды с '.$dats0[$p-1].' по '.$dats0[0].' (м3)';
$graph->title->Set($name);

// Add the plot to the graph
$graph->img->SetMargin(5,10,15,40);
//----------- title --------------------
$graph->Add($lineplot);                                      
$graph->xaxis->SetLabelAngle(45);
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>                                                          