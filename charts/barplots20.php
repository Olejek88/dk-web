<?php
include ("../jpgraph2/jpgraph.php");
include ("../jpgraph2/jpgraph_log.php");
include ("../jpgraph2/jpgraph_line.php");
include ("../jpgraph2/jpgraph_bar.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
//------------------------------------------------------------------------
 if ($_GET["pipe"]=='') $_GET["pipe"]=0;
 $query = 'SELECT * FROM device WHERE type='.$_GET["type"].' ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=0;
 while ($uy)
         {
	  $data[$cn]=0;	  
	  $query = 'SELECT * FROM prdata WHERE type=0 AND prm='.$_GET["prm"].' AND value!=0 AND value<500000 AND pipe='.$_GET["pipe"].' AND device='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  while ($ui)
         	{
		  $data[$cn]=$ui[5];
		  $ui = mysql_fetch_row ($e);
		}
	  $dat[$cn]=$cn+1;
	  $cn++;
	  $uy = mysql_fetch_row ($a);
         }

$graph = new Graph(800,400,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new LinePlot($data);
//$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->xaxis->HideLabels();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
//$lineplot->value->Show();
//$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 

// Add the plot to the graph
$graph->img->SetMargin(35,10,18,8);
//----------- title --------------------
$graph->Add($lineplot);
if ($_GET["prm"]=='1') $graph->title->Set("Энтальпия (кДж/кг)");
if ($_GET["prm"]=='2') $graph->title->Set("Электроэнергия (кВт)");
if ($_GET["prm"]=='6') $graph->title->Set("Накопленный расход ХВС (м3)");
if ($_GET["prm"]=='8') $graph->title->Set("Накопленный расход ГВС (м3)");
if ($_GET["prm"]=='5') $graph->title->Set("Текущий расход ХВС (м3)");
if ($_GET["prm"]=='7') $graph->title->Set("Текущий расход ГВС (м3)");
if ($_GET["prm"]=='14') $graph->title->Set("Электроэнергия мгновенная (кВт)");
if ($_GET["prm"]=='4') $graph->title->Set("Температура (C)");
if ($_GET["prm"]=='31') $graph->title->Set("Энтальпия накопленная (кДж/кг)");
if ($_GET["prm"]=='32') $graph->title->Set("Уровень сигнала");

//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>