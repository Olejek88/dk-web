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
 $query = 'SELECT * FROM dev_irp ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=0;
 while ($uy)
         {
	  $data[$cn]=0;
	  if ($_GET["type"]==1) $query = 'SELECT * FROM prdata WHERE type=0 AND prm=4 AND pipe=0 AND device='.$uy[1];
	  if ($_GET["type"]==2) $query = 'SELECT * FROM prdata WHERE type=0 AND prm=4 AND pipe=1 AND device='.$uy[1];
	  if ($_GET["type"]==3) $query = 'SELECT * FROM prdata WHERE type=0 AND prm=13 AND pipe=0 AND device='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  while ($ui)
         	{
		  if ($ui[5]>=0) $data[$cn]=$ui[5];		
		  else $data[$cn]=0;
		  if ($ui[5]>120) $data[$cn]=0;
		  //echo $data[$cn].'<br>';
		  $ui = mysql_fetch_row ($e);
		}
	  $dat[$cn]=$cn+1;
	  $cn++;
	  $uy = mysql_fetch_row ($a);
         }
if ($_GET["hg"]=='') $hg=400; else $hg=$_GET["hg"];
if ($_GET["wg"]=='') $wg=800; else $wg=$_GET["wg"];

$graph = new Graph($wg,$hg,"auto");
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

// Add the plot to the graph
$graph->img->SetMargin(30,15,20,30);
//----------- title --------------------
$graph->Add($lineplot);
if ($type==3) $graph->title->Set("Тепловая энергия (W,Гкал)");
if ($type==1) $graph->title->Set("Температура в подающем трубопроводе (C)");
if ($type==2) $graph->title->Set("Температура в обратном трубопроводе (C)");

//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>