<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_line.php");
include ("../jpgraph/jpgraph_bar.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

$query = 'SELECT * FROM ctek WHERE prm='.$_GET["prm"].' AND pipe='.$_GET["pipe"].' AND value!=0 ORDER BY date DESC LIMIT 10000';
$a = mysql_query ($query,$i); $rr=0;
if ($a) $uy = mysql_fetch_row ($a);
while ($uy)
    {
     $datas[$rr]=$uy[5];
     $dats[$rr]=sprintf ("%d%d:%d%d:%d0",$uy[4][11],$uy[4][12],$uy[4][14],$uy[4][15],$uy[4][17]);
     if ($rr>2000) break;
     $rr++;

     $uy = mysql_fetch_row ($a);
    }

for ($i=0; $i<=$rr; $i++) 
	{ 
	 $dat[$i]=$dats[$rr-$i]; 
	 $data[$i]=$datas[$rr-$i]; 
	}

$graph = new Graph(1200,300,"auto");	
$graph->img->SetMargin(45,15,5,30);
$graph->SetScale("textlin");
$graph->SetShadow();

$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);

// Create the linear plot
$lineplot=new LinePlot($data);
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,9);
$graph->legend->SetAbsPos(30,10,'right','top');

if ($_GET["prm"]==13 && $_GET["pipe"]==0) $graph->title->Set("Потребление тепловой энергии (ГКал)");
if ($_GET["prm"]==14 && $_GET["pipe"]==0) $graph->title->Set("Потребление электрической энергии (кВт)");
if ($_GET["prm"]==4 && $_GET["pipe"]==10) $graph->title->Set("Температура наружного воздуха (С)");
if ($_GET["prm"]==12 && $_GET["pipe"]==5) $graph->title->Set("Потребление ХВС (м3)");
if ($_GET["prm"]==12 && $_GET["pipe"]==6) $graph->title->Set("Потребление ГВС (м3)");
if ($_GET["prm"]==14 && $_GET["pipe"]==11) $graph->title->Set("Потребление электроэнергии нарастающим итогом (м3)");
if ($_GET["prm"]==16 && $_GET["pipe"]==0) $graph->title->Set("Температура подающего теплоносителя (С)");
if ($_GET["prm"]==16 && $_GET["pipe"]==1) $graph->title->Set("Температура обратного теплоносителя (С)");

// Add the plot to the graph
$graph->Add($lineplot);

$graph->SetMarginColor('white');
$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
//----------- legend -------------------
$lineplot->SetColor("red");
$lineplot->SetWeight(2);

$graph->yaxis->SetWeight(1);
$graph->xaxis->SetTickLabels($dat);
$graph->xaxis->SetTextTickInterval(150,0);

$graph->legend->Pos(0.15,0.02);
//--------------------------------------
// Display the graph
$graph->Stroke();
?>